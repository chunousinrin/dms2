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
        DB::statement("CREATE VIEW `ssn` AS select `dms`.`seisan`.`No` AS `No`,`dms`.`seisan`.`jigyoNo` AS `jigyoNo`,`dms`.`seisan`.`jigyomei` AS `jigyomei`,`dms`.`seisan`.`kanryo` AS `kanryo`,`dms`.`seisan`.`shoyusha` AS `shoyusha`,`dms`.`seisan`.`innai` AS `innai`,`dms`.`seisan`.`jusho` AS `jusho`,`dms`.`seisan`.`oaza` AS `oaza`,`dms`.`seisan`.`aza` AS `aza`,`dms`.`seisan`.`chiban` AS `chiban`,`dms`.`seisan`.`menseki` AS `menseki`,`dms`.`seisan`.`zaiseki` AS `zaiseki`,`dms`.`seisan`.`kingaku` AS `kingaku`,`dms`.`seisan`.`haidumi` AS `haidumi`,`dms`.`seisan`.`tesuryo` AS `tesuryo`,`dms`.`seisan`.`hojokin` AS `hojokin`,(round(((`dms`.`seisan`.`kingaku` / `dms`.`seisan`.`zaiseki`) / 500),0) * 500) AS `kngk` from `dms`.`seisan`");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::statement("DROP VIEW IF EXISTS `ssn`");
    }
};
