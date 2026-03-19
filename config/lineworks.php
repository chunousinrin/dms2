<?php

return [
    /*
    |--------------------------------------------------------------------------
    | LINE WORKS API 認証情報
    |--------------------------------------------------------------------------
    */
    'client_id' => env('LINEWORKS_CLIENT_ID'),
    'client_secret' => env('LINEWORKS_CLIENT_SECRET'),
    'service_account' => env('LINEWORKS_SERVICE_ACCOUNT'),
    'bot_no' => env('LINEWORKS_BOT_NO'),

    /*
    |--------------------------------------------------------------------------
    | 勤怠報告用の Flexible Message テンプレート
    |--------------------------------------------------------------------------
    */
    'messages' => [
        // メインメニュー（1タップで終わる主要な選択肢）
        'attendance_main' => [
            "type" => "bubble",
            "body" => [
                "layout" => "vertical",
                "contents" => [
                    ["type" => "text", "text" => "本日の勤怠報告", "weight" => "bold", "size" => "lg"],
                    ["type" => "text", "text" => "該当する項目を選択してください", "size" => "sm", "color" => "#888888", "margin" => "md"],
                    ["type" => "separator", "margin" => "lg"],

                    // 1.0 出勤
                    [
                        "type" => "button",
                        "style" => "primary",
                        "height" => "sm",
                        "margin" => "md",
                        "action" => ["type" => "postback", "label" => "1.0 出勤", "data" => "value=1.0&status=出勤"]
                    ],
                    // 1.0 有給
                    [
                        "type" => "button",
                        "style" => "secondary",
                        "height" => "sm",
                        "action" => ["type" => "postback", "label" => "1.0 有給", "data" => "value=1.0&status=有給"]
                    ],
                    // 1.0 特休
                    [
                        "type" => "button",
                        "style" => "secondary",
                        "height" => "sm",
                        "action" => ["type" => "postback", "label" => "1.0 特休", "data" => "value=1.0&status=特休"]
                    ],
                    // 0.0 欠勤
                    [
                        "type" => "button",
                        "style" => "link",
                        "height" => "sm",
                        "color" => "#ff4d4d",
                        "action" => ["type" => "postback", "label" => "0.0 欠勤", "data" => "value=0.0&status=欠勤"]
                    ],

                    ["type" => "separator", "margin" => "md"],

                    // サブメニューへの誘導
                    [
                        "type" => "button",
                        "style" => "link",
                        "height" => "sm",
                        "action" => ["type" => "postback", "label" => "半日単位の報告はこちら...", "data" => "action=show_sub_menu"]
                    ]
                ]
            ]
        ],

        // サブメニュー（半日単位の組み合わせ）
        'attendance_sub' => [
            "type" => "bubble",
            "body" => [
                "layout" => "vertical",
                "contents" => [
                    ["type" => "text", "text" => "半日単位の報告", "weight" => "bold", "size" => "md"],
                    ["type" => "separator", "margin" => "md"],

                    // 1.0 出勤-有給
                    [
                        "type" => "button",
                        "style" => "primary",
                        "height" => "sm",
                        "margin" => "md",
                        "action" => ["type" => "postback", "label" => "1.0 出勤-有給", "data" => "value=1.0&status=出勤-有給"]
                    ],
                    // 0.5 出勤-欠勤
                    [
                        "type" => "button",
                        "style" => "secondary",
                        "height" => "sm",
                        "action" => ["type" => "postback", "label" => "0.5 出勤-欠勤", "data" => "value=0.5&status=出勤-欠勤"]
                    ],
                    // 0.5 有給-欠勤
                    [
                        "type" => "button",
                        "style" => "secondary",
                        "height" => "sm",
                        "action" => ["type" => "postback", "label" => "0.5 有給-欠勤", "data" => "value=0.5&status=有給-欠勤"]
                    ],

                    ["type" => "separator", "margin" => "md"],

                    // 戻るボタン
                    [
                        "type" => "button",
                        "style" => "link",
                        "height" => "sm",
                        "action" => ["type" => "postback", "label" => "< 戻る", "data" => "action=show_main_menu"]
                    ]
                ]
            ]
        ]
    ]
];
