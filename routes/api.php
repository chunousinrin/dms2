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
    $imagePath = public_path('images/lw_full.png');

    if (!file_exists($imagePath)) {
        return "画像なし: " . $imagePath;
    }

    $url = "https://www.worksapis.com/v1.0/bots/{$botNo}/richmenus/{$richMenuId}/image";

    // cURLで直接リクエストを構成
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        "Authorization: Bearer {$token}",
        "Content-Type: multipart/form-data"
    ]);

    // CURLFileを使ってファイルを指定
    $postFields = [
        'file' => new \CURLFile($imagePath, 'image/png', 'menu.png')
    ];
    curl_setopt($ch, CURLOPT_POSTFIELDS, $postFields);

    $response = curl_exec($ch);
    $status = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);

    if ($status !== 201 && $status !== 200) {
        return "cURL失敗 (Status: {$status}): " . $response;
    }

    return "成功！！画像がアップロードされました。";
});
