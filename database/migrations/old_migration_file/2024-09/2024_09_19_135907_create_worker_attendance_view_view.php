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
        DB::statement("CREATE VIEW `worker_attendance_view` AS select `cf756484_dms`.`worker_attendance`.`waID` AS `waID`,`cf756484_dms`.`worker_attendance`.`AttendanceDay` AS `AttendanceDay`,`cf756484_dms`.`worker_group`.`WorkerGroupID` AS `WorkerGroupID`,`cf756484_dms`.`worker_group`.`WorkerGroupName` AS `WorkerGroupName`,`cf756484_dms`.`worker_attendance`.`WorkerNameID` AS `WorkerNameID`,`cf756484_dms`.`worker_group_member`.`WorkerName` AS `WorkerName`,`cf756484_dms`.`worker_attendance`.`watID` AS `watID`,`cf756484_dms`.`worker_attendace_type`.`AttendanceType` AS `AttendanceType`,`cf756484_dms`.`worker_attendance`.`watID2` AS `watID2`,`wat2`.`AttendanceType` AS `AttendanceType2`,`cf756484_dms`.`worker_attendace_type`.`NumberOfDaysWorked` AS `nodw`,`wat2`.`NumberOfDaysWorked` AS `nodw2`,`cf756484_dms`.`worker_attendance`.`NumberOfDaysWorked` AS `NumberOfDaysWorked` from ((((`cf756484_dms`.`worker_attendance` left join `cf756484_dms`.`worker_group_member` on(`cf756484_dms`.`worker_group_member`.`WorkerNameID` = `cf756484_dms`.`worker_attendance`.`WorkerNameID`)) left join `cf756484_dms`.`worker_group` on(`cf756484_dms`.`worker_group`.`WorkerGroupID` = `cf756484_dms`.`worker_group_member`.`WorkerGroupID`)) left join `cf756484_dms`.`worker_attendace_type` on(`cf756484_dms`.`worker_attendace_type`.`watID` = `cf756484_dms`.`worker_attendance`.`watID`)) left join `cf756484_dms`.`worker_attendace_type` `wat2` on(`wat2`.`watID` = `cf756484_dms`.`worker_attendance`.`watID2`))");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::statement("DROP VIEW IF EXISTS `worker_attendance_view`");
    }
};
