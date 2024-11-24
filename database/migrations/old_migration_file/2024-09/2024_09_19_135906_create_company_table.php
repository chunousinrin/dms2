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
        Schema::create('company', function (Blueprint $table) {
            $table->integer('BranchId', true);
            $table->string('BranchName');
            $table->string('Representative');
            $table->binary('SignatureStamp');
            $table->string('PostCode', 20);
            $table->string('Address');
            $table->string('Phone', 20);
            $table->string('Fax', 20);
            $table->string('InvoiceNo', 30)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('company');
    }
};
