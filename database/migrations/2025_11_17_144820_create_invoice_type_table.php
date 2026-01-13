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
        Schema::create('invoice_type', function (Blueprint $table) {
            $table->bigIncrements('InvoiceTypeID'); // 主キー
            $table->string('DocumentType');          // 種類名（請求書/納品書/見積書）
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('invoice_type');
    }
};
