<?php

// $Id: brokenfile.php,v 1.1 2004/01/29 14:45:12 buennagel Exp $
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
//  modify by photosite 2008/03/07 10:11:20 for d3downloads
//

include XOOPS_ROOT_PATH.'/header.php';

include_once dirname( dirname(__FILE__) ).'/class/user_access.php' ;
require_once dirname( dirname(__FILE__) ).'/class/broken_download.php' ;
require_once dirname( dirname(__FILE__) ).'/class/post_check.php' ;
require_once dirname( dirname(__FILE__) ).'/class/spam_check.php' ;
require_once dirname( dirname(__FILE__) ).'/include/common_functions.php' ;
require_once dirname( dirname(__FILE__) ).'/include/transact_functions.php' ;
require_once dirname( dirname(__FILE__) ).'/include/broken_file_rules.inc.php' ;

$xoopsOption['template_main'] = $mydirname.'_main_brokenfile.html';

$report = $errors = array() ;
$error_message = $liveValidator = '' ;

$cid = ! empty( $_GET['cid'] ) ? intval( $_GET['cid'] ) : 0 ;
$lid = ! empty( $_GET['lid'] ) ? intval( $_GET['lid'] ) : 0 ;

$broken_report = new broken_report( $mydirname ) ;
$user_access   = new user_access( $mydirname ) ;
$liveform      = new My_MassValidatePHP( 'brokenreport', $_POST ) ;
$spam_check    = new spam_check( $mydirname ) ;

$whr_cat = "cid IN (".implode(",", $user_access->can_read() ).")" ;
$whr_cat4read = "d.".$whr_cat ;

$bc[0] = d3download_breadcrumbs( $mydirname ) ;
$breadcrumbs = array_merge( $bc ,d3download_breadcrumbs_tree( $mydirname, $cid, $whr_cat, '', 1 ) ) ;
$download4assign = d3download_get_title( $mydirname, $lid, $whr_cat4read ) ;
$title4assign = $download4assign['title'] ;
$breadcrumbs[] = array( 'name' => $title4assign ) ;

$liveformrules = $formRules['brokenreport'] ;
$liveform->addRules( $liveformrules ) ;
$liveValidator = $liveform->generateAll() ;
$xoopsTpl->assign( 'liveValidator', $liveValidator ) ;
$message_option = $broken_report->message_option() ;
$spam_check->post_name = array( 'message' , 'name', 'email' ) ;

if ( ! empty( $_POST['report_submit'] ) ) {
	$broken_report->getReport() ;
	$errors = $liveform->validate() ;
	if ( $message_option && ! $spam_check->check() ) array_push( $errors, $spam_check->error_message ) ;
	switch( ! empty( $errors ) ) {
		case true :
			foreach ( $errors as $message ) {
				$error_message .= $message . '<br />' ;
			}
			$report = $broken_report->geteditData() ;
			break ;
		default :
			$lid = intval( $_POST['lid'] ) ;
			$cid = intval( $_POST['cid'] ) ;
			$broken_report->execute( $lid, $title4assign ) ;
	}
}

// store the referer
if( empty( $_SESSION["{$mydirname}_uri4return"] ) && ! empty( $_SERVER['HTTP_REFERER'] ) ) {
	$_SESSION["{$mydirname}_uri4return"] = $_SERVER['HTTP_REFERER'] ;
}

$xoops_module_header   = d3download_dbmoduleheader( $mydirname ) ;
$livevalidation_header = d3download_dbmoduleheader_for_livevalidation( $mydirname ) ;
$xoopsTpl->assign( 'xoops_module_header', $xoops_module_header . "\n" .$livevalidation_header. "\n" . $xoopsTpl->get_template_vars( 'xoops_module_header' ) ) ;

$xoopsTpl->assign( array(
	'mydirname'          => $mydirname ,
	'mod_url'            => XOOPS_URL.'/modules/'.$mydirname ,
	'page'               => 'brokenfile' ,
	'down'               => $download4assign ,
	'lang_reportbroken'  => _MD_D3DOWNLOADS_REPORTBROKEN ,
	'lang_thanksforhelp' => _MD_D3DOWNLOADS_THANKSFORHELP ,
	'lang_forsecurity'   => _MD_D3DOWNLOADS_FORSECURITY ,
	'lang_rateit'        => _MD_D3DOWNLOADS_RATEIT ,
	'lang_cancel'        => _CANCEL ,
	'report'             => $report ,
	'error_message'      => $error_message ,
	'message_option'     => $message_option ,
	'xoops_pagetitle'    => $title4assign ,
	'xoops_breadcrumbs'  => $breadcrumbs ,
	'mod_config'         => $xoopsModuleConfig ,
) ) ;

include_once XOOPS_ROOT_PATH.'/footer.php';

?>
