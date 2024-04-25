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
        Schema::create('draft', function (Blueprint $table) {
            $table->integer('draftID', true);
            $table->bigInteger('userID');
            $table->string('userName');
            $table->date('CreatedDate');
            $table->integer('DraftTypeId');
            $table->string('DraftNumber', 50);
            $table->string('Title');
            $table->text('Contents');
            $table->string('Documents')->nullable();
            $table->binary('Attachment')->nullable();
            $table->binary('Attachment2')->nullable();
            $table->binary('Attachment3')->nullable();
            $table->binary('Attachment4')->nullable();
            $table->binary('Attachment5')->nullable();
            $table->integer('Multiplepage');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('draft');
    }
};
