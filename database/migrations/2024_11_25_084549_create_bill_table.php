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
        Schema::create('bill', function (Blueprint $table) {
            $table->integer('BillID', true);
            $table->integer('classicationId')->comment('分類');
            $table->integer('UserID')->comment('作成者ID');
            $table->string('UserName', 50)->comment('作成者');
            $table->date('CreatedDate')->comment('作成日');
            $table->integer('Branch')->comment('請求者ID');
            $table->string('BillNumber', 50)->index('idxbillnumber')->comment('請求番号');
            $table->string('BizName', 50)->index('idxbizname')->comment('事業名');
            $table->integer('CustomerID')->nullable()->comment('顧客ID');
            $table->string('Customer', 50)->comment('顧客名');
            $table->string('CustomerAdd', 50)->comment('敬称');
            $table->string('Location', 50)->comment('事業場所');
            $table->string('CompletionDate', 20)->comment('完了日');
            $table->string('PaymentDueDate', 20)->comment('支払期限');
            $table->string('PaymentDate', 20)->comment('入金日');
            $table->decimal('Tax', 5)->default(0)->comment('消費税率');
            $table->text('Remark')->comment('備考');
            $table->text('Memo')->comment('メモ');
            $table->string('Summary', 100)->comment('摘要');
            $table->string('Quantity', 100)->comment('数量');
            $table->string('Unit', 50)->comment('単位');
            $table->string('UnitPrice', 100)->comment('単価');
            $table->integer('StaffDisplay')->comment('作成者表示');
            $table->integer('CDDisplay')->comment('作成日表示');
            $table->string('CompletionDate2', 20)->comment('完了日2');
            $table->integer('BankID1');
            $table->integer('BankID2');
            $table->integer('BankID3');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bill');
    }
};
