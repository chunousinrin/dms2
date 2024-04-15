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
        DB::statement("CREATE VIEW `all_document` AS select `alldoc`.`見積書` AS `DocType`,`alldoc`.`CreatedDate` AS `CreatedDate`,`alldoc`.`UserName` AS `UserName`,`alldoc`.`EstimateName` AS `Title`,`alldoc`.`price` AS `price` from (select '見積書' AS `見積書`,`dms`.`estimate_history`.`CreatedDate` AS `CreatedDate`,`dms`.`estimate_history`.`UserName` AS `UserName`,`dms`.`estimate_history`.`EstimateName` AS `EstimateName`,`dms`.`estimate_history`.`price` AS `price` from `dms`.`estimate_history` union all select '請求書' AS `請求書`,`dms`.`bill_history`.`CreatedDate` AS `CreatedDate`,`dms`.`bill_history`.`UserName` AS `UserName`,`dms`.`bill_history`.`BizName` AS `BizName`,`dms`.`bill_history`.`price` AS `price` from `dms`.`bill_history` union all select '稟議書' AS `稟議書`,`dms`.`draft_history`.`CreatedDate` AS `CreatedDate`,`dms`.`draft_history`.`userName` AS `userName`,`dms`.`draft_history`.`Title` AS `Title`,'0' AS `price` from `dms`.`draft_history`) `alldoc` order by `alldoc`.`CreatedDate` desc limit 0,10");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::statement("DROP VIEW IF EXISTS `all_document`");
    }
};
