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

if(file_exists(_BASEDIR."modules/tracker/languages/{$language}.php")) include_once(_BASEDIR."modules/tracker/languages/{$language}.php");
else include_once(_BASEDIR."modules/tracker/languages/en.php");
$result = dbquery("SELECT count( track.sid ) AS count, stories.*, "._PENNAMEFIELD." as penname, UNIX_TIMESTAMP(stories.date) as date, UNIX_TIMESTAMP(stories.updated) as updated FROM ".TABLEPREFIX."fanfiction_tracker as track, "._AUTHORTABLE.", ".TABLEPREFIX."fanfiction_stories as stories WHERE stories.uid = "._UIDFIELD." AND stories.validated > 0 AND track.sid = stories.sid GROUP BY stories.sid ORDER BY count DESC LIMIT 10");
if(dbnumrows($result) == 0) $output .= write_message(_NORESULTS);
$tpl->newBlock("listings");
while($stories = dbassoc($result)) { 
	$tpl->newblock("storyblock");
	include("includes/storyblock.php"); 
}
$tpl->gotoBlock( "_ROOT" );
?>
