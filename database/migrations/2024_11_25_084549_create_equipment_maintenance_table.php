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
        Schema::create('equipment_maintenance', function (Blueprint $table) {
            $table->integer('ID', true);
            $table->integer('EquipmentID')->nullable()->comment('重機ID
');
            $table->text('MaintenanceDetails')->nullable()->comment('内容');
            $table->integer('Cost')->nullable()->comment('費用');
            $table->date('EffectiveDate')->nullable()->comment('実施日');
            $table->text('Remark')->nullable()->comment('備考');
            $table->integer('InputUserID')->nullable()->comment('入力者');
            $table->date('InputDate')->nullable()->useCurrent()->comment('入力日');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('equipment_maintenance');
    }
};
