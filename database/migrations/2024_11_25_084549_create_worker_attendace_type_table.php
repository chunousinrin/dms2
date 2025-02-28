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
        Schema::create('worker_attendace_type', function (Blueprint $table) {
            $table->integer('watID')->primary();
            $table->string('AttendanceType', 50);
            $table->decimal('NumberOfDaysWorked', 2, 1)->default(0);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('worker_attendace_type');
    }
};
