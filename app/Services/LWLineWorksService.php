<?php

namespace App\Services;

if (!defined('CURL_SSLVERSION_TLSv1_2')) define('CURL_SSLVERSION_TLSv1_2', 6);

use Firebase\JWT\JWT;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class LWLineWorksService
{
    protected $config;
    protected $accessToken;

    public function __construct()
    {
        $this->config = config('lw_lineworks');
    }

    protected function getAccessToken()
    {
        if ($this->accessToken) return $this->accessToken;

        $now = time();
        $privateKey = file_get_contents(storage_path('app/lineworks/private_key.key'));

        $payload = [
            "iss" => $this->config['client_id'],
            "sub" => $this->config['service_account'],
            "iat" => $now,
            "exp" => $now + 3600
        ];

        $jwt = JWT::encode($payload, $privateKey, 'RS256');

        // 正しいトークン発行用URL
        $url = 'https://auth.worksmobile.com/oauth2/v2.0/token';

        $response = Http::asForm()->post($url, [
            'grant_type'    => 'urn:ietf:params:oauth:grant-type:jwt-bearer',
            'assertion'     => $jwt,
            'client_id'     => $this->config['client_id'],
            'client_secret' => $this->config['client_secret'],
            'scope'         => 'bot',
        ]);

        // 【デバッグ】もし失敗したら、原因を画面に詳しく表示する
        if ($response->failed()) {
            dd([
                '状況' => 'トークン取得に失敗しました',
                'ステータス' => $response->status(),
                'LINEWORKSからのメッセージ' => $response->json() ?? $response->body(),
                '設定値(Client ID)' => $this->config['client_id'],
            ]);
        }

        $this->accessToken = $response->json()['access_token'];
        return $this->accessToken;
    }

    public function sendTextMessage($userId, $text)
    {
        return $this->sendRequest($userId, [
            'content' => ['type' => 'text', 'text' => $text]
        ]);
    }

    public function sendFlexibleMessage($userId, $flexContent)
    {
        return $this->sendRequest($userId, [
            'content' => [
                'type' => 'flexible',
                'altText' => '勤怠報告メニュー',
                'contents' => $flexContent
            ]
        ]);
    }

    protected function sendRequest($userId, $body)
    {
        $token = $this->getAccessToken();

        // 【チェック1】トークン自体が取れているか？
        if (!$token) {
            dd('エラー: アクセストークンが空です。認証(JWT)に失敗しています。');
        }

        $botNo = $this->config['bot_no'];
        $url = "https://www.worksmobile.com/jp/message/v1/bot/{$botNo}/users/{$userId}/messages";

        $response = Http::withToken($token)->post($url, $body);

        // 【チェック2】送信リクエストの結果を確認
        if ($response->failed()) {
            dd([
                '状況' => 'メッセージ送信に失敗しました',
                'URL' => $url,
                'ステータス' => $response->status(),
                'エラー詳細' => $response->json() ?? $response->body(),
                '送信先ユーザーID' => $userId,
                '使用トークン' => substr($token, 0, 10) . '...' // セキュリティのため一部表示
            ]);
        }

        return $response->json();
    }
}
