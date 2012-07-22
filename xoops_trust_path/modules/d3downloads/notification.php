<?php

eval( '
function '.$mydirname.'_notify_iteminfo( $category, $item_id )
{
	return d3downloads_notify_base( "'.$mydirname.'" , $category , $item_id ) ;
}
' ) ;

if( ! function_exists( 'd3downloads_notify_base' ) ) {
	function d3downloads_notify_base( $mydirname , $category , $item_id )
	{
		include_once dirname( __FILE__ ).'/class/user_access.php' ;
		include_once dirname( __FILE__ ).'/class/mydownload.php' ;

		$db =& Database::getInstance() ;

		$module_handler =& xoops_gethandler( 'module' ) ;
		$module =& $module_handler->getByDirname( $mydirname ) ;

		$user_access = new user_access( $mydirname ) ;
		$mydownload = new MyDownload( $mydirname ) ;

		if ($category=='global') {
			$item['name'] = '';
			$item['url'] = '';
			return $item;
		}

		if ( $category=='category' ) {
			// Assume we have a valid cat_id
			$whr_cat = "cid IN (".implode(",", $user_access->can_read() ).")" ;

			$sql = "SELECT title FROM ".$db->prefix( $mydirname."_cat" )." WHERE cid='".$item_id."' AND ($whr_cat)" ;
			$result = $db->query( $sql );
			$result_array = $db->fetchArray( $result );
			$item['name'] = $result_array['title'];
			$item['url'] = XOOPS_URL . "/modules/" . $module->getVar('dirname') . "/index.php?cid=".$item_id ;
			return $item ;
		}

		if ( $category=='file' ) {
			// Assume we have a valid topid_id
			$whr_cat = "cid IN (".implode(",", $user_access->can_read() ).")" ;

			$sql = "SELECT cid, title FROM ".$db->prefix( $mydirname."_downloads" )." WHERE lid = '".$item_id."'";
			$sql .= " AND ".$mydownload->whr_append( 'Single' )." AND ($whr_cat)" ;
			$result = $db->query($sql);
			$result_array = $db->fetchArray( $result );
			$item['name'] = $result_array['title'];
			$item['url'] = XOOPS_URL . "/modules/" . $module->getVar('dirname') . "/index.php?page=singlefile&cid=" . $result_array['cid'] . "&amp;lid=" . $item_id;
			return $item ;
		}
	}
}

?>