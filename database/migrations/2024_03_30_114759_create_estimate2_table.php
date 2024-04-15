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
        Schema::create('estimate2', function (Blueprint $table) {
            $table->integer('Es2ID', true);
            $table->integer('classicationId')->comment('種類');
            $table->integer('UserID')->comment('作成者ID');
            $table->string('UserName', 50)->comment('作成者');
            $table->string('StaffDisplay', 5)->comment('作成者表示');
            $table->string('Es2Number', 50)->comment('見積番号');
            $table->date('CreatedDate')->comment('作成日');
            $table->string('CDDisplay', 5)->comment('発行日表示');
            $table->integer('Branch')->comment('支所');
            $table->string('Customer', 50)->comment('顧客名');
            $table->string('CustomerAdd', 50)->comment('顧客宛名');
            $table->string('Es2BizName', 50)->comment('業務名称');
            $table->string('Es2Location', 50)->comment('事業場所');
            $table->string('WorksType', 50)->comment('工種');
            $table->date('WorksPeriod1')->nullable()->comment('業務期間1');
            $table->date('WorksPeriod2')->nullable()->comment('業務期間2');
            $table->date('EffectiveDate')->nullable()->comment('見積有効期限');
            $table->integer('Es2UnitPrice')->comment('金額表示');
            $table->text('NB')->comment('摘要');
            $table->string('Summary', 100)->comment('品名/規格/仕様等');
            $table->string('Quantity', 100)->comment('数量');
            $table->string('Unit', 50)->comment('単位');
            $table->string('UnitPrice', 100)->comment('単価');
            $table->string('Amount', 100)->comment('金額');
            $table->string('Remark', 100)->comment('行摘要');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('estimate2');
    }
};
