<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('attendance', function (Blueprint $table) {
            $table->integer('ID', true);
            $table->bigInteger('UserID');
            $table->string('WorkingDay', 30)->comment('勤務日');
            $table->string('AttendanceTime', 30)->default('0')->comment('勤務開始時間');
            $table->string('OutingTime', 30)->default('0')->comment('時間内退勤');
            $table->string('ReentryTime', 30)->default('0')->comment('時間内出勤');
            $table->string('LeavingTime', 30)->default('0')->comment('勤務終了時間');
            $table->text('Remark')->comment('備考');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('attendance');
    }
};
