<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Firebase\JWT\JWT;

class LwApiService
{
    public static function getAccessToken()
    {
        // 1. もう Config や .env は見ない！ここに直接書く
        $clientId = 'WPcmfuIP1CiGM4ahu_eZ'; // ←実際の値をここに貼る
        $clientSecret = 'Rmm9WTCneq'; // ←実際の値をここに貼る
        $serviceAccount = 'd1gwz.serviceaccount@works-287419'; // ←実際の値をここに貼る

        // 2. 秘密鍵のパス（先ほどの config/services.php のパスに合わせる）
        $privateKeyPath = storage_path('app/certs/private_key.key');

        // --- ここから下はチェックなしで突き進む ---
        if (!file_exists($privateKeyPath)) {
            throw new \Exception("秘密鍵ファイルがありません: " . $privateKeyPath);
        }

        $privateKey = file_get_contents($privateKeyPath);

        // JWTの生成（以下、前回と同じ）
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
            "scope" => "bot" // 一旦 'bot' だけにしてみる

        ]);

        if (!$response->successful()) {
            throw new \Exception("トークン取得失敗: " . $response->body());
        }

        return $response->json()['access_token'];
    }

    public static function sendAttendanceSelection($userId)
    {
        $token = self::getAccessToken();

        // ✅ API 2.0用に新しく発行された Bot No.
        $botId = "6811673";

        // ✅ 2.0の標準URL (bots 複数形)
        $url = "https://www.worksapis.com/v2/bot/{$botId}/users/{$userId}/messages";

        $options = [
            ['label' => '1.0 出勤',      'val' => '1.0/出勤'],
            ['label' => '1.0 有給',      'val' => '1.0/有給'],
            ['label' => '1.0 特休',      'val' => '1.0/特休'],
            // ['label' => '1.0 出勤-有給', 'val' => '1.0/出勤-有給'], // ⚠️ 5個制限のため一旦コメントアウト
            // ['label' => '0.5 出勤-欠勤', 'val' => '0.5/出勤-欠勤'],
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
        }, array_slice($options, 0, 5)); // ✅ 確実に5個以内に収める

        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . $token,
            'Content-Type' => 'application/json',
        ])->post($url, [
            "content" => [
                "type" => "text",
                "text" => "本日の出刻内訳を選択してください。"
            ],
            "quickReply" => [
                "items" => array_slice($items, 0, 5) // 5個制限厳守
            ]
        ]);

        \Log::info("LAST TEST Status: " . $response->status());
        \Log::info("LAST TEST Body: " . $response->body());

        return $response;
    }


    /**
     * シンプルなテキスト送信
     */
    public static function sendSimpleText($userId, $text)
    {
        $token = self::getAccessToken();
        $botNo = "6811630";
        $url = "https://apis.worksmobile.com/v2/bot/6811630/users/{$userId}/messages";

        return Http::withToken($token)->post($url, [
            "content" => [
                "type" => "text",
                "text" => $text
            ]
        ]);
    }
    public static function debugToken()
    {
        $token = self::getAccessToken();
        $botId = "6811630";

        // ✅ URLに $userId を含めない「Bot詳細取得」API
        // これで 200 OK が出れば、IDとトークンは正しいことが証明されます
        $url = "https://apis.worksmobile.com/v2/bots/{$botId}";

        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . $token,
        ])->get($url);

        \Log::info("DEBUG Token Status: " . $response->status());
        \Log::info("DEBUG Token Body: " . $response->body());

        return $response->status();
    }
}
