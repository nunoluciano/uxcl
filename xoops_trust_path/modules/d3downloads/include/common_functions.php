<?php

if ( ! function_exists('d3download_getsub_categories') ) {
	function d3download_getsub_categories( $mydirname, $cid, $whr_cat )
	{
		include_once dirname( dirname(__FILE__) ).'/class/mycategory.php' ;
		$mycategory = new MyCategory( $mydirname, 'Show', $cid ) ;
		return $mycategory->getsub_categories( $whr_cat ) ;
	}
}

if ( ! function_exists('d3download_makecache_for_selbox') ) {
	function d3download_makecache_for_selbox( $mydirname, $whr_cat, $selectcat=0, $sum=0, $all=0, $none='', $top=0, $notnin=0 )
	{
		include_once dirname( dirname(__FILE__) ).'/class/mycategory.php' ;
		$mycategory = new MyCategory( $mydirname, 'Show' ) ;
		return $mycategory->makecache_for_selbox( $whr_cat, $selectcat, $sum, $all, $none, $top, $notnin ) ;
	}
}

if ( ! function_exists('d3download_categories_selbox') ) {
	function d3download_categories_selbox( $mydirname, $whr_cat, $selectcat=0, $sum=0, $all=0, $none='', $top=0, $notnin=0 )
	{
		include_once dirname( dirname(__FILE__) ).'/class/mycategory.php' ;
		$mycategory = new MyCategory( $mydirname, 'Show' ) ;
		return $mycategory->categories_selbox( $whr_cat, $selectcat, $sum, $all, $none, $top, $notnin ) ;
	}
}

if ( ! function_exists('d3download_get_title') ) {
	function d3download_get_title( $mydirname, $lid, $whr )
	{
		include_once dirname( dirname(__FILE__) ).'/class/mydownload.php' ;
		$mydownload = new MyDownload( $mydirname, $whr, $lid ) ;
		if( ! $mydownload->return_lid() ) {
			redirect_header( XOOPS_URL."/modules/$mydirname/" , 2 , _MD_D3DOWNLOADS_NOMATCH ) ;
			exit ;
		} else {
			return array(
				'lid' => $mydownload->return_lid() ,
				'cid' => $mydownload->return_cid() ,
				'title' => $mydownload->return_title('Show') ,
			) ;
		}
	}
}

if ( ! function_exists('d3download_items_perpage') ) {
	function d3download_items_perpage()
	{
		return array(
			'5'  => '5' ,
			'10' => '10' ,
			'15' => '15' ,
			'20' => '20' ,
			'25' => '25' ,
			'30' => '30' ,
			'50' => '50'
		) ;
	}
}

if ( ! function_exists('d3download_select_intree') ) {
	function d3download_select_intree()
	{
		return array(
			'0'  => _MD_D3DOWNLOADS_NO_INTREE ,
			'1' => _MD_D3DOWNLOADS_SEL_INTREE
		) ;
	}
}

if ( ! function_exists('d3download_select_perpage') ) {
	function d3download_select_perpage( $mydirname )
	{
		$module_handler =& xoops_gethandler('module');
		$config_handler =& xoops_gethandler('config');
		$module =& $module_handler->getByDirname( $mydirname );
		$mod_config =& $config_handler->getConfigsByCat( 0, $module->getVar( 'mid' ) );

		if ( isset( $_GET['perpage'] ) ) $perpage = intval( $_GET['perpage'] ) ;
		elseif ( isset( $_POST['perpage'] ) ) $perpage = intval( $_POST['perpage'] ) ;
		else $perpage = intval( $mod_config['perpage'] ) ;
		return $perpage ;
	}
}

if ( ! function_exists('d3download_list_order') ) {
	function d3download_list_order()
	{
		return array(
			'd.hits' ,
			'd.hits DESC' ,
			'd.rating' ,
			'd.rating DESC' ,
			'd.votes' ,
			'd.votes DESC' ,
			'd.title' ,
			'd.title DESC' ,
			'd.date' ,
			'd.date DESC' ,
		) ;
	}
}

if ( ! function_exists('d3download_select_order') ) {
	function d3download_select_order()
	{
		return array(
			'd.hits ASC'    => _MD_D3DOWNLOADS_POPULARITYLTOM ,
			'd.hits DESC'   => _MD_D3DOWNLOADS_POPULARITYMTOL ,
			'd.title ASC'   => _MD_D3DOWNLOADS_TITLEATOZ ,
			'd.title DESC'  => _MD_D3DOWNLOADS_TITLEZTOA,
			'd.date ASC'    => _MD_D3DOWNLOADS_DATEOLD ,
			'd.date DESC'   => _MD_D3DOWNLOADS_DATENEW ,
			'd.rating ASC'  => _MD_D3DOWNLOADS_RATINGLTOH ,
			'd.rating DESC' => _MD_D3DOWNLOADS_RATINGHTOL ,
			'd.mylink ASC'  => _MD_D3DOWNLOADS_MYLINKLTOH ,
			'd.mylink DESC' => _MD_D3DOWNLOADS_MYLINKHTOL ,
		) ;
	}
}

if ( ! function_exists('d3download_selected_order') ) {
	function d3download_selected_order( $mydirname )
	{
		$module_handler =& xoops_gethandler('module');
		$config_handler =& xoops_gethandler('config');
		$module =& $module_handler->getByDirname( $mydirname );
		$mod_config =& $config_handler->getConfigsByCat( 0, $module->getVar( 'mid' ) );

		$_GET = d3download_delete_nullbyte( $_GET );
		if ( isset( $_GET['orderby'] ) ) $order = d3download_convertorderbyin( trim( $_GET['orderby'] ) ) ;
		elseif ( isset( $_POST['order_select'] ) ) $order = $_POST['order_select'] ;
		else  $order =  $mod_config['order'] ;
		return  $order ;
	}
}

if ( ! function_exists('d3download_convertorderbyin') ) {
	function d3download_convertorderbyin( $orderby )
	{
		switch ( $orderby ) {
		case "titleA":
			$orderby = "d.title ASC";
			break;
		case "dateA":
			$orderby = "d.date ASC";
			break;
		case "hitsA":
			$orderby = "d.hits ASC";
			break;
		case "ratingA":
			$orderby = "d.rating ASC";
			break;
		case "mylinkA":
			$orderby = "d.mylink ASC";
			break;
		case "titleD":
			$orderby = "d.title DESC";
			break;
		case "hitsD":
			$orderby = "d.hits DESC";
			break;
		case "ratingD":
			$orderby = "d.rating DESC";
			break;
		case "mylinkD":
			$orderby = "d.mylink DESC";
			break;
		case"dateD":
		default:
			$orderby = "d.date DESC";
			break;
		}
		return $orderby;
	}
}

if ( ! function_exists('d3download_convertorderbytrans') ) {
	function d3download_convertorderbytrans( $orderby )
	{
		if ($orderby == "d.hits ASC")     $orderbyTrans = _MD_D3DOWNLOADS_POPULARITYLTOM;
		if ($orderby == "d.hits DESC")    $orderbyTrans = _MD_D3DOWNLOADS_POPULARITYMTOL;
		if ($orderby == "d.title ASC")    $orderbyTrans = _MD_D3DOWNLOADS_TITLEATOZ;
		if ($orderby == "d.title DESC")   $orderbyTrans = _MD_D3DOWNLOADS_TITLEZTOA;
		if ($orderby == "d.date ASC")     $orderbyTrans = _MD_D3DOWNLOADS_DATEOLD;
		if ($orderby == "d.date DESC")    $orderbyTrans = _MD_D3DOWNLOADS_DATENEW;
		if ($orderby == "d.rating ASC")   $orderbyTrans = _MD_D3DOWNLOADS_RATINGLTOH;
		if ($orderby == "d.rating DESC")  $orderbyTrans = _MD_D3DOWNLOADS_RATINGHTOL;
		if ($orderby == "d.mylink ASC")   $orderbyTrans = _MD_D3DOWNLOADS_MYLINKLTOH;
		if ($orderby == "d.mylink DESC")  $orderbyTrans = _MD_D3DOWNLOADS_MYLINKHTOL;
		return $orderbyTrans;
	}
}

if ( ! function_exists('d3download_convertorderbyout') ) {
	function d3download_convertorderbyout( $orderby )
	{
		if ($orderby == "d.title ASC")    $orderby = "titleA";
		if ($orderby == "d.date ASC")     $orderby = "dateA";
		if ($orderby == "d.hits ASC")     $orderby = "hitsA";
		if ($orderby == "d.rating ASC")   $orderby = "ratingA";
		if ($orderby == "d.mylink ASC")   $orderby = "mylinkA";
		if ($orderby == "d.title DESC")   $orderby = "titleD";
		if ($orderby == "d.date DESC")    $orderby = "dateD";
		if ($orderby == "d.hits DESC")    $orderby = "hitsD";
		if ($orderby == "d.rating DESC")  $orderby = "ratingD";
		if ($orderby == "d.mylink DESC")  $orderby = "mylinkD";
		return $orderby;
	}
}

if ( ! function_exists('d3download_get_categories_list') ) {
	function d3download_get_categories_list( $mydirname, $top=0 )
	{
		require_once dirname( dirname(__FILE__) ).'/class/block_download.php' ;
		$block_download = new block_download( $mydirname ) ;
		return $block_download->get_categories_list( $top ) ;
	}
}

if ( ! function_exists('d3download_get_downloads_title') ) {
	function d3download_get_downloads_title( $mydirname )
	{
		require_once dirname( dirname(__FILE__) ).'/class/block_download.php' ;
		$block_download = new block_download( $mydirname ) ;
		return $block_download->get_downloads_list() ;
	}
}

if ( ! function_exists('d3download_can_albumselect') ) {
	function d3download_can_albumselect( $mydirname, $myalbum_dirname='' )
	{
		include_once dirname( dirname(__FILE__) ).'/class/submit_download.php' ;
		$submit_download = new submit_download( $mydirname ) ;
		return $submit_download->can_albumselect( $myalbum_dirname ) ;
	}
}

if ( ! function_exists('d3download_delcat') ) {
	function d3download_delcat( $mydirname, $cid )
	{
		$db =& Database::getInstance() ;
		include_once dirname( dirname(__FILE__) ).'/class/mycategory.php' ;

		$mycategory = new MyCategory( $mydirname, 'Show' ) ;
		$module_handler =& xoops_gethandler('module');
		$xoopsModule =& $module_handler->getByDirname( $mydirname );
		$mid =& $xoopsModule->getVar('mid');
		$children = $mycategory->getAllChildId( $cid ) ;
		$whr = "cid IN (" ;
		foreach( $children as $child ) {
			$whr .= "$child," ;
			xoops_notification_deletebyitem( $mid , 'cat' , $child ) ;
		}
		$whr .= "$cid)" ;
		xoops_notification_deletebyitem( $mid, 'category', $cid ) ;
		d3download_delete_contents( $mydirname , $whr, $cid );
		d3download_delete_cache_of_categories( $mydirname ) ;
		$db->query( "DELETE FROM ".$db->prefix( $mydirname."_cat")." WHERE $whr" ) or die( "DB error: DELETE cat table" ) ;
	}
}

if ( ! function_exists('d3download_delete_contents') ) {
	function d3download_delete_contents( $mydirname, $whr, $cid )
	{
		$db =& Database::getInstance() ;
		$res = $db->query("SELECT lid, filename, file2 FROM ".$db->prefix( $mydirname."_downloads")." WHERE $whr" ) ;
		while( list( $id, $fname, $fil2 ) = $db->fetchRow( $res ) ) 
		{
			$lid = intval( $id ) ;
			$filename = htmlspecialchars( $fname , ENT_QUOTES ) ;
			$file2 = htmlspecialchars( $fil2 , ENT_QUOTES ) ;
			$db->query( "DELETE FROM ".$db->prefix( $mydirname."_broken")." WHERE lid=$lid" ) or die( "DB error: DELETE broken table." ) ;
			$db->query( "DELETE FROM ".$db->prefix( $mydirname."_downloads")." WHERE lid=$lid" ) or die( "DB error: DELETE downloads table." ) ;
			$db->query( "DELETE FROM ".$db->prefix( $mydirname."_downloads_history")." WHERE lid=$lid" ) or die( "DB error: DELETE downloads_history table." ) ;
			$db->query( "DELETE FROM ".$db->prefix( $mydirname."_votedata")." WHERE lid=$lid" ) or die( "DB error: DELETE votedata table." ) ;
			if( ! empty( $filename ) || ! empty( $file2 ) ){
				d3download_delete_uploadfiles( $mydirname , $lid );
			}
		}

		$urs = $db->query("SELECT cid FROM ".$db->prefix( $mydirname."_user_access")." WHERE cid=$cid" ) ;
		while( list( $delete_id ) = $db->fetchRow( $urs ) ) 
		{
			$db->query( "DELETE FROM ".$db->prefix( $mydirname."_user_access")." WHERE cid=$delete_id" ) or die( "DB error: DELETE broken table." ) ;
		}
	}
}

if ( ! function_exists('d3download_delete_lid') ) {
	function d3download_delete_lid( $mydirname, $lid )
	{
		$db =& Database::getInstance() ;
		$module_handler =& xoops_gethandler('module');
		$config_handler =& xoops_gethandler('config');
		$module =& $module_handler->getByDirname( $mydirname );
		$mod_config =& $config_handler->getConfigsByCat( 0, $module->getVar( 'mid' ) );

		$res = $db->query("SELECT lid, filename, file2, submitter FROM ".$db->prefix( $mydirname."_downloads")." WHERE lid=$lid" ) ;
		while( list( $id, $fname, $fil2, $uid ) = $db->fetchRow( $res ) ) 
		{
			$filename = htmlspecialchars( $fname , ENT_QUOTES ) ;
			$file2 = htmlspecialchars( $fil2 , ENT_QUOTES ) ;
			$submitter = intval( $uid ) ;

			// u“Še‚ðƒ†[ƒU[‚Ì“Še”‚É”½‰fv‚ª—LŒø‚Èê‡A“Še”‚É”½‰f
			if( $submitter > 0 && ! empty( $mod_config['plus_posts'] ) ) {
				d3download_decrementPost( $submitter ) ;
			}

			$db->query( "DELETE FROM ".$db->prefix( $mydirname."_downloads")." WHERE lid=$id" ) or die( "DB error: DELETE downloads table." ) ;
			$db->query( "DELETE FROM ".$db->prefix( $mydirname."_broken")." WHERE lid=$id" ) or die( "DB error: DELETE broken table." ) ;
			$db->query( "DELETE FROM ".$db->prefix( $mydirname."_downloads_history")." WHERE lid=$id" ) or die( "DB error: DELETE downloads_history table." ) ;
			$db->query( "DELETE FROM ".$db->prefix( $mydirname."_votedata")." WHERE lid=$id" ) or die( "DB error: DELETE votedata table." ) ;
		}
		if( ! empty( $filename ) || ! empty( $file2 ) ){
			d3download_delete_uploadfiles( $mydirname, $lid );
		}
		d3download_delete_cache_of_categories( $mydirname ) ;
	}
}

if ( ! function_exists('d3download_decrementPost') ) {
	function d3download_decrementPost( $submitter )
	{
		$member_handler = & xoops_gethandler( 'member' ) ;
		$user_obj = & $member_handler->getUser( $submitter ) ;
		if ( is_object( $user_obj ) ) {
			$member_handler->updateUserByField( $user_obj, 'posts', $user_obj->getVar( 'posts' ) - 1 );
		}
	}
}

if ( ! function_exists('d3download_delete_uploadfiles') ) {
	function d3download_delete_uploadfiles( $mydirname , $lid )
	{
		$uploads_dir = XOOPS_TRUST_PATH.'/uploads/'.$mydirname ;
		$site_salt = substr( md5( XOOPS_URL ) , -4 ) ;
		$target_name = $lid.'_'.$site_salt ;
		if( $handler = @opendir( $uploads_dir . '/' ) ) {
			while( ( $file = readdir( $handler ) ) !== false ) {
				$file_path = $uploads_dir . '/' . $file ;
				if ( is_file( $file_path ) && strstr( $file , $target_name ) ){
					@unlink( $file_path ) or die("File delete error ". $file );
				}
			}
		}
		closedir( $handler ) ;
	}
}

if ( ! function_exists('d3download_real_path') ) {
	function d3download_real_path( $mydirname, $text )
	{
		include_once dirname( dirname(__FILE__) ).'/class/mydownload.php' ;
		$mydownload = new MyDownload( $mydirname ) ;
		return $mydownload->Real_path( $text ) ;
	}
}

if ( ! function_exists('d3download_delete_cache_of_categories') ) {
	function d3download_delete_cache_of_categories( $mydirname )
	{
		include_once dirname( dirname(__FILE__) ).'/class/mycategory.php' ;
		$mycategory = new MyCategory( $mydirname, 'Show' ) ;
		$mycategory->delete_cache_of_categories() ;
	}
}

if ( ! function_exists('d3download_cat_description') ) {
	function d3download_cat_description( $mydirname, $cid )
	{
		include_once dirname( dirname(__FILE__) ).'/class/mycategory.php' ;
		$mycategory = new MyCategory( $mydirname, 'Show', $cid ) ;
		$cat_description = $mycategory->return_description() ;
		if( ! empty( $cat_description ) ) return $cat_description ;
		else return '' ;
	}
}

if ( ! function_exists('d3download_cat_pid') ) {
	function d3download_cat_pid( $mydirname, $cid )
	{
		include_once dirname( dirname(__FILE__) ).'/class/mycategory.php' ;
		$mycategory = new MyCategory( $mydirname, 'Show', $cid ) ;
		return $mycategory->return_pid() ;
	}
}

if ( ! function_exists('d3download_maincat_cid') ) {
	function d3download_maincat_cid( $mydirname, $cid )
	{
		include_once dirname( dirname(__FILE__) ).'/class/mycategory.php' ;
		$mycategory = new MyCategory( $mydirname, 'Show', $cid ) ;
		return $mycategory->get_my_maincid() ;
	}
}

if ( ! function_exists('d3download_subcategory_sum') ) {
	function d3download_subcategory_sum( $mydirname, $cid, $whr='' )
	{
		include_once dirname( dirname(__FILE__) ).'/class/mycategory.php' ;
		$mycategory = new MyCategory( $mydirname, 'Show' ) ;
		return $mycategory->subcategory_sum( $cid, $whr ) ;
	}
}

if ( ! function_exists('d3download_get_my_parent_cat') ) {
	function d3download_get_my_parent_cat( $mydirname, $cid )
	{
		include_once dirname( dirname(__FILE__) ).'/class/mycategory.php' ;
		$mycategory = new MyCategory( $mydirname, 'Show', $cid ) ;
		return $mycategory->get_my_parent_cat() ;
	}
}

if ( ! function_exists('d3download_useraccess_edit_info') ) {
	function d3download_useraccess_edit_info( $mydirname, $cid, $parentid=0 )
	{
		$pid = empty( $parentid ) ? d3download_cat_pid( $mydirname, $cid ) : $parentid ;
		if( ! empty( $cid ) && $pid == 0 ){
			$info = '<a href="'.XOOPS_URL.'/modules/'.$mydirname.'/admin/index.php?page=user_access&amp;cid='.$cid.'">'._MD_D3DOWNLOADS_USERACCESS_EDIT.'</a>' ;
		} elseif( empty( $cid ) && $pid > 0 ){
			$maincid = d3download_maincat_cid( $mydirname, $pid ) ;
			$info = '<a href="'.XOOPS_URL.'/modules/'.$mydirname.'/admin/index.php?page=user_access&amp;cid='.$maincid.'">'._MD_D3DOWNLOADS_MAINCAT_USERACCESS_EDIT.'</a>' ;
		} else {
			$maincid = d3download_maincat_cid( $mydirname, $cid ) ;
			$info = '<a href="'.XOOPS_URL.'/modules/'.$mydirname.'/admin/index.php?page=user_access&amp;cid='.$maincid.'">'._MD_D3DOWNLOADS_MAINCAT_USERACCESS_EDIT.'</a>' ;
		}
		return $info ;
	}
}

if ( ! function_exists('d3download_group_useraccess_info') ) {
	function d3download_group_useraccess_info( $mydirname, $cid )
	{
		$pid = d3download_cat_pid( $mydirname, $cid ) ;
		require_once dirname( dirname(__FILE__) ).'/class/user_access.php' ;
		$user_access = new user_access( $mydirname ) ;
		return $user_access->get_group_form( $cid, $pid, 1 ) ;
	}
}

if ( ! function_exists('d3download_myuser_useraccess_info') ) {
	function d3download_myuser_useraccess_info( $mydirname, $cid )
	{
		$pid = d3download_cat_pid( $mydirname, $cid ) ;
		require_once dirname( dirname(__FILE__) ).'/class/user_access.php' ;
		$user_access = new user_access( $mydirname ) ;
		return $user_access->get_user_form( $cid, $pid, 1 ) ;
	}
}
		
if ( ! function_exists('d3download_postname') ) {
	function d3download_postname( $mydirname , $submitter )
	{
		include_once dirname( dirname(__FILE__) ).'/class/mydownload.php' ;
		$mydownload = new MyDownload( $mydirname ) ;
		return $mydownload->get_postname( $submitter ) ;
	}
}

if ( ! function_exists('d3download_getlink_for_postname') ) {
	function d3download_getlink_for_postname( $mydirname , $submitter )
	{
		include_once dirname( dirname(__FILE__) ).'/class/mydownload.php' ;
		$mydownload = new MyDownload( $mydirname ) ;
		return $mydownload->getlink_for_postname( $submitter ) ;
	}
}

if ( ! function_exists('d3download_return_user_url') ) {
	function d3download_return_user_url( $mydirname , $submitter )
	{
		include_once dirname( dirname(__FILE__) ).'/class/mydownload.php' ;
		$mydownload = new MyDownload( $mydirname ) ;
		return $mydownload->return_user_url( $submitter ) ;
	}
}

if ( ! function_exists('d3download_can_read') ) {
	function d3download_can_read( $mydirname )
	{
		include_once dirname(dirname(__FILE__)).'/class/user_access.php' ;
		$user_access = new user_access( $mydirname ) ;
		return $user_access->can_read() ;
	}
}

if ( ! function_exists('d3download_canread_info') ) {
	function d3download_canread_info( $mydirname, $cid )
	{
		include_once dirname(dirname(__FILE__)).'/class/user_access.php' ;
		$user_access = new user_access( $mydirname ) ;
		return $user_access->canread_info( $cid ) ;
	}
}

// trigger event for D3
if ( ! function_exists('d3download_main_trigger_event') ) {
	function d3download_main_trigger_event( $mydirname , $category , $item_id, $event, $extra_tags=array(), $user_list=array(), $omit_user_id=null )
	{
		require_once XOOPS_TRUST_PATH.'/libs/altsys/class/D3NotificationHandler.class.php' ;
		$mytrustdirpath = dirname( dirname( __FILE__ ) );
		$mytrustdirname = basename( $mytrustdirpath );
		$not_handler =& D3NotificationHandler::getInstance() ;
		$not_handler->triggerEvent( $mydirname , $mytrustdirname , $category , $item_id , $event , $extra_tags , $user_list , $omit_user_id ) ;
	}
}

if ( ! function_exists('d3download_submenu') ) {
	function d3download_submenu( $mydirname, $submenu_option )
	{
		include_once dirname( dirname(__FILE__) ).'/class/user_access.php' ;

		$module_handler =& xoops_gethandler('module');
		$config_handler =& xoops_gethandler('config');
		$module =& $module_handler->getByDirname( $mydirname );
		$mod_config =& $config_handler->getConfigsByCat( 0, $module->getVar( 'mid' ) );

		$user_access = new user_access( $mydirname ) ;
		$whr = "cid IN (".implode(",", $user_access->can_read() ).")" ;
		$constpref = '_MI_' . strtoupper( $mydirname ) ;

		$submenu = array( 0 => array( 'name' => '' , 'url' => '' , 'sub' => array() ) ) ;

		if( d3download_submenu_option( $submenu_option, 'categories' ) ){
			$submenu = array_merge( $submenu, d3download_get_categories_for_submenu( $mydirname, $whr ) ) ;
		}

		if( ! empty( $mod_config['show_mypost'] ) ){
			$submitter = d3download_is_submitter( $mydirname, $whr ) ;
			if( ! empty( $submitter ) ) {
				$submenu['sub'][] = array(
					'name' => constant( $constpref.'_MYPOST_VIEW' ) ,
					'url' => 'index.php?submitter='.$submitter ,
				);
			}
		}

		if( d3download_submenu_option( $submenu_option, 'mylink' ) && d3download_total_mylink( $mydirname, 0, $whr ) ){
			$submenu['sub'][] = array(
				'name' => constant( $constpref.'_MYLINK' ) ,
				'url' => 'index.php?page=mylink' ,
			);
		}

		if( ! empty( $submenu['sub'] ) ) return $submenu['sub'];
		else return '';
	}
}

if ( ! function_exists('d3download_get_submenu_option') ) {
	function d3download_get_submenu_option( $mydirname )
	{
		require_once dirname( dirname(__FILE__) ).'/class/d3downloads.textsanitizer.php' ;
		$myts =& d3downloadsTextSanitizer::getInstance() ;

		$mytrustdirpath = dirname( dirname( __FILE__ ) ) ;
		$mytrustdirname = basename( $mytrustdirpath ) ;

		$config_file =  array(
			 XOOPS_ROOT_PATH.'/modules/'.$mydirname.'/include/config.inc.php' ,
			 XOOPS_TRUST_PATH.'/modules/'.$mytrustdirname.'/config/enabled/config.inc.php'
		) ;

		foreach ( $config_file as $file_path ){
			if( file_exists( $file_path ) ) {
				include $file_path ;
				$my_config = $myts->MyIntval( $submenu_option ) ;
				break ;
			}
		}
		return ( ! empty( $my_config ) ) ? $my_config : '' ;
	}
}

if ( ! function_exists('d3download_submenu_option') ) {
	function d3download_submenu_option( $submenu_option, $key )
	{
		if( $submenu_option === '' || $submenu_option[ $key ] != 0 ) return  true ;
		else return false ;
	}
}

if ( ! function_exists('d3download_get_categories_for_submenu') ) {
	function d3download_get_categories_for_submenu( $mydirname, $whr )
	{
		require_once dirname( dirname(__FILE__) ).'/class/d3downloads.textsanitizer.php' ;
		$myts =& d3downloadsTextSanitizer::getInstance() ;
		$db =& Database::getInstance() ;

		$categories = array( 0 => array( 'name' => '' , 'url' => '' , 'sub' => array() ) ) ;

		$sql = "SELECT cid, title FROM ".$db->prefix( $mydirname."_cat" )." WHERE ( $whr ) AND pid = '0' ORDER BY cat_weight" ;
		$crs = $db->query( $sql ) ;
		if( ! empty( $crs ) ) while( $myrow = $db->fetchArray( $crs ) ) {
			$cid = intval( $myrow['cid'] ) ;
			$categories['sub'][] = array(
				'name' => $myts->makeTboxData4Show( $myrow['title'] ) ,
				'url' => 'index.php?cid='.$cid ,
			);
		}
		return $categories ;
	}
}

if ( ! function_exists('d3download_is_submitter') ) {
	function d3download_is_submitter( $mydirname, $whr )
	{
		global $xoopsUser ;

		$submitter = 0 ;
		if( is_object( $xoopsUser ) ){
			include_once dirname( dirname(__FILE__) ).'/class/mydownload.php' ;
			$mydownload = new MyDownload( $mydirname ) ;
			$uid = $xoopsUser->getVar( 'uid' ) ;
			$mypost = $mydownload->Total_Mypost( $whr, $uid ) ;
			$submitter = ( empty( $mypost ) ) ? 0 : $uid ;
		}
		return $submitter ;
	}
}

if ( ! function_exists('d3download_total_mylink') ) {
	function d3download_total_mylink( $mydirname, $cid=0, $whr='', $intree=0 )
	{
		include_once dirname( dirname(__FILE__) ).'/class/mydownload.php' ;
		$mydownload = new MyDownload( $mydirname ) ;
		return $mydownload->total_mylink( $cid, $whr, $intree ) ;
	}
}

if ( ! function_exists('d3download_dbmoduleheader') ) {
	function d3download_dbmoduleheader( $mydirname, $add_array=array() )
	{
		include_once dirname( dirname(__FILE__) ).'/class/mydownload.php' ;
		include_once dirname( dirname(__FILE__) ).'/include/module_header.php' ;
		$mydownload = new MyDownload( $mydirname ) ;

		$module_handler =& xoops_gethandler('module');
		$config_handler =& xoops_gethandler('config');
		$module =& $module_handler->getByDirname( $mydirname );
		$mod_config =& $config_handler->getConfigsByCat( 0, $module->getVar( 'mid' ) );

		$css_uri = ( empty( $mod_config['css_uri'] ) ) ? '{mod_url}/index.php?page=module_header&src=main.css' : htmlspecialchars( @$mod_config['css_uri'] , ENT_QUOTES ) ;

		$array = array_merge( array( $css_uri ) , $add_array ) ;

		if( $mydownload->option_config( 'use_lightbox' ) ) $array = array_merge( $array , d3download_lightbox_header() ) ;
		
		return d3download_add_moduleheader( $mydirname, $array ) ;
	}
}

if ( ! function_exists('d3download_lightbox_header') ) {
	function d3download_lightbox_header()
	{
		return array( 'spica.js' , 'lightbox_plus.js' ) ;
	}
}

if ( ! function_exists('d3download_breadcrumbs') ) {
	function d3download_breadcrumbs( $mydirname )
	{
		$module_handler =& xoops_gethandler('module');
		$xoopsModule =& $module_handler->getByDirname( $mydirname );
		return array( 'url' => XOOPS_URL.'/modules/'.$mydirname.'/index.php' , 'name' => $xoopsModule->getVar( 'name' ) ) ;
	}
}

if ( ! function_exists('d3download_breadcrumbs_tree') ) {
	function d3download_breadcrumbs_tree( $mydirname, $cid, $whr, $path='', $halfway=0 )
	{
		include_once dirname( dirname(__FILE__) ).'/class/mycategory.php' ;
		$mycategory = new MyCategory( $mydirname, 'Show' ) ;

		$i = 0 ;
		$breadcrumbs = array() ;
		$funcURL = ( empty( $path ) ) ? "index.php?" : $path ;
		$bc_arr = $mycategory->getNicePathArrayFromId( $cid, $whr, $funcURL ) ;
		$count = count( $bc_arr ) ;
		if( ! empty( $bc_arr ) ) foreach( $bc_arr as $bc ) {
			$i++ ;
			if( empty( $halfway ) && $i == $count )  $breadcrumbs[] = array( 'name' => $bc['title'] ) ;
			else $breadcrumbs[] = array( 'name' => $bc['title'] ,'url' => $bc['url'] ) ;
		}
		return $breadcrumbs ;
	}
}

if ( ! function_exists('d3download_category_tree') ) {
	function d3download_category_tree( $mydirname, $cid, $path='', $whr='' )
	{
		include_once dirname( dirname(__FILE__) ).'/class/mycategory.php' ;
		$mycategory = new MyCategory( $mydirname, 'Show' ) ;
		$funcURL = ( empty( $path ) ) ? "index.php?" : $path ;
		return $mycategory->getNicePathFromId( $cid, $whr, $funcURL ) ;
	}
}

if ( ! function_exists('d3download_delete_nullbyte') ) {
	function d3download_delete_nullbyte( $arr )
	{
		require_once dirname( dirname(__FILE__) ).'/class/d3downloads.textsanitizer.php' ;
		$myts =& d3downloadsTextSanitizer::getInstance() ;
		return $myts->Delete_Nullbyte( $arr ) ;
	}
}

if ( ! function_exists('d3download_make_serialize_data') ) {
	function d3download_make_serialize_data( $mydirname )
	{
		include_once dirname( dirname(__FILE__) ).'/class/mycategory.php' ;
		$mycategory = new MyCategory( $mydirname, 'Show' ) ;
		$mycategory->serialize_insertdb() ;
	}
}

if ( ! function_exists('d3download_set_default_user_access') ) {
	function d3download_set_default_user_access( $mydirname )
	{
		require_once dirname( dirname(__FILE__) ).'/class/user_access.php' ;

		$db =& Database::getInstance() ;
		$user_access = new user_access( $mydirname ) ;
		$crs = $db->query( "SELECT cid FROM ".$db->prefix( $mydirname."_cat" )." WHERE pid = 0" ) ;
		while( list( $id ) = $db->fetchRow( $crs ) ) {
			$cid = intval( $id );
			$error = $user_access->default_user_access( $cid, 1, 1 ) ;
		}
		return $error ;
	}
}

if ( ! function_exists('d3download_update100') ) {
	function d3download_update100( $mydirname )
	{
		if ( ! ini_get( 'safe_mode' ) ) { @set_time_limit(0); }
		$db =& Database::getInstance() ;

		// upload url 
		$searches = XOOPS_TRUST_PATH.'/uploads/'.$mydirname ;
		$replacements = 'XOOPS_TRUST_PATH/uploads/'.$mydirname ;

		$result = $db->query("SELECT lid, url FROM ".$db->prefix( $mydirname."_downloads" )."");
		while( list( $id, $url ) = $db->fetchRow( $result ) ) {
			$lid = intval( $id );
			$new_url = str_replace( $searches , $replacements , $url ) ;
			$irs = $db->query( "UPDATE ".$db->prefix($mydirname."_downloads")." SET url = '".addslashes( $new_url )."' WHERE lid = '".$lid."'");
		}

		$result = $db->query("SELECT id, url FROM ".$db->prefix( $mydirname."_downloads_history" )."");
		while( list( $id, $url ) = $db->fetchRow( $result ) ) {
			$historyid = intval( $id );
			$new_url = str_replace( $searches , $replacements , $url ) ;
			$irs = $db->query( "UPDATE ".$db->prefix($mydirname."_downloads_history")." SET url = '".addslashes( $new_url )."' WHERE id = '".$historyid."'");
		}

		$result = $db->query("SELECT requestid, url FROM ".$db->prefix( $mydirname."_unapproval" )."");
		while( list( $id, $url ) = $db->fetchRow( $result ) ) {
			$requestid = intval( $id );
			$new_url = str_replace( $searches , $replacements , $url ) ;
			$irs = $db->query( "UPDATE ".$db->prefix($mydirname."_unapproval")." SET url = '".addslashes( $new_url )."' WHERE requestid = '".$requestid."'");
		}
	}
}

if ( ! function_exists('d3download_historycheck') ) {
	function d3download_historycheck( $mydirname )
	{
		if ( ! ini_get( 'safe_mode' ) ) { @set_time_limit(0); }
		$db =& Database::getInstance() ;
		$result = $db->query("SELECT id, url, file2 FROM ".$db->prefix( $mydirname."_downloads_history" )."");
		while( list( $id, $url, $file2 ) = $db->fetchRow( $result ) ) {
			$error = 0 ;
			$historyid = intval( $id );
			$error = d3download_history_filenamecheck( $mydirname, $historyid ) ;
			if( ! empty( $error ) ) d3download_history_delete( $mydirname, $historyid, $url, $file2 ) ;
		}
	}
}

if ( ! function_exists('d3download_history_filenamecheck') ) {
	function d3download_history_filenamecheck( $mydirname, $id  )
	{
		$db =& Database::getInstance() ;
		$error = 0 ;
		$result = $db->query( "SELECT url, filename, file2, filename2 FROM ".$db->prefix( $mydirname."_downloads_history" )." WHERE id='".$id."'" );
		while( list( $url, $filename, $file2, $filename2 ) = $db->fetchRow( $result ) ) {
			if ( strstr( $url , 'XOOPS_TRUST_PATH/uploads/'.$mydirname ) && empty( $filename) ) $error = 1;
			if ( strstr( $file2 , 'XOOPS_TRUST_PATH/uploads/'.$mydirname ) && empty( $filename2 ) ) $error = 1;
		}
		return $error;
	}
}

if ( ! function_exists('d3download_history_delete') ) {
	function d3download_history_delete( $mydirname, $id, $url, $file2 )
	{
		$db =& Database::getInstance() ;
		$searches = 'XOOPS_TRUST_PATH/uploads/'.$mydirname ;
		$replacements = XOOPS_TRUST_PATH.'/uploads/'.$mydirname ;
		$count = $count2 = 0 ;
		$count += $db->getRowsNum( $db->query( "SELECT * FROM ".$db->prefix( $mydirname."_downloads" )." WHERE url='".$url."'" ) );
		$count += $db->getRowsNum( $db->query( "SELECT * FROM ".$db->prefix( $mydirname."_downloads_history" )." WHERE id NOT IN ( '".$id."' ) AND url='".$url."'" ) );
		if( empty( $count ) ){
			$filepath = str_replace( $searches , $replacements , $url ) ;
			if ( file_exists( $filepath ) ) {
				@unlink( $filepath );
			}
		}
		$count2 += $db->getRowsNum( $db->query( "SELECT * FROM ".$db->prefix( $mydirname."_downloads" )." WHERE file2='".$file2."'" ) );
		$count2 += $db->getRowsNum( $db->query( "SELECT * FROM ".$db->prefix( $mydirname."_downloads_history" )." WHERE id NOT IN ( '".$id."' ) AND file2='".$file2."'" ) );
		if( empty( $count2 ) ){
			$filepath2 = str_replace( $searches , $replacements , $file2 ) ;
			if ( file_exists( $filepath2 ) ) {
				@unlink( $filepath2 );
			}
		}
		$db->query("DELETE FROM ".$db->prefix( $mydirname."_downloads_history" )." WHERE id='".$id."'" ) ;
	}
}

?>