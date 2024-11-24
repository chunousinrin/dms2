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
        DB::statement("CREATE VIEW `view_equipment_list` AS select `equipmentlist`.`ID` AS `ID`,`equipmentlist`.`CategoryID` AS `CategoryID`,`equipmentlist`.`MachineName` AS `MachineName`,`equipmentlist`.`Ownership` AS `Ownership`,`equipmentlist`.`Manufacturer` AS `Manufacturer`,`equipmentlist`.`BaseMachine` AS `BaseMachine`,`equipmentlist`.`Standard` AS `Standard`,`equipmentlist`.`EquipmentID1` AS `EquipmentID1`,`equipmentlist`.`EquipmentID2` AS `EquipmentID2`,`equipmentlist`.`Introduction` AS `Introduction`,`equipmentlist`.`ReturnDate` AS `ReturnDate`,`equipmentlist`.`Superintendent` AS `Superintendent`,`cf756484_dms`.`equipment_category`.`CategoryName` AS `CategoryName`,`cf756484_dms`.`equipment_classification`.`ModelNumber` AS `ModelNumber`,`equipment_classification2`.`ModelNumber` AS `ModelNumber2` from ((((select `cf756484_dms`.`equipment_list`.`ID` AS `ID`,`cf756484_dms`.`equipment_list`.`CategoryID` AS `CategoryID`,`cf756484_dms`.`equipment_list`.`MachineNAme` AS `MachineName`,`cf756484_dms`.`equipment_list`.`Ownership` AS `Ownership`,`cf756484_dms`.`equipment_list`.`Manufacturer` AS `Manufacturer`,`cf756484_dms`.`equipment_list`.`BaseMachine` AS `BaseMachine`,`cf756484_dms`.`equipment_list`.`Standard` AS `Standard`,`cf756484_dms`.`equipment_list`.`EquipmentID1` AS `EquipmentID1`,`cf756484_dms`.`equipment_list`.`EquipmentID2` AS `EquipmentID2`,`cf756484_dms`.`equipment_list`.`Introduction` AS `Introduction`,NULL AS `ReturnDate`,`cf756484_dms`.`equipment_list`.`Superintendent` AS `Superintendent` from `cf756484_dms`.`equipment_list` union all select `cf756484_dms`.`equipment_rental_list`.`ID` AS `ID`,`cf756484_dms`.`equipment_rental_list`.`CategoryID` AS `CategoryID`,`cf756484_dms`.`equipment_rental_list`.`MachineName` AS `MachineName`,`cf756484_dms`.`equipment_rental_list`.`Ownership` AS `Ownership`,`cf756484_dms`.`equipment_rental_list`.`Manufacturer` AS `Manufacturer`,`cf756484_dms`.`equipment_rental_list`.`BaseMachine` AS `BaseMachine`,`cf756484_dms`.`equipment_rental_list`.`Standard` AS `Standard`,`cf756484_dms`.`equipment_rental_list`.`EquipmentID1` AS `EquipmentID1`,`cf756484_dms`.`equipment_rental_list`.`EquipmentID2` AS `EquipmentID2`,`cf756484_dms`.`equipment_rental_list`.`Introduction` AS `Introduction`,`cf756484_dms`.`equipment_rental_list`.`ReturnDate` AS `ReturnDate`,`cf756484_dms`.`equipment_rental_list`.`Superintendent` AS `Superintendent` from `cf756484_dms`.`equipment_rental_list`) `equipmentlist` left join `cf756484_dms`.`equipment_category` on(`equipmentlist`.`CategoryID` = `cf756484_dms`.`equipment_category`.`ID`)) left join `cf756484_dms`.`equipment_classification` on(`equipmentlist`.`EquipmentID1` = `cf756484_dms`.`equipment_classification`.`ID`)) left join `cf756484_dms`.`equipment_classification` `equipment_classification2` on(`equipmentlist`.`EquipmentID2` = `equipment_classification2`.`ID`))");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::statement("DROP VIEW IF EXISTS `view_equipment_list`");
    }
};
