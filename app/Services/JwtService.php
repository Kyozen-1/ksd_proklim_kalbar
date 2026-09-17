<?php

namespace App\Services;

use App\Models\ApiClient;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use Illuminate\Support\Str;

class JwtService
{
    public function createAccessToken(
        ApiClient $client
    ): string {
        $now = now();

        $payload = [
            'iss' => config('jwt.issuer'),

            'aud' => config('jwt.audience'),

            'iat' => $now->timestamp,

            'nbf' => $now->timestamp,

            'exp' => $now
                ->copy()
                ->addMinutes(
                    config('jwt.access_ttl')
                )
                ->timestamp,

            /*
             * Application ID
             */
            'sub' => (string) $client->id,

            /*
             * Unique token ID
             */
            'jti' => (string) Str::uuid(),

            /*
             * Token type
             */
            'type' => 'access',

            /*
             * Application client ID
             */
            'client_id' => $client->client_id,
        ];

        return JWT::encode(
            $payload,
            config('jwt.secret'),
            config('jwt.algorithm')
        );
    }

    public function decode(
        string $token
    ): object {
        $payload = JWT::decode(
            $token,
            new Key(
                config('jwt.secret'),
                config('jwt.algorithm')
            )
        );

        if (
            !isset($payload->iss) ||
            $payload->iss !== config('jwt.issuer')
        ) {
            throw new \UnexpectedValueException(
                'Invalid issuer.'
            );
        }

        if (
            !isset($payload->aud) ||
            $payload->aud !== config('jwt.audience')
        ) {
            throw new \UnexpectedValueException(
                'Invalid audience.'
            );
        }

        return $payload;
    }
}
