<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\LWAttendance;    // 変更
use Illuminate\Support\Facades\Log;

class LWLineWorksService extends Controller
{
    protected $lwService;

    public function __construct(LWLineWorksService $lwService)
    {
        $this->lwService = $lwService;
    }

    public function handle(Request $request)
    {
        $userId = $request->input('source.userId');
        $content = $request->input('content');

        if ($content['type'] !== 'postback') {
            return response()->json(['status' => 'ignored']);
        }

        parse_str($content['postback'], $params);

        // メニュー切り替え
        if (isset($params['action'])) {
            $configKey = ($params['action'] === 'show_sub_menu') ? 'attendance_sub' : 'attendance_main';
            $flex = config("lw_lineworks.messages.{$configKey}");
            $this->lwService->sendFlexibleMessage($userId, $flex);
            return response()->json(['status' => 'menu_switched']);
        }

        // 保存処理
        if (isset($params['status'])) {
            LWAttendance::updateOrCreate(
                ['line_works_id' => $userId, 'work_date' => now()->toDateString()],
                ['status' => $params['status'], 'value' => $params['value']]
            );

            $this->lwService->sendTextMessage($userId, "【記録完了】\n状況を「{$params['status']}」で保存しました。");
        }

        return response()->json(['status' => 'success']);
    }
}
