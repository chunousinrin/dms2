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
        Schema::create('accountbook', function (Blueprint $table) {
            $table->integer('ID', true);
            $table->string('ErrlNumber', 50);
            $table->integer('UserID')->comment('作成者');
            $table->date('TradingDate')->comment('取引日');
            $table->string('RIType', 10)->comment('受領Receipt/発行Issue');
            $table->string('DocumentType', 10)->comment('書類種類');
            $table->string('Customer', 100)->comment('取引先');
            $table->integer('Amount')->comment('金額');
            $table->string('FileName', 200)->comment('ファイル名');
            $table->text('Remark')->comment('備考');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('accountbook');
    }
};
