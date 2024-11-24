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
        Schema::table('equipment_list', function (Blueprint $table) {
            $table->foreign(['CategoryID'], 'equipment_list_ibfk_1')->references(['ID'])->on('equipment_category')->onUpdate('restrict')->onDelete('restrict');
            $table->foreign(['EquipmentID1'], 'equipment_list_ibfk_2')->references(['ID'])->on('equipment_classification')->onUpdate('restrict')->onDelete('restrict');
            $table->foreign(['EquipmentID2'], 'equipment_list_ibfk_3')->references(['ID'])->on('equipment_classification')->onUpdate('restrict')->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('equipment_list', function (Blueprint $table) {
            $table->dropForeign('equipment_list_ibfk_1');
            $table->dropForeign('equipment_list_ibfk_2');
            $table->dropForeign('equipment_list_ibfk_3');
        });
    }
};
