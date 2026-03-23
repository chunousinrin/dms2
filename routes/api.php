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
    try {
        $token = App\Services\LwApiService::getAccessToken();
        $botNo = env('LW_BOT_NO');
        $richMenuId = 'rm-2205959'; // ここにコピーしたIDを貼る

        $imagePath = public_path('images/lw_full.png');

        if (!file_exists($imagePath)) {
            return "エラー: 画像ファイルがありません。パス: " . $imagePath;
        }

        // 1. 画像をバイナリとして読み込む
        $imageData = file_get_contents($imagePath);

        // 2. MIMEタイプを特定（念のためチェック）
        $mimeType = mime_content_type($imagePath); // image/png または image/jpeg

        $url = "https://www.worksapis.com/v1.0/bots/{$botNo}/richmenus/{$richMenuId}/image";

        // 3. 実行：attachを使わず、withBodyで直接送る
        $response = Http::withToken($token)
            ->withBody($imageData, $mimeType) // ここがポイント！バイナリを直接セット
            ->post($url);

        if ($response->failed()) {
            return "アップロード失敗詳細 (Status: " . $response->status() . "): " . $response->body();
        }

        return "成功！！画像が紐付きました。次は「有効化」です！";
    } catch (\Exception $e) {
        return "例外発生: " . $e->getMessage();
    }
});
