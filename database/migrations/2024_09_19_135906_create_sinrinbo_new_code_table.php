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
        Schema::create('sinrinbo_new_code', function (Blueprint $table) {
            $table->integer('Code')->index('index');
            $table->string('Cities', 50);

            $table->primary(['Code']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sinrinbo_new_code');
    }
};
