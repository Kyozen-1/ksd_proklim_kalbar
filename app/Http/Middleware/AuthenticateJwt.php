<?php

namespace App\Http\Middleware;

use App\Services\JwtService;
use Closure;
use Firebase\JWT\ExpiredException;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Throwable;

class AuthenticateJwt
{
    public function __construct(
        protected JwtService $jwt
    ) {
    }

    public function handle(
        Request $request,
        Closure $next
    ): Response {
        $header = $request->header('Authorization');

        /*
        |--------------------------------------------------------------------------
        | Authorization header wajib ada
        |--------------------------------------------------------------------------
        */

        if (
            !$header ||
            !preg_match(
                '/^Bearer\s+(.+)$/i',
                $header,
                $matches
            )
        ) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthenticated.',
            ], 401);
        }

        $token = $matches[1];

        try {

            /*
            |--------------------------------------------------------------------------
            | Decode + verify JWT
            |--------------------------------------------------------------------------
            */

            $payload = $this->jwt->decode($token);

            /*
            |--------------------------------------------------------------------------
            | Pastikan token adalah access token
            |--------------------------------------------------------------------------
            */

            if (($payload->type ?? null) !== 'access') {
                return response()->json([
                    'success' => false,
                    'message' => 'Invalid token type.',
                ], 401);
            }

            /*
            |--------------------------------------------------------------------------
            | Pastikan subject tersedia
            |--------------------------------------------------------------------------
            */

            if (empty($payload->sub)) {
                return response()->json([
                    'success' => false,
                    'message' => 'Invalid token subject.',
                ], 401);
            }

            /*
            |--------------------------------------------------------------------------
            | Simpan payload untuk endpoint berikutnya
            |--------------------------------------------------------------------------
            */

            $request->attributes->set(
                'jwt_payload',
                $payload
            );

        } catch (ExpiredException) {

            return response()->json([
                'success' => false,
                'message' => 'Token expired.',
            ], 401);

        } catch (Throwable) {

            return response()->json([
                'success' => false,
                'message' => 'Invalid token.',
            ], 401);
        }

        return $next($request);
    }
}
