<?php

require_once dirname( dirname(__FILE__) ).'/include/download_functions.php' ;

global $xoopsUser ;

$cid = isset( $_GET['cid'] ) ? intval( $_GET['cid'] ) : 0 ;
$lid = isset( $_GET['lid'] ) ? intval( $_GET['lid'] ) : 0 ;
$id = isset( $_GET['id'] ) ? intval( $_GET['id'] ) : 0 ;
$history = isset( $_GET['history'] ) ? intval( $_GET['history'] ) : 0 ;
$unapproval = isset( $_GET['unapproval'] ) ? intval( $_GET['unapproval'] ) : 0 ;
$second = isset( $_GET['second'] ) ? intval( $_GET['second'] ) : 0 ;

if( ! $xoopsUserIsAdmin ){
	include_once dirname( dirname(__FILE__) ).'/class/user_access.php' ;
	$user_access = new user_access( $mydirname ) ;
	$whr_cat = "d.cid IN (".implode(",", $user_access->can_read() ).")" ;
} else {
	$whr_cat = "" ;
}

if( ! empty( $lid ) ){
	include_once dirname( dirname(__FILE__) ).'/class/mydownload.php' ;
	$mydownload = new MyDownload( $mydirname, $whr_cat, $lid ) ;
	if( ! $mydownload->return_lid() ) {
		redirect_header( XOOPS_URL."/modules/".$mydirname."/", 20, _MD_D3DOWNLOADS_NOMATCH );
		exit();
	}
} elseif( ! empty( $history ) && ! empty( $id ) ) {
	include_once dirname( dirname(__FILE__) ).'/class/history_download.php' ;
	$mydownload = new history_download( $mydirname, $id ) ;
	if( ! $mydownload->return_lid() ) {
		redirect_header( XOOPS_URL."/modules/".$mydirname."/", 20, _MD_D3DOWNLOADS_NOMATCH );
		exit();
	}
} elseif( ! empty( $unapproval ) && ! empty( $id ) ) {
	include_once dirname( dirname(__FILE__) ).'/class/unapproval_download.php' ;
	$mydownload = new unapproval_download( $mydirname, $id ) ;
	if( ! $mydownload->return_requestid() ) {
		redirect_header( XOOPS_URL."/modules/".$mydirname."/", 20, _MD_D3DOWNLOADS_NOMATCH );
		exit();
	}
}

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

d3download_download( $url, $filename, $ext, 1 ) ;

?>