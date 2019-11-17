<?php
// ----------------------------------------------------------------------
// Copyright (c) 2007 by Tammy Keefer
// Valid HTML 4.01 Transitional
// Based on eFiction 1.1
// Copyright (C) 2003 by Rebecca Smallwood.
// http://efiction.sourceforge.net/
// ----------------------------------------------------------------------
// LICENSE
//
// This program is free software; you can redistribute it and/or
// modify it under the terms of the GNU General Public License (GPL)
// as published by the Free Software Foundation; either version 2
// of the License, or (at your option) any later version.
//
// This program is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
// GNU General Public License for more details.
//
// To read the license please visit http://www.gnu.org/copyleft/gpl.html
// ----------------------------------------------------------------------
if(!defined("_CHARSET")) exit( );
global $language;
if(isMEMBER) {
	if(file_exists(_BASEDIR."modules/tracker/languages/{$language}.php")) include_once(_BASEDIR."modules/tracker/languages/{$language}.php");
	else include_once(_BASEDIR."modules/tracker/languages/en.php");
	if(!isset($trackedStories)) {
		$trackedStories = array( );
		$trackedList = dbquery("SELECT sid, UNIX_TIMESTAMP(last_read) as last_read FROM ".TABLEPREFIX."fanfiction_tracker WHERE uid = '".USERUID."'");
		while($t = dbassoc($trackedList)) {
			$trackedStories[$t['sid']] = $t['last_read'];
		}
	}
	if(!empty($trackedStories[$stories['sid']])) {
		$tpl->assign("tracker", "[<a href='"._BASEDIR."browse.php?type=tracker&amp;remove=".$stories['sid']."'>"._STOPTRACK."</a>]");
		if($trackedStories[$stories['sid']] < $stories['updated']) $tpl->assign("new", isset($new) ? file_exists(_BASEDIR.$new) ? "<img src='$new' alt='"._NEW."'>" : $new : _NEW);
		if($current == "viewstory") {
			if(isset($jumpmenu2)) $jumpmenu2 .= "<option value='"._BASEDIR."browse.php?type=tracker&amp;remove=".$stories['sid']."'>"._STOPTRACK."</option>";
			dbquery("UPDATE ".TABLEPREFIX."fanfiction_tracker SET last_read = now( ) WHERE sid = '".$stories['sid']."' AND uid = '".USERUID."' LIMIT 1");
		}
		$tpl->assign("last_read", sprintf(_LASTREAD, date("$dateformat", $trackedStories[$stories['sid']])));
	}
	else {
		$tpl->assign("tracker", "[<a href='"._BASEDIR."browse.php?type=tracker&amp;add=".$stories['sid']."'>"._TRACKTHIS."</a>]");
		if($current == "viewstory" && isset($jumpmenu2)) $jumpmenu2 .= "<option value='"._BASEDIR."browse.php?type=tracker&amp;add=".$stories['sid']."'>"._TRACKTHIS."</option>";

	}
}
?>
