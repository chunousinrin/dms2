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
        Schema::create('invoices', function (Blueprint $table) {
            $table->id();
            $table->string('vendor');
            $table->date('invoice_date');
            $table->decimal('amount', 12, 2);
            $table->string('file_path');
            $table->text('extracted_text')->nullable();

            // 外部キー
            $table->unsignedBigInteger('InvoiceTypeID')->nullable();
            $table->foreign('InvoiceTypeID')
                ->references('InvoiceTypeID')
                ->on('invoice_type')
                ->cascadeOnUpdate()
                ->nullOnDelete();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('invoices');
    }
};
