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
        Schema::create('estimate', function (Blueprint $table) {
            $table->integer('EstimateID', true);
            $table->integer('classicationId')->comment('分類');
            $table->integer('UserID')->comment('作成者ID');
            $table->string('UserName', 50)->comment('作成者');
            $table->date('CreatedDate')->comment('作成日');
            $table->integer('Branch')->comment('支所ID');
            $table->string('EstimateNumber', 50)->comment('見積番号');
            $table->string('EstimateName', 50)->comment('事業名');
            $table->integer('CustomerID')->nullable()->comment('顧客ID');
            $table->string('Customer', 50)->comment('顧客名');
            $table->string('CustomerAdd', 50)->comment('敬称');
            $table->string('Location', 50)->comment('事業場所「');
            $table->string('ScheduledDate', 20)->comment('実施予定日');
            $table->string('EffectiveDate', 20)->comment('見積有効期限');
            $table->decimal('Tax', 5)->default(0)->comment('消費税率');
            $table->text('Remark')->comment('備考');
            $table->text('Memo')->comment('メモ');
            $table->string('Summary', 100)->comment('摘要');
            $table->string('Quantity', 100)->comment('数量');
            $table->string('Unit', 50)->comment('単位');
            $table->string('UnitPrice', 100)->comment('単価');
            $table->integer('StaffDisplay')->comment('作成者表示	');
            $table->integer('CDDisplay')->comment('作成日表示	');
            $table->integer('UnitPriceEstimate')->comment('金額表示');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('estimate');
    }
};
