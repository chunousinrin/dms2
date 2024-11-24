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
        DB::statement("CREATE VIEW `ssn` AS select `cf756484_dms`.`seisan`.`No` AS `No`,`cf756484_dms`.`seisan`.`jigyoNo` AS `jigyoNo`,`cf756484_dms`.`seisan`.`jigyomei` AS `jigyomei`,`cf756484_dms`.`seisan`.`kanryo` AS `kanryo`,`cf756484_dms`.`seisan`.`shoyusha` AS `shoyusha`,`cf756484_dms`.`seisan`.`innai` AS `innai`,`cf756484_dms`.`seisan`.`jusho` AS `jusho`,`cf756484_dms`.`seisan`.`oaza` AS `oaza`,`cf756484_dms`.`seisan`.`aza` AS `aza`,`cf756484_dms`.`seisan`.`chiban` AS `chiban`,`cf756484_dms`.`seisan`.`menseki` AS `menseki`,`cf756484_dms`.`seisan`.`zaiseki` AS `zaiseki`,`cf756484_dms`.`seisan`.`kingaku` AS `kingaku`,`cf756484_dms`.`seisan`.`haidumi` AS `haidumi`,`cf756484_dms`.`seisan`.`tesuryo` AS `tesuryo`,`cf756484_dms`.`seisan`.`hojokin` AS `hojokin`,round(`cf756484_dms`.`seisan`.`kingaku` / `cf756484_dms`.`seisan`.`zaiseki` / 500,0) * 500 AS `kngk` from `cf756484_dms`.`seisan`");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::statement("DROP VIEW IF EXISTS `ssn`");
    }
};
