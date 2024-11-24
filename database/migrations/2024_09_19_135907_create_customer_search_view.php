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
        DB::statement("CREATE VIEW `customer_search` AS select `cf756484_dms`.`customer`.`CustomerID` AS `CustomerID`,`cf756484_dms`.`customer`.`name` AS `name`,`cf756484_dms`.`customer`.`post_code` AS `post_code`,`cf756484_dms`.`customer`.`address1` AS `address1`,`cf756484_dms`.`customer`.`address2` AS `address2`,`cf756484_dms`.`customer`.`phone` AS `phone`,`cf756484_dms`.`customer`.`email` AS `email`,`cf756484_dms`.`customer`.`Remark` AS `Remark`,concat(`cf756484_dms`.`customer`.`name`,`cf756484_dms`.`customer`.`address1`,`cf756484_dms`.`customer`.`phone`) AS `keyword` from `cf756484_dms`.`customer` order by `cf756484_dms`.`customer`.`CustomerID`");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::statement("DROP VIEW IF EXISTS `customer_search`");
    }
};
