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
        DB::statement("CREATE VIEW `estimate_history` AS select `hst`.`CreatedDate` AS `CreatedDate`,`hst`.`UserID` AS `UserID`,`hst`.`UserName` AS `UserName`,`hst`.`classicationId` AS `classicationId`,`hst`.`Name` AS `NAME`,`hst`.`EstimateNumber` AS `EstimateNumber`,`hst`.`EstimateName` AS `EstimateName`,`hst`.`Customer` AS `Customer`,`hst`.`Location` AS `Location`,floor(sum(`hst`.`price`) * (1 + `hst`.`Tax`)) AS `price`,concat(`hst`.`EstimateNumber`,`hst`.`Customer`,`hst`.`EstimateName`,`hst`.`Location`,`hst`.`Remark`,`hst`.`Memo`) AS `keyword` from (select `cf756484_dms`.`estimate`.`CreatedDate` AS `CreatedDate`,`cf756484_dms`.`estimate`.`UserID` AS `UserID`,`cf756484_dms`.`estimate`.`UserName` AS `UserName`,`cf756484_dms`.`estimate`.`classicationId` AS `classicationId`,`cf756484_dms`.`estimate`.`EstimateNumber` AS `EstimateNumber`,`cf756484_dms`.`estimate`.`EstimateName` AS `EstimateName`,`cf756484_dms`.`estimate`.`Customer` AS `Customer`,`cf756484_dms`.`estimate`.`Location` AS `Location`,`cf756484_dms`.`estimate`.`Remark` AS `Remark`,`cf756484_dms`.`estimate`.`Memo` AS `Memo`,`cf756484_dms`.`estimate`.`Tax` AS `Tax`,`cf756484_dms`.`classication`.`Name` AS `Name`,if(`cf756484_dms`.`estimate`.`Quantity` <> 0 and `cf756484_dms`.`estimate`.`UnitPrice` <> 0,`cf756484_dms`.`estimate`.`Quantity` * `cf756484_dms`.`estimate`.`UnitPrice`,if(`cf756484_dms`.`estimate`.`UnitPrice` <> 0 and `cf756484_dms`.`estimate`.`Quantity` = 0,`cf756484_dms`.`estimate`.`UnitPrice`,NULL)) AS `price` from (`cf756484_dms`.`estimate` left join `cf756484_dms`.`classication` on(`cf756484_dms`.`estimate`.`classicationId` = `cf756484_dms`.`classication`.`Id`))) `hst` group by `hst`.`CreatedDate`,`hst`.`UserID`,`hst`.`UserName`,`hst`.`classicationId`,`hst`.`EstimateNumber`,`hst`.`EstimateName`,`hst`.`Customer`,`hst`.`Location`,`hst`.`Tax`,concat(`hst`.`EstimateNumber`,`hst`.`Customer`,`hst`.`EstimateName`,`hst`.`Location`,`hst`.`Remark`,`hst`.`Memo`)");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::statement("DROP VIEW IF EXISTS `estimate_history`");
    }
};
