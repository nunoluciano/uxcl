<?php
// $Id: topten.php,v 1.1 2004/01/29 14:45:12 buennagel Exp $
//  ------------------------------------------------------------------------ //
//                XOOPS - PHP Content Management System                      //
//                    Copyright (c) 2000 XOOPS.org                           //
//                       <http://www.xoops.org/>                             //
// ------------------------------------------------------------------------- //
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
//  modify by photosite 2008/03/14 18:18:50 for d3downloads
//

include XOOPS_ROOT_PATH.'/header.php';
include_once dirname( dirname(__FILE__) ).'/class/user_access.php' ;
include_once dirname( dirname(__FILE__) ).'/class/mydownload.php' ;
require_once dirname( dirname(__FILE__) ).'/include/common_functions.php' ;

$xoopsOption['template_main'] = $mydirname.'_main_topten.html' ;

$rankings = $category4assin = array();

$breadcrumbs[0] = d3download_breadcrumbs( $mydirname ) ;

//generates top 10 charts by rating and hits for each main category
if( isset( $_GET['rate'] ) ){
	$sort = _MD_D3DOWNLOADS_TOP_TEN_RATING;
	$sortDB = "d.rating";
	$pagetitle4assign = _MD_D3DOWNLOADS_TOP_TEN_TITLE_RATING ;
	$breadcrumbs[] = array( 'name' => _MD_D3DOWNLOADS_TOP_TEN_TITLE_RATING ) ;
} else {
	$sort = _MD_D3DOWNLOADS_TOP_TEN_HITS;
	$sortDB = "d.hits";
	$pagetitle4assign = _MD_D3DOWNLOADS_TOP_TEN_TITLE_HITS ;
	$breadcrumbs[] = array( 'name' => _MD_D3DOWNLOADS_TOP_TEN_TITLE_HITS ) ;
}
$xoopsTpl->assign('lang_sortby' ,$sort);
$xoopsTpl->assign('lang_rank' , _MD_D3DOWNLOADS_TOP_TEN_RANK);
$xoopsTpl->assign('lang_title' , _MD_D3DOWNLOADS_TOP_TEN_TITLE);
$xoopsTpl->assign('lang_category' , _MD_D3DOWNLOADS_TOP_TEN_CATEGORY);
$xoopsTpl->assign('lang_hits' , _MD_D3DOWNLOADS_TOP_TEN_HITS);
$xoopsTpl->assign('lang_rating' , _MD_D3DOWNLOADS_TOP_TEN_RATING);
$xoopsTpl->assign('lang_vote' , _MD_D3DOWNLOADS_TOP_TEN_VOTE);

$user_access = new user_access( $mydirname ) ;
$whr_cat = "cid IN (".implode(",", $user_access->can_read() ).")" ;

$mydownload = new MyDownload( $mydirname );
$rankings = $mydownload->get_downdata_for_topten( $whr_cat, $sortDB ) ;

// 閲覧可能なカテゴリのリストを SELECTボックス用に取得
$category4assin = d3download_makecache_for_selbox( $mydirname, $whr_cat, 0, 1 );
$lang_directcatsel = _MD_D3DOWNLOADS_SEL_CATEGORY;

// 閲覧可能な登録件数を SELECTボックス用に取得
$num = $mydownload->Total_Num( $whr_cat );
$total_num = sprintf( _MD_D3DOWNLOADS_TOTAL_NUM , intval( $num ) );
$xoopsTpl->assign( 'download_total_num' , $total_num ) ;

$xoops_module_header = d3download_dbmoduleheader( $mydirname );
$xoopsTpl->assign('xoops_module_header', $xoops_module_header . "\n" . $xoopsTpl->get_template_vars( 'xoops_module_header' ) );

$xoopsTpl->assign( array(
	'mydirname' => $mydirname ,
	'mod_url' => XOOPS_URL.'/modules/'.$mydirname ,
	'page' => 'topten' ,
	'rankings' => $rankings ,
	'category' => $category4assin ,
	'lang_directcatsel' => $lang_directcatsel ,
	'mod_config' => $xoopsModuleConfig ,
	'xoops_pagetitle' => $pagetitle4assign ,
	'xoops_breadcrumbs' => $breadcrumbs ,
) ) ;
include_once XOOPS_ROOT_PATH.'/footer.php';

?>
