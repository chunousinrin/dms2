<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LwAttendance extends Model
{
    use HasFactory;

    // 対応するテーブル名を明示（慣習通りなら省略可能ですが、念のため）
    protected $table = 'lw_attendances';

    /**
     * 複数代入可能な属性（保存を許可するカラム一覧）
     * これを設定しないと、updateOrCreate や create でデータが保存されません。
     */
    protected $fillable = [
        'lw_user_id',
        'user_name',
        'work_date',
        'category',
        'work_value',
    ];

    /**
     * キャスト設定
     * work_dateを日付型として、work_valueを浮動小数点として扱うようにします。
     */
    protected $casts = [
        'work_date' => 'date',
        'work_value' => 'float',
    ];
}
