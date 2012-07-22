<?php
// $Id: comment_new.php,v 1.1 2003/03/21 01:19:54 daniel Exp $
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

include '../../mainfile.php';

// for "Duplicatable"
$mydirname = basename( dirname( __FILE__ ) ) ;
if( ! preg_match( '/^(\D+)(\d*)$/' , $mydirname , $regs ) ) echo ( "invalid dirname: " . htmlspecialchars( $mydirname ) ) ;
$mydirnumber = $regs[2] === '' ? '' : intval( $regs[2] ) ;

// MySQLへの接続
$conn = $xoopsDB->conn ;

// setting physical & virtual paths
$mod_path = XOOPS_ROOT_PATH."/modules/$mydirname" ;
$mod_url = XOOPS_URL."/modules/$mydirname" ;

// クラス定義の読み込み
if( ! class_exists( 'piCal_xoops' ) ) {
	require_once( "$mod_path/class/piCal.php" ) ;
	require_once( "$mod_path/class/piCal_xoops.php" ) ;
}

// creating an instance of piCal 
$cal = new piCal_xoops( "" , $xoopsConfig['language'] , true ) ;

// setting properties of piCal
$cal->conn = $conn ;
include( "$mod_path/include/read_configs.php" ) ;
$cal->base_url = $mod_url ;
$cal->base_path = $mod_path ;
$cal->images_url = "$mod_url/images/$skin_folder" ;
$cal->images_path = "$mod_path/images/$skin_folder" ;

$event_id = empty( $_GET['com_itemid'] ) ? 0 : intval( $_GET['com_itemid'] ) ;
if( $event_id > 0 ) {
	$rs = $xoopsDB->query( "SELECT summary,rrule_pid FROM $cal->table WHERE id=$event_id AND admission>0" ) ;
	@list( $title , $rrule_pid ) = $xoopsDB->fetchRow( $rs ) ;
	// check valid id
	if( empty( $title ) ) die( "Invalid event_id" ) ;
	$com_replytitle = $title ;

	// RRULE events
	if( $rrule_pid != 0 ) {
		$_GET['com_itemid'] = $rrule_pid ;
		$HTTP_GET_VARS['com_itemid'] = $rrule_pid ;
	}

	include XOOPS_ROOT_PATH.'/include/comment_new.php';
}
?>