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
$meta_data_cashe = intval( @$mod_config['meta_data_cashe'] ) ;

// GET MODULE_NAME
$meta_lid = isset($_GET['lid']) ? intval($_GET['lid']) : "";

$res = $db->query( "SELECT mid, name FROM ".$db->prefix( "modules" )." WHERE mid='".$meta_lid."'" ) ;
$module_name = "" ;
while( $content_row = $db->fetchArray( $res ) ) {
	$module_name = $myts->makeTboxData4Show( $content_row['name'] );
}

// METADATA

require_once dirname(dirname(__FILE__)).'/include/main_functions.php' ;
$metadata4assign = dbcss_getmetadata( $mydirname , $meta_lid ) ;
$list_robots = dbcss_list_robots() ;
$list_rating = dbcss_list_rating() ;

// TRANSACTION PART
if( isset( $_POST['metaeditform_post'] ) && $meta_lid ) {
	if ( ! $xoopsGTicket->check( true , 'dbcss' ) ) {
		redirect_header(XOOPS_URL.'/modules/'.$mydirname.'/admin/index.php',3,$xoopsGTicket->getErrors());
	}

	$lid      = $meta_lid ;
	$metakey  = isset( $_POST['metakey'] )  ? mysql_real_escape_string( $myts->stripSlashesGPC( @$_POST['metakey'] ) ) : "" ;
	$metadesc = isset( $_POST['metadesc'] ) ? mysql_real_escape_string( $myts->stripSlashesGPC( @$_POST['metadesc'] ) ) : "" ;
	$robots = isset( $_POST['robots'] ) ? mysql_real_escape_string( $myts->stripSlashesGPC( @$_POST['robots'] ) ) : "" ;
	$rating = isset( $_POST['rating'] ) ? mysql_real_escape_string( $myts->stripSlashesGPC( @$_POST['rating'] ) ) : "" ;
	$author = isset( $_POST['author'] ) ? mysql_real_escape_string( $myts->stripSlashesGPC( @$_POST['author'] ) ) : "" ;

// FILE CASHE CONFIG
	if( !empty( $meta_data_cashe ) ){
		// METALINK_CACHE
		$site_salt = substr( md5( XOOPS_URL ) , -4 ) ;
		$metalink_cache = XOOPS_TRUST_PATH.'/cache/'.$mydirname.'_metalink_'.$meta_lid.'_'.$site_salt.'.php' ;

$metalink4cache =<<< CACHE
\$lid ="{$lid}";
\$metakey = "{$metakey}";
\$metadesc = "{$metadesc}";
\$robots = "{$robots}";
\$rating = "{$rating}";
\$author = "{$author}";
CACHE;
	}

	// ERORR STOP INITIALIZATION
	$stop = '';
	$errors = array() ;

	// No Data
	if( !$metakey && !$metadesc && !$robots && !$rating && !$author ){
		$stop .= true ;
		redirect_header( XOOPS_URL."/modules/$mydirname/admin/index.php?page=metaedit&amp;lid=".$lid, 2, _MD_DBCSS_NO_DATA);
		exit();
	}

	// DOES THE MODULE EXIST?
	$sql = "SELECT COUNT(*) FROM ".$db->prefix("modules")." WHERE mid='".$lid."'";
	list($count) = $db->fetchRow( $db->query($sql) );
	if( empty( $count) ){
		$stop .= true ;
		redirect_header( XOOPS_URL."/modules/$mydirname/admin/index.php?page=metalink", 2, _MD_DBCSS_MODULE_NOTFOUND);
		exit();
	}

	// DOES THE LINK ALREADY EXIST? -- UPDATE SQL
	$sql = "SELECT COUNT(*) FROM ".$db->prefix($mydirname."_metalink")." WHERE lid='".$lid."'";
	list($count) = $db->fetchRow( $db->query($sql) );
	if($count > 0){
		$sql = "UPDATE ".$db->prefix($mydirname."_metalink")." SET lid = '".$lid."', metakey = '".$metakey."', metadesc = '".$metadesc."', robots = '".$robots."', rating = '".$rating."', author = '".$author."' WHERE lid = ".$lid;
		$result = $db->query($sql);
		if( ! $result ) $errors[] = $lid ;

		if( ! empty( $meta_data_cashe ) ){
			$fp = fopen( $metalink_cache , 'wb' ) ;
			fwrite( $fp , "<?php\n".$metalink4cache."\n?>" ) ;
			fclose( $fp ) ;
		}
		redirect_header( XOOPS_URL."/modules/$mydirname/admin/index.php?page=metalink" , 2 , $errors ? sprintf( _MD_DBCSS_ERROR_MESSEAGE , implode( ',' , $errors ) ) : _MD_DBCSS_REGSTERED ) ;
		exit();
	}

	// MAKE LINK SQL
	if( empty( $stop ) ){
		$sql  = "INSERT INTO ".$db->prefix($mydirname."_metalink")." (lid, metakey, metadesc, robots, rating, author) ";
		$sql .= "VALUES(".$lid.", '".$metakey."', '".$metadesc."', '".$robots."', '".$rating."', '".$author."')"; 
		$result = $db->query($sql);
		if( ! $result ) $errors[] = $lid ;

		if( ! empty( $meta_data_cashe ) ){
			$fp = fopen( $metalink_cache , 'wb' ) ;
			fwrite( $fp , "<?php\n".$metalink4cache."\n?>" ) ;
			fclose( $fp ) ;
		}

		redirect_header( XOOPS_URL."/modules/$mydirname/admin/index.php?page=metalink" , 2 , $errors ? sprintf( _MD_DBCSS_ERROR_MESSEAGE , implode( ',' , $errors ) ) : _MD_DBCSS_REGSTERED ) ;
		exit();
	}
}

// DELETE SQL
if( isset( $_POST['contentman_delete'] ) && $meta_lid ) {
	if ( ! $xoopsGTicket->check( true , 'dbcss' ) ) {
		redirect_header(XOOPS_URL.'/modules/'.$mydirname.'/admin/index.php',3,$xoopsGTicket->getErrors());
	}

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
		redirect_header( XOOPS_URL."/modules/$mydirname/admin/index.php?page=metalink" , 2 , $errors ? sprintf( _MD_DBCSS_ERROR_MESSEAGE , implode( ',' , $errors ) ) : _MD_DBCSS_DELETED ) ;
		exit();
	} else {
		redirect_header( XOOPS_URL."/modules/$mydirname/admin/index.php?page=metaedit&amp;lid=".$meta_lid, 2, _MD_DBCSS_NONDELETED);
		exit();
	}
}

// DISPLAY STAGE

xoops_cp_header();
include dirname(__FILE__).'/mymenu.php' ;
require_once XOOPS_ROOT_PATH.'/class/template.php' ;
$tpl =& new XoopsTpl() ;
$tpl->assign( array(
	'mydirname' => $mydirname ,
	'mod_url' => XOOPS_URL.'/modules/'.$mydirname ,
	'page' => 'metaedit' ,
	'meta_lid' => $meta_lid ,
	'module_name' => $module_name ,
	'metadata' => $metadata4assign ,
	'list_robots' => $list_robots ,
	'list_rating' => $list_rating ,
	'meta_data_cashe' => $meta_data_cashe ,
	'gticket_hidden' => $xoopsGTicket->getTicketHtml( __LINE__ , 1800 , 'dbcss') ,
) ) ;
$tpl->display( 'db:'.$mydirname.'_admin_metaedit.html' ) ;
xoops_cp_footer();

?>