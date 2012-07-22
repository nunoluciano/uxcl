<?php
/**
 * $Id: letter.php v 1.0 8 May 2004 hsalazar Exp $
 * Module: Wordbook - a multicategory glossary
 * Version: v 1.00
 * Release Date: 8 May 2004
 * Author: hsalazar
 * Licence: GNU
 */

// XOOPS2 - Xwords 0.42
// WEBMASTER @ KANPYO.NET, 2005.

include "./header.php";
include_once( XOOPS_ROOT_PATH . '/class/pagenav.php' );

global $xoopsUser;

$post_init = !empty($_GET['init']) ? $_GET['init'] : constant("_MD_{$MYDIRNAME}_ALL_ID");
$catID = !empty($_GET['categoryID']) ? intval($_GET['categoryID']) : 0;
$start = !empty( $_GET['start'] ) ? intval( $_GET['start'] ) : 0;
$init_str = '';
$page_str = '';
$eachentry = array();
$entriesarray = array();
$block0 = catlinksArray();
$rndlength = !empty($xoopsModuleConfig['rndlength']) ? intval($xoopsModuleConfig['rndlength']) : 100 ;
$cID = $catID ? "AND e.categoryID = '$catID'" : '';
$xoops_pagetitle = $xoopsModule->name().' : ';

if ($cID)
	{
	for ($i=0; $i < count($block0); $i++)
		{
		if ($block0['categories'][$i]['id'] == $catID)
			{
			$xoops_pagetitle .= $block0['categories'][$i]['linktext'].' : ';
			break;
			}
		}
	}
elseif ($xoopsModuleConfig['multicats'])
	{
	$xoops_pagetitle .= constant("_MD_{$MYDIRNAME}_ALLCATEGORY").' : ';
	}

for ($i=0; $i < count($mb_init); $i++)
	{
	if ($post_init == $mb_id[$i])
		{
		$init_str = $mb_init[$i];
		$page_str = $catID ? 'categoryID='.$catID.'&amp;init='.$post_init.'&amp;start' : 'init='.$post_init.'&amp;start';
		$xoops_pagetitle .= $mb_linktext[$i];
		$pageinitial = $mb_linktext[$i];
		$firstletter = $mb_linktext[$i];
		break;
		}
	}

if ( !$init_str )
	{
	redirect_header( "index.php", 1, constant("_MD_{$MYDIRNAME}_NOTERMSINLETTER"));
	exit();
	}

// How many entries will we show in this page?
$queryA = "SELECT e.entryID, e.categoryID, e.term, e.proc, e.init, e.definition, e.ref, e.url, e.uid, e.submit, e.datesub, e.counter, e.html, e.smiley, e.xcodes, e.breaks, e.block, e.offline, e.notifypub, e.request, c.name ".
		" FROM (".$ent_table." e ".
		" LEFT JOIN ".$cat_table." c ".
		" ON e.categoryID = c.categoryID) ".
		" WHERE e.init regexp binary '".$init_str."' AND e.datesub < '".time()."' AND e.datesub > '0' AND e.submit = '0' AND e.offline = '0' AND e.request = '0' ".
		"$cID ORDER BY binary e.proc ASC";

$resultA = $xoopsDB -> query ($queryA, $xoopsModuleConfig['indexperpage'], $start );
$entrieshere = $xoopsDB -> getRowsNum( $resultA );
if ( $entrieshere == 0 )
	{
	redirect_header( "index.php", 1, constant("_MD_{$MYDIRNAME}_NOTERMSINLETTER"));
	exit();
	}

// To display the linked letter list
$alpha = alphaArray($catID);

$pagenav = new XoopsPageNav( $alpha['initial'][$i]['total'], $xoopsModuleConfig['indexperpage'], $start, $page_str);
$entriesarray['navbar'] = $pagenav -> renderNav();

while (list( $entryID, $categoryID, $term, $proc, $init, $definition, $ref, $url, $uid, $submit, $datesub, $counter, $html, $smiley, $xcodes, $breaks, $block, $offline, $notifypub, $request, $name ) = $xoopsDB->fetchRow($resultA))
	{
	$eachentry['catname'] = $myts -> makeTboxData4Show( $name );
	$eachentry['id'] = intval($entryID);
	$eachentry['term'] = $myts -> makeTboxData4Show( $term );
	if ($proc)
		{
		list($temp,$proc) = explode(",",$proc);
		}
	$eachentry['proc'] = $myts -> makeTboxData4Show( $proc );
	$definition = strip_tags( $myts -> displayTarea ( $definition, intval($html), intval($smiley), intval($xcodes), 1, intval($breaks) ) );
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

for ($i=0; $i < count($alpha['initial']); $i++)
	{
	if ($alpha['initial'][$i]['linktext'] == constant("_MD_{$MYDIRNAME}_ALL_LINKTEXT"))
		{
		$publishedwords = $alpha['initial'][$i]['total'];
		break;
		}
	}

$xoopsOption['template_main'] = "{$mydirname}_letter.html";
include_once( XOOPS_ROOT_PATH . '/header.php' );

$xoopsTpl -> assign ( 'lang_modulename', $xoopsModule->name() );
$xoopsTpl -> assign ( 'lang_moduledirname', $xoopsModule->dirname() );
$xoopsTpl -> assign ( 'lang_home', constant("_MD_{$MYDIRNAME}_HOME") );
$xoopsTpl -> assign ( 'lang_allcategory', constant("_MD_{$MYDIRNAME}_ALLCATEGORY") );
$xoopsTpl -> assign ( 'lang_allcats', constant("_MD_{$MYDIRNAME}_ALLCATS") );
$xoopsTpl -> assign ( 'lang_browsecat', constant("_MD_{$MYDIRNAME}_BROWSECAT") );
$xoopsTpl -> assign ( 'lang_browseletter', constant("_MD_{$MYDIRNAME}_BROWSELETTER") );
$xoopsTpl -> assign ( 'lang_wehave', constant("_MD_{$MYDIRNAME}_WEHAVE") );
$xoopsTpl -> assign ( 'lang_begin', constant("_MD_{$MYDIRNAME}_BEGINWITHLETTER") );
$xoopsTpl -> assign ( 'lang_entryyomi', constant("_MD_{$MYDIRNAME}_ENTRYYOMI") );
$xoopsTpl -> assign ( 'lang_letterdef', constant("_MD_{$MYDIRNAME}_LETTERDEFINS") );
$xoopsTpl -> assign ( 'lang_entrycat', constant("_MD_{$MYDIRNAME}_ENTRYCATEGORY") );
$xoopsTpl -> assign ( 'lang_return', constant("_MD_{$MYDIRNAME}_RETURN") );
$xoopsTpl -> assign ( 'lang_index', constant("_MD_{$MYDIRNAME}_RETURN2INDEX") );
$xoopsTpl -> assign ( 'lang_rubyl', constant("_MD_{$MYDIRNAME}_RUBYL") );
$xoopsTpl -> assign ( 'lang_rubyr', constant("_MD_{$MYDIRNAME}_RUBYR") );
$xoopsTpl -> assign ( 'xoops_pagetitle', $xoops_pagetitle );
$xoopsTpl -> assign ( 'pageinitial', $pageinitial );
$xoopsTpl -> assign ( 'firstletter', $firstletter );
$xoopsTpl -> assign ( 'alpha', $alpha );
$xoopsTpl -> assign ( 'catid', $catID );
$xoopsTpl -> assign ( 'publishedwords', $publishedwords );
$xoopsTpl -> assign ( 'multicats', intval($xoopsModuleConfig['multicats']) );
$xoopsTpl -> assign ( 'titleblockuse', intval($xoopsModuleConfig["titleblockuse"]) );
$xoopsTpl -> assign ( 'catsarrayuse', intval($xoopsModuleConfig["catsarrayuse"]) );
$xoopsTpl -> assign ( 'h1id', $myts -> makeTboxData4Show( $xoopsModuleConfig["h1id"] ) );
$xoopsTpl -> assign ( 'block0', $block0 );
$xoopsTpl -> assign ( 'entriesarray', $entriesarray );

include( XOOPS_ROOT_PATH . '/footer.php' );
?>