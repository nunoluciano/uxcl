<?php

require_once dirname(dirname(__FILE__)).'/include/attach_functions.php' ;

global $xoopsModuleConfig , $xoopsDB ;

$mod_url = XOOPS_URL."/modules/".$mydirname ;

$offset = isset( $_GET['offset'] ) ? $_GET['offset'] : '' ;
$offset = preg_replace( '/[^0-9]/' , '' , $offset ) ;
$offset = empty( $offset ) ? '0' : $offset ;

$limit = isset( $_GET['limit'] ) ? $_GET['limit'] : '' ;
$limit = preg_replace( '/[^0-9]/' , '' , $limit ) ;
$limit = empty( $limit ) ? '50' : $limit ;

$sql = "SELECT COUNT(*) FROM ".$xoopsDB->prefix( $mydirname."_attach" ) ;

if( ! $result = $xoopsDB->query( $sql ) ) die( "DB ERROR in get attached files" ) ;

list($all_count) = $xoopsDB->fetchRow( $result ) ;

$sql = "SELECT * FROM ".$xoopsDB->prefix( $mydirname."_attach" ) ;
$sql = $sql." ORDER BY attach_id DESC" ;
$sql = $sql." LIMIT ".$offset.",".$limit ;

if( ! $result = $xoopsDB->query( $sql ) ) die( "DB ERROR in get attached files" ) ;

$attached_files = array() ;
while( $attach_row = $xoopsDB->fetchArray( $result ) ) {
	$link_name = rawurldecode( $attach_row['title'] );
	if( ! empty( $xoopsModuleConfig['link_enc'] ) && function_exists('mb_convert_encoding') ) {
		$link_name = mb_convert_encoding( $link_name, $xoopsModuleConfig['link_enc'] ) ;
	}
	$attached_files[] = array(
		'attach_id' => intval( $attach_row['attach_id'] ),
		'module_dirname' => $attach_row['module_dirname'],
		'target_id' => intval( $attach_row['target_id'] ),
		'title' => $attach_row['title'],
		'saved_name' => $attach_row['saved_name'],
		'file_size' => intval( $attach_row['file_size'] ),
		'link_name' => $link_name,
	) ;
}

$attached_files_count = count( $attached_files ) ;
$attached_files4assign = attachfile_htmlspecialchars_to_2array( $attached_files ) ;

xoops_cp_header();
include dirname(__FILE__).'/mymenu.php' ;
$xoopsTpl =& new XoopsTpl() ;
$xoopsTpl->assign(
	array(
		'mod_url' => $mod_url ,
		'attached_files_count' => $attached_files_count ,
		'attached_files' => $attached_files4assign ,
		'all_count' => $all_count ,
		'offset_num' => (int)$offset ,
		'offset' => $offset ,
		'limit' => $limit ,
	)
) ;
$xoopsTpl->display( 'db:'.$mydirname.'_admin_list.html' ) ;
xoops_cp_footer();

?>
