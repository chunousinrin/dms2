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
        $keyPath = storage_path('app/private_key.pem');

        if (!file_exists($keyPath)) {
            throw new \Exception("Private Key ファイルが見つかりません: {$keyPath}");
        }
        $privateKey = file_get_contents($keyPath);

        $now = time();
        $payload = [
            "iss" => $clientId,
            "sub" => $serviceAccount,
            "iat" => $now,
            "exp" => $now + 3600
        ];

        try {
            $assertion = JWT::encode($payload, $privateKey, 'RS256');
        } catch (\Exception $e) {
            throw new \Exception("JWTエンコード失敗: " . $e->getMessage());
        }

        $response = Http::asForm()->post("https://auth.worksmobile.com/oauth2/v2.0/token", [
            "grant_type" => "urn:ietf:params:oauth:grant-type:jwt-bearer",
            "assertion" => $assertion,
            "client_id" => $clientId,
            "client_secret" => $clientSecret,
            "scope" => "bot" // ここを 'bot' だけにする（コンマ区切りも不要です）
        ]);

        if ($response->failed()) {
            // ここで LINE WORKS から返ってきたエラーを直接投げる
            throw new \Exception("LINE WORKS認証エラー: " . $response->body());
        }

        return $response->json('access_token');
    }
}
