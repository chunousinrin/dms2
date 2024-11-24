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
        DB::statement("CREATE VIEW `drs_history` AS select `dms`.`drs_reports`.`No` AS `No`,`dms`.`drs_reports`.`WorkingDay` AS `WorkingDay`,`dms`.`drs_reports`.`UserID` AS `UserID`,`dms`.`drs_reports`.`AmIndustry` AS `AmIndustryID`,`dms`.`drs_reports`.`AmRemark` AS `AmRemark`,`dms`.`drs_reports`.`PmIndustry` AS `PmIndustryID`,`dms`.`drs_reports`.`PmRemark` AS `PmRemark`,`dms`.`drs_reports`.`Remark` AS `Remark`,`dms`.`drs_reports`.`Weather1` AS `Weather1`,`dms`.`drs_reports`.`Weather2` AS `Weather2`,`dms`.`users`.`name` AS `UserName`,`dms`.`drs_industries`.`Industry` AS `AmIndustry`,`drs_industries_1`.`Industry` AS `PmIndustry`,`dms`.`drs_weathers`.`Weather` AS `AmWeather`,`drs_weathers_1`.`Weather` AS `PmWeather`,concat(`dms`.`users`.`name`,`dms`.`drs_industries`.`Industry`,`drs_industries_1`.`Industry`,convert(`dms`.`drs_reports`.`Remark` using utf8mb4)) AS `keyword` from (((((`dms`.`drs_reports` left join `dms`.`drs_weathers` on((`dms`.`drs_reports`.`Weather1` = `dms`.`drs_weathers`.`WeatherID`))) left join `dms`.`drs_weathers` `drs_weathers_1` on((`dms`.`drs_reports`.`Weather2` = `drs_weathers_1`.`WeatherID`))) left join `dms`.`drs_industries` on((`dms`.`drs_reports`.`AmIndustry` = `dms`.`drs_industries`.`ID`))) left join `dms`.`drs_industries` `drs_industries_1` on((`dms`.`drs_reports`.`PmIndustry` = `drs_industries_1`.`ID`))) left join `dms`.`users` on((`dms`.`drs_reports`.`UserID` = `dms`.`users`.`id`))) order by `dms`.`drs_reports`.`WorkingDay` desc,`dms`.`drs_reports`.`UserID`");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::statement("DROP VIEW IF EXISTS `drs_history`");
    }
};
