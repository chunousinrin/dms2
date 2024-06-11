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
        DB::statement("CREATE VIEW `accountbook_history` AS select `dms`.`accountbook`.`ID` AS `ID`,`dms`.`accountbook`.`ErrlNumber` AS `ErrlNumber`,`dms`.`accountbook`.`UserID` AS `UserID`,`dms`.`accountbook`.`TradingDate` AS `TradingDate`,`dms`.`accountbook`.`RIType` AS `RIType`,`dms`.`accountbook`.`DocumentType` AS `DocumentType`,`dms`.`accountbook`.`Customer` AS `Customer`,`dms`.`accountbook`.`Amount` AS `Amount`,`dms`.`accountbook`.`FileName` AS `FileName`,`dms`.`accountbook`.`Remark` AS `Remark`,`dms`.`accountbook_type`.`TypeName` AS `TypeName`,concat(`dms`.`accountbook`.`FileName`,`dms`.`accountbook`.`Customer`,`dms`.`accountbook`.`Amount`,`dms`.`accountbook`.`Remark`) AS `keyword` from (`dms`.`accountbook` left join `dms`.`accountbook_type` on((`dms`.`accountbook_type`.`TypeID` = `dms`.`accountbook`.`DocumentType`)))");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::statement("DROP VIEW IF EXISTS `accountbook_history`");
    }
};
