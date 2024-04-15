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
        DB::statement("CREATE VIEW `ssn2` AS select `dms`.`ssn`.`jigyoNo` AS `jigyoNo`,`dms`.`ssn`.`jigyomei` AS `jigyomei`,`dms`.`ssn`.`kanryo` AS `kanryo`,`dms`.`ssn`.`shoyusha` AS `shoyusha`,`dms`.`ssn`.`innai` AS `innai`,`dms`.`ssn`.`jusho` AS `jusho`,`dms`.`ssn`.`oaza` AS `oaza`,`dms`.`ssn`.`aza` AS `aza`,`dms`.`ssn`.`chiban` AS `chiban`,`dms`.`ssn`.`menseki` AS `menseki`,`dms`.`ssn`.`zaiseki` AS `zaiseki`,`dms`.`ssn`.`kingaku` AS `kingaku`,`dms`.`ssn`.`haidumi` AS `haidumi`,`dms`.`ssn`.`tesuryo` AS `tesuryo`,`dms`.`ssn`.`hojokin` AS `hojokin`,ifnull(`dms`.`zaiseki`.`batsuboku`,0) AS `batsuboku`,ifnull(`dms`.`zaiseki`.`shuzai`,0) AS `shuzai`,ifnull(`dms`.`zaiseki`.`zozai`,0) AS `zozai`,ifnull(`dms`.`zaiseki`.`tsumikomi`,0) AS `tsumikomi` from (`dms`.`ssn` left join `dms`.`zaiseki` on((`dms`.`ssn`.`kngk` = `dms`.`zaiseki`.`kingaku`)))");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::statement("DROP VIEW IF EXISTS `ssn2`");
    }
};
