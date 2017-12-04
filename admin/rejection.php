
		
		
		if(($edited == 0) || ($edited == 3){
			$edited = '3';}
			else if(($edited == 1) || ($edited == 2)){
			$edited = '2';}	
			
			dbquery("UPDATE ".TABLEPREFIX."fanfiction_chapters SET validated = '-1', edited = '$edited' WHERE chapid = '$_GET[chapid]'");
			
			echo  write_message(_STORYREJECTED);
		}
		else
			echo  write_error(_NOTAUTHORIZEDADMIN."  "._TRYAGAIN);