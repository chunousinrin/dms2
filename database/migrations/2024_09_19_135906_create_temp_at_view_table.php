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
        Schema::create('temp_at_view', function (Blueprint $table) {
            $table->integer('tmpID', true);
            $table->integer('waID')->nullable();
            $table->date('AttendanceDay')->nullable();
            $table->integer('WorkerGroupID')->nullable();
            $table->string('WorkerGroupName', 30)->nullable();
            $table->integer('WorkerNameID')->nullable();
            $table->string('WorkerName', 30)->nullable();
            $table->integer('watID')->nullable();
            $table->string('AttendanceType', 50)->nullable();
            $table->integer('watID2')->nullable();
            $table->string('AttendanceType2', 50)->nullable();
            $table->decimal('nodw', 2, 1)->nullable();
            $table->decimal('nodw2', 2, 1)->nullable();
            $table->decimal('NumberOfDaysWorked', 2, 1)->nullable();
            $table->integer('calID')->default(0);
            $table->date('CalDate');
            $table->integer('wd')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('temp_at_view');
    }
};
