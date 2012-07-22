<?php 
/**
 * $Id: arts_top.php v 1.0 8 May 2004 hsalazar Exp $
 * Module: Wordbook
 * Version: v 1.00
 * Release Date: 8 May 2004
 * Author: hsalazar
 * Licence: GNU
 */

// XOOPS2 - Xwords 0.46
// WEBMASTER @ KANPYO.NET, 2006.

if( ! defined( 'XOOPS_ROOT_PATH' ) ) exit ;
$mydirname = basename( dirname( dirname( __FILE__ ) ) ) ;

eval( '
	function '.$mydirname.'_b_entries_top_show( $options )
		{
		return xwords_b_entries_top_show_base( "'.$mydirname.'" , $options ) ;
		}
' ) ;


if( ! function_exists( 'xwords_b_entries_top_show_base' ) )
	{
	function xwords_b_entries_top_show_base( $mydirname, $options )
		{
		$xoopsDB =& Database::getInstance();
		$ent_table = $xoopsDB -> prefix ("{$mydirname}_ent") ;
		$myts = & MyTextSanitizer :: getInstance();

		$hModule =& xoops_gethandler('module');
		$hModConfig =& xoops_gethandler('config');
		$xwModule =& $hModule->getByDirname("$mydirname");
		$module_id = $xwModule -> getVar( 'mid' );
		$module_name = $xwModule -> getVar( 'dirname' );
		$xwConfig =& $hModConfig->getConfigsByCat(0, $xwModule->getVar('mid'));

		$block = array();
		$popentries = array();

//		$words = $xoopsDB -> query( "SELECT * FROM $ent_table WHERE datesub < '".time()."' AND datesub > '0' AND submit = '0' AND offline = '0' AND request = '0'" );
//		$totalwords = $xoopsDB -> getRowsNum( $words );

		$sql = "SELECT entryID, categoryID, term, counter FROM $ent_table WHERE datesub < '".time()."' AND datesub > '0' AND submit = '0' AND offline = '0' AND request = '0' ORDER BY " . $options[0] . " DESC";
		$result = $xoopsDB -> query ($sql, $options[1], 0);
		$totalwords = $xoopsDB -> getRowsNum( $result );

		if ( $totalwords > 0 ) // If there are definitions
			{
			while (list( $entryID, $categoryID, $term, $counter ) = $xoopsDB->fetchRow($result))
				{
				$popentries['dir'] = $xwModule->dirname();
				$popentries['linktext'] = $myts -> makeTboxData4Show($term);
				$popentries['id'] = intval( $entryID );
				$popentries['categoryID'] = intval($xwConfig['multicats']) ? intval($categoryID) : 0;
				$popentries['counter'] = intval( $counter );

				$block['popstuff'][] = $popentries;
				} 
			}
		return $block;
		} 
	}

eval( '
	function '.$mydirname.'_b_entries_top_edit( $options )
		{
		return xwords_b_entries_top_edit_base( "'.$mydirname.'" , $options ) ;
		}
' ) ;

if( ! function_exists( 'xwords_b_entries_top_edit_base' ) )
	{
	function xwords_b_entries_top_edit_base( $mydirname, $options )
		{
		$form = "<input type='hidden' name='options[0]' value='counter' />";
		$form .= constant("_MB_{$MYDIRNAME}_DISP") . "&nbsp;<input type='text' name='options[]' value='" . $options[1] . "' />&nbsp;" . constant("_MB_{$MYDIRNAME}_TERMS") . "";
		return $form;
		} 
	}
?>