// ----------------------------------------------------------------------
// Copyright (c) 2007 by Tammy Keefer
// Also Like Module developed for eFiction 3.0
// // http://efiction.hugosnebula.com/
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


To install this module:

1. Upload the entire folder to the the modules folder within your eFiction installation.

2. Go to http://www.yoursite.com/modules/tracker/install.php where www.yoursite.com is 
your eFiction site's address. Or alternatively, go to the Modules admin panel and click on 
the install link.

3. Goto the main default_tpls folder.  Open up viewstory.tpl, listings.tpl (storyblock) 
and/or storyindex.tpl and add {tracker} and {last_read} where you want this text to appear.

4. Do the same for any skins with their own viewstory.tpl, listings.tpl (storyblock) and/or 
storyindex.tpl

To uninsall this module:

1. Go to http://www.yoursite.com/modules/tracker/uninstall.php where 
www.yoursite.com is your eFiction site's address. Alternatively, go to the Modules admin
panel and click on the unintall link for this module.


{tracker} will add a link that reads "Track this Story" or "Stop Tracking this Story" 
depending on whether or not the story is being tracked.

{last_read} will display "You last read this story on DATE." when it is a story you are 
tracking.

The module also marks any stories you are tracking that have been updated since you last 
read them with the "New!" marker. This is independent of whether or not the site has a # 
of recent days set.
