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
        DB::statement("CREATE VIEW `eshistory` AS select `cf756484_dms`.`estimate_history`.`CreatedDate` AS `CreatedDate`,`cf756484_dms`.`estimate_history`.`UserID` AS `UserID`,`cf756484_dms`.`estimate_history`.`UserName` AS `UserName`,`cf756484_dms`.`estimate_history`.`classicationId` AS `classicationId`,`cf756484_dms`.`estimate_history`.`NAME` AS `NAME`,`cf756484_dms`.`estimate_history`.`EstimateNumber` AS `EstimateNumber`,`cf756484_dms`.`estimate_history`.`EstimateName` AS `EstimateName`,`cf756484_dms`.`estimate_history`.`Customer` AS `Customer`,`cf756484_dms`.`estimate_history`.`Location` AS `Location`,`cf756484_dms`.`estimate_history`.`price` AS `price`,`cf756484_dms`.`estimate_history`.`keyword` AS `keyword` from `cf756484_dms`.`estimate_history` union all select `cf756484_dms`.`estimate2_history`.`CreatedDate` AS `CreatedDate`,`cf756484_dms`.`estimate2_history`.`UserID` AS `UserID`,`cf756484_dms`.`estimate2_history`.`UserName` AS `UserName`,`cf756484_dms`.`estimate2_history`.`classicationId` AS `classicationId`,`cf756484_dms`.`estimate2_history`.`Name` AS `Name`,`cf756484_dms`.`estimate2_history`.`Es2Number` AS `Es2Number`,`cf756484_dms`.`estimate2_history`.`Es2BizName` AS `Es2BizName`,`cf756484_dms`.`estimate2_history`.`Customer` AS `Customer`,`cf756484_dms`.`estimate2_history`.`Es2Location` AS `Es2Location`,`cf756484_dms`.`estimate2_history`.`price` AS `price`,`cf756484_dms`.`estimate2_history`.`keyword` AS `keyword` from `cf756484_dms`.`estimate2_history` order by `CreatedDate` desc");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::statement("DROP VIEW IF EXISTS `eshistory`");
    }
};
