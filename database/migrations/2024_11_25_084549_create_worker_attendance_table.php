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
        Schema::create('worker_attendance', function (Blueprint $table) {
            $table->integer('waID', true);
            $table->date('AttendanceDay')->nullable();
            $table->integer('WorkerNameID')->index('workernameid');
            $table->integer('watID')->index('watid');
            $table->integer('watID2')->nullable()->index('watid2');
            $table->decimal('NumberOfDaysWorked', 2, 1)->default(0);
            $table->text('Remark')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('worker_attendance');
    }
};
