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
        DB::statement("CREATE VIEW `ssn2` AS select `ssn`.`jigyoNo` AS `jigyoNo`,`ssn`.`jigyomei` AS `jigyomei`,`ssn`.`kanryo` AS `kanryo`,`ssn`.`shoyusha` AS `shoyusha`,`ssn`.`innai` AS `innai`,`ssn`.`jusho` AS `jusho`,`ssn`.`oaza` AS `oaza`,`ssn`.`aza` AS `aza`,`ssn`.`chiban` AS `chiban`,`ssn`.`menseki` AS `menseki`,`ssn`.`zaiseki` AS `zaiseki`,`ssn`.`kingaku` AS `kingaku`,`ssn`.`haidumi` AS `haidumi`,`ssn`.`tesuryo` AS `tesuryo`,`ssn`.`hojokin` AS `hojokin`,ifnull(`cf756484_dms`.`zaiseki`.`batsuboku`,0) AS `batsuboku`,ifnull(`cf756484_dms`.`zaiseki`.`shuzai`,0) AS `shuzai`,ifnull(`cf756484_dms`.`zaiseki`.`zozai`,0) AS `zozai`,ifnull(`cf756484_dms`.`zaiseki`.`tsumikomi`,0) AS `tsumikomi` from (`cf756484_dms`.`ssn` left join `cf756484_dms`.`zaiseki` on(`ssn`.`kngk` = `cf756484_dms`.`zaiseki`.`kingaku`))");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::statement("DROP VIEW IF EXISTS `ssn2`");
    }
};
