<?php
/*
		Skin Name: Zenlike
		Skin Download: http://sally.lunaescence.com/tag/zenlike
		Description: A light green and white skin with very few graphics
		Author: Sally Anderson
		Author E-Mail: sally@lunaescence.com
		Author URI: http://sally.lunaescence.com/
*/




/* CATEGORY BLOCK
		Categories are to show only on the index.
		I currently have it set to display:
		The image, then the link, the story count in brackets, and then the description in a div tag. (template)
		Three columns (columns)*/
$blocks["categories"]["status"] = '2';
$blocks["categories"]["template"] = "{image} {link} [{count}] <div>{description}</div>";
$blocks["categories"]["columns"] = '3';


/* FEATURED BLOCK
		By default, the featured stories is off.*/
$blocks["featured"]["status"] =  '0';


/* INFO BLOCK
		Info is set to display only on the home page.  I don't bother to style it.*/
$blocks["info"]["status"] = '2';


/* MENU BLOCK
		The menu is set to display on all pages.
		Additional styles include:
		As an inline list. (style=2)
		Links to home, recent, authors, categories,titles,series,search,top tens, browse by, help, contact us, and the login info. */
$blocks["menu"]["status"] = '1';
$blocks["menu"]["content"] = array (
  0	=>	'home',
  1 => 	'recent',
  2 => 	'catslink',
  3 => 	'authors',
  4 => 	'browse',
  5 =>  'search',
  6 =>  'featured',
  7 =>  'toptens',
  8 =>  'FROGS_link',
  9 => 	'siteguidelines',
  10 =>  'Forums',
  11 =>  'adminarea',
  12 => 'login',
  13 => 'logout');
$blocks["menu"]["style"] = 0;


/* LOG-IN BLOCK
		The login form is set to display on all pages, even though I only actually call it on the index.  It can safely be changed to just the index, but I did this to address a possible bug.
		I currently have it set to display:
		In long format (form) */
$blocks["login"]["status"] = '1';
$blocks["login"]["form"] = '1';


/* RANDOM STORIES BLOCK
		Status is set to display on just the index page.*/
$blocks["random"]["status"] = '2';


/* RECENT STORIES BLOCK
		By default, the recent stories block is off.*/
$blocks["recent"]["status"] = '0';


/* SKIN CHANGER
		Status is set to display on all pages. */
$blocks["skinchange"]["status"] = '1';


/* NEWS BLOCK
		Status is set to display on just the index page. */
$blocks["news"]["status"] = '2';


/* NEW STORY INDICATOR
		Styled: Plain text surrounded with the superscript HTML tag with font-size set to extra small and italic.*/
$new = "<sup style='font-size:xx-small;font-style:italic'>New!</sup>";
?>