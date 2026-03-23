<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Firebase\JWT\JWT;

class LwApiService
{
    /**
     * API 2.0 アクセストークンの取得
     */
    public static function getAccessToken()
    {
        // 1. Configから取得（基本）
        $clientId = config('services.lineworks.client_id');
        $clientSecret = config('services.lineworks.client_secret');
        $serviceAccount = config('services.lineworks.service_account');
        $privateKeyPath = config('services.lineworks.private_key');

        // 2. もし .env が読み込めていない場合の「緊急避難用」
        // ※ 上記が null の場合、ここに直接文字列を貼り付けても動きます
        $clientId = $clientId ?? 'WPcmfuIP1CiGM4ahu_eZ';
        $clientSecret = $clientSecret ?? 'Rmm9WTCneq';
        $serviceAccount = $serviceAccount ?? 'd1gwz.serviceaccount@works-287419';

        if (!$clientId || $clientId === 'WPcmfuIP1CiGM4ahu_eZ') {
            throw new \Exception("LINE WORKSの設定（Client ID等）が空です。.envまたはLwApiServiceを確認してください。");
        }

        // 秘密鍵の読み込み
        if (!file_exists($privateKeyPath)) {
            throw new \Exception("秘密鍵ファイルが見つかりません: {$privateKeyPath}");
        }
        $privateKey = file_get_contents($privateKeyPath);

        // JWTの生成
        $now = time();
        $payload = [
            "iss" => $clientId,
            "sub" => $serviceAccount,
            "iat" => $now,
            "exp" => $now + 3600
        ];

        $assertion = JWT::encode($payload, $privateKey, 'RS256');

        // トークン要求
        $response = Http::asForm()->post("https://auth.worksmobile.com/oauth2/v2.0/token", [
            "assertion" => $assertion,
            "grant_type" => "urn:ietf:params:oauth:grant-type:jwt-bearer",
            "client_id" => $clientId,
            "client_secret" => $clientSecret,
            "scope" => "bot,bot.read,bot.message"
        ]);

        if (!$response->successful()) {
            Log::error("LINE WORKS Token Error: " . $response->body());
            throw new \Exception("トークン取得失敗: " . $response->body());
        }

        return $response->json()['access_token'];
    }

    /**
     * クイッキリプライ（出勤内訳ボタン）の送信
     */
    public static function sendAttendanceSelection($userId)
    {
        $token = self::getAccessToken();
        $botNo = "6811630";
        $url = "https://www.worksapis.com/v1.0/bots/{$botNo}/users/{$userId}/messages";

        $options = [
            ['label' => '1.0 出勤',      'val' => '1.0/出勤'],
            ['label' => '1.0 有給',      'val' => '1.0/有給'],
            ['label' => '1.0 特休',      'val' => '1.0/特休'],
            ['label' => '1.0 出勤-有給', 'val' => '1.0/出勤-有給'],
            ['label' => '0.5 出勤-欠勤', 'val' => '0.5/出勤-欠勤'],
            ['label' => '0.5 有給-欠勤', 'val' => '0.5/有給-欠勤'],
            ['label' => '0.0 欠勤',      'val' => '0.0/欠勤'],
        ];

        $items = array_map(function ($opt) {
            return [
                "action" => [
                    "type" => "message",
                    "label" => $opt['label'],
                    "text" => "【打刻】" . $opt['val']
                ]
            ];
        }, $options);

        return Http::withToken($token)->post($url, [
            "content" => [
                "type" => "text",
                "text" => "本日の出勤内訳を選択してください。"
            ],
            "quickReply" => [
                "items" => $items
            ]
        ]);
    }

    /**
     * シンプルなテキスト送信
     */
    public static function sendSimpleText($userId, $text)
    {
        $token = self::getAccessToken();
        $botNo = "6811630";
        $url = "https://www.worksapis.com/v1.0/bots/{$botNo}/users/{$userId}/messages";

        return Http::withToken($token)->post($url, [
            "content" => [
                "type" => "text",
                "text" => $text
            ]
        ]);
    }
}
