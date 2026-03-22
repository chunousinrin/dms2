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
        Schema::create('lw_attendances', function (Blueprint $table) {
            $table->id();
            $table->string('lw_user_id');      // LINE WORKSのユーザーID
            $table->string('user_name')->nullable(); // 記録者の表示名
            $table->date('work_date');         // 出勤日
            $table->string('category');        // 例: "出勤-有給"
            $table->decimal('work_value', 2, 1); // 例: 1.0 / 0.5 / 0.0
            $table->timestamps();

            // 重複登録防止
            $table->unique(['lw_user_id', 'work_date']);
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
