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
        DB::statement("CREATE VIEW `customer_search` AS select `dms`.`customer`.`CustomerID` AS `CustomerID`,`dms`.`customer`.`name` AS `name`,`dms`.`customer`.`post_code` AS `post_code`,`dms`.`customer`.`address1` AS `address1`,`dms`.`customer`.`address2` AS `address2`,`dms`.`customer`.`phone` AS `phone`,`dms`.`customer`.`email` AS `email`,`dms`.`customer`.`Remark` AS `Remark`,concat(`dms`.`customer`.`name`,`dms`.`customer`.`address1`,`dms`.`customer`.`phone`) AS `keyword` from `dms`.`customer` order by `dms`.`customer`.`CustomerID`");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::statement("DROP VIEW IF EXISTS `customer_search`");
    }
};
