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
        DB::statement("CREATE VIEW `worker_list` AS select `dms`.`worker_group`.`WorkerGroupID` AS `WorkerGroupID`,`dms`.`worker_group`.`WorkerGroupName` AS `WorkerGroupName`,`dms`.`worker_group_member`.`WorkerNameID` AS `WorkerNameID`,`dms`.`worker_group_member`.`WorkerName` AS `WorkerName` from (`dms`.`worker_group` left join `dms`.`worker_group_member` on((`dms`.`worker_group`.`WorkerGroupID` = `dms`.`worker_group_member`.`WorkerGroupID`))) order by `dms`.`worker_group`.`WorkerGroupID`,`dms`.`worker_group_member`.`WorkerNameID`");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::statement("DROP VIEW IF EXISTS `worker_list`");
    }
};
