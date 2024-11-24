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
        DB::statement("CREATE VIEW `bill_history` AS select `hst`.`CreatedDate` AS `CreatedDate`,`hst`.`UserID` AS `UserID`,`hst`.`UserName` AS `UserName`,`hst`.`classicationId` AS `classicationId`,`hst`.`Name` AS `Name`,`hst`.`BillNumber` AS `BillNumber`,`hst`.`BizName` AS `BizName`,`hst`.`PaymentDate` AS `PaymentDate`,`hst`.`Customer` AS `Customer`,`hst`.`Location` AS `Location`,floor(sum(`hst`.`price`) * (1 + `hst`.`Tax`)) AS `price`,concat(`hst`.`BillNumber`,`hst`.`Customer`,`hst`.`BizName`,`hst`.`Location`,`hst`.`Remark`,`hst`.`Memo`) AS `keyword` from (select `cf756484_dms`.`bill`.`CreatedDate` AS `CreatedDate`,`cf756484_dms`.`bill`.`UserID` AS `UserID`,`cf756484_dms`.`bill`.`UserName` AS `UserName`,`cf756484_dms`.`bill`.`classicationId` AS `classicationId`,`cf756484_dms`.`bill`.`BillNumber` AS `BillNumber`,`cf756484_dms`.`bill`.`BizName` AS `BizName`,`cf756484_dms`.`bill`.`PaymentDate` AS `PaymentDate`,`cf756484_dms`.`bill`.`Customer` AS `Customer`,`cf756484_dms`.`bill`.`Location` AS `Location`,`cf756484_dms`.`bill`.`Remark` AS `Remark`,`cf756484_dms`.`bill`.`Memo` AS `Memo`,`cf756484_dms`.`classication`.`Name` AS `Name`,`cf756484_dms`.`bill`.`Tax` AS `Tax`,if(`cf756484_dms`.`bill`.`Quantity` <> 0 and `cf756484_dms`.`bill`.`UnitPrice` <> 0,`cf756484_dms`.`bill`.`Quantity` * `cf756484_dms`.`bill`.`UnitPrice`,if(`cf756484_dms`.`bill`.`UnitPrice` <> 0 and `cf756484_dms`.`bill`.`Quantity` = 0,`cf756484_dms`.`bill`.`UnitPrice`,NULL)) AS `price` from (`cf756484_dms`.`bill` left join `cf756484_dms`.`classication` on(`cf756484_dms`.`bill`.`classicationId` = `cf756484_dms`.`classication`.`Id`))) `hst` group by `hst`.`CreatedDate`,`hst`.`UserID`,`hst`.`UserName`,`hst`.`classicationId`,`hst`.`BillNumber`,`hst`.`BizName`,`hst`.`PaymentDate`,`hst`.`Customer`,`hst`.`Location`,`hst`.`Tax`,concat(`hst`.`BillNumber`,`hst`.`Customer`,`hst`.`BizName`,`hst`.`Location`,`hst`.`Remark`,`hst`.`Memo`)");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::statement("DROP VIEW IF EXISTS `bill_history`");
    }
};
