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
        DB::statement("CREATE VIEW `drs_history` AS select `cf756484_dms`.`drs_reports`.`No` AS `No`,`cf756484_dms`.`drs_reports`.`WorkingDay` AS `WorkingDay`,`cf756484_dms`.`drs_reports`.`UserID` AS `UserID`,`cf756484_dms`.`drs_reports`.`AmIndustry` AS `AmIndustryID`,`cf756484_dms`.`drs_reports`.`AmRemark` AS `AmRemark`,`cf756484_dms`.`drs_reports`.`PmIndustry` AS `PmIndustryID`,`cf756484_dms`.`drs_reports`.`PmRemark` AS `PmRemark`,`cf756484_dms`.`drs_reports`.`Remark` AS `Remark`,`cf756484_dms`.`drs_reports`.`Weather1` AS `Weather1`,`cf756484_dms`.`drs_reports`.`Weather2` AS `Weather2`,`cf756484_dms`.`users`.`name` AS `UserName`,`cf756484_dms`.`drs_industries`.`Industry` AS `AmIndustry`,`drs_industries_1`.`Industry` AS `PmIndustry`,`cf756484_dms`.`drs_weathers`.`Weather` AS `AmWeather`,`drs_weathers_1`.`Weather` AS `PmWeather`,concat(`cf756484_dms`.`users`.`name`,`cf756484_dms`.`drs_industries`.`Industry`,`drs_industries_1`.`Industry`,convert(`cf756484_dms`.`drs_reports`.`Remark` using utf8mb4)) AS `keyword` from (((((`cf756484_dms`.`drs_reports` left join `cf756484_dms`.`drs_weathers` on(`cf756484_dms`.`drs_reports`.`Weather1` = `cf756484_dms`.`drs_weathers`.`WeatherID`)) left join `cf756484_dms`.`drs_weathers` `drs_weathers_1` on(`cf756484_dms`.`drs_reports`.`Weather2` = `drs_weathers_1`.`WeatherID`)) left join `cf756484_dms`.`drs_industries` on(`cf756484_dms`.`drs_reports`.`AmIndustry` = `cf756484_dms`.`drs_industries`.`ID`)) left join `cf756484_dms`.`drs_industries` `drs_industries_1` on(`cf756484_dms`.`drs_reports`.`PmIndustry` = `drs_industries_1`.`ID`)) left join `cf756484_dms`.`users` on(`cf756484_dms`.`drs_reports`.`UserID` = `cf756484_dms`.`users`.`id`)) order by `cf756484_dms`.`drs_reports`.`WorkingDay` desc,`cf756484_dms`.`drs_reports`.`UserID`");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::statement("DROP VIEW IF EXISTS `drs_history`");
    }
};
