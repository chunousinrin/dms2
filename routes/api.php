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

Route::get('/upload-final-fix', function () {
    $token = App\Services\LwApiService::getAccessToken();
    $botNo = "6811630";
    $richMenuId = "rm-2205959";

    // 1. 画像生成（2500x1686）
    $image = imagecreatetruecolor(2500, 1686);
    $tempFile = tempnam(sys_get_temp_dir(), 'richmenu');
    imagepng($image, $tempFile); // 一時ファイルとして保存
    imagedestroy($image);

    $url = "https://www.worksapis.com/v1.0/bots/{$botNo}/richmenus/{$richMenuId}/image";

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

    // 2. 重要：CURLFile を使って「ファイル」として定義する
    $postFields = [
        'file' => new \CURLFile($tempFile, 'image/png', 'menu.png')
    ];

    curl_setopt($ch, CURLOPT_POSTFIELDS, $postFields);
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        "Authorization: Bearer " . $token,
        "Content-Type: multipart/form-data" // これが必要
    ]);

    $response = curl_exec($ch);
    $status = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);
    unlink($tempFile); // 一時ファイルを削除

    if ($status == 201 || $status == 200) {
        return "【成功】画像がアップロードされました！直ちに /api/activate-menu を叩いてください！";
    }

    return "Status: {$status} <br> Response: " . $response;
});
