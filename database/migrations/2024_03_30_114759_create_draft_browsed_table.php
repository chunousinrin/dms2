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
        Schema::create('draft_browsed', function (Blueprint $table) {
            $table->integer('ID', true);
            $table->string('DraftNumber', 50);
            $table->bigInteger('BrowseUserID')->nullable();
            $table->text('Comment');
            $table->date('Update_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('draft_browsed');
    }
};
