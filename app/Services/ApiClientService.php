<?php

namespace App\Services;

use App\Models\ApiClient;
use Illuminate\Support\Str;

class ApiClientService
{
    public function generateClientId(): string
    {
        return 'redd_' . Str::random(48);
    }

    public function generateClientSecret(): string
    {
        return bin2hex(random_bytes(32));
    }

    public function hashSecret(string $secret): string
    {
        return hash('sha256', $secret);
    }

    public function findByClientId(
        string $clientId
    ): ?ApiClient {
        return ApiClient::where(
            'client_id',
            $clientId
        )->first();
    }

    public function verifySecret(
        string $secret,
        ApiClient $client
    ): bool {
        $hash = $this->hashSecret($secret);

        return hash_equals(
            $client->client_secret_hash,
            $hash
        );
    }
}
