<?php 
/**
 * $Id: arts_new.php v 1.0 8 May 2004 hsalazar Exp $
 * Module: Soapbox
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
	function '.$mydirname.'_b_entries_new_show( $options )
		{
		return xwords_b_entries_new_show_base( "'.$mydirname.'" , $options ) ;
		}
' ) ;


if( ! function_exists( 'xwords_b_entries_new_show_base' ) )
	{
	function xwords_b_entries_new_show_base( $mydirname, $options )
		{
		global $xoopsUser;
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
		$newentries = array();

//		$words = $xoopsDB -> query( "SELECT * FROM $ent_table WHERE datesub < '".time()."' AND datesub > '0' AND submit = '0' AND offline = '0' AND request = '0'" );
//		$totalwords = $xoopsDB -> getRowsNum( $words );

		$sql = "SELECT entryID, categoryID, term, datesub, definition FROM $ent_table WHERE datesub < '".time()."' AND datesub > '0' AND submit = '0' AND offline = '0' AND request = '0' ORDER BY " . $options[0] . " DESC";	//okino
		$result = $xoopsDB->query ($sql, $options[1], 0);
		$totalwords = $xoopsDB -> getRowsNum( $result );

		if ( $totalwords > 0 ) // If there are definitions
			{
			while (list( $entryID, $categoryID, $term, $datesub, $definition) = $xoopsDB->fetchRow($result))
				{
				$newentries['dir'] = $xwModule->dirname();
				$newentries['linktext'] = $myts -> makeTboxData4Show($term);
				$newentries['id'] = intval($entryID);
				$newentries['categoryID'] = intval($xwConfig['multicats']) ? intval($categoryID) : 0;
				$newentries['date'] = formatTimestamp( $datesub, "s" );
				$newentries['summary'] = xoops_substr( $definition , 0 , 255 ); //okino

				$block['newstuff'][] = $newentries;
				}
			}
		return $block;
		}
	}

eval( '
	function '.$mydirname.'_b_entries_new_edit( $options )
		{
		return xwords_b_entries_new_edit_base( "'.$mydirname.'" , $options ) ;
		}
' ) ;

if( ! function_exists( 'xwords_b_entries_new_edit_base' ) )
	{
	function xwords_b_entries_new_edit_base( $mydirname, $options )
		{
		$form = "<input type='hidden' name='options[0]' value='datesub' />";
		$form .= constant("_MB_{$MYDIRNAME}_DISP") . "&nbsp;<input type='text' name='options[]' value='" . $options[1] . "' />&nbsp;" . constant("_MB_{$MYDIRNAME}_TERMS") . "";

		return $form;
		}
	}
?>