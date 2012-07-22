<?php

$constpref = '_MI_' . strtoupper( $mydirname ) ;

$adminmenu = array(
	array(
		'title' => constant( $constpref.'_ADMENU_LIST' ) ,
		'link' => 'admin/index.php?page=list' ,
	) ,
) ;

?>