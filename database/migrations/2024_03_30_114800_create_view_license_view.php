<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement("CREATE VIEW `view_license` AS select `dms`.`license`.`LicenseID` AS `LicenseID`,`dms`.`license`.`ReferenceNumber` AS `ReferenceNumber`,`dms`.`license`.`BranchNumber` AS `BranchNumber`,`dms`.`license`.`FacilityName` AS `FacilityName`,`dms`.`license`.`ForestReserve` AS `ForestReserve`,`dms`.`license`.`Location` AS `Location`,`dms`.`license`.`Stock` AS `Stock`,`dms`.`license`.`Applicant` AS `Applicant`,`dms`.`license`.`Contact` AS `Contact`,`dms`.`license`.`PermittedArea` AS `PermittedArea`,`dms`.`license`.`ApplicationDate` AS `ApplicationDate`,`dms`.`license`.`PermitDate` AS `PermitDate`,`dms`.`license`.`InstructionNumber` AS `InstructionNumber`,`dms`.`license`.`LicensedStartDate` AS `LicensedStartDate`,`dms`.`license`.`LicensedEndDate` AS `LicensedEndDate`,`dms`.`license`.`Completed` AS `Completed`,`dms`.`license`.`DeforestationDate` AS `DeforestationDate`,`dms`.`license`.`PlantingDate` AS `PlantingDate`,`dms`.`license`.`SubmissionDate` AS `SubmissionDate`,`dms`.`license`.`Remark` AS `Remark`,(to_days(`dms`.`license`.`LicensedEndDate`) - to_days(curdate())) AS `ld` from `dms`.`license`");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::statement("DROP VIEW IF EXISTS `view_license`");
    }
};
