<?php

namespace App\Http\Middleware;

use App\Models\ApiClient;
use App\Models\ApiPermission;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckApiPermission
{
    public function handle(
        Request $request,
        Closure $next
    ): Response {

        $payload = $request
            ->attributes
            ->get('jwt_payload');

        if (!$payload) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthenticated.',
            ], 401);
        }

        $clientId = $payload->sub ?? null;

        if (!$clientId) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid token subject.',
            ], 401);
        }

        $client = ApiClient::find($clientId);

        if (!$client || !$client->isValid()) {
            return response()->json([
                'success' => false,
                'message' => 'API client is inactive.',
            ], 401);
        }

        if (
            !isset($payload->client_id) ||
            !hash_equals(
                $client->client_id,
                (string) $payload->client_id
            )
        ) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid token.',
            ], 401);
        }

        /*
         * Ambil route Laravel yang sedang diakses.
         */
        $routeName = $request->route()?->getName();

        if (!$routeName) {
            return response()->json([
                'success' => false,
                'message' => 'Forbidden.',
            ], 403);
        }

        /*
         * Ambil HTTP method.
         */
        $method = $request->method();

        /*
         * Cari permission berdasarkan
         * route Laravel + HTTP method.
         */
        $permission = ApiPermission::query()
            ->where('route_name', $routeName)
            ->where('method', $method)
            ->where('is_active', true)
            ->first();

        /*
         * Fail closed:
         * route yang belum memiliki permission
         * tidak boleh diakses.
         */
        if (!$permission) {
            return response()->json([
                'success' => false,
                'message' => 'Forbidden.',
            ], 403);
        }

        /*
         * Cek apakah API Client memiliki
         * permission tersebut.
         */
        $hasPermission = $client->permissions()
            ->where('api_permissions.id', $permission->id)
            ->where('api_permissions.is_active', true)
            ->exists();

        if (!$hasPermission) {
            return response()->json([
                'success' => false,
                'message' => 'Forbidden.',
            ], 403);
        }

        /*
         * Simpan client dan permission
         * untuk endpoint berikutnya.
         */
        $request->attributes->set(
            'api_client',
            $client
        );

        $request->attributes->set(
            'api_permission',
            $permission
        );

        return $next($request);
    }
}
