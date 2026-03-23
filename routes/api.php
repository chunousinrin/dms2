<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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
use App\Http\Controllers\LwAttendanceController;

// Webhook受信用（LINE WORKSからの通知を受ける）
Route::post('/lw/webhook', [LwAttendanceController::class, 'handleWebhook']);

// テスト用：ブラウザでここを叩くと、あなたにボタンが届く
Route::get('/test-options', function () {
    // あなたのLINE WORKS ユーザーIDを直接入れてテスト
    return App\Services\LwApiService::sendAttendanceSelection("wo.57832@works-287419");
});
