<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LWAttendance extends Model
{
    // テーブル名を明示的に指定（スネークケースになるため）
    protected $table = 'l_w_attendances';

    protected $fillable = [
        'line_works_id',
        'work_date',
        'status',
        'value',
    ];

    protected $casts = [
        'work_date' => 'date',
        'value' => 'float',
    ];
}
