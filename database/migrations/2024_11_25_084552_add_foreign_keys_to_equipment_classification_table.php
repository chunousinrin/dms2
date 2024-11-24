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
        Schema::table('equipment_classification', function (Blueprint $table) {
            $table->foreign(['CategoryID'], 'equipment_classification_ibfk_1')->references(['ID'])->on('equipment_category')->onUpdate('restrict')->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('equipment_classification', function (Blueprint $table) {
            $table->dropForeign('equipment_classification_ibfk_1');
        });
    }
};
