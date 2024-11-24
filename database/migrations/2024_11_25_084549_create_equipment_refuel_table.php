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
        Schema::create('equipment_refuel', function (Blueprint $table) {
            $table->integer('ID', true);
            $table->integer('EquipmentID')->comment('重機ID');
            $table->date('RefuelDate')->comment('給油日');
            $table->integer('FuelVolume')->comment('給油量');
            $table->string('GasStation', 100)->comment('スタンド名');
            $table->string('FuelingLocations', 100)->comment('給油場所');
            $table->text('Remark')->nullable()->comment('備考');
            $table->integer('InputUserID')->comment('入力者');
            $table->date('InputDate')->useCurrent()->comment('入力日');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('equipment_refuel');
    }
};
