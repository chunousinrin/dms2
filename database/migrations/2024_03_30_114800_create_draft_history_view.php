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
        DB::statement("CREATE VIEW `draft_history` AS select `dms`.`draft`.`draftID` AS `draftID`,`dms`.`draft`.`userID` AS `userID`,`dms`.`draft`.`userName` AS `userName`,`dms`.`draft`.`CreatedDate` AS `CreatedDate`,`dms`.`draft`.`DraftTypeId` AS `DraftTypeId`,`dms`.`draft`.`DraftNumber` AS `DraftNumber`,`dms`.`draft`.`Title` AS `Title`,`dms`.`draft`.`Contents` AS `Contents`,`dms`.`draft`.`Documents` AS `Documents`,`dms`.`draft`.`Attachment` AS `Attachment`,`dms`.`draft`.`Attachment2` AS `Attachment2`,`dms`.`draft`.`Attachment3` AS `Attachment3`,`dms`.`draft`.`Attachment4` AS `Attachment4`,`dms`.`draft`.`Attachment5` AS `Attachment5`,`dms`.`draft`.`Multiplepage` AS `Multiplepage`,concat(`dms`.`draft`.`Title`,`dms`.`draft`.`Contents`,`dms`.`draft`.`Documents`) AS `keyword`,`dms`.`draft_type`.`DraftName` AS `DraftName`,`dms`.`draft_browsed`.`BrowseUserID` AS `BrowseUserID`,`dms`.`draft_browsed`.`Comment` AS `Comment` from ((`dms`.`draft` left join `dms`.`draft_type` on((`dms`.`draft`.`DraftTypeId` = `dms`.`draft_type`.`DraftID`))) left join `dms`.`draft_browsed` on((`dms`.`draft`.`DraftNumber` = `dms`.`draft_browsed`.`DraftNumber`)))");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::statement("DROP VIEW IF EXISTS `draft_history`");
    }
};
