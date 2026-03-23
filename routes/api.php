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

Route::get('/upload-perfect-binary', function () {
    try {
        $token = App\Services\LwApiService::getAccessToken();
        $botNo = "6811630";
        $richMenuId = "rm-2205961"; // 既存のIDを使用

        // 1. メモリ上で完璧な 2500x1686 の画像を作成
        $width = 2500;
        $height = 1686;
        $image = imagecreatetruecolor($width, $height);

        // 背景を中濃森林組合様のイメージに近い緑色 (#70bd29) で塗りつぶし
        $green = imagecolorallocate($target = $image, 112, 189, 41);
        imagefill($image, 0, 0, $green);

        // 2. バイナリデータをキャプチャ
        ob_start();
        imagepng($image);
        $imageData = ob_get_contents();
        ob_end_clean();
        imagedestroy($image);

        // 3. 送信（LaravelのHttpクライアントで、最も成功率の高い構成）
        $url = "https://www.worksapis.com/v1.0/bots/{$botNo}/richmenus/{$richMenuId}/image";

        $response = Http::withToken($token)
            ->attach(
                'file',       // キー名
                $imageData,   // 生成したバイナリ
                'test.png',   // ダミーファイル名
                ['Content-Type' => 'image/png']
            )
            ->post($url);

        if ($response->successful()) {
            return "【成功】完璧なバイナリでアップロードに成功しました！次は /api/activate-menu です。";
        }

        return "失敗 (Status: " . $response->status() . "): " . $response->body();
    } catch (\Exception $e) {
        return "エラー発生: " . $e->getMessage();
    }
});
