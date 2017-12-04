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

$chapid = isset($_GET['chapid']) && isNumber($_GET['chapid']) ? $_GET['chapid'] : 0;

		$adminquery = dbquery("SELECT "._EMAILFIELD." as email, "._PENNAMEFIELD." as penname FROM "._AUTHORTABLE." WHERE "._UIDFIELD." = '".USERUID."' LIMIT 1");
		list($adminemail, $adminname) = dbrow($adminquery);
		if($adminemail)
			$ademail = $adminemail;
		else 
			$ademail = $siteemail;
	if(isset($_POST['submit'])) {
		
		
			//begin validation code
	
		$storyquery = dbquery("SELECT story.validated, story.catid, story.sid, story.title, story.summary, story.uid, "._PENNAMEFIELD." as penname, chapter.inorder, story.coauthors FROM ".TABLEPREFIX."fanfiction_stories as story, ".TABLEPREFIX."fanfiction_chapters  as chapter, "._AUTHORTABLE." WHERE "._UIDFIELD." = story.uid AND chapter.sid = story.sid AND chapter.chapid ='$_GET[chapid]' LIMIT 1");

		list($storyvalid, $catid, $sid, $title, $summary, $authoruid, $author, $inorder, $coauthors) = dbrow($storyquery);
		
		if(uLEVEL == 1 || (empty($admincats) || sizeof(array_intersect(explode(",", $catid), explode(",", $admincats))))) {
		$subject = strip_tags(descript($_POST['subject']));
		$letter = stripslashes(descript($_POST['letter']));
		include("includes/emailer.php");
		$result = sendemail($_POST['authorname'], $_POST['authoremail'], $adminname, $ademail, $subject, $letter, "html");
		$result2 = sendemail($adminname, "validator@hpfanfictalk.com", $adminname, $ademail, $subject, $letter, "html");
		if($result) echo write_message(_EMAILSENT);
		else echo write_error(_ERROR);
					if(!$storyvalid) {
				dbquery("UPDATE ".TABLEPREFIX."fanfiction_stories SET validated = '1', updated = NOW() WHERE sid = '$_GET[sid]'");
				foreach(explode(",", $catid) as $cat) {
					categoryitems($cat, 1);
				}
				$au[] = $authoruid;
				if($coauthors == 1) {
					$au = array();
					$coauth = dbquery("SELECT "._PENNAMEFIELD." as penname, co.uid FROM ".TABLEPREFIX."fanfiction_coauthors AS co LEFT JOIN "._AUTHORTABLE." ON co.uid = "._UIDFIELD." WHERE co.sid = '".$_GET['sid']."'");
					while($c = dbassoc($coauth)) {
						$au[] = $c['uid'];
					}
					dbquery("UPDATE ".TABLEPREFIX."fanfiction_authorprefs SET stories = stories + 1 WHERE FIND_IN_SET(uid, '".implode(",", $au)."') > 0");
				}
				dbquery("UPDATE ".TABLEPREFIX."fanfiction_authorprefs SET stories = stories + 1 WHERE uid = '$authoruid'");	
				$codequery = dbquery("SELECT * FROM ".TABLEPREFIX."fanfiction_codeblocks WHERE code_type = 'addstory'");
				while($code = dbassoc($codequery)) {
					eval($code['code_text']);
				}
				if($alertson) {
					if($au) $cond = " FIND_IN_SET(fav.item, '".implode(",", $au).",$authoruid') > 0";
					else $cond = "fav.item = $authoruid";
					$subject = _NEWSTORYAT." $sitename";
					$mailtext = sprintf(_AUTHORALERTNOTE, $title, $author, $summary, $sid);
					$favorites = dbquery("SELECT "._UIDFIELD." as uid, "._EMAILFIELD." as email, "._PENNAMEFIELD." as penname, alertson FROM ".TABLEPREFIX."fanfiction_favorites as fav, ".TABLEPREFIX."fanfiction_authorprefs as ap, "._AUTHORTABLE." WHERE $cond AND fav.type = 'AU' AND fav.uid = "._UIDFIELD." AND ap.uid = "._UIDFIELD." AND ap.alertson = '1'");
					while($favuser = dbassoc($favorites)) { 
						sendemail($favuser['penname'], $favuser['email'], $sitename, $siteemail, $subject, $mailtext, "html");
					}				
				}
				if($logging) dbquery("INSERT INTO ".TABLEPREFIX."fanfiction_log (`log_action`, `log_uid`, `log_ip`, `log_type`) VALUES('".escapestring(sprintf(_LOG_VALIDATE_STORY, USERPENNAME, USERUID, $title, $sid, $author, $authoruid))."', '".USERUID."', INET_ATON('".$_SERVER['REMOTE_ADDR']."'), 'VS')");
				dbquery("UPDATE ".TABLEPREFIX."fanfiction_stats SET stories = stories + 1");
			}
			else if($alertson) {
				$subject = _STORYALERT;
				$mailtext = sprintf(_STORYALERTNOTE, $title, $author, $sid, $inorder);
				$codequery = dbquery("SELECT * FROM ".TABLEPREFIX."fanfiction_codeblocks WHERE code_type = 'addchapter'");
				while($code = dbassoc($codequery)) {
					eval($code['code_text']);
				}
				$favorites = dbquery("SELECT "._UIDFIELD." as uid, "._EMAILFIELD." as email, "._PENNAMEFIELD." as penname, alertson FROM ".TABLEPREFIX."fanfiction_favorites as fav, ".TABLEPREFIX."fanfiction_authorprefs as ap, "._AUTHORTABLE." WHERE fav.item = '$sid' AND fav.type = 'ST' AND fav.uid = "._UIDFIELD." AND ap.uid = "._UIDFIELD." AND ap.alertson = '1'");
				while($favuser = dbassoc($favorites)) { 
					sendemail($favuser['penname'], $favuser['email'], $sitename, $siteemail, $subject, $mailtext, "html");
				}
				if($logging) dbquery("INSERT INTO ".TABLEPREFIX."fanfiction_log (`log_action`, `log_uid`, `log_ip`, `log_type`) VALUES('".escapestring(sprintf(_LOG_VALIDATE_CHAPTER, USERPENNAME, USERUID, $title, $sid, $author, $authoruid, $inorder))."', '".USERUID."', INET_ATON('".$_SERVER['REMOTE_ADDR']."'), 'VS')");
			}
			dbquery("UPDATE ".TABLEPREFIX."fanfiction_chapters SET validated = '1', edited = '0', v_uid = '0' WHERE chapid = '$_GET[chapid]'");
			dbquery("UPDATE ".TABLEPREFIX."fanfiction_stories SET updated = NOW( ) WHERE sid = '$sid'");
			$count =  dbquery("SELECT SUM(wordcount) as totalcount FROM ".TABLEPREFIX."fanfiction_chapters WHERE sid = '$sid' and validated = 1");
			list($totalcount) = dbrow($count);
			if($totalcount) {
				dbquery("UPDATE ".TABLEPREFIX."fanfiction_stories SET wordcount = '$totalcount' WHERE sid = '$sid'");
			}
			list($chapters, $words) = dbrow(dbquery("SELECT COUNT(chapid), SUM(wordcount) FROM ".TABLEPREFIX."fanfiction_chapters WHERE validated = 1"));
//			list($authors) = dbrow(dbquery("SELECT COUNT(DISTINCT uid) FROM ".TABLEPREFIX."fanfiction_chapters WHERE validated > 0"));
			list($authors) = dbrow(dbquery("SELECT COUNT(uid) FROM ".TABLEPREFIX."fanfiction_authorprefs WHERE stories > 0"));
			dbquery("UPDATE ".TABLEPREFIX."fanfiction_stats set wordcount = '$words', chapters = '$chapters', authors = '$authors'");
			echo  write_message(_STORYVALIDATED);
		}
		else
			echo  write_error(_NOTAUTHORIZEDADMIN."  "._TRYAGAIN);
	

		
//end validation code
		
	}
	else {
			$storyquery = dbquery("SELECT story.title, story.sid, chapter.title as chapter, "._EMAILFIELD." as email, "._PENNAMEFIELD." as penname, chapter.uid FROM ".TABLEPREFIX."fanfiction_stories as story, ".TABLEPREFIX."fanfiction_chapters as chapter, "._AUTHORTABLE." WHERE chapter.uid = "._UIDFIELD." AND chapter.chapid = '$chapid' AND chapter.sid = story.sid LIMIT 1");
			$story = dbassoc($storyquery);
			$letterquery = dbquery("SELECT message_text, message_title FROM ".TABLEPREFIX."fanfiction_messages WHERE message_name = 'thankyou' LIMIT 1");
			list($letter, $subject) = dbrow($letterquery);
			$letter = stripslashes($letter);
			$search = array("@\{sitename\}@", "@\{adminname\}@",  "@\{author\}@", "@\{storytitle\}@",  "@\{chaptertitle\}@", "@\{rules\}@");
			$replace = array( $sitename, $adminname, $story['penname'], $story['title'], $story['chapter'], "<a href=\"$url/viewpage.php?id=rules\">"._RULES."</a>");
			$letter = preg_replace($search, $replace, $letter);
			$subject = preg_replace($search, $replace, $subject);
			echo "<body>
			<div id=\"pagetitle\"> $story[title]: $story[chapter] "._BY." $story[penname]</div>
			<div style=\"line-height: 4ex; margin: 0 auto; width: 90%;\">
				<form method=\"POST\" enctype=\"multipart/form-data\" action=\"admin.php?action=yesletter&amp;uid=$story[uid]&amp;sid=$story[sid]&amp;chapid=$chapid\">
				<input type=\"hidden\" name=\"authoremail\" value=\"$story[email]\"><input type=\"hidden\" name=\"authorname\" value=\"story[penname]\">
				<label for=\"subject\">"._SUBJECT.":</label> <INPUT type=\"text\" class=\"textbox=\" size=\"40\"  name=\"subject\" value=\"$subject\"><br />
				<textarea  name=\"letter\" cols=\"40\" rows=\"7\">$letter</TEXTAREA><br /><INPUT type=\"submit\" style=\"margin: 10px;\" class=\"button\" name=\"submit\" value=\""._SUBMIT."\"></form></div></body></html>";
	}
	exit( );
?>