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
        DB::statement("CREATE VIEW `working_time` AS select `wt`.`ID` AS `ID`,`wt`.`UserID` AS `UserID`,`wt`.`WorkingDay` AS `WorkingDay`,`wt`.`AttendanceTime` AS `AttendanceTime`,`wt`.`OutingTime` AS `OutingTime`,`wt`.`ReentryTime` AS `ReentryTime`,`wt`.`LeavingTime` AS `LeavingTime`,`wt`.`Remark` AS `Remark`,`wt`.`WorkingHours` AS `WorkingHours`,hour(`wt`.`WorkingHours`) * 3600 + minute(`wt`.`WorkingHours`) * 60 AS `tm`,concat(`wt`.`WorkingDay`,' ',`wt`.`AttendanceTime`,' ',`wt`.`OutingTime`,' ',`wt`.`ReentryTime`,' ',`wt`.`LeavingTime`,' ',`wt`.`WorkingHours`,`wt`.`Remark`) AS `keyword` from (select `cf756484_dms`.`attendance`.`ID` AS `ID`,`cf756484_dms`.`attendance`.`UserID` AS `UserID`,`cf756484_dms`.`attendance`.`WorkingDay` AS `WorkingDay`,`cf756484_dms`.`attendance`.`AttendanceTime` AS `AttendanceTime`,`cf756484_dms`.`attendance`.`OutingTime` AS `OutingTime`,`cf756484_dms`.`attendance`.`ReentryTime` AS `ReentryTime`,`cf756484_dms`.`attendance`.`LeavingTime` AS `LeavingTime`,`cf756484_dms`.`attendance`.`Remark` AS `Remark`,timediff(ifnull(timediff(`cf756484_dms`.`attendance`.`LeavingTime`,`cf756484_dms`.`attendance`.`AttendanceTime`),0),ifnull(timediff(`cf756484_dms`.`attendance`.`ReentryTime`,`cf756484_dms`.`attendance`.`OutingTime`),0)) AS `WorkingHours` from `cf756484_dms`.`attendance`) `wt`");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::statement("DROP VIEW IF EXISTS `working_time`");
    }
};
