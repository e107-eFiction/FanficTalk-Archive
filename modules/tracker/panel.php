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
if(!isMEMBER) accessDenied( );
// Page Setup

if(file_exists("modules/tracker/languages/{$language}.php")) include_once("modules/tracker/languages/{$language}.php");
else include_once("modules/tracker/languages/en.php");

$current = "tracked";

if(isset($_GET['add']) && isNumber($_GET['add'])) {
	$check = dbquery("SELECT sid FROM ".TABLEPREFIX."fanfiction_tracker WHERE sid = '".$_GET['add']."' AND uid = '".USERUID."'");
	if(dbnumrows($check) == 0) $result = dbquery("INSERT INTO ".TABLEPREFIX."fanfiction_tracker VALUES('".$_GET['add']."', '".USERUID."', now( ))");
	else $result = false;
	if($result) $output .= write_message(_ACTIONSUCCESSFUL);
	else $output .= write_error(_ERROR);
}
if(isset($_GET['remove']) && isNumber($_GET['remove'])) {
	$result = dbquery("DELETE FROM ".TABLEPREFIX."fanfiction_tracker WHERE sid = '".$_GET['remove']."' AND uid = '".USERUID."' LIMIT 1");
	if($result) $output .= write_message(_ACTIONSUCCESSFUL);
	else $output .= write_error(_ERROR);
}


	$output .= "<div id=\"pagetitle\">"._YOURTRACKED.($let ? " - $let" : "")."</div>".build_alphalinks("browse.php?$terms&amp;", $let);
	if($let == _OTHER) $storyquery .= " AND stories.title REGEXP '^[^a-z]'";
	else if(!empty($let)) $storyquery .= " AND stories.title LIKE '$let%'";
	$select = "SELECT count(t.sid) FROM ".TABLEPREFIX."fanfiction_tracker as t, ".TABLEPREFIX."fanfiction_stories as stories WHERE stories.sid = t.sid AND t.uid = ".USERUID.$storyquery;
	$storyquery  .= " GROUP BY t.sid "._ORDERBY;
	$select2= "SELECT last_read, stories.*, "._PENNAMEFIELD." as penname, UNIX_TIMESTAMP(stories.date) as date, UNIX_TIMESTAMP(stories.updated) as updated FROM ".TABLEPREFIX."fanfiction_tracker as t LEFT JOIN ("._AUTHORTABLE.", ".TABLEPREFIX."fanfiction_stories as stories) ON t.sid = stories.sid AND stories.uid = "._UIDFIELD." WHERE stories.validated > 0 AND t.uid = '".USERUID."' ".$storyquery;
	$numrows = search($select2, $select, "browse.php?");
?>