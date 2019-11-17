<?php
/*
This file will be called by admin/modules.php and update.php to determine if 
the module version in the database is the current version of the module.  
The version number in this file will be the current version.
*/

if(!defined("_CHARSET")) exit( );

$moduleVersion = "1.2";
$moduleName = "Story Tracker";

$moduleDescription = "This module lets visitors mark stories to be tracked. The module consists 
of an addition to the storyblock information and a new browse panel.

The addition to the storyblock will give you 2 new options to add to the block {tracker} which 
will display either [Track this Story] or [Stop Tracking this Story] links depending on whether 
or not you're tracking the story. The second option is {last_read} which will tell you when you 
last read the story. The storyblock addition will also mark the story as {new} if the update 
date is more recent than your last read date. This {new} isn't dependent on the Most Recent 
days setting. So even if you have the most recent days set to 0 you'll still see New if you're 
tracking the story and the update date is more recent than the last read date. You only have 
last read dates for stories you are tracking.

The browse panel will be \"Tracked Stories\" and will only appear if the member is logged in. This 
will list all your tracked stories. I made it a browse panel rather than user panel because as a 
browse panel you have the sort options.";
$moduleAuthor = "Tammy Keefer";
$moduleAuthorEmail = "efiction@hugosnebula.com";
$moduleWebsite = "http://efiction.hugosnebula.com";

?>