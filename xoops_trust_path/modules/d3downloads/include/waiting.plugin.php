<?php

function b_waiting_d3downloads( $mydirname )
{
	$db =& Database::getInstance();
	$ret = array() ;

	// d3downloads links
	$block = array();
	$result = $db->query( "SELECT COUNT(*) FROM ".$db->prefix( $mydirname."_unapproval" )." WHERE lid='0'" );
	if ( $result ) {
		$block['adminlink'] = XOOPS_URL."/modules/".$mydirname."/admin/index.php?page=approvalmanager";
		list( $block['pendingnum'] ) = $db->fetchRow( $result);
		$block['lang_linkname'] = _PI_WAITING_WAITINGS ;
	}
	$ret[] = $block ;

	// d3downloads broken
	$block = array();
	$result = $db->query( "SELECT COUNT(*) FROM ".$db->prefix( $mydirname."_broken" ) );
	if ( $result ) {
		$block['adminlink'] = XOOPS_URL."/modules/".$mydirname."/admin/index.php?page=brokenmanager";
		list( $block['pendingnum'] ) = $db->fetchRow( $result );
		$block['lang_linkname'] = _PI_WAITING_BROKENS ;
	}
	$ret[] = $block ;

	// d3downloads modreq
	$block = array();
	$result = $db->query( "SELECT COUNT(*) FROM ".$db->prefix( $mydirname."_unapproval" )." WHERE lid > '0'" );
	if ( $result ) {
		$block['adminlink'] = XOOPS_URL."/modules/".$mydirname."/admin/index.php?page=approvalmanager";
		list( $block['pendingnum'] ) = $db->fetchRow( $result );
		$block['lang_linkname'] = _PI_WAITING_MODREQS ;
	}
	$ret[] = $block ;

	return $ret;
}

?>