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
        Schema::create('equipment_usage_history', function (Blueprint $table) {
            $table->integer('ID', true);
            $table->integer('EquipmentID')->nullable()->index('equipmentid')->comment('重機ID');
            $table->date('StartDay')->nullable()->comment('利用開始日');
            $table->date('EndDate')->nullable()->comment('利用終了日');
            $table->string('Workplace', 50)->nullable()->comment('現場');
            $table->string('InstructionNumber', 50)->nullable()->comment('指示書番号');
            $table->integer('WorkerGroupInUse')->nullable()->index('workergroupinuse')->comment('使用班');
            $table->text('Remark')->nullable()->comment('備考');
            $table->integer('InputUserID')->comment('入力者');
            $table->date('InputDate')->useCurrent()->comment('入力日');
            $table->integer('HourMeterStart')->nullable()->comment('始業時アワメーター');
            $table->integer('HourMeterEnd')->nullable()->comment('終業時アワメーター');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('equipment_usage_history');
    }
};
