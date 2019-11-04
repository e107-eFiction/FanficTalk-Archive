<?php
// ----------------------------------------------------------------------
// eFiction 3.0
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

function preview_story($stories) {
	global $extendcats, $skindir, $catlist, $charlist, $store, $storiespath, $classlist, $featured, $retired, $rr, $reviewsallowed, $star, $halfstar, $ratingslist, $classtypelist, $dateformat, $recentdays, $current;
		$count = 0;

		if(isset($_GET['textsize'])) $textsize = $_GET['textsize'];
		else $textsize = 0;
		
		if(file_exists("./$skindir/validate.tpl")) $tpl = new TemplatePower("./$skindir/validate.tpl");
		else $tpl = new TemplatePower(_BASEDIR."default_tpls/validate.tpl");
		$tpl->prepare( );	
		include("includes/storyblock.php");
		$adminlinks = "<div class=\"adminoptions\"><span class='label'>"._ADMINOPTIONS.":</span> <a href=\"javascript:pop('admin.php?action=yesletter&amp;uid=$stories[uid]&amp;chapid=$stories[chapid]', 400, 350, 'yes')\">"._VALIDATE."</a> "._OR." <a href=\"javascript:pop('admin.php?action=noletter&amp;uid=$stories[uid]&amp;chapid=$stories[chapid]',400, 350, 'yes')\">"._REJECT."</a>| "._EDIT." - <a href=\"stories.php?action=editstory&amp;sid=$stories[sid]&amp;admin=1\">"._STORY."</a> "._OR." <a href=\"stories.php?action=editchapter&amp;chapid=$stories[chapid]&amp;admin=1\">"._CHAPTER."</a> | "._DELETE." - <a href=\"stories.php?action=delete&amp;sid=$stories[sid]\">"._STORY."</a> "._OR." <a href=\"stories.php?action=delete&amp;chapid=$stories[chapid]&amp;sid=$stories[sid]&amp;admin=1&amp;uid=$stories[uid]\">"._CHAPTER."</a> </div>";
		$tpl->assign("adminlinks", $adminlinks);
		//classes code
		
		$storyclasses = array( );
	if($stories['classes']) {
		foreach(explode(",", $stories['classes']) as $c) {
			if(isset($action) && $action == "printable") $storyclasses[$classlist["$c"]['type']][] = $classlist[$c]['name'];
			else $storyclasses[$classlist["$c"]['type']][] = "<a href='browse.php?type=class&amp;type_id=".$classlist["$c"]['type']."&amp;classid=$c'>".$classlist[$c]['name']."</a>";
		}
	}
	foreach($classtypelist as $num => $c) {
		if(isset($storyclasses[$num])) {
			$tpl->newBlock("classes");
			$tpl->assign($c['name'], implode(", ", $storyclasses[$num]));
			$allclasslist .= "<span class='label'>".$c['title'].": </span> ".implode(", ", $storyclasses[$num])."<br />";
		}
		else {
			$tpl->newBlock("classes");
			$tpl->assign($c['name'], _NONE);
			$allclasslist .= "<span class='label'>".$c['title'].": </span> "._NONE."<br />";
		}
	}	
		
		if($stories['inorder'] == 1 && !empty($stories['storynotes'])) {
			$tpl->gotoBlock("_ROOT");
			$tpl->newBlock("storynotes");
			$tpl->assign( "storynotes", stripslashes($stories['storynotes']));
			$tpl->gotoBlock("_ROOT");
			}
		if(!empty($stories['notes'])) {
			$tpl->newBlock("notes");
			$tpl->assign( "notes", $stories['notes']);
			$tpl->gotoBlock("_ROOT");
		}
		if(!empty($stories['endnotes'])) {
			$tpl->newBlock("endnotes");
			$tpl->assign( "endnotes", $stories['endnotes']);
			$tpl->gotoBlock("_ROOT");
		}
		if($store == "files")
		{
			$file = STORIESPATH."/$stories[uid]/$stories[chapid].txt";
			$log_file = fopen($file, "r");
			$file_contents = fread($log_file, filesize($file));
			$storytext = $file_contents;
			fclose($log_file);
		}
		else if($store == "mysql")
		{
			$storytext = $stories['storytext'];
		}
		$storytext = format_story($storytext);
		$tpl->gotoBlock("_ROOT");
		$tpl->assign("chaptertitle", $stories['chaptertitle']);
		$tpl->assign("chapternumber", $stories['inorder']);
		$tpl->assign( "story", "<span style=\"font-size: ".(100 + ($textsize * 20))."%;\">$storytext</span>" );
		return $tpl->getOutputContent( );
}


	$output .= "<div id='pagetitle'>"._VIEWSUBMITTED."</div>";

		if(isNumber($_GET['chapid'])) {
			$result = dbquery("SELECT stories.*, stories.title as title, "._PENNAMEFIELD." as penname, UNIX_TIMESTAMP(stories.updated) as updated, UNIX_TIMESTAMP(stories.date) as date, chapter.uid as uid, chapter.inorder, chapter.title as chaptertitle, chapter.storytext, chapter.chapid, chapter.notes, chapter.endnotes FROM "._AUTHORTABLE.", ".TABLEPREFIX."fanfiction_stories as stories, ".TABLEPREFIX."fanfiction_chapters as chapter WHERE chapter.chapid = '$_GET[chapid]' AND chapter.sid = stories.sid AND chapter.uid = "._UIDFIELD);
			$stories = dbassoc($result);
			$output .= preview_story($stories);
			
			dbquery("update ". TABLEPREFIX ."fanfiction_chapters set v_uid =". USERUID . " where chapid = '$_GET[chapid]'");

		}
	
?>