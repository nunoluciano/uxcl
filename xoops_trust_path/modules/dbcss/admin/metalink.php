<?php

require_once dirname(dirname(__FILE__)).'/class/gtickets.php' ;
require_once dirname(dirname(__FILE__)).'/include/main_functions.php' ;

// PERMISSION ERROR
if( ! is_object( $xoopsUser )  &&  ! $xoopsUser->isAdmin() ) {
	die( 'Only administrator can use this feature.' ) ;
}

// GET MODULE_LIST WITH PAGENAV

$perpage4assign = dbcss_items_perpage();
$items_perpage = isset( $_POST['perpage'] ) ? intval( $_POST['perpage'] ) : 30;

if ( isset( $_GET['perpage'] ) ){
	$select_perpage = intval( $_GET['perpage'] );
} elseif( ! empty( $items_perpage ) ){
	$select_perpage = $items_perpage;
} else {
	$select_perpage = '30';
}

$current_start = isset($_GET['start']) ? intval( $_GET['start'] ) : 0;
$module_list = array() ;
$module_list = dbcss_getmodulelist( $mydirname, $select_perpage, $current_start );
$total_modulelist = "" ;
$total_modulelist = dbcss_totalmodulelist() ;

require_once XOOPS_ROOT_PATH.'/class/pagenav.php' ;
$pagenav = new XoopsPageNav( $total_modulelist, $select_perpage, $current_start , 'start' , "page=metalink&amp;perpage=$select_perpage" ) ;
$pagenav4assign = $pagenav->renderNav( 5 ) ;

// CASHE CONFIG

$module_handler =& xoops_gethandler('module');
$config_handler =& xoops_gethandler('config');
$module =& $module_handler->getByDirname($mydirname);
$mod_config =& $config_handler->getConfigsByCat(0, $module->getVar('mid'));
$meta_data_cashe = intval( @$mod_config['meta_data_cashe'] ) ;

// DELETE

if( ! empty( $_POST['delete'] ) && ! empty( $_POST['action_selects'] ) ) {
	$db =& Database::getInstance() ;
	if ( ! $xoopsGTicket->check( true , 'dbcss' ) ) {
		redirect_header(XOOPS_URL.'/modules/'.$mydirname.'/admin/index.php',3,$xoopsGTicket->getErrors());
	}

	$errors = array() ;
	foreach( $_POST['action_selects'] as $meta_lid => $value ) {
		if( empty( $value ) ) continue ;
		$meta_lid = intval( $meta_lid ) ;

		// if( !empty( $meta_data_cashe ) ){
			$site_salt = substr( md5( XOOPS_URL ) , -4 ) ;
			$metalink_cache = XOOPS_TRUST_PATH.'/cache/'.$mydirname.'_metalink_'.$meta_lid.'_'.$site_salt.'.php' ;

			if( file_exists( $metalink_cache ) ){
				unlink( $metalink_cache );
			}
		// }

		$sql = "SELECT COUNT(*) FROM ".$db->prefix($mydirname."_metalink")." WHERE lid='".$meta_lid."'";
		list($count) = $db->fetchRow( $db->query($sql) );
		if($count > 0){
			$sql = "DELETE FROM ".$db->prefix($mydirname."_metalink")." WHERE lid = ".$meta_lid;
			$result = $db->query($sql);
			if( ! $result ) $errors[] = $meta_lid ;
		}
	}
	redirect_header( XOOPS_URL."/modules/$mydirname/admin/index.php?page=metalink" , 2 , $errors ? sprintf( _MD_DBCSS_ERROR_MESSEAGE , implode( ',' , $errors ) ) : _MD_DBCSS_DELETED ) ;
	exit();
}

// CONFIG CHECK
if( file_exists( XOOPS_TRUST_PATH.'/cache/' ) ){
	$cache_dir = true;
}

if( is_writable( XOOPS_TRUST_PATH.'/cache/' ) ){
	$writable = true;
}

// DISPLAY STAGE

xoops_cp_header();
include dirname(__FILE__).'/mymenu.php' ;
require_once XOOPS_ROOT_PATH.'/class/template.php' ;
$tpl =& new XoopsTpl() ;
$tpl->assign( array(
	'mod_url' => XOOPS_URL.'/modules/'.$mydirname ,
	'page' => 'metalink' ,
	'modulelist' => $module_list ,
	'cache_dir' => $cache_dir ,
	'writable' => $writable ,
	'meta_data_cashe' => $meta_data_cashe ,
	'perpage' => $perpage4assign ,
	'select_perpage' => $select_perpage ,
	'modulelist_pagenav' => $pagenav4assign ,
	'gticket_hidden' => $xoopsGTicket->getTicketHtml( __LINE__ , 1800 , 'dbcss') ,
) ) ;
$tpl->display( 'db:'.$mydirname.'_admin_metalink.html' ) ;
xoops_cp_footer();

?>