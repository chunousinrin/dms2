<?php

namespace App\Models\WorkerV2;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use App\Models\WorkerV2\AttendanceV2;
use App\Models\WorkerV2\WorkerGroupHistory;

class WorkerV2 extends Model
{
    protected $table = 'workers_v2';

    protected $fillable = [
        'name',
        'qr_token',
    ];

    // 自動でQRトークン生成（未設定時）
    protected static function booted()
    {
        static::creating(function ($worker) {
            if (!$worker->qr_token) {
                $worker->qr_token = (string) Str::uuid();
            }
        });
    }

    // 勤怠
    public function attendances()
    {
        return $this->hasMany(AttendanceV2::class, 'worker_id');
    }

    // 今日の所属班（よく使うのでメソッド化）
    public function currentGroup($date = null)
    {
        $date = $date ?? today();

        return $this->groupHistories()
            ->where('start_date', '<=', $date)
            ->where(function ($q) use ($date) {
                $q->whereNull('end_date')
                    ->orWhere('end_date', '>=', $date);
            })
            ->orderBy('start_date', 'desc')
            ->first();
    }

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
