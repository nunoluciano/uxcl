<?php

$constpref = '_MI_' . strtoupper( $mydirname ) ;

$adminmenu = array(
	array(
		'title' => constant( $constpref.'_ADMENU_FILEMANAGER' ) ,
		'link' => 'admin/index.php?page=filemanager' ,
	) ,
	array(
		'title' => constant( $constpref.'_ADMENU_CATEGORYMANAGER' ) ,
		'link' => 'admin/index.php?page=categorymanager' ,
	) ,
	array(
		'title' => constant( $constpref.'_ADMENU_USER_ACCES' ) ,
		'link' => 'admin/index.php?page=user_access' ,
	) ,
	array(
		'title' => constant( $constpref.'_ADMENU_APPROVALMANAGER' ) ,
		'link' => 'admin/index.php?page=approvalmanager' ,
	) ,
	array(
		'title' => constant( $constpref.'_ADMENU_BROKENMANAGER' ) ,
		'link' => 'admin/index.php?page=brokenmanager' ,
	) ,
	array(
		'title' => constant( $constpref.'_ADMENU_IMPORT' ) ,
		'link' => 'admin/index.php?page=import' ,
	) ,
	array(
		'title' => constant( $constpref.'_ADMENU_CONFIG_CHECK' ) ,
		'link' => 'admin/index.php?page=config_check' ,
	) ,
) ;

$adminmenu4altsys = array(
	array(
		'title' => constant( $constpref.'_ADMENU_MYLANGADMIN' ) ,
		'link' => 'admin/index.php?mode=admin&lib=altsys&page=mylangadmin' ,
	) ,
	array(
		'title' => constant( $constpref.'_ADMENU_MYTPLSADMIN' ) ,
		'link' => 'admin/index.php?mode=admin&lib=altsys&page=mytplsadmin' ,
	) ,
	array(
		'title' => constant( $constpref.'_ADMENU_MYBLOCKSADMIN' ) ,
		'link' => 'admin/index.php?mode=admin&lib=altsys&page=myblocksadmin' ,
	) ,
	array(
		'title' => constant( $constpref.'_ADMENU_MYPREFERENCES' ) ,
		'link' => 'admin/index.php?mode=admin&lib=altsys&page=mypreferences' ,
	) ,
) ;

?>