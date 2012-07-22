<?php

// Skip for ORETEKI XOOPS
if( defined( 'XOOPS_ORETEKI' ) ) return ;

global $xoopsModule ;
if( ! is_object( $xoopsModule ) ) die( '$xoopsModule is not set' )  ;

// language files (modinfo.php)
$language = empty( $xoopsConfig['language'] ) ? 'english' : $xoopsConfig['language'] ;
if( file_exists( "$mydirpath/language/$language/modinfo.php" ) ) {
	// user customized language file
	include_once "$mydirpath/language/$language/modinfo.php" ;
} else if( file_exists( "$mytrustdirpath/language/$language/modinfo.php" ) ) {
	// default language file
	include_once "$mytrustdirpath/language/$language/modinfo.php" ;
} else {
	// fallback english
	include_once "$mytrustdirpath/language/english/modinfo.php" ;
}

include dirname(dirname( __FILE__ )).'/admin_menu.php' ;

if( file_exists( XOOPS_TRUST_PATH.'/libs/altsys/mytplsadmin.php' ) ) {
	// mytplsadmin (TODO check if this module has tplfile)
	$title = defined( '_MD_A_MYMENU_MYTPLSADMIN' ) ? _MD_A_MYMENU_MYTPLSADMIN : 'tplsadmin' ;
	array_push( $adminmenu , array( 'title' => $title , 'link' => 'admin/index.php?mode=admin&lib=altsys&page=mytplsadmin' ) ) ;
}

if( file_exists( XOOPS_TRUST_PATH.'/libs/altsys/myblocksadmin.php' ) ) {
	// myblocksadmin
	$title = defined( '_MD_A_MYMENU_MYBLOCKSADMIN' ) ? _MD_A_MYMENU_MYBLOCKSADMIN : 'blocksadmin' ;
	array_push( $adminmenu , array( 'title' => $title , 'link' => 'admin/index.php?mode=admin&lib=altsys&page=myblocksadmin' ) ) ;
}

// preferences
$config_handler =& xoops_gethandler('config');
if( count( $config_handler->getConfigs( new Criteria( 'conf_modid' , $xoopsModule->mid() ) ) ) > 0 ) {
	if( file_exists( XOOPS_TRUST_PATH.'/libs/altsys/mypreferences.php' ) ) {
		// mypreferences
		$title = defined( '_MD_A_MYMENU_MYPREFERENCES' ) ? _MD_A_MYMENU_MYPREFERENCES : _PREFERENCES ;
		array_push( $adminmenu , array( 'title' => $title , 'link' => 'admin/index.php?mode=admin&lib=altsys&page=mypreferences' ) ) ;
	} else {
		// system->preferences
		array_push( $adminmenu , array( 'title' => _PREFERENCES , 'link' => XOOPS_URL.'/modules/system/admin.php?fct=preferences&op=showmod&mod='.$xoopsModule->mid() ) ) ;
	}
}

$mymenu_uri = empty( $mymenu_fake_uri ) ? $_SERVER['REQUEST_URI'] : $mymenu_fake_uri ;
$mymenu_link = substr( strstr( $mymenu_uri , '/admin/' ) , 1 ) ;



// highlight (you can customize the colors)
foreach( array_keys( $adminmenu ) as $i ) {
	if( $mymenu_link == $adminmenu[$i]['link'] ) {
		$adminmenu[$i]['color'] = '#FFCCCC' ;
		$adminmenu_hilighted = true ;
	} else {
		$adminmenu[$i]['color'] = '#DDDDDD' ;
	}
}
if( empty( $adminmenu_hilighted ) ) {
	foreach( array_keys( $adminmenu ) as $i ) {
		if( stristr( $mymenu_uri , $adminmenu[$i]['link'] ) ) {
			$adminmenu[$i]['color'] = '#FFCCCC' ;
			break ;
		}
	}
}

// link conversion from relative to absolute
foreach( array_keys( $adminmenu ) as $i ) {
	if( stristr( $adminmenu[$i]['link'] , XOOPS_URL ) === false ) {
		$adminmenu[$i]['link'] = XOOPS_URL."/modules/$mydirname/" . $adminmenu[$i]['link'] ;
	}
}

// display (you can customize htmls)
echo "<div style='text-align:left;width:98%;'>" ;
foreach( $adminmenu as $menuitem ) {
	echo "<div style='float:left;height:1.5em;'><nobr><a href='".htmlspecialchars($menuitem['link'],ENT_QUOTES)."' style='background-color:{$menuitem['color']};font:normal normal bold 9pt/12pt;'>".htmlspecialchars($menuitem['title'],ENT_QUOTES)."</a> | </nobr></div>\n" ;
}
echo "</div>\n<hr style='clear:left;display:block;' />\n" ;

// for attachfile
// altsys_functions.php - altsys_include_mymenu() does not specify
// $xoopsModuleConfig in global.
// So this file emulates include/common.php by myself.
if ($xoopsModule->getVar('hasconfig') == 1 || $xoopsModule->getVar('hascomments') == 1 || $xoopsModule->getVar( 'hasnotification' ) == 1) {
    $xoopsModuleConfig =& $config_handler->getConfigsByCat(0, $xoopsModule->getVar('mid'));
}
$error_msg = '';
$uploads_path = XOOPS_TRUST_PATH."/uploads/".$mydirname ;
if( strpos( $uploads_path, ".." ) )  $error_msg = _MD_ATTACHFILE_ERR_INVALIDUPLOADSPATH ;
if( ! is_dir( $uploads_path ) ) $error_msg = _MD_ATTACHFILE_ERR_NONUPLOADSPATH ;
if( ! is_writable( $uploads_path ) || ! is_readable( $uploads_path ) ) $error_msg = _MD_ATTACHFILE_ERR_DENYUPLOADSPATH ;
if( $error_msg != '' ) {
	echo "<div style='background-color: #ff0000; padding: 5px; color: #ffffff; font-weight: bold;'>$error_msg<br/>$uploads_path</div>" ;
}

?>