<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LwAttendanceController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/webhook', [LwAttendanceController::class, 'handleWebhook']);


use Illuminate\Support\Facades\Http;
use App\Services\LwApiService;
use Illuminate\Support\Facades\Log;

Route::get('/create-menu', function () {
    try {
        echo "1. 処理開始...<br>";

        $token = App\Services\LwApiService::getAccessToken();
        $botNo = env('LW_BOT_NO'); // .envから取得

        echo "2. トークン取得成功。Bot No: " . $botNo . "<br>";

        // URLの組み立てを確実に
        $url = "https://www.worksapis.com/v1.0/bots/" . $botNo . "/richmenus";

        $response = Http::withToken($token)
            ->post($url, [
                "size" => [           // ← ここを 'size' で囲む必要があります
                    "width" => 2500,
                    "height" => 1686,
                ],
                "selected" => true,
                "name" => "勤怠メニュー",
                "areas" => [
                    [
                        "bounds" => [
                            "x" => 0,
                            "y" => 0,
                            "width" => 2500,
                            "height" => 1686
                        ],
                        "action" => [
                            "type" => "message",
                            "label" => "出勤入力",
                            "text" => "出勤入力"
                        ]
                    ]
                ]
            ]);

        echo "3. APIリクエスト完了。URL: " . $url . "<br>";
        echo "ステータスコード: " . $response->status() . "<br>";

        if ($response->failed()) {
            return "APIエラー詳細: " . $response->body();
        }

        return "成功！ Rich Menu ID: " . $response->json('richMenuId');
    } catch (\Exception $e) {
        return "例外発生: " . $e->getMessage();
    }
});
