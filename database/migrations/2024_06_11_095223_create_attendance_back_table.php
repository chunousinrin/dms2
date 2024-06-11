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
        Schema::create('attendance_back', function (Blueprint $table) {
            $table->integer('ID', true);
            $table->bigInteger('UserID');
            $table->string('WorkingDay', 30)->comment('勤務日');
            $table->string('AttendanceTime', 30)->nullable()->comment('勤務開始時間');
            $table->string('OutingTime', 30)->nullable()->comment('時間内退勤');
            $table->string('ReentryTime', 30)->nullable()->comment('時間内出勤');
            $table->string('LeavingTime', 30)->nullable()->comment('勤務終了時間');
            $table->text('Remark')->comment('備考');
            $table->integer('PaidHoliday')->nullable()->comment('有給');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('attendance_back');
    }
};
