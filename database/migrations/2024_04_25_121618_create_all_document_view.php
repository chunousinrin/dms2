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
        DB::statement("CREATE VIEW `all_document` AS select `alldoc`.`見積書` AS `DocType`,`alldoc`.`CreatedDate` AS `CreatedDate`,`alldoc`.`UserName` AS `UserName`,`alldoc`.`EstimateName` AS `Title`,`alldoc`.`price` AS `price` from (select '見積書' AS `見積書`,`cf756484_dms`.`estimate_history`.`CreatedDate` AS `CreatedDate`,`cf756484_dms`.`estimate_history`.`UserName` AS `UserName`,`cf756484_dms`.`estimate_history`.`EstimateName` AS `EstimateName`,`cf756484_dms`.`estimate_history`.`price` AS `price` from `cf756484_dms`.`estimate_history` union all select '請求書' AS `請求書`,`cf756484_dms`.`bill_history`.`CreatedDate` AS `CreatedDate`,`cf756484_dms`.`bill_history`.`UserName` AS `UserName`,`cf756484_dms`.`bill_history`.`BizName` AS `BizName`,`cf756484_dms`.`bill_history`.`price` AS `price` from `cf756484_dms`.`bill_history` union all select '稟議書' AS `稟議書`,`cf756484_dms`.`draft_history`.`CreatedDate` AS `CreatedDate`,`cf756484_dms`.`draft_history`.`userName` AS `userName`,`cf756484_dms`.`draft_history`.`Title` AS `Title`,'0' AS `price` from `cf756484_dms`.`draft_history`) `alldoc` order by `alldoc`.`CreatedDate` desc limit 0,10");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::statement("DROP VIEW IF EXISTS `all_document`");
    }
};
