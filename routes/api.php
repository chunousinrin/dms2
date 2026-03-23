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


Route::get('/upload-ultra-fix', function () {
    $token = App\Services\LwApiService::getAccessToken();
    $botNo = "6811630";
    $richMenuId = "rm-2205959";
    $imagePath = public_path('images/menu.png'); // 2500x1686の画像

    if (!file_exists($imagePath)) {
        return "エラー: 画像が {$imagePath} にありません。";
    }

    $imageData = file_get_contents($imagePath);
    $url = "https://www.worksapis.com/v1.0/bots/{$botNo}/richmenus/{$richMenuId}/image";

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

    // 重要：Bodyに画像バイナリをそのままセット（名前なし）
    curl_setopt($ch, CURLOPT_POSTFIELDS, $imageData);

    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        "Authorization: Bearer " . $token,
        "Content-Type: image/png", // multipartではなくimage/png
        "Content-Length: " . strlen($imageData)
    ]);

    $response = curl_exec($ch);
    $status = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);

    if ($status == 201 || $status == 200) {
        return "【祝・成功！！】画像が紐付きました！今すぐ /api/activate-menu を実行してください！";
    }

    return "Status: {$status} <br> Response: " . $response;
});
