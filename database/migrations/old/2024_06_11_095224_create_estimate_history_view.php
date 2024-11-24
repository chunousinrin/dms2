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
        DB::statement("CREATE VIEW `estimate_history` AS select `hst`.`CreatedDate` AS `CreatedDate`,`hst`.`UserID` AS `UserID`,`hst`.`UserName` AS `UserName`,`hst`.`classicationId` AS `classicationId`,`hst`.`Name` AS `NAME`,`hst`.`EstimateNumber` AS `EstimateNumber`,`hst`.`EstimateName` AS `EstimateName`,`hst`.`Customer` AS `Customer`,`hst`.`Location` AS `Location`,floor((sum(`hst`.`price`) * (1 + `hst`.`Tax`))) AS `price`,concat(`hst`.`EstimateNumber`,`hst`.`Customer`,`hst`.`EstimateName`,`hst`.`Location`,`hst`.`Remark`,`hst`.`Memo`) AS `keyword` from (select `dms`.`estimate`.`CreatedDate` AS `CreatedDate`,`dms`.`estimate`.`UserID` AS `UserID`,`dms`.`estimate`.`UserName` AS `UserName`,`dms`.`estimate`.`classicationId` AS `classicationId`,`dms`.`estimate`.`EstimateNumber` AS `EstimateNumber`,`dms`.`estimate`.`EstimateName` AS `EstimateName`,`dms`.`estimate`.`Customer` AS `Customer`,`dms`.`estimate`.`Location` AS `Location`,`dms`.`estimate`.`Remark` AS `Remark`,`dms`.`estimate`.`Memo` AS `Memo`,`dms`.`estimate`.`Tax` AS `Tax`,`dms`.`classication`.`Name` AS `Name`,if(((`dms`.`estimate`.`Quantity` <> 0) and (`dms`.`estimate`.`UnitPrice` <> 0)),(`dms`.`estimate`.`Quantity` * `dms`.`estimate`.`UnitPrice`),if(((`dms`.`estimate`.`UnitPrice` <> 0) and (`dms`.`estimate`.`Quantity` = 0)),`dms`.`estimate`.`UnitPrice`,NULL)) AS `price` from (`dms`.`estimate` left join `dms`.`classication` on((`dms`.`estimate`.`classicationId` = `dms`.`classication`.`Id`)))) `hst` group by `hst`.`CreatedDate`,`hst`.`UserID`,`hst`.`UserName`,`hst`.`classicationId`,`hst`.`EstimateNumber`,`hst`.`EstimateName`,`hst`.`Customer`,`hst`.`Location`,`hst`.`Tax`,`keyword`");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::statement("DROP VIEW IF EXISTS `estimate_history`");
    }
};
