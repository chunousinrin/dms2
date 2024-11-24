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
        Schema::create('worker_group_member', function (Blueprint $table) {
            $table->integer('WorkerNameID')->primary();
            $table->integer('WorkerGroupID');
            $table->string('WorkerName', 30);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('worker_group_member');
    }
};
