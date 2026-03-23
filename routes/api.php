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

        $imagePath = public_path('/images/lw_full.png'); // 画像のパス

        if (!file_exists($imagePath)) {
            return "エラー: 画像ファイルが {$imagePath} に見つかりません。";
        }

        $url = "https://www.worksapis.com/v1.0/bots/{$botNo}/richmenus/{$richMenuId}/image";

        $response = Http::withToken($token)
            ->attach('file', file_get_contents($imagePath), 'menu.png') // 画像を添付
            ->post($url);

        if ($response->failed()) {
            return "アップロードエラー: " . $response->body();
        }

        return "成功！画像がアップロードされました。";
    } catch (\Exception $e) {
        return "例外発生: " . $e->getMessage();
    }
});
