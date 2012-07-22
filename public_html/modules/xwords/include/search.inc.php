<?php
/**
 * $Id: search.inc.php v 1.0 8 May 2004 hsalazar Exp $
 * Module: Wordbook
 * Version: v 1.00
 * Release Date: 8 May 2004
 * Author: hsalazar
 * Licence: GNU
 */
// XOOPS2 - Xwords 0.42
// WEBMASTER @ KANPYO.NET, 2005.

if( ! defined( 'XOOPS_ROOT_PATH' ) ) exit ;
$mydirname = basename( dirname( dirname( __FILE__ ) ) ) ;

eval( '

function '.$mydirname.'_search( $queryarray , $andor , $limit , $offset , $userid )
{
	return xwords_search_base( "'.$mydirname.'" , $queryarray , $andor , $limit , $offset , $userid ) ;
}

' ) ;

if( ! function_exists( 'xwords_search_base' ) ) {

function xwords_search_base( $mydirname, $queryarray, $andor, $limit, $offset, $userid )
	{
	include_once XOOPS_ROOT_PATH."/modules/$mydirname/class/xwords.textsanitizer.php" ;
	$myts =& XwordsTextSanitizer::getInstance();
	$xoopsDB =& Database::getInstance();
	$xoopsModule = XoopsModule::getByDirname("{$mydirname}");

	$ret = array();
	// XOOPS Search module
	$showcontext = empty( $_GET['showcontext'] ) ? 0 : 1 ;
	$select4con = $showcontext ? "definition, html, smiley, xcodes, breaks, " : "" ;

	$sql = "SELECT entryID, categoryID, term, $select4con uid, datesub FROM " . $xoopsDB -> prefix( "{$mydirname}_ent" ) . " WHERE datesub < '".time()."' AND datesub > '0' AND submit = '0' AND offline = '0' AND request = '0' "; 

	if ( $userid != 0 && strlen($userid) < 9) {
		$sql .= " AND uid = '".$userid."' ";
	}
	// because count() returns 1 even if a supplied variable
	// is not an array, we must check if $querryarray is really an array
	$count = count( $queryarray );
	if ( $count > 0 && is_array( $queryarray ) )
		{
		$sql .= "AND (";
		for ( $i = 0; $i < $count; $i++ )
			{
			$binary = (preg_match('/^[[:alnum:]]+$/',$queryarray[$i])) ? "":"BINARY";
			$sql .= ($i > 0) ? " $andor " : "";
			$sql .= (strlen($userid) > 8) ? "(term LIKE $binary '%$queryarray[$i]%')" : "(term LIKE $binary '%$queryarray[$i]%' OR proc LIKE $binary '%,%$queryarray[$i]%' OR definition LIKE $binary '%$queryarray[$i]%')" ;
			}
		$sql .= ') ';
		}
	$sql .= 'ORDER BY entryID DESC';
	$result = $xoopsDB -> query( $sql, $limit, $offset );
	$ret = array() ;
	$context = '' ;
	$i = 0;
	while ( $myrow = $xoopsDB -> fetchArray( $result ) )
		{
		$ret[$i]['image'] = 'images/xw.gif';
		$ret[$i]['link'] = 'entry.php?entryID='.$myrow['entryID'].'&amp;categoryID='.$myrow['categoryID'];
		$ret[$i]['title'] = $myrow['term'];
		$ret[$i]['time'] = $myrow['datesub'];
		$ret[$i]['uid'] = $myrow['uid'];
		if( function_exists( 'search_make_context' ) && $showcontext )
			{
			$context = strip_tags($myts->displayTarea($myrow['definition'], intval($myrow['html']), intval($myrow['smiley']), intval($myrow['xcodes']), 1, intval($myrow['breaks'])));
			$ret[$i]['context'] = search_make_context($context,$queryarray);
			}
		$i++;
		}
	return $ret;
	}
}
?>