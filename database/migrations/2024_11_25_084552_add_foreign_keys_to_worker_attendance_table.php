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
        Schema::table('worker_attendance', function (Blueprint $table) {
            $table->foreign(['WorkerNameID'], 'worker_attendance_ibfk_1')->references(['WorkerNameID'])->on('worker_group_member')->onUpdate('restrict')->onDelete('restrict');
            $table->foreign(['watID'], 'worker_attendance_ibfk_2')->references(['watID'])->on('worker_attendace_type')->onUpdate('restrict')->onDelete('restrict');
            $table->foreign(['watID2'], 'worker_attendance_ibfk_3')->references(['watID'])->on('worker_attendace_type')->onUpdate('restrict')->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('worker_attendance', function (Blueprint $table) {
            $table->dropForeign('worker_attendance_ibfk_1');
            $table->dropForeign('worker_attendance_ibfk_2');
            $table->dropForeign('worker_attendance_ibfk_3');
        });
    }
};
