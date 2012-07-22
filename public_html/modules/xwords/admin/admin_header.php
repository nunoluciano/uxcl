<?php
/**
 * $Id: admin_header.php v 1.0 8 May 2004 hsalazar Exp $
 * Module: Wordbook - a multicategory glossary
 * Version: v 1.00
 * Release Date: 8 May 2004
 * Author: hsalazar
 * Licence: GNU
 */
// XOOPS2 - Xwords 0.42
// Presented by WEBMASTER @ KANPYO.NET, 2004.

$mydirname = basename( dirname( dirname( __FILE__ ) ) ) ;
$MYDIRNAME = strtoupper($mydirname);

include ( '../../../include/cp_header.php' );
include_once ( XOOPS_ROOT_PATH."/modules/$mydirname/include/functions.php" );
include_once ( XOOPS_ROOT_PATH."/class/xoopsmodule.php" );
include_once ( XOOPS_ROOT_PATH."/class/xoopstree.php" );
include_once ( XOOPS_ROOT_PATH."/class/xoopslists.php" );
include_once ( XOOPS_ROOT_PATH."/class/xoopsformloader.php" );

$xoopsModule = XoopsModule::getByDirname("$mydirname");
$cat_table = $xoopsDB -> prefix ("{$mydirname}_cat") ;
$ent_table = $xoopsDB -> prefix ("{$mydirname}_ent") ;

if ( file_exists(XOOPS_ROOT_PATH."/modules/$mydirname/language/".$xoopsConfig['language']."/main.php") ) 
	{
	include XOOPS_ROOT_PATH."/modules/$mydirname/language/".$xoopsConfig['language']."/main.php";
	}
else 
	{
	include XOOPS_ROOT_PATH."/modules/$mydirname/language/english/main.php";
	}

if( ! class_exists( 'XwordsTextSanitizer' ) )
	{
	include_once( XOOPS_ROOT_PATH . "/modules/$mydirname/class/xwords.textsanitizer.php" ) ;
	}
$myts = & XwordsTextSanitizer::getInstance();

?>