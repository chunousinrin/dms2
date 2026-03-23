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


Route::get('/upload-final-fix', function () {
    try {
        $token = App\Services\LwApiService::getAccessToken();
        $botNo = "6811630";
        $richMenuId = "2205959";
        $imagePath = public_path('images/menu.jpg');

        if (!file_exists($imagePath)) {
            return "画像が見つかりません: " . $imagePath;
        }

        $url = "https://www.worksapis.com/v1.0/bots/{$botNo}/richmenus/{$richMenuId}/image";

        // 掲示板の解決策: multipart/form-data で 'file' キーに
        // (ファイル名, バイナリ, Content-Type) をセットする
        $response = Http::withToken($token)
            ->attach(
                'file',                       // キー名は 'file' 固定
                file_get_contents($imagePath), // 画像バイナリ
                'menu.jpg',                   // ファイル名
                ['Content-Type' => 'image/jpeg'] // MIMEタイプを明示
            )
            ->post($url);

        if ($response->successful()) {
            return "【大勝利！！】画像が登録されました！直ちに /api/activate-menu を実行してください！";
        }

        return "Status: " . $response->status() . "<br> Response: " . $response->body();
    } catch (\Exception $e) {
        return "エラー: " . $e->getMessage();
    }
});
