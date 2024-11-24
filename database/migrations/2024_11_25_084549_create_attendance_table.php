<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('attendance', function (Blueprint $table) {
            $table->integer('ID', true);
            $table->integer('UserID')->nullable();
            $table->date('WorkingDay')->nullable()->comment('出勤日');
            $table->time('AttendanceTime')->nullable()->comment('出勤時間');
            $table->time('OutingTime')->nullable()->comment('時間内退勤');
            $table->time('ReentryTime')->nullable()->comment('時間内出勤');
            $table->time('LeavingTime')->nullable()->comment('退勤時間');
            $table->text('Remark')->nullable()->comment('備考');
            $table->integer('PaidHoliday')->nullable()->comment('有給');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('attendance');
    }
};
