<?php

// language file (modinfo.php)
if( file_exists( dirname( __FILE__ ).'/language/'.@$xoopsConfig['language'].'/modinfo.php' ) ) {
	include dirname( __FILE__ ).'/language/'.@$xoopsConfig['language'].'/modinfo.php' ;
} else if( file_exists( dirname( __FILE__ ).'/language/english/modinfo.php' ) ) {
	include dirname( __FILE__ ).'/language/english/modinfo.php' ;
}
$constpref = '_MI_' . strtoupper( $mydirname ) ;


$modversion['name'] = constant($constpref.'_NAME') ;
$modversion['description'] = constant($constpref.'_DESC') ;
$modversion['version'] = 1.03 ;
$modversion['credits'] = "t_yamo at unknown-artifacts.info";
$modversion['author'] = "t_yamo hacked by naao" ;
$modversion['help'] = "" ;
$modversion['license'] = "GPL" ;
$modversion['official'] = 0 ;
$modversion['image'] = 'module_icon.php' ;
$modversion['dirname'] = $mydirname ;

// Any tables can't be touched by modulesadmin.
$modversion['sqlfile'] = false ;
$modversion['tables'] = array() ;

// Admin things
$modversion['hasAdmin'] = 1 ;
$modversion['adminindex'] = 'admin/index.php' ;
$modversion['adminmenu'] = 'admin/admin_menu.php' ;

// Search
$modversion['hasSearch'] = 0 ;

// Menu
$modversion['hasMain'] = 1 ;

// Submenu (just for mainmenu)
$modversion['sub'] = array() ;
// if( is_object( @$GLOBALS['xoopsModule'] ) && $GLOBALS['xoopsModule']->getVar('dirname') == $mydirname ) {
// 	require_once dirname( __FILE__ ).'/include/common_functions.php' ;
// 	$modversion['sub'] = attachfile_get_submenu( $mydirname ) ;
// }

// All Templates can't be touched by modulesadmin.
$modversion['templates'] = array() ;

// Blocks
$modversion['blocks'] = array() ;

// Comments
$modversion['hasComments'] = 0 ;

// Configurations
$modversion['config'][] = array(
	'name'			=> 'link_enc' ,
	'title'			=> $constpref.'_LINK_ENC' ,
	'description'	=> $constpref.'_LINK_ENCDSC' ,
	'formtype'		=> 'textbox' ,
	'valuetype'		=> 'text' ,
	'default'		=> 'EUC-JP' ,
	'options'		=> array()
) ;

$modversion['config'][] = array(
	'name'			=> 'ttl_enc_ie' ,
	'title'			=> $constpref.'_TTL_ENC_IE' ,
	'description'	=> $constpref.'_TTL_ENC_IEDSC' ,
	'formtype'		=> 'textbox' ,
	'valuetype'		=> 'text' ,
	'default'		=> 'SJIS' ,
	'options'		=> array()
) ;

$modversion['config'][] = array(
	'name'			=> 'ttl_enc_oth' ,
	'title'			=> $constpref.'_TTL_ENC_OTH' ,
	'description'	=> $constpref.'_TTL_ENC_OTHDSC' ,
	'formtype'		=> 'textbox' ,
	'valuetype'		=> 'text' ,
	'default'		=> 'UTF8' ,
	'options'		=> array()
) ;

$modversion['config'][] = array(
	'name'			=> 'max_size' ,
	'title'			=> $constpref.'_MAX_SIZE' ,
	'description'	=> $constpref.'_MAX_SIZEDSC' ,
	'formtype'		=> 'textbox' ,
	'valuetype'		=> 'int' ,
	'default'		=> 1000 ,
	'options'		=> array()
) ;

$modversion['config'][] = array(
	'name'			=> 'mimem' ,
	'title'			=> $constpref.'_MIMEM' ,
	'description'	=> $constpref.'_MIMEMDSC' ,
	'formtype'		=> 'select' ,
	'valuetype'		=> 'int' ,
	'default'		=> 0 ,
	'options'		=> array(
						$constpref.'_MIMEM_NON_N'=>0 ,
						$constpref.'_MIMEM_DNY_N'=>1 ,
						$constpref.'_MIMEM_ALW_N'=>2
	)
) ;

$modversion['config'][] = array(
	'name'			=> 'mimet' ,
	'title'			=> $constpref.'_MIMET' ,
	'description'	=> $constpref.'_MIMETDSC' ,
	'formtype'		=> 'textbox' ,
	'valuetype'		=> 'text' ,
	'default'		=> '' ,
	'options'		=> array()
) ;

$modversion['config'][] = array(
	'name'			=> 'f_pre' ,
	'title'			=> $constpref.'_F_PRE' ,
	'description'	=> $constpref.'_F_PREDSC' ,
	'formtype'		=> 'select' ,
	'valuetype'		=> 'int' ,
	'default'		=> 0 ,
	'options'		=> array(
						$constpref.'_F_PRE_NON_N'=>0 ,
						$constpref.'_F_PRE_DBP_N'=>1 ,
						$constpref.'_F_PRE_DBN_N'=>2
	)
) ;


// Notification
$modversion['hasNotification'] = 0;

$modversion['onInstall'] = 'oninstall.php' ;
$modversion['onUpdate'] = 'onupdate.php' ;
$modversion['onUninstall'] = 'onuninstall.php' ;

// keep block's options
if( ! defined( 'XOOPS_CUBE_LEGACY' ) && substr( XOOPS_VERSION , 6 , 3 ) < 2.1 && ! empty( $_POST['fct'] ) && ! empty( $_POST['op'] ) && $_POST['fct'] == 'modulesadmin' && $_POST['op'] == 'update_ok' && $_POST['dirname'] == $modversion['dirname'] ) {
	include dirname( __FILE__ ).'/include/x20_keepblockoptions.inc.php' ;
}

?>