<?php
// ----------------------------------------------------------------------
// Copyright (c) 2007 by Tammy Keefer
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

define("_BASEDIR", "");
  include_once("includes/dbfunctions.php");    
  include_once("config.php"); 
$settingsresults = dbquery("SELECT sitename, url, siteemail, slogan, language, tableprefix, dateformat FROM ".$settingsprefix."fanfiction_settings WHERE sitekey = '$sitekey'");
$settings = dbassoc($settingsresults);
foreach($settings as $var => $val) {
	$$var = $val;
}
define("TABLEPREFIX", $tableprefix);
define("SITEKEY", $sitekey);
  include_once("includes/queries.php");
  if(file_exists("languages/{$language}.php")) include("languages/{$language}.php");
  else include("languages/en.php");
  ob_start ("ob_gzhandler"); 

function xmlentities ( $string )
{
   return str_replace ( array ( '&', '"', "'", '<', '>','#' ), array ( '&amp;' , '&quot;', '&apos;' , '&lt;' , '&gt;' ,'&#35;'), $string );
}

$ratlist = dbquery("SELECT * FROM ".TABLEPREFIX."fanfiction_ratings");
while($rate = dbassoc($ratlist)) {
	$ratings[$rate['rid']] = $rate['rating'];
}

  $rss="<?xml version=\"1.0\" encoding=\""._CHARSET."\"?>\n"; 
  $rss.="<rss version=\"2.0\" xmlns:atom=\"http://www.w3.org/2005/Atom\">\n"; 
  $rss.="<channel>\n"; 
  $rss.="<atom:link href=\"".$url."/rss.php\" rel=\"self\" type=\"application/rss+xml\" />";
  $rss.="<copyright>Copyright ".date("Y")."</copyright>\n"; 
  $rss.="<lastBuildDate>".date("r")."</lastBuildDate>\n"; 
  $rss.="<description>".xmlentities($slogan)."</description>\n"; 
  $rss.="<link>$url</link>\n"; 
  $rss.="<title>".xmlentities( $sitename)."</title>\n"; 
  $rss.="<managingEditor>$siteemail</managingEditor>\n"; 
  $rss.="<webMaster>$siteemail</webMaster>\n"; 
  $rss.="<language>$language</language>\n"; 

$query = "SELECT stories.*, "._PENNAMEFIELD." as penname, UNIX_TIMESTAMP(stories.date) as date, UNIX_TIMESTAMP(stories.updated) as updated, stories.catid as category, stories.classes as class FROM ("._AUTHORTABLE.", ".TABLEPREFIX."fanfiction_stories as stories) WHERE "._UIDFIELD." = stories.uid AND stories.validated > 0  AND DATEDIFF(current_date, updated) < 2 ORDER BY updated DESC";
$results = dbquery($query);
while($story = dbassoc($results)) {
    $story['authors'][] = $story['penname'];
    if($story['coauthors']) {
		$coauth = dbquery("SELECT "._PENNAMEFIELD." as penname, co.uid FROM ".TABLEPREFIX."fanfiction_coauthors AS co LEFT JOIN "._AUTHORTABLE." ON co.uid = "._UIDFIELD." WHERE co.sid = '".$story['sid']."'");
		while($c = dbassoc($coauth)) {
			$story['authors'][] = $c['penname'];
		}
    }
    foreach($story['authors'] AS $k => $v) {
	$story['authors'][$k] = strip_tags(xmlentities( $v));
    }
	$story['hashtags'] = "";
	foreach(explode(',', $story['category']) as $c) {
	    $hashtags = dbquery("SELECT hashtag FROM ".TABLEPREFIX."fanfiction_categories WHERE catid = '". $c ."'");
		$h = dbassoc($hashtags);
		if (strlen(trim($h['hashtag']))) {
		    $story['hashtags'] .= $h['hashtag'] . " ";
	    }
	}
	$story['house'] = "";
	foreach(explode(',', $story['class']) as $m) {
	    $house = dbquery("SELECT class_name FROM ".TABLEPREFIX."fanfiction_classes WHERE class_id = '". $m ."' and class_type = 14");
		$s = dbassoc($house);
		if (strlen(trim($s['class_name']))) {
		    $story['house'] .= $s['class_name'] . " ";
	    }
	}
    $rss.= "<item>
	<title>".strip_tags(xmlentities($story['title']))." "._BY." ".implode(", ", $story['authors'])." [".$ratings[$story['rid']]."] ".$story['hashtags']." ".$story['house']."</title>
	<link>$url/viewstory.php?sid=".$story['sid']."</link>
	<guid>$url/viewstory.php?sid=".$story['sid']."</guid>
	<description>".strip_tags(xmlentities($story['summary']))."</description>
	<pubDate>".date("r",$story['updated'])."</pubDate>
     </item>\n";  
} 

  $rss.="</channel>
</rss>"; 

  header("Content-type: application/rss+xml"); 
  header("Cache-Control: must-revalidate"); 
  header("Expires: ".gmdate("D, d M Y H:i:s", time() + 3600) . " GMT"); 
  header('Content-Type: text/html; charset=utf-8');

  echo $rss; 

?>
