<?php

require_once dirname(dirname(__FILE__)).'/class/gtickets.php' ;
$myts =& MyTextSanitizer::getInstance() ;
$db =& Database::getInstance() ;

// PERMISSION ERROR
if( ! is_object( $xoopsUser )  &&  ! $xoopsUser->isAdmin() ) {
	die( 'Only administrator can use this feature.' ) ;
}

// CASHE CONFIG

$module_handler =& xoops_gethandler('module');
$config_handler =& xoops_gethandler('config');
$module =& $module_handler->getByDirname($mydirname);
$mod_config =& $config_handler->getConfigsByCat(0, $module->getVar('mid'));
$script_data_cashe = intval( @$mod_config['script_data_cashe'] ) ;

// GET SCRIPTDATA

$script_lid = isset($_GET['lid']) ? intval($_GET['lid']) : "";
require_once dirname(dirname(__FILE__)).'/include/main_functions.php' ;
$scriptdata4assign = dbcss_getscriptdata( $mydirname , $script_lid ) ;

// TRANSACTION PART

if( isset( $_POST['scripteditform_post'] ) ) {
	if ( ! $xoopsGTicket->check( true , 'dbcss' ) ) {
		redirect_header(XOOPS_URL.'/modules/'.$mydirname.'/admin/index.php',3,$xoopsGTicket->getErrors());
	}

	$lid = isset( $_POST['lid'] ) ? intval( @$_POST['lid'] ) : "" ;
	$title  = isset( $_POST['title'] )  ? mysql_real_escape_string( $myts->stripSlashesGPC( @$_POST['title'] ) ) : "" ;
	$created = time() ;
	$body = isset( $_POST['body'] ) ? mysql_real_escape_string( $myts->stripSlashesGPC( @$_POST['body'] ) ) : "" ;
	$css = isset( $_POST['css'] ) ? mysql_real_escape_string( $myts->stripSlashesGPC( @$_POST['css'] ) ) : "" ;

	// SCRIPTLINK_CACHE
	if( ! empty( $script_data_cashe ) ){
		$site_salt = substr( md5( XOOPS_URL ) , -4 ) ;
		$cache_time = time() ;

$scriptlink4cache =<<< CACHE
\$created = "{$cache_time}";
\$body = "{$body}";
\$css = "{$css}";
CACHE;
	}

	// ERORR STOP INITIALIZATION
	$stop = '';
	$errors = '';

	// NO Data
	if( !$title && !$body ){
		$stop .= true ;
		redirect_header( XOOPS_URL."/modules/$mydirname/admin/index.php?page=scriptedit&amp;lid=".$lid, 2, _MD_DBCSS_NO_DATA);
		exit();
	}

	// MAKE LINK SQL
	if( empty( $stop ) && empty( $lid ) ) {
		$sql  = "INSERT INTO ".$db->prefix($mydirname."_scriptbody")." ( lid, title, created, body, css ) ";
		$sql .= "VALUES( 'NULL', '".$title."','".$created."', '".$body."', '".$css."' )"; 
		$result = $db->query($sql);
		$lid = $db->getInsertId() ;
		if( ! $result ) $errors = true ;

		// SCRIPTLINK_CACHE
		if( !empty( $script_data_cashe ) ){
			$scriptlink_cache = XOOPS_TRUST_PATH.'/cache/'.$mydirname.'_scriptlink_'.$lid.'_'.$site_salt.'.php' ;
			$fp = fopen( $scriptlink_cache , 'w' ) ;
			fwrite( $fp , "<?php\n".$scriptlink4cache."\n?>" ) ;
			fclose( $fp ) ;
		}

		redirect_header( XOOPS_URL."/modules/$mydirname/admin/index.php?page=scriptlink" , 2 , $errors ? _MD_DBCSS_ERROR_MESSEAGE_NOID : _MD_DBCSS_REGSTERED ) ;
		$stop .= true ;
		exit();
	} elseif ( empty( $stop ) && ! empty( $lid ) ) {
		// DOES THE LINK ALREADY EXIST? -- UPDATE SQL
		$sql = "SELECT COUNT(*) FROM ".$db->prefix($mydirname."_scriptbody")." WHERE lid='".$lid."'";
		list($count) = $db->fetchRow( $db->query($sql) );
		if( $count > 0 ){
			$sql = "UPDATE ".$db->prefix($mydirname."_scriptbody")." SET title = '".$title."', created = '".$created."', body = '".$body."', css = '".$css."' WHERE lid = ".$lid;
			$result = $db->query($sql);
		if( ! $result ) $errors = $lid ;

			// SCRIPTLINK_CACHE
			if( !empty( $script_data_cashe ) ){
				$scriptlink_cache = XOOPS_TRUST_PATH.'/cache/'.$mydirname.'_scriptlink_'.$lid.'_'.$site_salt.'.php' ;
				$fp = fopen( $scriptlink_cache , 'w' ) ;
				fwrite( $fp , "<?php\n".$scriptlink4cache."\n?>" ) ;
				fclose( $fp ) ;
			}
		redirect_header( XOOPS_URL."/modules/$mydirname/admin/index.php?page=scriptlink" , 2 , $errors ? sprintf( _MD_DBCSS_ERROR_MESSEAGE , $errors ) : _MD_DBCSS_REGSTERED ) ;
		exit();
		}
	}
}

// DELETE SQL
if( isset( $_POST['contentman_delete'] )) {
	$errors = '';
	$lid = isset( $_POST['lid'] ) ? intval( @$_POST['lid'] ) : "" ;

	if ( ! $xoopsGTicket->check( true , 'dbcss' ) ) {
		redirect_header(XOOPS_URL.'/modules/'.$mydirname.'/admin/index.php',3,$xoopsGTicket->getErrors());
	}

	// if( !empty( $script_data_cashe ) ){
		// DELETE CACHE
		$site_salt = substr( md5( XOOPS_URL ) , -4 ) ;
		$scriptlink_cache = XOOPS_TRUST_PATH.'/cache/'.$mydirname.'_scriptlink_'.$lid.'_'.$site_salt.'.php' ;
		if( file_exists( $scriptlink_cache ) ){
			unlink( $scriptlink_cache );
		}
	// }

	$sql = "SELECT COUNT(*) FROM ".$db->prefix($mydirname."_scriptbody")." WHERE lid='".$script_lid."'";
	list( $count ) = $db->fetchRow( $db->query($sql) );
	if( $count > 0 ){
		$sql = "DELETE FROM ".$db->prefix($mydirname."_scriptbody")." WHERE lid = ".$script_lid;
		$result = $db->query($sql);
		if( ! $result ) $errors[] = $script_lid ;
		redirect_header( XOOPS_URL."/modules/$mydirname/admin/index.php?page=scriptlink" , 2 , $errors ? sprintf( _MD_DBCSS_ERROR_MESSEAGE , implode( ',' , $errors ) ) : _MD_DBCSS_DELETED ) ;
		exit();
	} else {
		redirect_header( XOOPS_URL."/modules/$mydirname/admin/index.php?page=scriptedit&amp;lid=".$script_lid, 2, _MD_DBCSS_NONDELETED);
		exit();
	}
}

// COPY SQL
if( isset( $_POST['contentman_copy'] )) {
	$errors = '';
	if ( ! $xoopsGTicket->check( true , 'dbcss' ) ) {
		redirect_header(XOOPS_URL.'/modules/'.$mydirname.'/admin/index.php',3,$xoopsGTicket->getErrors());
	}

	$title  = isset( $_POST['title'] )  ? mysql_real_escape_string( $myts->stripSlashesGPC( @$_POST['title'] ) ) : "" ;
	$created = time() ;
	$body = isset( $_POST['body'] ) ? mysql_real_escape_string( $myts->stripSlashesGPC( @$_POST['body'] ) ) : "" ;
	$css = isset( $_POST['css'] ) ? mysql_real_escape_string( $myts->stripSlashesGPC( @$_POST['css'] ) )  : "" ;

	if( !empty( $script_data_cashe ) ){
		// SCRIPTLINK_CACHE
		$site_salt = substr( md5( XOOPS_URL ) , -4 ) ;
		$cache_time = time() ;

$scriptlink4cache =<<< CACHE
\$created = "{$cache_time}";
\$body = "{$body}";
\$css = "{$css}";
CACHE;
	}

	$sql  = "INSERT INTO ".$db->prefix($mydirname."_scriptbody")." ( lid, title, created, body, css ) ";
	$sql .= "VALUES( 'NULL', '".$title."','".$created."', '".$body."', '".$css."' )"; 
	$result = $db->query($sql);
	if( ! $result ) $errors = TRUE ;
	$lid = $db->getInsertId() ;

	// SCRIPTLINK_CACHE
	if( !empty( $script_data_cashe ) ){
		$scriptlink_cache = XOOPS_TRUST_PATH.'/cache/'.$mydirname.'_scriptlink_'.$lid.'_'.$site_salt.'.php' ;
		$fp = fopen( $scriptlink_cache , 'w' ) ;
		fwrite( $fp , "<?php\n".$scriptlink4cache."\n?>" ) ;
		fclose( $fp ) ;
	}

	redirect_header( XOOPS_URL."/modules/$mydirname/admin/index.php?page=scriptlink" , 2 , $errors ? _MD_DBCSS_ERROR_MESSEAGE_NOID : _MD_DBCSS_REGSTERED ) ;
	exit();
}

// DISPLAY STAGE

xoops_cp_header();
include dirname(__FILE__).'/mymenu.php' ;
require_once XOOPS_ROOT_PATH.'/class/template.php' ;
$tpl =& new XoopsTpl() ;
$tpl->assign( array(
	'mydirname' => $mydirname ,
	'mod_url' => XOOPS_URL.'/modules/'.$mydirname ,
	'page' => 'scriptedit' ,
	'script_lid' => $script_lid ,
	'scriptdata' => $scriptdata4assign ,
	'script_data_cashe' => $script_data_cashe ,
	'gticket_hidden' => $xoopsGTicket->getTicketHtml( __LINE__ , 1800 , 'dbcss') ,
) ) ;
$tpl->display( 'db:'.$mydirname.'_admin_scriptedit.html' ) ;
xoops_cp_footer();

?>