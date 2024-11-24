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
        DB::statement("CREATE VIEW `eshistory` AS select `dms`.`estimate_history`.`CreatedDate` AS `CreatedDate`,`dms`.`estimate_history`.`UserID` AS `UserID`,`dms`.`estimate_history`.`UserName` AS `UserName`,`dms`.`estimate_history`.`classicationId` AS `classicationId`,`dms`.`estimate_history`.`NAME` AS `NAME`,`dms`.`estimate_history`.`EstimateNumber` AS `EstimateNumber`,`dms`.`estimate_history`.`EstimateName` AS `EstimateName`,`dms`.`estimate_history`.`Customer` AS `Customer`,`dms`.`estimate_history`.`Location` AS `Location`,`dms`.`estimate_history`.`price` AS `price`,`dms`.`estimate_history`.`keyword` AS `keyword` from `dms`.`estimate_history` union all select `dms`.`estimate2_history`.`CreatedDate` AS `CreatedDate`,`dms`.`estimate2_history`.`UserID` AS `UserID`,`dms`.`estimate2_history`.`UserName` AS `UserName`,`dms`.`estimate2_history`.`classicationId` AS `classicationId`,`dms`.`estimate2_history`.`Name` AS `Name`,`dms`.`estimate2_history`.`Es2Number` AS `Es2Number`,`dms`.`estimate2_history`.`Es2BizName` AS `Es2BizName`,`dms`.`estimate2_history`.`Customer` AS `Customer`,`dms`.`estimate2_history`.`Es2Location` AS `Es2Location`,`dms`.`estimate2_history`.`price` AS `price`,`dms`.`estimate2_history`.`keyword` AS `keyword` from `dms`.`estimate2_history` order by `CreatedDate` desc");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::statement("DROP VIEW IF EXISTS `eshistory`");
    }
};
