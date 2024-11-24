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
        DB::statement("CREATE VIEW `estimate2_history` AS select `cf756484_dms`.`estimate2`.`CreatedDate` AS `CreatedDate`,`cf756484_dms`.`estimate2`.`UserID` AS `UserID`,`cf756484_dms`.`estimate2`.`UserName` AS `UserName`,`cf756484_dms`.`estimate2`.`classicationId` AS `classicationId`,`cf756484_dms`.`classication`.`Name` AS `Name`,`cf756484_dms`.`estimate2`.`Es2Number` AS `Es2Number`,`cf756484_dms`.`estimate2`.`Es2BizName` AS `Es2BizName`,`cf756484_dms`.`estimate2`.`Customer` AS `Customer`,`cf756484_dms`.`estimate2`.`Es2Location` AS `Es2Location`,sum(`cf756484_dms`.`estimate2`.`Amount`) AS `price`,concat(`cf756484_dms`.`estimate2`.`Es2Number`,`cf756484_dms`.`estimate2`.`Customer`,`cf756484_dms`.`estimate2`.`Es2BizName`,`cf756484_dms`.`estimate2`.`Es2Location`,replace(replace(`cf756484_dms`.`estimate2`.`NB`,char(13),''),char(10),'')) AS `keyword` from (`cf756484_dms`.`estimate2` left join `cf756484_dms`.`classication` on(`cf756484_dms`.`estimate2`.`classicationId` = `cf756484_dms`.`classication`.`Id`)) where `cf756484_dms`.`estimate2`.`Summary` not in ('直接作業代小計','工事原価') group by `cf756484_dms`.`estimate2`.`CreatedDate`,`cf756484_dms`.`estimate2`.`UserID`,`cf756484_dms`.`estimate2`.`UserName`,`cf756484_dms`.`estimate2`.`classicationId`,`cf756484_dms`.`classication`.`Name`,`cf756484_dms`.`estimate2`.`Es2Number`,`cf756484_dms`.`estimate2`.`Es2BizName`,`cf756484_dms`.`estimate2`.`Customer`,`cf756484_dms`.`estimate2`.`Es2Location`,concat(`cf756484_dms`.`estimate2`.`Es2Number`,`cf756484_dms`.`estimate2`.`Customer`,`cf756484_dms`.`estimate2`.`Es2BizName`,`cf756484_dms`.`estimate2`.`Es2Location`,replace(replace(`cf756484_dms`.`estimate2`.`NB`,char(13),''),char(10),''))");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::statement("DROP VIEW IF EXISTS `estimate2_history`");
    }
};
