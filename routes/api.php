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

Route::get('/upload-menu-image', function () {
    $token = App\Services\LwApiService::getAccessToken();
    $botNo = env('LW_BOT_NO');
    $richMenuId = 'rm-2205959';

    // 1. プログラムで 2500x1686 の真っ黒な画像を生成 (GDライブラリ使用)
    $width = 2500;
    $height = 1686;
    $image = imagecreatetruecolor($width, $height);

    // 2. バッファにPNGとして書き出し、バイナリを取得
    ob_start();
    imagepng($image);
    $imageData = ob_get_contents();
    ob_end_clean();
    imagedestroy($image);

    $url = "https://www.worksapis.com/v1.0/bots/{$botNo}/richmenus/{$richMenuId}/image";

    // 3. 実行：純粋なバイナリとして送信
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $imageData);
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        "Authorization: Bearer {$token}",
        "Content-Type: image/png",
        "Content-Length: " . strlen($imageData)
    ]);

    $response = curl_exec($ch);
    $status = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);

    return "テスト結果 (Status: {$status}): " . $response;
});
