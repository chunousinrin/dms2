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

        $url = "https://www.worksapis.com/v1.0/bots/{$botNo}/richmenus/{$richMenuId}/image";

        // 画像ファイルを読み込む
        $fileStream = fopen($imagePath, 'r');

        // attachを使用して、ファイルとして送信
        $response = Http::withToken($token)
            ->attach(
                'file',             // フィールド名
                $fileStream,        // ファイルストリーム
                'lw_full.png',         // ファイル名
                ['Content-Type' => 'image/png'] // Content-Typeを明示
            )
            ->post($url);

        fclose($fileStream); // ファイルを閉じる

        if ($response->failed()) {
            return "アップロード失敗詳細: " . $response->body();
        }

        return "画像アップロード成功！これでメニューが完成しました。";
    } catch (\Exception $e) {
        return "例外発生: " . $e->getMessage();
    }
});
