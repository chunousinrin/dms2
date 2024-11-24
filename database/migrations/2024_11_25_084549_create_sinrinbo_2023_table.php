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
        Schema::create('sinrinbo_2023', function (Blueprint $table) {
            $table->comment('令和5年度');
            $table->bigInteger('SID')->primary();
            $table->string('ID', 15);
            $table->integer('年度');
            $table->string('計画区', 6);
            $table->string('県事務所', 7);
            $table->integer('新市町村');
            $table->integer('市町村');
            $table->integer('林班');
            $table->integer('準林班');
            $table->integer('小班');
            $table->integer('枝番');
            $table->string('対象外', 11);
            $table->string('大字', 7);
            $table->string('字', 7);
            $table->string('地番', 16);
            $table->string('合併', 7);
            $table->string('現に所有者住所', 5);
            $table->string('現に所有者番号', 19);
            $table->string('現に所有者共有有無', 30)->nullable();
            $table->string('林地所有者住所', 5);
            $table->string('林地所有者番号', 19);
            $table->string('林地所有者共有有無', 30)->nullable();
            $table->string('林地更新年月日', 30)->nullable();
            $table->string('登記所有者住所', 5)->nullable();
            $table->string('所有規模', 13);
            $table->string('在不在', 18);
            $table->string('立木所有形態', 7);
            $table->string('林地所有形態', 6)->nullable();
            $table->string('分収林', 5);
            $table->integer('面積');
            $table->string('施業方法', 13);
            $table->string('第1層区分', 3);
            $table->string('第1林種', 4);
            $table->string('第1針広別', 3)->nullable();
            $table->string('第1樹種', 7);
            $table->integer('第1歩合');
            $table->integer('第1林齢');
            $table->integer('第1齢級');
            $table->integer('第1面積');
            $table->integer('第1材積表')->nullable();
            $table->integer('第1材積計算樹種')->nullable();
            $table->integer('第1ＨＡ材積')->nullable();
            $table->integer('第1蓄積')->nullable();
            $table->string('第2層区分', 3)->nullable();
            $table->string('第2林種', 3)->nullable();
            $table->string('第2針広別', 3)->nullable();
            $table->string('第2樹種', 6)->nullable();
            $table->integer('第2歩合')->nullable();
            $table->integer('第2林齢')->nullable();
            $table->integer('第2齢級')->nullable();
            $table->integer('第2面積')->nullable();
            $table->integer('第2蓄積')->nullable();
            $table->string('第3林種', 3)->nullable();
            $table->string('第3針広別', 3)->nullable();
            $table->string('第3樹種', 6)->nullable();
            $table->integer('第3歩合')->nullable();
            $table->integer('第3林齢')->nullable();
            $table->integer('第3齢級')->nullable();
            $table->integer('第3面積')->nullable();
            $table->integer('第3蓄積')->nullable();
            $table->string('制普別', 3);
            $table->string('保安林1', 9)->nullable();
            $table->string('保安林2', 5)->nullable();
            $table->string('保安林3', 30)->nullable();
            $table->string('伐採方法', 4);
            $table->string('自然公園法', 13);
            $table->string('砂防法', 5);
            $table->string('岐阜県自然環境保全条例', 2);
            $table->string('急傾斜地法', 10);
            $table->string('岐阜県立自然公園条例', 10);
            $table->string('鳥獣害防止森林区域', 5);
            $table->integer('標準伐期齢')->nullable();
            $table->string('施業履歴', 2)->nullable();
            $table->integer('林道距離現在');
            $table->integer('標高');
            $table->integer('傾斜');

            $table->index(['SID', '現に所有者番号'], 'r5index');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sinrinbo_2023');
    }
};
