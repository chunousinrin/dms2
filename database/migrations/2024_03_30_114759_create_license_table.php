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
        Schema::create('license', function (Blueprint $table) {
            $table->integer('LicenseID', true);
            $table->integer('ReferenceNumber')->nullable()->comment('整理番号');
            $table->integer('BranchNumber')->nullable()->comment('枝番');
            $table->string('FacilityName')->nullable()->comment('施設名称');
            $table->string('ForestReserve', 50)->nullable()->comment('保安林種');
            $table->string('Location')->nullable()->comment('森林所在地');
            $table->decimal('Stock', 50)->nullable()->comment('筆数');
            $table->string('Applicant')->nullable()->comment('申請者');
            $table->string('Contact')->nullable()->comment('連絡先');
            $table->decimal('PermittedArea', 50, 5)->nullable()->comment('許可面積');
            $table->date('ApplicationDate')->nullable()->comment('申請年月日');
            $table->date('PermitDate')->nullable()->comment('許可年月日');
            $table->string('InstructionNumber', 50)->nullable()->comment('指令番号');
            $table->date('LicensedStartDate')->nullable()->comment('許可始期');
            $table->date('LicensedEndDate')->nullable()->comment('許可終期');
            $table->string('Completed', 50)->nullable()->comment('完了');
            $table->date('DeforestationDate')->nullable()->comment('皆伐完了日');
            $table->date('PlantingDate')->nullable()->comment('植栽完了日');
            $table->date('SubmissionDate')->nullable()->comment('提出日');
            $table->date('StartDate')->nullable()->comment('着手日');
            $table->date('CompletionDate')->nullable()->comment('完了日');
            $table->text('Remark')->nullable()->comment('備考');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('license');
    }
};
