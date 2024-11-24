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
        Schema::create('equipment_rental_list', function (Blueprint $table) {
            $table->integer('ID')->primary();
            $table->integer('CategoryID')->nullable()->index('categoryid')->comment('分類');
            $table->string('MachineName', 100)->nullable()->comment('名称');
            $table->string('Ownership', 100)->nullable()->comment('所有権');
            $table->string('Manufacturer', 100)->nullable()->comment('メーカー');
            $table->string('BaseMachine', 100)->nullable()->comment('ベースマシン');
            $table->string('Standard', 100)->nullable()->comment('規格');
            $table->integer('EquipmentID1')->nullable()->index('equipmentid1')->comment('装備1');
            $table->integer('EquipmentID2')->nullable()->index('equipmentid2')->comment('装備2');
            $table->date('Introduction')->nullable()->comment('導入年月日');
            $table->date('ReturnDate')->nullable()->comment('返却年月日');
            $table->integer('Superintendent')->nullable()->comment('管理者');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('equipment_rental_list');
    }
};
