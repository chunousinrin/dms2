<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Firebase\JWT\JWT; // composer require firebase/php-jwt が必要です

class LwApiService
{
    public static function getAccessToken()
    {
        $clientId = env('LW_CLIENT_ID');
        $clientSecret = env('LW_CLIENT_SECRET');
        $serviceAccount = env('LW_SERVICE_ACCOUNT');
        $privateKey = file_get_contents(storage_path('app/private_key.pem'));

        $now = time();
        $payload = [
            "iss" => $clientId,
            "sub" => $serviceAccount,
            "iat" => $now,
            "exp" => $now + 3600
        ];

        // JWTの生成
        $assertion = JWT::encode($payload, $privateKey, 'RS256');

        // トークンの取得
        $response = Http::asForm()->post("https://auth.worksmobile.com/oauth2/v2.0/token", [
            "grant_type" => "urn:ietf:params:oauth:grant-type:jwt-bearer",
            "assertion" => $assertion,
            "client_id" => $clientId,
            "client_secret" => $clientSecret,
            "scope" => "bot,bot.read,richmenu,richmenu.read"
        ]);

        return $response->json('access_token');
    }
}
