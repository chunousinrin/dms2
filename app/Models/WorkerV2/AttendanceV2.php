<?php

namespace App\Models\WorkerV2;

use Illuminate\Database\Eloquent\Model;
use App\Models\WorkerV2\AttendanceV2;

class WorkerV2 extends Model
{
    protected $table = 'workers_v2';

    protected $fillable = [
        'name',
        'qr_token',
        'is_active',
    ];

    /*
    |--------------------------------------------------------------------------
    | 今日の勤怠
    |--------------------------------------------------------------------------
    */
    public function todayAttendance()
    {
        return $this->hasOne(
            AttendanceV2::class,
            'worker_id'
        );
    }

    /*
    |--------------------------------------------------------------------------
    | 班履歴
    |--------------------------------------------------------------------------
    */
    public function groupHistories()
    {
        return $this->hasMany(
            WorkerGroupHistory::class,
            'worker_id'
        );
    }
}
