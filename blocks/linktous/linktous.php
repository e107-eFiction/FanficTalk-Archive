<?php
if(!defined("_CHARSET")) exit( );

/* Start block configuration */

// The text that will appear under your image.  
//$link2us = "Affiliates";

// The folder or URL to the folder where your images are stored.
// Include the trailing slash!
$imgfolder = _BASEDIR."buttons/";

// The page you're sending them to for the code
$codepage = _BASEDIR."https://shadowplayers.jcink.net/ ";

// The list of your images.  One per line.
$images[] = "Shadowplay.png";


/* End block configuration */

$img = $images[mt_rand(0, count($images) - 1)];

$content = "<div style='text-align: center;'><a href='$codepage' alt='$link2us'><img src='$imgfolder$img' alt='$sitename' /></a><br /><a href='$codepage'>$link2us</a></div>";
unset($images, $img);
?>