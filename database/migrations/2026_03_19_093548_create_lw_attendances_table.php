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
        Schema::create('attendances', function (Blueprint $table) {
            $table->id();
            $table->string('line_works_id'); // LINE WORKSのユーザー識別子
            $table->date('work_date');       // 対象日
            $table->string('status');        // "出勤", "有給-欠勤" など
            $table->decimal('value', 2, 1);  // 1.0, 0.5, 0.0（集計用）
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('lw_attendances');
    }
};
