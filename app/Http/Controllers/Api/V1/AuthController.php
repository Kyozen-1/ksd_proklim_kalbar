<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Services\ApiClientService;
use App\Services\JwtService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function token(
        Request $request,
        ApiClientService $clients,
        JwtService $jwt
    ): JsonResponse {

        $validated = $request->validate([
            'client_id' => [
                'required',
                'string',
                'max:80',
            ],

            'client_secret' => [
                'required',
                'string',
            ],
        ]);

        $client = $clients->findByClientId(
            $validated['client_id']
        );

        if (
            !$client ||
            !$client->isValid() ||
            !$clients->verifySecret(
                $validated['client_secret'],
                $client
            )
        ) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid client credentials.',
            ], 401);
        }

        $accessToken = $jwt->createAccessToken(
            $client
        );

        return response()->json([
            'success' => true,

            'token_type' => 'Bearer',

            'access_token' => $accessToken,

            'expires_in' =>
                config('jwt.access_ttl') * 60,
        ]);
    }
}
