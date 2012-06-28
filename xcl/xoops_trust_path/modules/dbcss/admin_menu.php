<?php

$constpref = '_MI_' . strtoupper( $mydirname ) ;

$adminmenu = array(
	array(
		'title' => constant( $constpref.'_ADMENU_CSSADMIN' ) ,
		'link' => 'admin/index.php?page=export' ,
	) ,
	array(
		'title' => constant( $constpref.'_ADMENU_METAHEAD' ) ,
		'link' => 'admin/index.php?page=metalink' ,
	) ,
	array(
		'title' => constant( $constpref.'_ADMENU_SCRIPTHEAD' ) ,
		'link' => 'admin/index.php?page=scriptlink' ,
	) ,

) ;

$adminmenu4altsys = array(
	array(
		'title' => 'Themes' ,
		'link' => ''.XOOPS_URL.'/modules/legacy/admin/index.php?action=ThemeList' ,
	) ,
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