<?php

$constpref = '_MI_'.strtoupper($mydirname);

$adminmenu = array(
	array(
		'title' => constant($constpref.'_AD_MENU_CATEGORY'),
		'link' => "admin/index.php?act=category",
	),
	array(
		'title' => constant($constpref.'_AD_MENU_IMAGE'),
		'link' => "admin/index.php?act=image",
	),
	array(
		'title' => constant($constpref.'_AD_MENU_FILE'),
		'link' => "admin/index.php?act=file",
	),
	array(
		'title' => constant($constpref.'_AD_MENU_ACCESS'),
		'link' => "admin/index.php?act=access",
	),
);

$adminmenu4altsys = array(
	array(
		'title' => constant($constpref.'_AD_MENU_MYTPLSADMIN'),
		'link' => 'admin/lib.php?mode=admin&lib=altsys&page=mytplsadmin',
	) ,
	array(
		'title' => constant($constpref.'_AD_MENU_MYBLOCKSADMIN'),
		'link' => 'admin/lib.php?mode=admin&lib=altsys&page=myblocksadmin',
	) ,
	array(
		'title' => constant($constpref.'_AD_MENU_MYPREFERENCES'),
		'link' => 'admin/lib.php?mode=admin&lib=altsys&page=mypreferences',
	) ,
) ;

?>