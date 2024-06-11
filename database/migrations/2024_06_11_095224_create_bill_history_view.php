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
        DB::statement("CREATE VIEW `bill_history` AS select `hst`.`CreatedDate` AS `CreatedDate`,`hst`.`UserID` AS `UserID`,`hst`.`UserName` AS `UserName`,`hst`.`classicationId` AS `classicationId`,`hst`.`Name` AS `Name`,`hst`.`BillNumber` AS `BillNumber`,`hst`.`BizName` AS `BizName`,`hst`.`PaymentDate` AS `PaymentDate`,`hst`.`Customer` AS `Customer`,`hst`.`Location` AS `Location`,floor((sum(`hst`.`price`) * (1 + `hst`.`Tax`))) AS `price`,concat(`hst`.`BillNumber`,`hst`.`Customer`,`hst`.`BizName`,`hst`.`Location`,`hst`.`Remark`,`hst`.`Memo`) AS `keyword` from (select `dms`.`bill`.`CreatedDate` AS `CreatedDate`,`dms`.`bill`.`UserID` AS `UserID`,`dms`.`bill`.`UserName` AS `UserName`,`dms`.`bill`.`classicationId` AS `classicationId`,`dms`.`bill`.`BillNumber` AS `BillNumber`,`dms`.`bill`.`BizName` AS `BizName`,`dms`.`bill`.`PaymentDate` AS `PaymentDate`,`dms`.`bill`.`Customer` AS `Customer`,`dms`.`bill`.`Location` AS `Location`,`dms`.`bill`.`Remark` AS `Remark`,`dms`.`bill`.`Memo` AS `Memo`,`dms`.`classication`.`Name` AS `Name`,`dms`.`bill`.`Tax` AS `Tax`,if(((`dms`.`bill`.`Quantity` <> 0) and (`dms`.`bill`.`UnitPrice` <> 0)),(`dms`.`bill`.`Quantity` * `dms`.`bill`.`UnitPrice`),if(((`dms`.`bill`.`UnitPrice` <> 0) and (`dms`.`bill`.`Quantity` = 0)),`dms`.`bill`.`UnitPrice`,NULL)) AS `price` from (`dms`.`bill` left join `dms`.`classication` on((`dms`.`bill`.`classicationId` = `dms`.`classication`.`Id`)))) `hst` group by `hst`.`CreatedDate`,`hst`.`UserID`,`hst`.`UserName`,`hst`.`classicationId`,`hst`.`BillNumber`,`hst`.`BizName`,`hst`.`PaymentDate`,`hst`.`Customer`,`hst`.`Location`,`hst`.`Tax`,`keyword`");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::statement("DROP VIEW IF EXISTS `bill_history`");
    }
};
