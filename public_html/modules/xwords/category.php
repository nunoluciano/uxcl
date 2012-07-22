<?php
/**
 * $Id: category.php v 1.0 8 May 2004 hsalazar Exp $
 * Module: Wordbook - a multicategory glossary
 * Version: v 1.00
 * Release Date: 8 May 2004
 * Author: hsalazar
 * Licence: GNU
 */

// XOOPS2 - Xwords 0.44
// WEBMASTER @ KANPYO.NET, 2005.

include "./header.php";
include_once( XOOPS_ROOT_PATH . '/class/pagenav.php' );

$cID = $categoryID = !empty($_GET['categoryID']) ? intval($_GET['categoryID']) : 0;
$start = !empty($_GET['start']) ? intval($_GET['start']) : 0;

// To display the list of linked initials
$block0 = Array ();
$catsarray = array();
$eachcat = array();
$eachentry = array();
$singlecat = array();
$entriesarray = array();
$rndlength = !empty($xoopsModuleConfig['rndlength']) ? intval($xoopsModuleConfig['rndlength']) : 100 ;
$xoops_pagetitle = $xoopsModule->name().' : ';

$alpha = alphaArray($categoryID);

for ($i=0; $i < count($alpha['initial']); $i++)
	{
	if ($alpha['initial'][$i]['linktext'] == constant("_MD_{$MYDIRNAME}_ALL_LINKTEXT"))
		{
		$publishedwords = $alpha['initial'][$i]['total'];
		break;
		}
	}

if ( !$publishedwords )
	{
	redirect_header( "index.php", 1, constant("_MD_{$MYDIRNAME}_STILLNOTHINGHERE"));
	exit();
	}

// No ID of category: we need to see all categories descriptions
if ( !$categoryID )
	{
	// How many categories are there?
	$resultcats = $xoopsDB -> query( "SELECT * FROM $cat_table ORDER BY weight" );
	$totalcats = $xoopsDB -> getRowsNum( $resultcats );
	if ( $totalcats == 0 )
		{
		redirect_header( "index.php", 1, constant("_MD_{$MYDIRNAME}_NOCATSINSYSTEM") );
		exit();
		}

	// If therz no $categoryID, we want to show just the categories with their description
	// How many categories will we show in this page?
	$queryA = "SELECT * FROM $cat_table ORDER BY weight ASC";
	$resultA = $xoopsDB -> query ($queryA, $xoopsModuleConfig['indexperpage'], $start );
	
	while (list( $categoryID, $name, $description, $total ) = $xoopsDB->fetchRow($resultA))
		{
		$eachcat['dir'] = $xoopsModule->dirname();
		$eachcat['id'] = intval($categoryID);
		$eachcat['name'] = $myts -> makeTboxData4Show( $name );
		$eachcat['description'] = $myts -> displayTarea( $description,1,1,1,1,1,1);
//		$eachcat['description'] = $myts -> makeTboxData4Show( $description );
		// Total entries in this category
		$entriesincat = countByCategory($categoryID);
		$eachcat['total'] = intval($entriesincat);

		$catsarray['single'][] = $eachcat;
		}
	$pagenav = new XoopsPageNav( $totalcats, $xoopsModuleConfig['indexperpage'], $start, 'start');
	$catsarray['navbar'] = $pagenav -> renderNav();
	$xoops_pagetitle .= constant("_MD_{$MYDIRNAME}_ALLCATS");
	$pagetype = '0';
	}
else	
	{
	// There IS a $categoryID, thus we show only that categoryz description
	$catdata = $xoopsDB -> query( "SELECT categoryID, name, description, total FROM $cat_table WHERE categoryID = '$categoryID'" );

	while (list( $categoryID, $name, $description , $total ) = $xoopsDB->fetchRow($catdata))
		{
		if ( $total == 0 )
			{
			redirect_header( "index.php", 1, constant("_MD_{$MYDIRNAME}_NOENTRIESINCAT") );
			exit();
			}
		$singlecat['dir'] = $xoopsModule->dirname();
		$singlecat['id'] = intval($categoryID);
		$singlecat['name'] = $myts -> makeTboxData4Show( $name );
		$singlecat['description'] = $myts -> displayTarea( $description,1,1,1,1,1,1);
//		$singlecat['description'] = $myts -> makeTboxData4Show( $description );
		// Total entries in this category
		$entriesincat = countByCategory($categoryID);

		$singlecat['total'] = intval($entriesincat);

		// Entries to show in current page
		// Now we retrieve a specific number of entries according to start variable
		$queryB = "SELECT entryID, term, proc, definition, html, smiley, xcodes, breaks, uid FROM $ent_table WHERE datesub < '".time()."' AND datesub > '0' AND submit = '0' AND offline = '0' AND request = '0' AND categoryID = '$categoryID' ORDER BY binary proc ASC";
		$resultB = $xoopsDB -> query( $queryB, $xoopsModuleConfig['indexperpage'], $start );
		while (list( $entryID, $term, $proc, $definition, $html, $smiley, $xcodes, $breaks, $uid ) = $xoopsDB->fetchRow($resultB))
			{
			$eachentry['dir'] = $xoopsModule->dirname();
			$eachentry['id'] = intval($entryID);
			$eachentry['term'] = $myts -> makeTboxData4Show( $term );
			if ($proc)
				{
				list($temp,$proc) = explode(",",$proc);
				}
			$eachentry['proc'] = $myts -> makeTboxData4Show( $proc );
			$definition = strip_tags($myts->displayTarea($definition, intval($html), intval($smiley), intval($xcodes), 1, intval($breaks)));
			if ( !XOOPS_USE_MULTIBYTES )
				{
				$eachentry['definition'] = substr ( $definition, 0, $rndlength -1 ) . "...";
				}
			else
				{
				$eachentry['definition'] = xoops_substr( $definition, 0, $rndlength +2 );
				}
			$eachentry['microlinks'] = serviceLinks ( $eachentry['id'] ,intval($uid) );
			$entriesarray['single'][] = $eachentry;
			}
		}
	$navstring = "categoryID=".$singlecat['id']."&amp;start";
	$pagenav = new XoopsPageNav( $entriesincat, $xoopsModuleConfig['indexperpage'], $start, $navstring);
	$entriesarray['navbar'] = $pagenav -> renderNav();
	$xoops_pagetitle .= $singlecat['name'];
	
	$pagetype = '1';
	}

$xoopsOption['template_main'] = "{$mydirname}_category.html";
include_once( XOOPS_ROOT_PATH . '/header.php' );

$xoopsTpl -> assign ( 'lang_modulename', $xoopsModule->name() );
$xoopsTpl -> assign ( 'lang_moduledirname', $xoopsModule->dirname() );
$xoopsTpl -> assign ( 'lang_home', constant("_MD_{$MYDIRNAME}_HOME") );
$xoopsTpl -> assign ( 'lang_allcats', constant("_MD_{$MYDIRNAME}_ALLCATS") );
$xoopsTpl -> assign ( 'lang_browsecat', constant("_MD_{$MYDIRNAME}_BROWSECAT") );
$xoopsTpl -> assign ( 'lang_browseletter', constant("_MD_{$MYDIRNAME}_BROWSELETTER") );
$xoopsTpl -> assign ( 'lang_wehave', constant("_MD_{$MYDIRNAME}_WEHAVE") );
$xoopsTpl -> assign ( 'lang_entcat', constant("_MD_{$MYDIRNAME}_ENTRIESINCAT") );
$xoopsTpl -> assign ( 'lang_return', constant("_MD_{$MYDIRNAME}_RETURN") );
$xoopsTpl -> assign ( 'lang_index', constant("_MD_{$MYDIRNAME}_RETURN2INDEX") );
$xoopsTpl -> assign ( 'lang_entryyomi', constant("_MD_{$MYDIRNAME}_ENTRYYOMI") );
$xoopsTpl -> assign ( 'lang_letterdef', constant("_MD_{$MYDIRNAME}_LETTERDEFINS") );
$xoopsTpl -> assign ( 'lang_rubyl', constant("_MD_{$MYDIRNAME}_RUBYL") );
$xoopsTpl -> assign ( 'lang_rubyr', constant("_MD_{$MYDIRNAME}_RUBYR") );
$xoopsTpl -> assign ( 'xoops_pagetitle', $xoops_pagetitle );
$xoopsTpl -> assign ( 'multicats', intval($xoopsModuleConfig['multicats']) );
$xoopsTpl -> assign ( 'titleblockuse', intval($xoopsModuleConfig["titleblockuse"]) );
$xoopsTpl -> assign ( 'h1id', $myts -> makeTboxData4Show( $xoopsModuleConfig["h1id"] ) );
$xoopsTpl -> assign ( 'catsarrayuse', intval($xoopsModuleConfig["catsarrayuse"]) );
$xoopsTpl -> assign ( 'blocksperpage', intval($xoopsModuleConfig["blocksperpage"]) );
$xoopsTpl -> assign ( 'publishedwords', $publishedwords );
$xoopsTpl -> assign ( 'block0', catlinksArray () );
$xoopsTpl -> assign ( 'alpha', $alpha );
$xoopsTpl -> assign ( 'lang_recentent', constant("_MD_{$MYDIRNAME}_CATRECENTENT") );
$xoopsTpl -> assign ( 'lang_popular', constant("_MD_{$MYDIRNAME}_CATPOPULARENT") );

if ($xoopsModuleConfig["blocksperpage"] > 0)
	{
	$xoopsTpl -> assign ( 'block1', NewEntriesArray($cID) );
	$xoopsTpl -> assign ( 'block2', PopEntriesArray($cID) );
	}

$xoopsTpl -> assign ( 'pagetype', $pagetype );
$xoopsTpl -> assign ( 'singlecat', $singlecat );
$xoopsTpl -> assign ( 'catsarray', $catsarray );
$xoopsTpl -> assign ( 'entriesarray', $entriesarray );

include( XOOPS_ROOT_PATH . '/footer.php' );
?>