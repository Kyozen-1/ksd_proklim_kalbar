<?php

namespace App\Services;

use Illuminate\Routing\Route;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Route as RouteFacade;
use App\Models\ApiPermission;

class ApiRouteService
{
    /**
     * Get all API routes that are eligible
     * to have API permissions.
     */
    public function availableRoutes(): Collection
    {
        return collect(RouteFacade::getRoutes()->getRoutes())
            ->filter(function (Route $route) {
                return $this->isApiPermissionRoute($route);
            })
            ->map(function (Route $route) {
                return [
                    'name' => $route->getName(),
                    'uri' => '/' . ltrim($route->uri(), '/'),
                    'methods' => $this->getMethods($route),
                    'method' => $this->getPrimaryMethod($route),
                ];
            })
            ->sortBy([
                ['uri', 'asc'],
                ['method', 'asc'],
            ])
            ->values();
    }

    /**
     * Find an eligible API route by route name.
     */
    public function findByName(string $routeName): ?array
    {
        return $this->availableRoutes()
            ->firstWhere('name', $routeName);
    }

    /**
     * Determine whether a route can be used
     * as an API permission.
     */
    protected function isApiPermissionRoute(Route $route): bool
    {
        $name = $route->getName();

        if (!$name) {
            return false;
        }

        /**
         * Only routes inside the API namespace.
         *
         * Example:
         * api.deforestation.index
         * api.regencies.index
         */
        if (!str_starts_with($name, 'api.')) {
            return false;
        }

        /**
         * Do not expose OPTIONS / HEAD as
         * independent permissions.
         */
        $methods = $route->methods();

        if (
            empty(
                array_intersect(
                    $methods,
                    ['GET', 'POST', 'PUT', 'PATCH', 'DELETE']
                )
            )
        ) {
            return false;
        }

        /**
         * Only routes protected by JWT middleware.
         */
        if (!$this->hasJwtMiddleware($route)) {
            return false;
        }

        return true;
    }

    /**
     * Check whether route contains JWT middleware.
     */
    protected function hasJwtMiddleware(Route $route): bool
    {
        $middleware = $route->gatherMiddleware();

        return collect($middleware)->contains(function ($middleware) {
            return $middleware === 'jwt'
                || $middleware === \App\Http\Middleware\AuthenticateJwt::class;
        });
    }

    /**
     * Remove HEAD and OPTIONS from displayed methods.
     */
    protected function getMethods(Route $route): array
    {
        return collect($route->methods())
            ->filter(function (string $method) {
                return in_array(
                    $method,
                    ['GET', 'POST', 'PUT', 'PATCH', 'DELETE'],
                    true
                );
            })
            ->values()
            ->all();
    }

    /**
     * Get the primary HTTP method.
     */
    protected function getPrimaryMethod(Route $route): ?string
    {
        return $this->getMethods($route)[0] ?? null;
    }

    public function syncPermissions(): array
    {
        $routes = $this->availableRoutes();

        $routeKeys = $routes
            ->mapWithKeys(function (array $route) {
                return [
                    $route['name'] . '|' . $route['method'] => true,
                ];
            });

        $existingKeys = ApiPermission::query()
            ->get([
                'route_name',
                'method',
            ])
            ->mapWithKeys(function (ApiPermission $permission) {
                return [
                    $permission->route_name
                        . '|'
                        . $permission->method => true,
                ];
            });

        $created = 0;

        foreach ($routes as $route) {

            $key = $route['name'] . '|' . $route['method'];

            if (isset($existingKeys[$key])) {
                continue;
            }

            ApiPermission::create([
                'name' => $this->generatePermissionName($route),
                'slug' => $route['name'],
                'route_name' => $route['name'],
                'method' => $route['method'],
                'description' => null,
                'is_active' => true,
            ]);

            $created++;
        }

        $orphaned = ApiPermission::query()
            ->where('is_active', true)
            ->get([
                'route_name',
                'method',
            ])
            ->filter(function (ApiPermission $permission) use ($routeKeys) {

                $key = $permission->route_name
                    . '|'
                    . $permission->method;

                return !isset($routeKeys[$key]);
            })
            ->count();

        return [
            'created' => $created,
            'orphaned' => $orphaned,
        ];
    }

    protected function generatePermissionName(array $route): string
    {
        $parts = explode('.', $route['name']);

        $resource = $parts[1] ?? 'API';
        $action = $parts[2] ?? 'access';

        $actions = [
            'index' => 'Read',
            'show' => 'Read Detail',
            'store' => 'Create',
            'update' => 'Update',
            'destroy' => 'Delete',
        ];

        $resourceName = ucwords(
            str_replace(
                ['-', '_'],
                ' ',
                $resource
            )
        );

        $actionName = $actions[$action] ?? ucwords(
            str_replace(
                ['-', '_'],
                ' ',
                $action
            )
        );

        return $resourceName . ' Data ' . $actionName;
    }
}
