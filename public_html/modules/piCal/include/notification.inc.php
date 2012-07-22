<?php
// $Id: notification.inc.php,v 1.1 2003/04/01 23:40:27 w4z004 Exp $
//  ------------------------------------------------------------------------ //
//                XOOPS - PHP Content Management System                      //
//                    Copyright (c) 2000 XOOPS.org                           //
//                       <http://www.xoops.org/>                             //
//  ------------------------------------------------------------------------ //
//  This program is free software; you can redistribute it and/or modify     //
//  it under the terms of the GNU General Public License as published by     //
//  the Free Software Foundation; either version 2 of the License, or        //
//  (at your option) any later version.                                      //
//                                                                           //
//  You may not change or alter any portion of this comment or credits       //
//  of supporting developers from this source code or any supporting         //
//  source code which is considered copyrighted (c) material of the          //
//  original comment or credit authors.                                      //
//                                                                           //
//  This program is distributed in the hope that it will be useful,          //
//  but WITHOUT ANY WARRANTY; without even the implied warranty of           //
//  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the            //
//  GNU General Public License for more details.                             //
//                                                                           //
//  You should have received a copy of the GNU General Public License        //
//  along with this program; if not, write to the Free Software              //
//  Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307 USA //
//  ------------------------------------------------------------------------ //

if( ! defined( 'XOOPS_ROOT_PATH' ) ) exit ;

$mydirname = basename( dirname( dirname( __FILE__ ) ) ) ;
if( ! preg_match( '/^(\D+)(\d*)$/' , $mydirname , $regs ) ) die ( "invalid dirname: " . htmlspecialchars( $mydirname ) ) ;
$mydirnumber = $regs[2] === '' ? '' : intval( $regs[2] ) ;

eval( '

function pical'.$mydirnumber.'_notify_iteminfo($not_category, $item_id)
{
	global $xoopsModule, $xoopsModuleConfig, $xoopsConfig , $xoopsDB ;

	if (empty($xoopsModule) || $xoopsModule->getVar("dirname") != "'.$mydirname.'") {
		$module_handler =& xoops_gethandler("module");
		$module =& $module_handler->getByDirname("'.$mydirname.'");
		$config_handler =& xoops_gethandler("config");
		$config =& $config_handler->getConfigsByCat(0,$module->getVar("mid"));
	} else {
		$module =& $xoopsModule;
		$config =& $xoopsModuleConfig;
	}
	$mod_url = XOOPS_URL . "/modules/" . $module->getVar("dirname") ;

	$myts =& MyTextSanitizer::getInstance();

	if ($not_category=="global") {
		$item["name"] = "";
		$item["url"] = "";
	} else if( $not_category == "category" ) {
		// Assume we have a valid cid
		$sql = "SELECT cat_title FROM ".$xoopsDB->prefix("pical'.$mydirnumber.'_cat")." WHERE cid=\'$item_id\'";
		$rs = $xoopsDB->query( $sql ) ;
		list( $cat_title ) = $xoopsDB->fetchRow( $rs ) ;
		$item["name"] = $myts->makeTboxData4Show( $cat_title ) ;
		$item["url"] = "$mod_url/index.php?smode=List&amp;cid=$item_id" ;
	} else if( $not_category == "event" ) {
		// Assume we have a valid event_id
		$sql = "SELECT summary,start FROM ".$xoopsDB->prefix("pical'.$mydirnumber.'_event")." WHERE id=$item_id";
		$rs = $xoopsDB->query( $sql ) ;
		list( $summary , $start ) = $xoopsDB->fetchRow( $rs ) ;
		$start_str = formatTimestamp( $start , "s" ) ;
		$item["name"] = $myts->makeTboxData4Show( "[$start_str] $summary" ) ;
		$item["url"] = "$mod_url/index.php?action=View&amp;event_id=$item_id" ;
	}

	return $item;
}

' ) ;

?>
