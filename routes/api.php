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


Route::get('/get-token', function () {
    try {
        // あなたが作った LwApiService を使ってトークンを生成
        $token = App\Services\LwApiService::getAccessToken();
        return "これをコピーしてください：<br><br><textarea style='width:100%;height:100px;'>" . $token . "</textarea>";
    } catch (\Exception $e) {
        return "エラー発生: " . $e->getMessage();
    }
});



Route::get('/upload-ultimate', function () {
    try {
        $token = App\Services\LwApiService::getAccessToken();
        $botNo = "6811630";
        $richMenuId = "rm-2205959";
        $imagePath = public_path('images/menu.png');

        if (!file_exists($imagePath)) {
            return "画像がありません: " . $imagePath;
        }

        $url = "https://www.worksapis.com/v1.0/bots/{$botNo}/richmenus/{$richMenuId}/image";

        // ポイント：withHeadersでContent-Typeを指定「しない」のがコツです。
        // attachを使うと、Laravelが自動で正しいマルチパートヘッダーを作ってくれます。
        $response = Http::withToken($token)
            ->attach(
                'file',                   // APIが求めている名前
                file_get_contents($imagePath),
                'menu.png'                // ファイル名
            )
            ->post($url);

        if ($response->successful()) {
            return "【祝・成功！！】ついにアップロードされました！すぐに /api/activate-menu を実行してください！";
        }

        return "Status: " . $response->status() . "<br> Response: " . $response->body();
    } catch (\Exception $e) {
        return "例外: " . $e->getMessage();
    }
});
