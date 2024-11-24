<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        DB::statement("CREATE VIEW `license_history` AS select `cf756484_dms`.`license`.`LicenseID` AS `LicenseID`,`cf756484_dms`.`license`.`ReferenceNumber` AS `ReferenceNumber`,`cf756484_dms`.`license`.`BranchNumber` AS `BranchNumber`,`cf756484_dms`.`license`.`FacilityName` AS `FacilityName`,`cf756484_dms`.`license`.`ForestReserve` AS `ForestReserve`,`cf756484_dms`.`license`.`Location` AS `Location`,`cf756484_dms`.`license`.`Stock` AS `Stock`,`cf756484_dms`.`license`.`Applicant` AS `Applicant`,`cf756484_dms`.`license`.`Contact` AS `Contact`,`cf756484_dms`.`license`.`PermittedArea` AS `PermittedArea`,`cf756484_dms`.`license`.`ApplicationDate` AS `ApplicationDate`,`cf756484_dms`.`license`.`PermitDate` AS `PermitDate`,`cf756484_dms`.`license`.`InstructionNumber` AS `InstructionNumber`,`cf756484_dms`.`license`.`LicensedStartDate` AS `LicensedStartDate`,`cf756484_dms`.`license`.`LicensedEndDate` AS `LicensedEndDate`,`cf756484_dms`.`license`.`Completed` AS `Completed`,`cf756484_dms`.`license`.`DeforestationDate` AS `DeforestationDate`,`cf756484_dms`.`license`.`PlantingDate` AS `PlantingDate`,`cf756484_dms`.`license`.`SubmissionDate` AS `SubmissionDate`,`cf756484_dms`.`license`.`StartDate` AS `StartDate`,`cf756484_dms`.`license`.`CompletionDate` AS `CompletionDate`,`cf756484_dms`.`license`.`Remark` AS `Remark`,concat(`cf756484_dms`.`license`.`FacilityName`,`cf756484_dms`.`license`.`Location`,`cf756484_dms`.`license`.`Applicant`,`cf756484_dms`.`license`.`Remark`) AS `keyword`,(to_days(curdate()) - to_days(`cf756484_dms`.`license`.`LicensedEndDate`)) * -1 AS `lmt`,if(to_days(curdate()) - to_days(`cf756484_dms`.`license`.`LicensedEndDate`) > 0,'期限切','有効') AS `validity` from `cf756484_dms`.`license`");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::statement("DROP VIEW IF EXISTS `license_history`");
    }
};
