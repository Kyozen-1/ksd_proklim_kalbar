<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ContentSecurityPolicy
{
    public function handle(Request $request, Closure $next): Response
    {
        $response = $next($request);

        $imgSources = [
            "'self'",
            "data:",
            "blob:",
            "https:",
            "http://127.0.0.1:9000"
        ];

        $mediaSources = [
            "'self'",
            "data:",
            "blob:",
            "https:",
            "http://127.0.0.1:9000"
        ];

        $connectSource = [
            "'self'",
            "https://cdn.ckeditor.com",
            "https://unpkg.com",
            "https://static.cloudflareinsights.com",
            "http://127.0.0.1:9000"
        ];

        $scriptSources = [
            "'self'",
            "'unsafe-inline'",
            "'unsafe-eval'",
            "data:",
            "blob:",
            "https://cdn.ckeditor.com",
            "https://unpkg.com",
            "https://static.cloudflareinsights.com",
            "https://cdn.jsdelivr.net"
        ];

        $styleSources = [
            "'self'",
            "'unsafe-inline'",
            "https://cdn.ckeditor.com",
            "https://fonts.googleapis.com",
            "https://unpkg.com",
            "https://cdnjs.cloudflare.com"
        ];

        $fontSources = [
            "'self'",
            "data:",
            "https://fonts.gstatic.com",
            "https://unpkg.com",
            "https://cdnjs.cloudflare.com"
        ];

        // Add Vite dev server connection URLs when running in local environment
        if (app()->environment('local')) {
            $viteDevUrlHttp = 'http://localhost:5173';
            $viteDevUrlHttpIp = 'http://127.0.0.1:5173';
            $viteDevUrlHttpIpv6 = 'http://[::1]:5173';
            $viteDevUrlWs = 'ws://localhost:5173';
            $viteDevUrlWsIp = 'ws://127.0.0.1:5173';
            $viteDevUrlWsIpv6 = 'ws://[::1]:5173';

            $scriptSources[] = $viteDevUrlHttp;
            $scriptSources[] = $viteDevUrlHttpIp;
            $scriptSources[] = $viteDevUrlHttpIpv6;

            $styleSources[] = $viteDevUrlHttp;
            $styleSources[] = $viteDevUrlHttpIp;
            $styleSources[] = $viteDevUrlHttpIpv6;

            $connectSource[] = $viteDevUrlHttp;
            $connectSource[] = $viteDevUrlHttpIp;
            $connectSource[] = $viteDevUrlHttpIpv6;
            $connectSource[] = $viteDevUrlWs;
            $connectSource[] = $viteDevUrlWsIp;
            $connectSource[] = $viteDevUrlWsIpv6;
        }

        $csp = implode('; ', [
            "default-src 'self'",
            "script-src " . implode(' ', $scriptSources),
            "style-src " . implode(' ', $styleSources),
            "font-src " . implode(' ', $fontSources),
            "img-src " . implode(' ', $imgSources),
            "media-src " . implode(' ', $mediaSources),
            "connect-src " . implode(' ', $connectSource),
            "frame-src 'self' https://view.officeapps.live.com http://127.0.0.1:9000",
        ]);

        $response->headers->set(
            'Content-Security-Policy',
            $csp
        );

        return $response;
    }
}
