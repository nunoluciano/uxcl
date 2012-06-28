<?php

// language file (modinfo.php)
$langmanpath = XOOPS_TRUST_PATH.'/libs/altsys/class/D3LanguageManager.class.php' ;
if( ! file_exists( $langmanpath ) ) die( 'install the latest altsys' ) ;
require_once( $langmanpath ) ;
$langman =& D3LanguageManager::getInstance() ;
$langman->read( 'modinfo.php' , $mydirname , $mytrustdirname , false ) ;

$constpref = '_MI_' . strtoupper( $mydirname ) ;

$modversion['name'] = $mydirname ;
$modversion['version'] = 1.20 ;
$modversion['description'] = constant($constpref.'_DESC') ;
$modversion['credits'] = "photosite";
$modversion['author'] = "photosite(http://www.photositelinks.com/)" ;
$modversion['help'] = "" ;
$modversion['license'] = "GPL" ;
$modversion['official'] = 0 ;
$modversion['image'] = file_exists( $mydirpath.'/module_icon.png' ) ? 'module_icon.png' : 'module_icon.php' ;
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
$modversion['hasMain'] = 0 ;

// There are no submenu (use menu moudle instead of mainmenu)
$modversion['sub'] = array() ;

// All Templates can't be touched by modulesadmin.
$modversion['templates'] = array() ;

// Blocks
$modversion['blocks'][1] = array(
	'file'			=> 'blocks.php' ,
	'name'			=> constant($constpref.'_BNAME_DBCSSHOOK') ,
	'description'	=> '' ,
	'show_func'		=> 'b_dbcss_dbhook_show' ,
	'edit_func'		=> 'b_dbcss_dbhook_edit' ,
	'options'		=> "$mydirname||0|all" ,
	'template'		=> '' , // use "module" template instead
	'can_clone'		=> true ,
) ;

$modversion['blocks'][2] = array(
	'file'			=> 'blocks.php' ,
	'name'			=> constant($constpref.'_BNAME_CSSHOOK') ,
	'description'	=> '' ,
	'show_func'		=> 'b_dbcss_hook_show' ,
	'edit_func'		=> 'b_dbcss_hook_edit' ,
	'options'		=> "$mydirname||0|all" ,
	'template'		=> '' , // use "module" template instead
	'can_clone'		=> true ,
) ;

$modversion['blocks'][3] = array(
	'file'			=> 'blocks.php' ,
	'name'			=> constant($constpref.'_BNAME_METAHOOK') ,
	'description'	=> '' ,
	'show_func'		=> 'b_dbcss_metahook_show' ,
	'edit_func'		=> '' ,
	'options'		=> "$mydirname" ,
	'template'		=> '' , // use "module" template instead
	'can_clone'		=> true ,
) ;

$modversion['blocks'][4] = array(
	'file'			=> 'blocks.php' ,
	'name'			=> constant($constpref.'_BNAME_SCRIPTHOOK') ,
	'description'	=> '' ,
	'show_func'		=> 'b_dbcss_scripthook_show' ,
	'edit_func'		=> 'b_dbcss_scripthook_edit' ,
	'options'		=> "$mydirname||0" ,
	'template'		=> '' , // use "module" template instead
	'can_clone'		=> true ,
) ;

// Comments
$modversion['hasComments'] = 0 ;

// Configs
$modversion['config'][1] = array(
	'name'			=> 'css_template' ,
	'title'			=> $constpref.'_CSS_TEMPLATE' ,
	'description'	=> $constpref.'_CSS_TEMPLATEDSC' ,
	'formtype'		=> 'textbox' ,
	'valuetype'		=> 'text' ,
	'default'		=> 'common.css' ,
	'options'		=> array()
) ;

$modversion['config'][] = array(
	'name'			=> 'css_uri' ,
	'title'			=> $constpref.'_CSS_URI' ,
	'description'	=> $constpref.'_CSS_URIDSC' ,
	'formtype'		=> 'textbox' ,
	'valuetype'		=> 'text' ,
	'default'		=> '<{$xoops_url}>/common/css/common.css' ,
	'options'		=> array()
) ;

$modversion['config'][] = array(
	'name'			=> 'css_cache_time' ,
	'title'			=> $constpref.'_CSSCACHETIME' ,
	'description'	=> '' ,
	'formtype'		=> 'textbox' ,
	'valuetype'		=> 'int' ,
	'default'		=> 3600 ,
	'options'		=> array()
) ;

$modversion['config'][] = array(
	'name'			=> 'css_export_dir' ,
	'title'			=> $constpref.'_CSSEXPORT_DIR' ,
	'description'	=> $constpref.'_CSSEXPORT_DIRDSC' ,
	'formtype'		=> 'textbox' ,
	'valuetype'		=> 'text' ,
	'default'		=> 'common/css/' ,
	'options'		=> array()
) ;

$modversion['config'][] = array(
	'name'			=> 'meta_data_cashe' ,
	'title'			=> $constpref.'_METADATA_CASHE' ,
	'description'	=> $constpref.'_METADATA_CASHEDSC' ,
	'formtype'		=> 'yesno' ,
	'valuetype'		=> 'int' ,
	'default'		=> '1' ,
	'options'		=> array()
) ;

$modversion['config'][] = array(
	'name'			=> 'script_data_cashe' ,
	'title'			=> $constpref.'_SCRIPTDATA_CASHE' ,
	'description'	=> $constpref.'_SCRIPTDATA_CASHEDSC' ,
	'formtype'		=> 'yesno' ,
	'valuetype'		=> 'int' ,
	'default'		=> '0' ,
	'options'		=> array()
) ;

// Notification
$modversion['hasNotification'] = 0 ;

$modversion['onInstall'] = 'oninstall.php' ;
$modversion['onUpdate'] = 'onupdate.php' ;
$modversion['onUninstall'] = 'onuninstall.php' ;

// keep block's options
if( ! defined( 'XOOPS_CUBE_LEGACY' ) && substr( XOOPS_VERSION , 6 , 3 ) < 2.1 && ! empty( $_POST['fct'] ) && ! empty( $_POST['op'] ) && $_POST['fct'] == 'modulesadmin' && $_POST['op'] == 'update_ok' && $_POST['dirname'] == $modversion['dirname'] ) {
	include dirname(__FILE__).'/include/x20_keepblockoptions.inc.php' ;
}

?>