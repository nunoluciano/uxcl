<?php

require_once dirname(dirname(__FILE__)).'/class/gtickets.php' ;
require_once XOOPS_ROOT_PATH.'/class/xoopsblock.php' ;
require_once XOOPS_ROOT_PATH.'/class/template.php' ;

define( 'ALTSYS_DIR' , XOOPS_TRUST_PATH.'/libs/altsys' ) ;

if( ! file_exists( ALTSYS_DIR.'/include/Text_Diff.php' ) ) die( 'Install altsys' ) ;

require_once ALTSYS_DIR.'/include/Text_Diff.php' ;
require_once ALTSYS_DIR.'/include/Text_Diff_Renderer.php' ;
require_once ALTSYS_DIR.'/include/Text_Diff_Renderer_unified.php' ;

$db =& Database::getInstance();
$myts =& MyTextSanitizer::getInstance() ;

// THIS PAGE CAN BE CALLED ONLY FROM DBCSS
if( $xoopsModule->getVar('dirname') != $mydirname ) //die( 'this page can be called only from '.$mydirname ) ;

// PERMISSION ERROR
$module_handler =& xoops_gethandler( 'module' ) ;
$module =& $module_handler->getByDirname( $mydirname ) ;
$moduleperm_handler =& xoops_gethandler( 'groupperm' ) ;
$mid = $module->getVar('mid') ;
if( ! is_object( @$xoopsUser ) || ! $moduleperm_handler->checkRight( 'module_admin' , $mid , $xoopsUser->getGroups() ) ) {
	die( 'Only administrator can use this feature.' ) ;
}

// TPL_FILE FROM $_GET OR $_POST
if( ! empty( $_GET['tpl_file'] ) ){
	$edit_file = htmlspecialchars( $_GET['tpl_file'], ENT_QUOTES ) ;
}

// TPL_ID FROM $_GET OR $_POST
if( ! empty( $_GET['tpl_id'] ) ){
	$tpl_id = intval( $_GET['tpl_id'] ) ;
} elseif( ! empty( $_POST['tpl_id'] ) ){
	$tpl_id = intval( $_POST['tpl_id'] ) ;
}

if( ! empty( $_GET['bid'] ) ){
	$bid = intval( $_GET['bid'] ) ;
} elseif( ! empty( $_POST['bid'] ) ){
	$bid = intval( $_POST['bid'] ) ;
}

// GET TPLFILE FROM TABLE
if( ! empty( $edit_file ) ){
	$config_tplsets = $xoopsConfig['template_set'] ;
	$sql = "SELECT COUNT(*) FROM ".$db->prefix("tplfile")." WHERE tpl_module='".$mydirname."' AND tpl_tplset='".$config_tplsets."' AND tpl_file='".$edit_file."'";
	list( $count ) = $db->fetchRow( $db->query( $sql ) );
	if( $count > 0 ){
		$sql = "SELECT * FROM ".$db->prefix("tplfile")." f NATURAL LEFT JOIN ".$db->prefix("tplsource")." s WHERE f.tpl_tplset='".$config_tplsets."' AND f.tpl_file='".$edit_file."'";
	} else {
		$sql = "SELECT * FROM ".$db->prefix("tplfile")." f NATURAL LEFT JOIN ".$db->prefix("tplsource")." s WHERE f.tpl_tplset='default' AND f.tpl_file='".$edit_file."'";
	}
} elseif ( ! empty( $tpl_id ) ){
	$sql = "SELECT * FROM ".$db->prefix("tplfile")." f NATURAL LEFT JOIN ".$db->prefix("tplsource")." s WHERE f.tpl_id='".$tpl_id."'";
}

$cssfile = $db->fetchArray( $db->query( $sql ) ) ;

// TPL_FILE
$tpl_file = htmlspecialchars( $cssfile['tpl_file'], ENT_QUOTES ) ;
$tpl_file = str_replace( 'db:' , '' , $tpl_file ) ;
$tpl_file4sql = mysql_real_escape_string( $tpl_file ) ;

// BASEFILEPATH
$name_string = explode($mydirname.'_', $tpl_file ,2 ) ;
$css_filepath = $name_string[1];
$basefilepath =  XOOPS_TRUST_PATH.'/uploads/'.$mydirname.'/'.$css_filepath;

// ERROR IN SPECIFYING TPL_FILE
/*
if( empty( $cssfile ) ) {
	if( strncmp( $tpl_file , 'file:' , 5 ) === 0 ) {
		die( 'Not DB template' ) ;
	} else {
		die( 'Invalid tpl_file.' ) ;
	}
}
*/
// DIFF FROM FILE TO SELECTED DB TEMPLATE
$diff_from_file4disp = '' ;
if( file_exists( $basefilepath ) ) {
	$diff =& new Text_Diff( file( $basefilepath ) , explode("\n",$cssfile['tpl_source']) ) ;
	$renderer =& new Text_Diff_Renderer_unified();
	$diff_str = htmlspecialchars( $renderer->render( $diff ) , ENT_QUOTES ) ;
	foreach( explode( "\n" , $diff_str ) as $line ) {
		if( ord( $line ) == 0x2d ) {
			$diff_from_file4disp .= "<span style='color:red;'>".$line."</span>\n" ;
		} else if( ord( $line ) == 0x2b ) {
			$diff_from_file4disp .= "<span style='color:blue;'>".$line."</span>\n" ;
		} else {
			$diff_from_file4disp .= $line."\n" ;
		}
	}
}

// DIFF FROM DB-DEFAULT TO SELECTED DB TEMPLATE
$diff_from_default4disp = '' ;
if( $cssfile['tpl_tplset'] != 'default' ) {
	list( $default_source ) = $db->fetchRow( $db->query( "SELECT tpl_source FROM ".$db->prefix("tplfile")." NATURAL LEFT JOIN ".$db->prefix("tplsource")." WHERE tpl_tplset='default' AND tpl_file='".addslashes($cssfile['tpl_file'])."' AND tpl_module='".addslashes($cssfile['tpl_module'])."'" ) ) ;
	$diff =& new Text_Diff( explode("\n",$default_source) , explode("\n",$cssfile['tpl_source']) ) ;
	$renderer =& new Text_Diff_Renderer_unified();
	$diff_str = htmlspecialchars( $renderer->render( $diff ) , ENT_QUOTES ) ;
	foreach( explode( "\n" , $diff_str ) as $line ) {
		if( ord( $line ) == 0x2d ) {
			$diff_from_default4disp .= "<span style='color:red;'>".$line."</span>\n" ;
		} else if( ord( $line ) == 0x2b ) {
			$diff_from_default4disp .= "<span style='color:blue;'>".$line."</span>\n" ;
		} else {
			$diff_from_default4disp .= $line."\n" ;
		}
	}
}

// EDIT UPDATE
$errors = array() ;
if( ! empty( $_POST['do_modifycont'] ) || ! empty( $_POST['do_modify'] ) ) {
	if ( ! $xoopsGTicket->check( true , 'dbcss' ) ) {
		redirect_header(XOOPS_URL.'/modules/'.$mydirname.'/admin/index.php',3,$xoopsGTicket->getErrors());
	}

	$post_source = addslashes($myts->stripSlashesGPC( $_POST['tpl_source'] ) );

	$result = $db->query( "UPDATE ".$db->prefix("tplsource")." SET tpl_source='".$post_source."' WHERE tpl_id=$tpl_id" ) ;
	if( ! $result ) $errors[] = $tpl_id ;
	$result = $db->query( "UPDATE ".$db->prefix("tplfile")." SET tpl_lastmodified=UNIX_TIMESTAMP() WHERE tpl_id=$tpl_id" ) ;
	if( ! $result ) $errors[] = $tpl_id ;
	xoops_template_touch( $tpl_id ) ;

	// CONTINUE OR END ?
	if( ! empty( $_POST['do_modifycont'] ) ) {
		redirect_header(  XOOPS_URL."/modules/$mydirname/admin/index.php?page=mytplsform&tpl_id=".$tpl_id."&#dbcss_tplsform_top." , 2 , $errors ? sprintf( _MD_DBCSS_ERROR_MESSEAGE , implode( ',' , $errors ) ) : _MD_DBCSS_MYTPLSFORM_UPDATED ) ;
	} else {
		if( ! empty( $bid ) ) {
			redirect_header( XOOPS_URL."/modules/$mydirname/admin/index.php?mode=admin&lib=altsys&page=myblocksadmin&op=edit&bid=".$bid , 2 , $errors ? sprintf( _MD_DBCSS_ERROR_MESSEAGE , implode( ',' , $errors ) ) : _MD_DBCSS_MYTPLSFORM_UPDATED ) ;
		} else {
			redirect_header( XOOPS_URL."/modules/$mydirname/admin/index.php?page=export" , 2 , $errors ? sprintf( _MD_DBCSS_ERROR_MESSEAGE , implode( ',' , $errors ) ) : _MD_DBCSS_MYTPLSFORM_UPDATED ) ;
		}
	}
	exit() ;
}

// DISPLAY STAGE
xoops_cp_header();
include dirname(__FILE__).'/mymenu.php' ;
$tpl =& new XoopsTpl() ;
$tpl->assign( array(
	'mydirname' => $mydirname ,
	'mod_url' => XOOPS_URL.'/modules/'.$mydirname ,
	'page' => 'mytplsform' ,
	'diff_from_file4disp' => $diff_from_file4disp ,
	'diff_from_default4disp' => $diff_from_default4disp ,
	'cssfile' => $cssfile ,
	'gticket_hidden' => $xoopsGTicket->getTicketHtml( __LINE__ , 1800 , 'dbcss') ,
) ) ;
$tpl->display( 'db:'.$mydirname.'_admin_mytplsform.html' ) ;
xoops_cp_footer();

?>
