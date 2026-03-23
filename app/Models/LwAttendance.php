<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LwAttendance extends Model
{
    use HasFactory;

    // テーブル名を明示的に指定
    protected $table = 'lw_attendances';

    protected $fillable = [
        'lw_user_id',
        'user_name',
        'work_date',
        'category',
        'work_value',
    ];

    protected $casts = [
        'work_date' => 'date',
        'work_value' => 'float',
    ];
}
