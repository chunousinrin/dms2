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
        Schema::create('draft', function (Blueprint $table) {
            $table->integer('draftID', true);
            $table->bigInteger('userID');
            $table->string('userName');
            $table->date('CreatedDate');
            $table->integer('DraftTypeId');
            $table->string('DraftNumber', 50);
            $table->string('Title');
            $table->text('Contents');
            $table->string('Documents');
            $table->binary('Attachment');
            $table->binary('Attachment2');
            $table->binary('Attachment3');
            $table->binary('Attachment4');
            $table->binary('Attachment5');
            $table->integer('Multiplepage');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('draft');
    }
};
