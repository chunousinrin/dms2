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
        Schema::create('zaiseki', function (Blueprint $table) {
            $table->integer('ID', true);
            $table->decimal('kingaku', 20, 0)->default(0);
            $table->decimal('batsuboku', 20, 0)->default(0);
            $table->decimal('shuzai', 20, 0)->default(0);
            $table->decimal('zozai', 20, 0)->default(0);
            $table->decimal('tsumikomi', 20, 0)->default(0);
            $table->decimal('shokeihi', 20)->default(0);
            $table->decimal('chokusetsuhi', 20, 0)->default(0);
            $table->decimal('chosahi', 20, 0)->default(0);
            $table->decimal('gokeiktanka', 20, 0)->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('zaiseki');
    }
};
