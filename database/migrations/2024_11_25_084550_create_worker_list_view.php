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
        DB::statement("CREATE VIEW `worker_list` AS select `cf756484_dms`.`worker_group`.`WorkerGroupID` AS `WorkerGroupID`,`cf756484_dms`.`worker_group`.`WorkerGroupName` AS `WorkerGroupName`,`cf756484_dms`.`worker_group_member`.`WorkerNameID` AS `WorkerNameID`,`cf756484_dms`.`worker_group_member`.`WorkerName` AS `WorkerName` from (`cf756484_dms`.`worker_group` left join `cf756484_dms`.`worker_group_member` on(`cf756484_dms`.`worker_group`.`WorkerGroupID` = `cf756484_dms`.`worker_group_member`.`WorkerGroupID`)) order by `cf756484_dms`.`worker_group`.`WorkerGroupID`,`cf756484_dms`.`worker_group_member`.`WorkerNameID`");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::statement("DROP VIEW IF EXISTS `worker_list`");
    }
};
