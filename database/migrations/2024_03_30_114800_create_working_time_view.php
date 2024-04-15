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
        DB::statement("CREATE VIEW `working_time` AS select `wt`.`ID` AS `ID`,`wt`.`UserID` AS `UserID`,`wt`.`WorkingDay` AS `WorkingDay`,`wt`.`AttendanceTime` AS `AttendanceTime`,`wt`.`OutingTime` AS `OutingTime`,`wt`.`ReentryTime` AS `ReentryTime`,`wt`.`LeavingTime` AS `LeavingTime`,`wt`.`Remark` AS `Remark`,`wt`.`WorkingHours` AS `WorkingHours`,((hour(`wt`.`WorkingHours`) * 3600) + (minute(`wt`.`WorkingHours`) * 60)) AS `tm`,concat(`wt`.`WorkingDay`,' ',`wt`.`AttendanceTime`,' ',`wt`.`OutingTime`,' ',`wt`.`ReentryTime`,' ',`wt`.`LeavingTime`,' ',`wt`.`WorkingHours`,`wt`.`Remark`) AS `keyword` from (select `dms`.`attendance`.`ID` AS `ID`,`dms`.`attendance`.`UserID` AS `UserID`,`dms`.`attendance`.`WorkingDay` AS `WorkingDay`,`dms`.`attendance`.`AttendanceTime` AS `AttendanceTime`,`dms`.`attendance`.`OutingTime` AS `OutingTime`,`dms`.`attendance`.`ReentryTime` AS `ReentryTime`,`dms`.`attendance`.`LeavingTime` AS `LeavingTime`,`dms`.`attendance`.`Remark` AS `Remark`,timediff(ifnull(timediff(`dms`.`attendance`.`LeavingTime`,`dms`.`attendance`.`AttendanceTime`),0),ifnull(timediff(`dms`.`attendance`.`ReentryTime`,`dms`.`attendance`.`OutingTime`),0)) AS `WorkingHours` from `dms`.`attendance`) `wt`");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::statement("DROP VIEW IF EXISTS `working_time`");
    }
};
