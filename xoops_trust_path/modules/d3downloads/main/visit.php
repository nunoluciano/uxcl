<?php

// $Id: visit.php,v 1.1 2004/01/29 14:45:12 buennagel Exp $
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
//
//  modify by photosite 2008/03/08 13:21:56 for d3downloads
//  Marijuana ‚³‚ñ‚Ì mydownloads+ ‚ðŽQl‚É‚³‚¹‚Ä‚¢‚½‚¾‚«AC³‚µ‚Ü‚µ‚½
//

include_once dirname( dirname(__FILE__) ).'/class/user_access.php' ;
include_once dirname( dirname(__FILE__) ).'/class/mydownload.php' ;
require_once dirname( dirname(__FILE__) ).'/include/download_functions.php' ;
include_once dirname( dirname(__FILE__) ).'/include/common_functions.php' ;

$cid = isset( $_GET['cid'] ) ? intval( $_GET['cid'] ) : 0 ;
$lid = isset( $_GET['lid'] ) ? intval( $_GET['lid'] ) : 0 ;
$second = isset( $_GET['second'] ) ? intval( $_GET['second'] ) : 0 ;

if ( $xoopsModuleConfig['check_host'] ) {
	$goodhost = 0;
	$referer = parse_url( xoops_getenv( 'HTTP_REFERER' ) ) ;
	$referer_host = $referer['host'];
	foreach ( $xoopsModuleConfig['referers'] as $ref ) {
		if ( ! empty( $ref ) && preg_match("/".$ref."/i", $referer_host ) ) {
			$goodhost = "1";
			break ;
		}
	}

	if ( ! $goodhost ) {
		redirect_header( XOOPS_URL."/modules/".$mydirname."/index.php?page=singlefile?cid=$cid&amp;lid=$lid", 20, _MD_D3DOWNLOADS_NOPERMISETOLINK );
		exit() ;
	}
}

$user_access = new user_access( $mydirname ) ;
$whr_cat = "d.cid IN (".implode(",", $user_access->can_read() ).")" ;
$mydownload = new MyDownload( $mydirname, $whr_cat, $lid ) ;
if( ! $mydownload->return_lid() ) {
	d3download_delete_cache_of_categories( $mydirname ) ;
	redirect_header( XOOPS_URL."/modules/".$mydirname."/", 20, _MD_D3DOWNLOADS_NOMATCH ) ;
	exit() ;
}

if ( xoops_refcheck() ) $mydownload->Hits_Count( $lid ) ;
d3download_delete_cache_of_categories( $mydirname ) ;

switch( $second ) {
	case false :
		$url = $mydownload->return_url('Show') ;
		$filename = $mydownload->return_filename('Show') ;
		$ext = $mydownload->return_ext('Show') ;
		break ;
	case true :
		$url = $mydownload->return_file2('Show') ;
		$filename = $mydownload->return_filename2('Show') ;
		$ext = $mydownload->return_ext2('Show') ;
		break ;
}

d3download_download( $url, $filename, $ext, 0 ) ;

?>