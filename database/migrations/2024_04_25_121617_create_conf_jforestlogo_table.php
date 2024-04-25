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
        Schema::create('conf_jforestlogo', function (Blueprint $table) {
            $table->integer('JFID', true);
            $table->binary('JforestColor');
            $table->binary('JforestWhite');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('conf_jforestlogo');
    }
};
