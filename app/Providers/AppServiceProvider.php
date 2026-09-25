<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Contracts\FileStorageInterface;
use App\Services\Storage\FileStorageService;
use Illuminate\Support\Facades\Vite;

class AppServiceProvider extends ServiceProvider
{
    private const VITE_PROJECT_HEADER = 'X-Vite-Project: ksd-proklim-kalbar';

    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(
            FileStorageInterface::class,
            FileStorageService::class
        );
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        $this->ignoreStaleViteHotFile();

        // \URL::forceScheme('https');
    }

    /**
     * Fall back to the production manifest when a crashed Vite process leaves
     * public/hot behind. Laravel otherwise keeps pointing every asset at the
     * unavailable development server.
     */
    private function ignoreStaleViteHotFile(): void
    {
        $hotFile = public_path('hot');

        if (!is_file($hotFile)) {
            return;
        }

        $hotUrl = trim((string) file_get_contents($hotFile));
        $parts = parse_url($hotUrl);

        if (!is_array($parts) || empty($parts['host'])) {
            Vite::useHotFile(storage_path('framework/vite.hot.unavailable'));

            return;
        }

        if ($this->viteDevServerResponds($parts)) {
            return;
        }

        Vite::useHotFile(storage_path('framework/vite.hot.unavailable'));
    }

    private function viteDevServerResponds(array $parts): bool
    {
        $host = trim($parts['host'], '[]');
        $scheme = $parts['scheme'] ?? 'http';
        $port = (int) ($parts['port'] ?? ($scheme === 'https' ? 443 : 80));
        $transport = $scheme === 'https' ? 'ssl' : 'tcp';
        $socketHost = str_contains($host, ':') ? "[{$host}]" : $host;
        $address = "{$transport}://{$socketHost}:{$port}";

        $connection = @stream_socket_client($address, $errorCode, $errorMessage, 0.1);

        if (!is_resource($connection)) {
            return false;
        }

        stream_set_timeout($connection, 0, 250000);
        fwrite(
            $connection,
            "GET /@vite/client HTTP/1.0\r\nHost: {$socketHost}:{$port}\r\nConnection: close\r\n\r\n"
        );

        $statusLine = fgets($connection);
        $belongsToThisProject = false;

        while (($headerLine = fgets($connection)) !== false && trim($headerLine) !== '') {
            if (strcasecmp(trim($headerLine), self::VITE_PROJECT_HEADER) === 0) {
                $belongsToThisProject = true;
            }
        }

        fclose($connection);

        return is_string($statusLine)
            && preg_match('/^HTTP\/\d(?:\.\d)?\s+[23]\d{2}\b/', $statusLine) === 1
            && $belongsToThisProject;
    }
}
