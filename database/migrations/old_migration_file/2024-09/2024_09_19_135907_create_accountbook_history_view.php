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
        DB::statement("CREATE VIEW `accountbook_history` AS select `cf756484_dms`.`accountbook`.`ID` AS `ID`,`cf756484_dms`.`accountbook`.`ErrlNumber` AS `ErrlNumber`,`cf756484_dms`.`accountbook`.`UserID` AS `UserID`,`cf756484_dms`.`accountbook`.`TradingDate` AS `TradingDate`,`cf756484_dms`.`accountbook`.`RIType` AS `RIType`,`cf756484_dms`.`accountbook`.`DocumentType` AS `DocumentType`,`cf756484_dms`.`accountbook`.`Customer` AS `Customer`,`cf756484_dms`.`accountbook`.`Amount` AS `Amount`,`cf756484_dms`.`accountbook`.`FileName` AS `FileName`,`cf756484_dms`.`accountbook`.`Remark` AS `Remark`,`cf756484_dms`.`accountbook_type`.`TypeName` AS `TypeName`,concat(`cf756484_dms`.`accountbook`.`FileName`,`cf756484_dms`.`accountbook`.`Customer`,`cf756484_dms`.`accountbook`.`Amount`,`cf756484_dms`.`accountbook`.`Remark`) AS `keyword` from (`cf756484_dms`.`accountbook` left join `cf756484_dms`.`accountbook_type` on(`cf756484_dms`.`accountbook_type`.`TypeID` = `cf756484_dms`.`accountbook`.`DocumentType`))");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::statement("DROP VIEW IF EXISTS `accountbook_history`");
    }
};
