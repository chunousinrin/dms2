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
        Schema::create('equipment_classification', function (Blueprint $table) {
            $table->integer('ID')->primary();
            $table->integer('CategoryID')->index('categoryid')->comment('分類');
            $table->string('ModelNumber', 100)->comment('形式番号');
            $table->string('Manufacturer', 100)->comment('メーカー');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('equipment_classification');
    }
};
