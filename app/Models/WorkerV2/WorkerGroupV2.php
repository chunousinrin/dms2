<?php

namespace App\Models\WorkerV2;

use Illuminate\Database\Eloquent\Model;


class WorkerGroupV2 extends Model
{
    protected $table = 'workergroups_v2';

    protected $fillable = [
        'name',
    ];

    public function workers()
    {
        return $this->hasMany(WorkerGroupHistory::class, 'group_id');
    }

    public function attendances()
    {
        return $this->hasMany(AttendanceV2::class, 'group_id');
    }
}
