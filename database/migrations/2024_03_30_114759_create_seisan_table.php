<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('seisan', function (Blueprint $table) {
            $table->integer('No', true);
            $table->decimal('jigyoNo', 50, 0);
            $table->text('jigyomei');
            $table->date('kanryo');
            $table->text('shoyusha');
            $table->text('innai');
            $table->text('jusho');
            $table->text('oaza');
            $table->text('aza');
            $table->text('chiban');
            $table->decimal('menseki', 10)->default(0);
            $table->decimal('zaiseki', 10)->default(0);
            $table->decimal('kingaku', 50)->default(0);
            $table->decimal('haidumi', 50)->default(0);
            $table->decimal('tesuryo', 50)->default(0);
            $table->decimal('hojokin', 50)->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('seisan');
    }
};
