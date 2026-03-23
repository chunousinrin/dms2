<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Firebase\JWT\JWT; // composer require firebase/php-jwt が必要

class LwApiService
{
    /**
     * API 2.0 アクセストークンの取得
     */
    public static function getAccessToken()
    {
        // config/lineworks.php などに値を逃がしている想定です
        $clientId = config('services.lineworks.client_id');
        $clientSecret = config('services.lineworks.client_secret');
        $serviceAccount = config('services.lineworks.service_account');
        $privateKey = file_get_contents(storage_path('app/private_key.pem')); // 読み込んだ中身

        $now = time();
        $payload = [
            "iss" => $clientId,
            "sub" => $serviceAccount,
            "iat" => $now,
            "exp" => $now + 3600
        ];

        $assertion = JWT::encode($payload, $privateKey, 'RS256');

        $response = Http::asForm()->post("https://auth.worksmobile.com/oauth2/v2.0/token", [
            "assertion" => $assertion,
            "grant_type" => "urn:ietf:params:oauth:grant-type:jwt-bearer",
            "client_id" => $clientId,
            "client_secret" => $clientSecret,
            "scope" => "bot" // まずは最小限のスコープでテスト
        ]);

        if (!$response->successful()) {
            // ここでエラー内容を画面に出す
            return dd($response->json());
        }

        return $response->json()['access_token'];
    }

    /**
     * クイッキリプライ送信
     */
    public static function sendAttendanceSelection($userId)
    {
        $token = self::getAccessToken(); // ここで呼び出し
        $botNo = "6811630";
        // ... (以下、前回お伝えしたクイッキリプライのコード)
    }
}
