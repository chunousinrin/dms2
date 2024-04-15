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
        Schema::create('drs_reports', function (Blueprint $table) {
            $table->integer('No', true);
            $table->date('WorkingDay')->comment('勤務日');
            $table->integer('UserID');
            $table->integer('AmIndustry')->nullable()->comment('午前業種');
            $table->string('AmRemark', 200)->nullable()->comment('午前摘要');
            $table->integer('PmIndustry')->nullable()->comment('午後業種');
            $table->string('PmRemark', 200)->nullable()->comment('午後摘要');
            $table->string('Remark', 200)->nullable()->comment('備考');
            $table->integer('Print')->nullable()->default(-1)->comment('印刷');
            $table->integer('Weather1')->nullable()->default(0)->comment('天気1');
            $table->integer('Weather2')->nullable()->default(0)->comment('天気2');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('drs_reports');
    }
};
