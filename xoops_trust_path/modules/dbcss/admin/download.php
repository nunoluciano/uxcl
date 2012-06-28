<?php

$db =& Database::getInstance() ;
$myts =& MyTextSanitizer::getInstance() ;

// THIS PAGE CAN BE CALLED ONLY FROM DBCSS
if( $xoopsModule->getVar('dirname') != $mydirname );// die( 'this page can be called only from '.$mydirname ) ;

// PERMISSION ERROR
if( ! is_object( $xoopsUser )  &&  ! $xoopsUser->isAdmin() ) {
	die( 'Only administrator can use this feature.' ) ;
}

// DOWNLOAD TPL

$tpl_id = isset($_GET['lid']) ? intval( $_GET['lid'] ) : 0;
$errors = "";
if( ! empty( $tpl_id ) ) {
	$result = $db->query( "SELECT tpl_file, tpl_source FROM ".$db->prefix("tplfile")." NATURAL LEFT JOIN ".$db->prefix("tplsource")." WHERE tpl_id='$tpl_id'") ;
	if( ! $result ){
		$errors = $tpl_id ;
		redirect_header( XOOPS_URL."/modules/$mydirname/admin/index.php?page=export" , 2 , sprintf( _MD_DBCSS_ERROR_MESSEAGE , $errors ) ) ;
		exit();
	} else {
		while ( $myrow = $db->fetchArray( $result ) ) {
			$css_tpl = htmlspecialchars( $myrow['tpl_file'], ENT_QUOTES );
			$name_string = explode( $mydirname.'_',$css_tpl ) ;
			$css_name = $name_string[1];
			$tplsource = $myts->stripSlashesGPC( $myrow['tpl_source'] ) ;
			//$tplsource = trim( $myrow['tpl_source'] ) ;
		}
	}

	if( headers_sent() ) die( 'headers are already sent' ) ;

	header( 'Content-Type: text/css;' ) ;
	header('Content-Disposition: attachment; filename="'.$css_name.'"');

	echo $tplsource ;
}

// DOWNLOAD TPL WITH ZIP OR TAR

if( isset ( $_POST['zip'] ) || isset ( $_POST['tar'] ) ){
	$errors = array() ;
	$selected = htmlspecialchars( $_POST['download_tplsets'], ENT_QUOTES );
	if ( empty( $selected ) ){
		redirect_header( XOOPS_URL."/modules/$mydirname/admin/index.php?page=export", 2, _MD_DBCSS_DOWNLOADERROR);
		exit();
	} else {
		if( isset( $_POST['zip'] ) ){
			require_once XOOPS_ROOT_PATH.'/class/zipdownloader.php';
			$mydownload = new XoopsZipDownloader;
		} elseif( isset ( $_POST['tar'] ) ){
			require_once XOOPS_ROOT_PATH.'/class/tardownloader.php';
			$mydownload = new XoopsTarDownloader;
		}

		$res = $db->query( "SELECT tpl_id, tpl_tplset, tpl_file, tpl_lastmodified, tpl_source FROM ".$db->prefix("tplfile")." NATURAL LEFT JOIN ".$db->prefix("tplsource")." WHERE tpl_file LIKE '%.css' AND tpl_tplset='$selected' AND tpl_module='$mydirname'" ) ;
		if( ! $res ){
			$errors = $selected ;
			redirect_header( XOOPS_URL."/modules/$mydirname/admin/index.php?page=export" , 2 , sprintf( _MD_DBCSS_ERROR_MESSEAGE , $errors ) ) ;
			exit();
		} else {
			while( $content_row = $db->fetchArray( $res ) ) {
				$css_tpl = htmlspecialchars( $content_row['tpl_file'], ENT_QUOTES );
				$name_string = explode($mydirname.'_',$css_tpl ,2 ) ;
				$name = $name_string[1];
				$body = $myts->stripSlashesGPC( $content_row['tpl_source'] ) ;
				//$body = trim( $content_row['tpl_source'] ) ;
				$tplset = htmlspecialchars( $content_row['tpl_tplset'], ENT_QUOTES );
				$tpl_lastmodified = intval( $content_row['tpl_lastmodified'] ) ;
				$mydownload->addFileData( $body, $tplset.'/'.$name, $tpl_lastmodified );
			}
		}
		echo $mydownload->download($mydirname.'_css_template', true ) ;
	}
}

?>