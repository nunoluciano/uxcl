<?php
/**
 * $Id: xoops_version.php v 1.0 8 May 2004 hsalazar Exp $
 * Module: Wordbook - a multicategory glossary
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
	function '.$mydirname.'_b_entries_random_show()
		{
		return xwords_b_entries_random_show_base( "'.$mydirname.'" ) ;
		}
' ) ;


if( ! function_exists( 'xwords_b_entries_random_show_base' ) )
	{
	function xwords_b_entries_random_show_base( $mydirname )
		{
		$MYDIRNAME = strtoupper($mydirname);
		$xoopsDB =& Database::getInstance();
		$cat_table = $xoopsDB -> prefix ("{$mydirname}_cat") ;
		$ent_table = $xoopsDB -> prefix ("{$mydirname}_ent") ;

		global $xoopsUser;

		$hModule =& xoops_gethandler('module');
		$hModConfig =& xoops_gethandler('config');
		$xwModule =& $hModule->getByDirname("$mydirname");
		$module_id = $xwModule -> getVar( 'mid' );
		$module_name = $xwModule -> getVar( 'dirname' );
		$xwConfig =& $hModConfig->getConfigsByCat(0, $xwModule->getVar('mid'));

		if( ! class_exists( 'XwordsTextSanitizer' ) )
			{
			include_once( XOOPS_ROOT_PATH . "/modules/$mydirname/class/xwords.textsanitizer.php" ) ;
			}
		$myts = & XwordsTextSanitizer::getInstance();

		$block = array();
		$rndlength = isset($xwConfig['rndlength']) ? intval($xwConfig['rndlength']) : 100 ;
//		$randomterm['title'] = constant("_MB_{$MYDIRNAME}_RANDOMTITLE");
		
		list ( $numrows ) = $xoopsDB -> fetchRow( $xoopsDB -> query ( "SELECT COUNT(*) FROM $ent_table WHERE datesub < '".time()."' AND datesub > '0' AND submit = '0' AND offline = '0' AND request = '0'"));
		if ($numrows > 1) 
			{
			$numrows = $numrows - 1;
			mt_srand((double)microtime()*1000000);
			$entrynumber = mt_rand(0, $numrows);
			}
		else 
			{
			$entrynumber = 0;
			}

		$result = $xoopsDB -> query ( "SELECT e.entryID, e.categoryID, e.term, e.definition, e.html, e.smiley, e.xcodes, e.breaks, e.uid, c.name FROM $ent_table e LEFT JOIN $cat_table c ON e.categoryID = c.categoryID WHERE datesub < '".time()."' AND datesub > '0' AND submit = '0' AND offline = '0' AND request = '0' LIMIT $entrynumber, 1");

		while ($myrow = $xoopsDB->fetchArray($result)) 
			{
			$uid = intval($myrow['uid']);
			$randomterm['entryID'] = intval($myrow['entryID']);
			$randomterm['term'] = $myts->makeTboxData4Show($myrow['term']);

			$definition = strip_tags($myts->displayTarea($myrow['definition'], intval($myrow['html']), intval($myrow['smiley']), intval($myrow['xcodes']), 1, intval($myrow['breaks'])));

			if ( !XOOPS_USE_MULTIBYTES )
				{
				$randomterm['definition'] = substr ( $definition, 0, $rndlength -1 ) . "...";
				}
			else
				{
				$randomterm['definition'] = xoops_substr( $definition, 0, $rndlength +2 );
				}
			$randomterm['categoryID'] = intval($myrow['categoryID']);
			$randomterm['categoryname'] = $myts -> makeTboxData4Show($myrow['name']);

			$randomterm['adminlinks'] = '';
			$randomterm['userlinks'] = '';
			// Functional links
			if ( is_object($xoopsUser) )
				{
				if ( $xoopsUser->isAdmin($xwModule->getVar('mid')) ) 
					{
					$randomterm['adminlinks'] = "<a href=\"".XOOPS_URL."/modules/$mydirname/admin/entry.php?op=mod&amp;entryID=".$randomterm['entryID']."\" target=\"_blank\"><img src=\"".XOOPS_URL."/modules/$mydirname/images/edit.gif\" border=\"0\" alt=\"".constant("_MB_{$MYDIRNAME}_EDITTERM")."\" width=\"15\" height=\"11\" /></a>&nbsp;<a href=\"".XOOPS_URL."/modules/$mydirname/admin/entry.php?op=del&amp;entryID=".$randomterm['entryID']."\" target=\"_blank\"><img src=\"".XOOPS_URL."/modules/$mydirname/images/delete.gif\" border=\"0\" alt=\"".constant("_MB_{$MYDIRNAME}_DELTERM")."\" width=\"15\" height=\"11\" /></a>&nbsp;";
					}
				elseif ( $uid == $xoopsUser -> getVar( 'uid' ))
					{
					$randomterm['userlinks'] = "<a href=\"".XOOPS_URL."/modules/$mydirname/submit.php?entryID=".$randomterm['entryID']."\" target=\"_blank\"><img src=\"".XOOPS_URL."/modules/$mydirname/images/edit.gif\" border=\"0\" alt=\"".constant("_MB_{$MYDIRNAME}_EDITTERM")."\" width=\"15\" height=\"11\" /></a>&nbsp;";
					}
				}

			$randomterm['multicats'] = $xwConfig['multicats'];
			$randomterm['seemore'] = constant("_MB_{$MYDIRNAME}_SEEMORE");
			$randomterm['dir'] = $mydirname;
			
			$block['randomstuff'][] = $randomterm;
			}
		return $block;
		}
	}
?>