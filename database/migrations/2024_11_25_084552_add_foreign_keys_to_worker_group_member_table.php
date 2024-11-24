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
        Schema::table('worker_group_member', function (Blueprint $table) {
            $table->foreign(['WorkerGroupID'], 'worker_group_member_ibfk_1')->references(['WorkerGroupID'])->on('worker_group')->onUpdate('restrict')->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('worker_group_member', function (Blueprint $table) {
            $table->dropForeign('worker_group_member_ibfk_1');
        });
    }
};
