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
        DB::statement("CREATE VIEW `draft_history` AS select `cf756484_dms`.`draft`.`draftID` AS `draftID`,`cf756484_dms`.`draft`.`userID` AS `userID`,`cf756484_dms`.`draft`.`userName` AS `userName`,`cf756484_dms`.`draft`.`CreatedDate` AS `CreatedDate`,`cf756484_dms`.`draft`.`DraftTypeId` AS `DraftTypeId`,`cf756484_dms`.`draft`.`DraftNumber` AS `DraftNumber`,`cf756484_dms`.`draft`.`Title` AS `Title`,`cf756484_dms`.`draft`.`Contents` AS `Contents`,`cf756484_dms`.`draft`.`Documents` AS `Documents`,`cf756484_dms`.`draft`.`Attachment` AS `Attachment`,`cf756484_dms`.`draft`.`Attachment2` AS `Attachment2`,`cf756484_dms`.`draft`.`Attachment3` AS `Attachment3`,`cf756484_dms`.`draft`.`Attachment4` AS `Attachment4`,`cf756484_dms`.`draft`.`Attachment5` AS `Attachment5`,`cf756484_dms`.`draft`.`Multiplepage` AS `Multiplepage`,concat(`cf756484_dms`.`draft`.`Title`,`cf756484_dms`.`draft`.`Contents`,`cf756484_dms`.`draft`.`Documents`) AS `keyword`,`cf756484_dms`.`draft_type`.`DraftName` AS `DraftName`,`cf756484_dms`.`draft_browsed`.`BrowseUserID` AS `BrowseUserID`,`cf756484_dms`.`draft_browsed`.`Comment` AS `Comment` from ((`cf756484_dms`.`draft` left join `cf756484_dms`.`draft_type` on(`cf756484_dms`.`draft`.`DraftTypeId` = `cf756484_dms`.`draft_type`.`DraftID`)) left join `cf756484_dms`.`draft_browsed` on(`cf756484_dms`.`draft`.`DraftNumber` = `cf756484_dms`.`draft_browsed`.`DraftNumber`))");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::statement("DROP VIEW IF EXISTS `draft_history`");
    }
};
