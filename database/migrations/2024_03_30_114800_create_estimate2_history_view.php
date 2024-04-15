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
        DB::statement("CREATE VIEW `estimate2_history` AS select `dms`.`estimate2`.`CreatedDate` AS `CreatedDate`,`dms`.`estimate2`.`UserID` AS `UserID`,`dms`.`estimate2`.`UserName` AS `UserName`,`dms`.`estimate2`.`classicationId` AS `classicationId`,`dms`.`classication`.`Name` AS `Name`,`dms`.`estimate2`.`Es2Number` AS `Es2Number`,`dms`.`estimate2`.`Es2BizName` AS `Es2BizName`,`dms`.`estimate2`.`Customer` AS `Customer`,`dms`.`estimate2`.`Es2Location` AS `Es2Location`,sum(`dms`.`estimate2`.`Amount`) AS `price`,concat(`dms`.`estimate2`.`Es2Number`,`dms`.`estimate2`.`Customer`,`dms`.`estimate2`.`Es2BizName`,`dms`.`estimate2`.`Es2Location`,replace(replace(`dms`.`estimate2`.`NB`,char(13),''),char(10),'')) AS `keyword` from (`dms`.`estimate2` left join `dms`.`classication` on((`dms`.`estimate2`.`classicationId` = `dms`.`classication`.`Id`))) where (`dms`.`estimate2`.`Summary` not in ('直接作業代小計','工事原価')) group by `dms`.`estimate2`.`CreatedDate`,`dms`.`estimate2`.`UserID`,`dms`.`estimate2`.`UserName`,`dms`.`estimate2`.`classicationId`,`dms`.`classication`.`Name`,`dms`.`estimate2`.`Es2Number`,`dms`.`estimate2`.`Es2BizName`,`dms`.`estimate2`.`Customer`,`dms`.`estimate2`.`Es2Location`,`keyword`");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::statement("DROP VIEW IF EXISTS `estimate2_history`");
    }
};
