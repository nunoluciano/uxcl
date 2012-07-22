<?php

require_once dirname( dirname(__FILE__) ).'/include/upload_functions.php' ;

$db =& Database::getInstance() ;
global $xoopsConfig ;

// this page can be called only from d3downloads
if( $xoopsModule->getVar('dirname') != $mydirname ) die( 'this page can be called only from '.$mydirname ) ;

// permission error
$module_handler =& xoops_gethandler( 'module' ) ;
$module =& $module_handler->getByDirname( $mydirname ) ;
$moduleperm_handler =& xoops_gethandler( 'groupperm' ) ;
$mid = $module->getVar('mid') ;
if( ! is_object( @$xoopsUser ) || ! $moduleperm_handler->checkRight( 'module_admin' , $mid , $xoopsUser->getGroups() ) ) {
	die( 'Only administrator can use this feature.' ) ;
}

xoops_cp_header();
include dirname(__FILE__).'/mymenu.php' ;

echo '<h2>'._MD_D3DOWNLOADS_H2_CONFIG_CHECK.'</h2>';
echo '<div style="color:inherit;border: 1px inset #CCC;padding: 5px;with: 80%;">';

echo '<ul>';

// config_check
$maxfilesize = ! empty( $GLOBALS['xoopsModuleConfig']['maxfilesize'] )? intval( $GLOBALS['xoopsModuleConfig']['maxfilesize'] ) * 1024  : 1000 * 1024;
echo '<li>'.sprintf( _MD_D3DOWNLOADS_MAXFILESIZE , number_format( $maxfilesize ) );

// uploaddir_check
echo '<li>'._MD_D3DOWNLOADS_UPLOADDIR_CHECK ;
echo '<ul style="margin-left:2em">';
$upload_dir = XOOPS_TRUST_PATH.'/uploads/'.$mydirname.'/' ;
$safe_mode = ini_get( "safe_mode" ) ;
echo '<li>'._MD_D3DOWNLOADS_UPLOADDIR_CONFIFG.'<span style="padding-left:1em">'.$upload_dir.'</span>';
if( ! is_dir( XOOPS_TRUST_PATH.'/uploads/' ) ) {
	echo '<br /><span style="color:red;font-weight:bold;padding-left:1em;">'._MD_D3DOWNLOADS_UPLOADDIR_NOT_IS_DIR.'</span>';
} elseif ( ! is_dir( $upload_dir ) ) {
	if( $safe_mode ) {
		echo '<br /><span style="color:red;font-weight:bold;padding-left:1em;">'._MD_D3DOWNLOADS_UPLOADDIR_NOT_IS_DIR.'</span>';
	} elseif ( ! mkdir( $upload_dir , 0777 ) ) {
		echo '<br /><span style="color:red;font-weight:bold;padding-left:1em;">'._MD_D3DOWNLOADS_UPLOADDIR_NOT_MKDIR.'</span>';
	}
} elseif ( ! is_writeable( $upload_dir ) ) {
	if( ! chmod( $upload_dir , 0777 ) ) {
		echo '<br /><span style="color:red;font-weight:bold;padding-left:1em;">'._MD_D3DOWNLOADS_UPLOADDIR_NOT_IS_WRITEABLE.'</span>';
	}
} else {
	echo '<span style="color:green;font-weight:bold;padding-left:1em;">OK</span></li>';
}
if( is_dir( $upload_dir ) ) {
	require_once dirname( dirname(__FILE__) ).'/class/broken_download.php' ;
	$broken_report = new broken_report( $mydirname ) ;
	$filecount = $broken_report->File_Count();
	$nolinkfile = $filecount['nolink'];
	$totalfile = $filecount['total'];
	echo '<li>'._MD_D3DOWNLOADS_NOLINK_CHECK.'<span style="color:green;font-weight:bold;padding-left:1em;">'.$nolinkfile.' Files ( total '.$totalfile.' Files )</span>';
}

echo '</ul>';

// cachedir_check
echo '<li>'._MD_D3DOWNLOADS_CACHEDIR_CHECK ;
echo '<ul style="margin-left:2em">';
$cache_dir = XOOPS_TRUST_PATH.'/cache/' ;
echo '<li>'._MD_D3DOWNLOADS_CACHEDIR_CONFIFG.'<span style="padding-left:1em">'.$cache_dir.'</span>';
if( ! is_dir( $cache_dir ) ) {
	if( $safe_mode ) {
		echo '<br /><span style="color:red;font-weight:bold;padding-left:1em;">'._MD_D3DOWNLOADS_CACHEDIR_NOT_IS_DIR.'</span>';
	} elseif ( ! mkdir( $cache_dir , 0777 ) ) {
		echo '<br /><span style="color:red;font-weight:bold;padding-left:1em;">'._MD_D3DOWNLOADS_CACHEDIR_NOT_MKDIR.'</span>';
	}
} elseif ( ! is_writeable( $cache_dir ) ) {
	if( ! chmod( $cache_dir , 0777 ) ) {
		echo '<br /><span style="color:red;font-weight:bold;padding-left:1em;">'._MD_D3DOWNLOADS_CACHEDIR_NOT_IS_WRITEABLE.'</span>';
	}
} else {
	echo '<span style="color:green;font-weight:bold;padding-left:1em;">OK</span></li>';
}
echo '</ul>';

// system
echo '<li>'._MD_D3DOWNLOADS_SYSTEM_CHECK ;
echo '<ul style="margin-left:2em">';

echo '<li>XOOPS<span style="padding-left:1em">'.XOOPS_VERSION.'</span></li>';
echo '<li>LANGUAGE<span style="padding-left:1em">'.$xoopsConfig['language'].'</span></li>';
echo '<li>SERVER<span style="padding-left:1em">'.$_SERVER['SERVER_SOFTWARE'].'</span></li>';
echo '<li>PHP<span style="padding-left:1em">'.phpversion().'</span></li>';
list( $SV ) = $db->fetchRow( $db->query( 'SELECT version()' ) );
echo '<li>MySQL<span style="padding-left:1em">'.$SV.'</span></li>';
$module_handler =& xoops_gethandler('module');
$module =& $module_handler->getByDirname( $mydirname );
$version =intval( $module->getVar( 'version' ) ) / 100;
echo '<li>d3downloads<span style="padding-left:1em">v'.$version.'</span></li>';
$module4altsys =& $module_handler->getByDirname( 'altsys' );
$version4altsys =intval( $module4altsys->getVar( 'version' ) ) / 100 ;
echo '<li>altsys<span style="padding-left:1em">v'.$version4altsys.'</span>';
echo ( $version4altsys >= 0.61 ) ? '<span style="color:green;font-weight:bold;padding-left:1em;">OK</span></li>':'<span style="color:red;font-weight:bold;padding-left:1em;">NG</span></li>';

echo '</ul>';

// phpini_check
echo '<li>'._MD_D3DOWNLOADS_PHPINI_CHECK ;
echo '<ul style="margin-left:2em">';

// file_uploads
echo '<li>file_uploads';
echo ini_get('file_uploads')? '<span style="color:green;font-weight:bold;padding-left:1em;">OK</span></li>' : '<span style="color:red;font-weight:bold;padding-left:1em;">NG</span></li>';

// upload_max_filesize
$upload_max_filesize = d3download_return_bytes( ini_get( 'upload_max_filesize' ) );
echo '<li>upload_max_filesize<span style="padding-left:1em">'. number_format( $upload_max_filesize ).' byte</span>';
echo ( $upload_max_filesize > $maxfilesize )? '<span style="color:green;font-weight:bold;padding-left:1em;">OK</span></li>' : '<span style="color:red;font-weight:bold;padding-left:1em;">NG</span></li>';

// post_max_size
$post_max_size = d3download_return_bytes( ini_get( 'post_max_size' ) );
echo '<li>post_max_size<span style="padding-left:1em">';
echo number_format( $post_max_size ).' byte</span>';
echo ( $maxfilesize <= $post_max_size ) ? '<span style="color:green;font-weight:bold;padding-left:1em;">OK</span></li>':'<span style="color:red;font-weight:bold;padding-left:1em;">NG</span></li>';

// open_basedir
$open_basedir = ini_get( 'open_basedir' );
echo '<li>open_basedir';
echo ( $open_basedir ) ? '<span style="color:green;font-weight:bold;padding-left:1em;">'.$open_basedir.'</span></li>':'<span style="color:green;font-weight:bold;padding-left:1em;">noting</span></li>';

// path_separator
if( ! defined( 'PATH_SEPARATOR' ) ) {
	if( DIRECTORY_SEPARATOR == '/' ) define( 'PATH_SEPARATOR' , ':' ) ;
	else define( 'PATH_SEPARATOR' , ';' ) ;
}

// upload_tmp_dir
$upload_tmp_dir = ini_get( 'upload_tmp_dir' );
$tmp_dirs = explode( PATH_SEPARATOR , $upload_tmp_dir ) ;
echo '<li>upload_tmp_dir';
foreach( $tmp_dirs as $dir ){
	echo '<span style="padding-left:1em">'.$dir.'</span>';
	if( $dir != "" && ( ! is_writable( $dir ) || ! is_readable( $dir ) ) ) {
		echo '<br /><span style="color:red;font-weight:bold;padding-left:1em;">'._MD_D3DOWNLOADS_UPLOAD_TMP_DIR_IS_NOTWRITEABLE.'</span>';
	} else {
		echo '<span style="color:green;font-weight:bold;padding-left:1em;">OK</span></li>';
	}
}

// memory_limit
$memory_limit = ini_get( 'memory_limit' );
if( ! empty( $memory_limit ) ){
	echo '<li>memory_limit<span style="padding-left:1em">';
	echo $memory_limit.'</span>';
}

// max_execution_time
$max_execution_time = ini_get( 'max_execution_time' );
echo '<li>max_execution_time<span style="padding-left:1em">';
echo $max_execution_time.'s</span>';

// safe_mode
echo '<li>safe_mode<span style="padding-left:1em">'.( ( $safe_mode ) ? "on" : "off").'</span></li>';

// register_globals
$register_globals = ini_get( 'register_globals' );
echo '<li>register_globals<span style="padding-left:1em">'.( ( $register_globals ) ? "on" : "off").'</span></li>';

// output_buffering
echo '<li>output_buffering<span style="padding-left:1em">'.ini_get('output_buffering').'</span></li>';

// output_handler
echo '<li>output_handler<span style="padding-left:1em">'.ini_get('output_handler').'</span></li>';

// default_charset
echo '<li>default_charset<span style="padding-left:1em">'.ini_get('default_charset').'</span></li>';

// multibyte extention
echo '<li>multibyte extention<span style="padding-left:1em">'.( ( extension_loaded( 'mbstring' ) ) ? "loaded" : "not loaded").'</span></li>';
if ( extension_loaded( 'mbstring' ) ){
	echo '<li>mbstring.language<span style="padding-left:1em">'.ini_get('mbstring.language').'</span></li>';
	echo '<li>mbstring.encoding_translation<span style="padding-left:1em">'.ini_get('mbstring.encoding_translation').'</span></li>';
	echo '<li>mbstring.internal_encoding<span style="padding-left:1em">'.ini_get('mbstring.internal_encoding').'</span></li>';
	echo '<li>mbstring.http_input<span style="padding-left:1em">'.ini_get('mbstring.http_input').'</span></li>';
	echo '<li>mbstring.http_output<span style="padding-left:1em">'.ini_get('mbstring.http_output').'</span></li>';
	echo '<li>mbstring.detect_order <span style="padding-left:1em">'.ini_get('mbstring.detect_order').'</span></li>';
	echo '<li>mbstring.substitute_character<span style="padding-left:1em">'.ini_get('mbstring.substitute_character').'</span></li>';
	echo '<li>mbstring.func_overload <span style="padding-left:1em">'.ini_get('mbstring.func_overload').'</span></li>';
}

echo '</ul>';

$v = substr( $SV, 0, 3 ) ;
if ( $v >= 4.1 ) {
	echo '<li>MySQL CHARACTER SET' ;
	echo '<ul style="margin-left:2em">';
	echo '<li>version<span style="padding-left:1em">'.$SV.'</span></li>' ;
	$result = $db->queryF( "SHOW VARIABLES LIKE 'character\_set\_%'" ) ;
	while ( list( $key, $value ) = $db->fetchRow( $result ) ) {
		echo '<li>'.$key.'<span style="padding-left:1em">'.$value.'</span></li>' ;
	}
	echo '</ul>';
}

// table
echo '<li>'._MD_D3DOWNLOADS_TABLE_CHECK ;
echo '<ul style="margin-left:2em">';
$rs = $db->query( "SELECT COUNT(cid) FROM ".$db->prefix( $mydirname."_cat" )."" ) ;
list( $num_cat ) = $db->fetchRow( $rs ) ;
echo '<li>'.$mydirname.'_cat';
echo ( $rs ) ? '<span style="color:green;font-weight:bold;padding-left:1em;">OK ( '.intval( $num_cat ).' Records )</span></li>':'<span style="color:red;font-weight:bold;padding-left:1em;">Error</span></li>';

$rs = $db->query( "SELECT COUNT(lid) FROM ".$db->prefix( $mydirname."_downloads" )."" ) ;
list( $num_down ) = $db->fetchRow( $rs ) ;
echo '<li>'.$mydirname.'_downloads';
echo ( $rs ) ? '<span style="color:green;font-weight:bold;padding-left:1em;">OK ( '.intval( $num_down ).' Records )</span></li>':'<span style="color:red;font-weight:bold;padding-left:1em;">Error</span></li>';

$rs = $db->query( "SELECT COUNT(reportid) FROM ".$db->prefix( $mydirname."_broken" )."" ) ;
list( $num_broken ) = $db->fetchRow( $rs ) ;
echo '<li>'.$mydirname.'_broken';
echo ( $rs ) ? '<span style="color:green;font-weight:bold;padding-left:1em;">OK ( '.intval( $num_broken ).' Records )</span></li>':'<span style="color:red;font-weight:bold;padding-left:1em;">Error</span></li>';

$rs = $db->query( "SELECT COUNT(requestid) FROM ".$db->prefix( $mydirname."_unapproval" )."" ) ;
list( $num_unapproval ) = $db->fetchRow( $rs ) ;
echo '<li>'.$mydirname.'_unapproval';
echo ( $rs ) ? '<span style="color:green;font-weight:bold;padding-left:1em;">OK ( '.intval( $num_unapproval ).' Records )</span></li>':'<span style="color:red;font-weight:bold;padding-left:1em;">Error</span></li>';

$rs = $db->query( "SELECT COUNT(id) FROM ".$db->prefix( $mydirname."_downloads_history" )."" ) ;
list( $num_history ) = $db->fetchRow( $rs ) ;
echo '<li>'.$mydirname.'_downloads_history';
echo ( $rs ) ? '<span style="color:green;font-weight:bold;padding-left:1em;">OK ( '.intval( $num_history ).' Records )</span></li>':'<span style="color:red;font-weight:bold;padding-left:1em;">Error</span></li>';

$rs = $db->query( "SELECT COUNT(cid) FROM ".$db->prefix( $mydirname."_user_access" )."" ) ;
list( $num_access ) = $db->fetchRow( $rs ) ;
echo '<li>'.$mydirname.'_user_access';
echo ( $rs ) ? '<span style="color:green;font-weight:bold;padding-left:1em;">OK ( '.intval( $num_access ).' Records )</span></li>':'<span style="color:red;font-weight:bold;padding-left:1em;">Error</span></li>';

$rs = $db->query( "SELECT COUNT(ratingid) FROM ".$db->prefix( $mydirname."_votedata" )."" ) ;
list( $num_votedata ) = $db->fetchRow( $rs ) ;
echo '<li>'.$mydirname.'_votedata';
echo ( $rs ) ? '<span style="color:green;font-weight:bold;padding-left:1em;">OK ( '.intval( $num_votedata ).' Records )</span></li>':'<span style="color:red;font-weight:bold;padding-left:1em;">Error</span></li>';

$rs = $db->query( "SELECT COUNT(uid) FROM ".$db->prefix( $mydirname."_mylink" )."" ) ;
list( $num_mylink ) = $db->fetchRow( $rs ) ;
echo '<li>'.$mydirname.'_mylink';
echo ( $rs ) ? '<span style="color:green;font-weight:bold;padding-left:1em;">OK ( '.intval( $num_mylink ).' Records )</span></li>':'<span style="color:red;font-weight:bold;padding-left:1em;">Error</span></li>';

echo '</ul>';

//echo '<center>---- phpinfo() ----</center><br />';
//echo phpinfo();

echo '</div>';

xoops_cp_footer();

?>