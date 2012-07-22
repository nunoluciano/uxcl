<?php
/**
 * $Id: index.php v 1.0 8 May 2004 hsalazar Exp $
 * Module: Wordbook - a multicategory glossary
 * Version: v 1.00
 * Release Date: 8 May 2004
 * Author: hsalazar
 * Licence: GNU
 */
// XOOPS2 - Xwords 0.45
// WEBMASTER @ KANPYO.NET, 2006.

include "./header.php";
include_once( XOOPS_ROOT_PATH . '/class/pagenav.php' );

global $xoopsUser;

$totalcats = 0;
$columna = array ();
$block0 = array();
$block1 = array();
$block2 = array();
$newentries = array();
$popentries = array();
$random = array();
$blockS = array();
$subentries = array();
$blockR = array();
$reqentries = array();
$totalSwords = 0;
$totalRwords = 0;
$microlinks = "";
$rndlength = !empty($xoopsModuleConfig['rndlength']) ? intval($xoopsModuleConfig['rndlength']) : 100 ;
calculateTotals();

/*
// To display the linked letter list
$alpha = alphaArray();

for ($i=0; $i < count($alpha['initial']); $i++)
	{
	if ($alpha['initial'][$i]['linktext'] == constant("_MD_{$MYDIRNAME}_ALL_LINKTEXT"))
		{
		$publishedwords = $alpha['initial'][$i]['total'];
		break;
		}
	}
*/

//** To display the random term block **//
if ($xoopsModuleConfig["blocksperpage"] > 0)
	{
	list($numrows) = $xoopsDB -> fetchRow($xoopsDB->query("SELECT COUNT(*) FROM $ent_table WHERE datesub < '".time()."' AND datesub > '0' AND submit = '0' AND offline = '0' AND request = '0'"));
	if ( $numrows > 1) 
		{
		$numrows = $numrows-1;
		mt_srand((double)microtime()*1000000);
		$entrynumber = mt_rand(0, $numrows);
		}
	else
		{
		$entrynumber = 0;
		}

	$resultZ = $xoopsDB -> query ( "SELECT e.entryID, e.categoryID, e.term, e.definition, e.html, e.smiley, e.xcodes, e.breaks, e.uid, c.name FROM $ent_table e LEFT JOIN $cat_table c ON e.categoryID = c.categoryID WHERE datesub < '".time()."' AND datesub > '0' AND submit = '0' AND offline = '0' AND request = '0' LIMIT $entrynumber, 1");

	$zerotest = $xoopsDB -> getRowsNum( $resultZ );
	if ( $zerotest != 0 )
		{
		while( $myrow = $xoopsDB->fetchArray($resultZ)) 
			{
			$random['uid'] = intval($myrow['uid']);
			$random['entryID'] = intval($myrow['entryID']);
			$random['term'] = $myts -> makeTboxData4Show($myrow['term']);
			$myrow['definition'] = strip_tags( $myts -> displayTarea ( $myrow['definition'],1,1,1,1,1 ) );
			if ( !XOOPS_USE_MULTIBYTES )
				{
				$random['definition'] = substr ( $myrow['definition'], 0, $rndlength -1 ) . "...";
				}
			else
				{
				$random['definition'] = xoops_substr( $myrow['definition'], 0, $rndlength +2 );
				}
			$random['categoryID'] = intval($myrow['categoryID']);
			$random['categoryname'] = $myts -> makeTboxData4Show($myrow['name']);
			}
		$microlinks = serviceLinks ( $random['entryID'] ,$random['uid']);
		}
	}


//** To display the submitted and requested terms box **//
if ( is_object($xoopsUser) ) 
	{
	if ( $xoopsUser->isAdmin($xoopsModule->getVar('mid')) ) 
		{
		$resultS = $xoopsDB -> query( "SELECT entryID, term FROM $ent_table WHERE submit = '1' ORDER BY term" );
		$totalSwords = $xoopsDB -> getRowsNum ( $resultS );

		if ( $totalSwords > 0 ) // If there are definitions
			{
			while (list( $entryID, $term ) = $xoopsDB->fetchRow($resultS))
				{
				$subentries['linktext'] = $myts -> makeTboxData4Show( $term );
				$subentries['id'] = intval($entryID);

				$blockS['substuff'][] = $subentries;
				}
			}
		$resultR = $xoopsDB -> query( "SELECT entryID, term FROM $ent_table WHERE request = '1' ORDER BY term" );
		$totalRwords = $xoopsDB -> getRowsNum ( $resultR );

		if ( $totalRwords > 0 ) // If there are definitions
			{
			while (list( $entryID, $term ) = $xoopsDB->fetchRow($resultR))
				{
				$reqentries['linktext'] = $myts -> makeTboxData4Show( $term );
				$reqentries['id'] = intval($entryID);

				$blockR['reqstuff'][] = $reqentries;
				}
			}
		}
	}

// Various strings
$xoopsOption['template_main'] = "{$mydirname}_index.html";
include_once( XOOPS_ROOT_PATH . '/header.php' );

$xoopsTpl -> assign ( 'multicats', intval($xoopsModuleConfig['multicats']));
$xoopsTpl -> assign ( 'lang_modulename', $xoopsModule->name() );
$xoopsTpl -> assign ( 'lang_moduledirname', $xoopsModule->dirname() );
$xoopsTpl -> assign ( 'lang_config', intval($xoopsModuleConfig["allowsubmit"]) );
$xoopsTpl -> assign ( 'lang_home', constant("_MD_{$MYDIRNAME}_HOME") );
$xoopsTpl -> assign ( 'lang_nothing', constant("_MD_{$MYDIRNAME}_STILLNOTHINGHERE") );
$xoopsTpl -> assign ( 'lang_first', constant("_MD_{$MYDIRNAME}_READMEFIRST") );
$xoopsTpl -> assign ( 'lang_now', constant("_MD_{$MYDIRNAME}_NOW") );
$xoopsTpl -> assign ( 'lang_defs', constant("_MD_{$MYDIRNAME}_DEFS") );
$xoopsTpl -> assign ( 'lang_cats', constant("_MD_{$MYDIRNAME}_CATS") );
$xoopsTpl -> assign ( 'lang_browsecat', constant("_MD_{$MYDIRNAME}_BROWSECAT") );
$xoopsTpl -> assign ( 'lang_browseletter', constant("_MD_{$MYDIRNAME}_BROWSELETTER") );
$xoopsTpl -> assign ( 'lang_recentent', constant("_MD_{$MYDIRNAME}_RECENTENT") );
$xoopsTpl -> assign ( 'lang_popular', constant("_MD_{$MYDIRNAME}_POPULARENT") );
$xoopsTpl -> assign ( 'lang_randamterm', constant("_MD_{$MYDIRNAME}_RANDOMTERM") );
$xoopsTpl -> assign ( 'lang_entcat', constant("_MD_{$MYDIRNAME}_ENTRYCATEGORY") );
$xoopsTpl -> assign ( 'lang_letterdef', constant("_MD_{$MYDIRNAME}_LETTERDEFINS") );
$xoopsTpl -> assign ( 'lang_seach', constant("_MD_{$MYDIRNAME}_SEARCHENTRY") );
$xoopsTpl -> assign ( 'lang_subandreq', constant("_MD_{$MYDIRNAME}_SUBANDREQ") );
$xoopsTpl -> assign ( 'lang_sub', constant("_MD_{$MYDIRNAME}_SUB") );
$xoopsTpl -> assign ( 'lang_nosub', constant("_MD_{$MYDIRNAME}_NOSUB") );
$xoopsTpl -> assign ( 'lang_req', constant("_MD_{$MYDIRNAME}_REQ") );
$xoopsTpl -> assign ( 'lang_noreq', constant("_MD_{$MYDIRNAME}_NOREQ") );
$xoopsTpl -> assign ( 'lang_allcats', constant("_MD_{$MYDIRNAME}_ALLCATS") );
$xoopsTpl -> assign ( 'config_req', intval($xoopsModuleConfig["allowreq"]) );
$xoopsTpl -> assign ( 'config_readme', $myts -> displayTarea($xoopsModuleConfig["readme1st"],1,1,1,1,1) );
$xoopsTpl -> assign ( 'titleblockuse', intval($xoopsModuleConfig["titleblockuse"]) );
$xoopsTpl -> assign ( 'h1id', $myts -> makeTboxData4Show( $xoopsModuleConfig["h1id"] ) );
$xoopsTpl -> assign ( 'catsarrayuse', intval($xoopsModuleConfig["catsarrayuse"]) );
$xoopsTpl -> assign ( 'blocksperpage', intval($xoopsModuleConfig["blocksperpage"]) );
$xoopsTpl -> assign ( 'publishedwords', countWords() );
$xoopsTpl -> assign ( 'totalcats', intval(countCats()));
$xoopsTpl -> assign ( 'searchform', showSearchForm("",4,0,"OR"));
$xoopsTpl -> assign ( 'block0', catlinksArray () );

if (!$xoopsModuleConfig["catsarrayuse"])
	{
	$xoopsTpl -> assign ( 'alpha', alphaArray() );
	}

if ($xoopsModuleConfig["blocksperpage"] > 0)
	{
	$xoopsTpl -> assign ( 'block1', NewEntriesArray() );
//	$xoopsTpl -> assign ( 'block1', $block1);
	$xoopsTpl -> assign ( 'block2', PopEntriesArray() );
//	$xoopsTpl -> assign ( 'block2', $block2);
	$xoopsTpl -> assign ( 'random', $random );
	}

$xoopsTpl -> assign ( 'microlinks', $microlinks );
$xoopsTpl -> assign ( 'blockS', $blockS);
$xoopsTpl -> assign ( 'blockR', $blockR);
$xoopsTpl -> assign ( 'wehavesubs', $totalSwords );
$xoopsTpl -> assign ( 'wehavereqs', $totalRwords );

include( XOOPS_ROOT_PATH . '/footer.php' );
?>