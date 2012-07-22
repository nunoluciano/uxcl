<?php
/**
 * $Id: entry.php v 1.0 8 May 2004 hsalazar Exp $
 * Module: Wordbook - a multicategory glossary
 * Version: v 1.00
 * Release Date: 8 May 2004
 * Author: hsalazar
 * Licence: GNU
 */

// XOOPS2 - Xwords 0.44
// WEBMASTER @ KANPYO.NET, 2005.

include "./header.php";

global $xoopsUser;

// okino xpwiki‚©‚çxword‚ÉŽ©“®ƒŠƒ“ƒN
if (!isset($_GET['entryID'])) {
    if (isset($_SERVER['QUERY_STRING']) && $_SERVER['QUERY_STRING']) {
    	$_temp = $_SERVER['QUERY_STRING'];
    	if (strpos($_temp,'&') > 0) {
        	$_arg = substr($_temp,0,strpos($_temp,'&'));
        }
        else {
        	$_arg = $_temp;
        }
    } else if (isset($_SERVER['argv']) && ! empty($_SERVER['argv'])) {
        $_arg = $_SERVER['argv'][0];
    }
 
    $_arg = rawurldecode($_arg);
 
    $result = $xoopsDB->query( "SELECT `entryID` FROM ".$ent_table." WHERE `term`='".addslashes($_arg)."'" ) ;
    if( $xoopsDB->getRowsNum( $result ) ) {
        list( $_GET['entryID'] ) = $xoopsDB->fetchRow( $result ) ;
    }
}

$entryID = !empty($_GET['entryID']) ? intval($_GET['entryID']) : 0;
$catID = !empty($_GET['categoryID']) ? intval($_GET['categoryID']) : 0;
$thisterm = array();
$block0 = array ();
$eachletter = array ();
$letterarray = array ();
$url = '';

// To display the linked letter list
$alpha = alphaArray($catID);

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
	redirect_header( "index.php", 1, constant("_MD_{$MYDIRNAME}_NOTERMSINLETTER"));
	exit();
	}

$result = $xoopsDB -> query( "SELECT e.entryID, e.categoryID, e.term, e.proc, e.init, e.definition, e.ref, e.url, e.uid, e.datesub, e.counter, e.html, e.smiley, e.xcodes, e.breaks, e.block, e.notifypub, c.name FROM $ent_table e LEFT JOIN $cat_table c ON e.categoryID = c.categoryID WHERE e.datesub < '". time() ."' AND e.datesub > '0' AND e.submit = '0' AND e.offline = '0' AND e.request = '0' AND e.entryID = '$entryID'" );

if ( !$xoopsDB -> getRowsNum( $result ) )
	{
	redirect_header( "index.php", 2, constant("_MD_{$MYDIRNAME}_NORESULTS") );
	exit();
	}

if ( !$xoopsUser || ( $xoopsUser->isAdmin($xoopsModule->mid()) && $xoopsModuleConfig['adminhits'] == 1 ) || ( $xoopsUser && !$xoopsUser -> isAdmin( $xoopsModule -> mid() ) ) )
	{
	$xoopsDB -> queryF( "UPDATE $ent_table SET counter = counter+1 WHERE entryID = $entryID" );
	}

while (list( $entryID, $categoryID, $term, $proc, $init, $definition, $ref, $url, $uid, $datesub, $counter, $html, $smiley, $xcodes, $breaks, $block, $notifypub, $name ) = $xoopsDB->fetchRow($result))
	{
	$thisterm['id'] = intval($entryID);
	$microlinks = serviceLinks ( $thisterm['id'] ,intval($uid) );

	$thisterm['categoryID'] = intval($categoryID);
	$thisterm['catname'] = $myts -> makeTboxData4Show( $name );
	$thisterm['term'] = $myts -> makeTboxData4Show( $term );
	if ($proc)
		{
		list($temp,$proc) = explode(",",$proc);
		}
	$thisterm['proc'] = $myts -> makeTboxData4Show( $proc );

	if ( !$xoopsModuleConfig['linktermsposition'] )
		{
		$thisterm['definition'] = $myts->displayTarea( $definition, intval($html), intval($smiley), intval($xcodes), 1, intval($breaks) );
		$thisterm['linkedterms'] = $myts->getAutoLinkTerms( $definition, intval($html), $mydirname, $entryID, 0 );
		}
	else
		{
		$thisterm['definition'] = $myts->displayTarea( $definition, intval($html), intval($smiley), intval($xcodes), 1, intval($breaks), $mydirname, $entryID );
		}
	$thisterm['ref'] = $myts -> makeTboxData4Show( $ref );
	$thisterm['url'] = $myts->makeClickable(formatURL($url), $allowimage = 0);
	$thisterm['submitter'] = xoops_getLinkedUnameFromId ( intval($uid) );
	if ( $xoopsModuleConfig['strfformat'] )
		{
		$thisterm['datesub'] = $myts->makeTboxData4Show(formatTimestamp(xoops_getUserTimestamp(intval($datesub)), $xoopsModuleConfig['strfformat']));
		}
	else
		{
		$thisterm['datesub'] = formatTimestampJ(xoops_getUserTimestamp(intval($datesub)));
		}
	$thisterm['counter'] = intval($counter);
	$thisterm['block'] = intval($block);
	$thisterm['notifypub'] = intval($notifypub);
	$thisterm['dir'] = $xoopsModule->dirname();

	if ( $xoopsModuleConfig['multicats'] == 1 )
		{
		$xoops_pagetitle = $xoopsModule->name().' : '.$thisterm['catname'].' : ';
		}
	else
		{
		$xoops_pagetitle = $xoopsModule->name().' : ';
		}

	for ($n=0; $n < count($mb_init); $n++)
		{
		if (preg_match('/'.$mb_init[$n].'/',$init) && $mb_linktext[$n] != constant("_MD_{$MYDIRNAME}_ALL_LINKTEXT"))
			{
			$xoops_pagetitle .= $mb_linktext[$n].' ';

			$eachletter['text'] = $mb_linktext[$n];
			$eachletter['id'] = $mb_id[$n];
			$letterarray['navi'][] = $eachletter;
			}
		}

	$xoops_pagetitle .= ' : '.$thisterm['term'];

	// amazon keyword link
	$amazon = $searchstring = '';
	if (extension_loaded('mbstring') && $xoopsModuleConfig['amazon_id'] && _CHARSET !="UTF-8")
		{
		$searchstring = preg_replace('/^(.*?)(\xA1[\xA2-\xC5]|\,|\.).*/', '$1', $thisterm['term']);
		$searchstring = urlencode (mb_convert_encoding($searchstring, "UTF-8", _CHARSET));
		}
	elseif ($xoopsModuleConfig['amazon_id'] && _CHARSET == "UTF-8")
		{
		$searchstring = urlencode($thisterm['term']);
		}
	}

// Various strings
$xoopsOption['template_main'] = "{$mydirname}_entry.html";
include_once( XOOPS_ROOT_PATH . '/header.php' );

$xoopsTpl -> assign ( 'lang_modulename', $xoopsModule->name() );
$xoopsTpl -> assign ( 'lang_moduledirname', $xoopsModule->dirname() );
$xoopsTpl -> assign ( 'lang_home', constant("_MD_{$MYDIRNAME}_HOME") );
$xoopsTpl -> assign ( 'lang_browsecat', constant("_MD_{$MYDIRNAME}_BROWSECAT") );
$xoopsTpl -> assign ( 'lang_allcats', constant("_MD_{$MYDIRNAME}_ALLCATS") );
$xoopsTpl -> assign ( 'lang_browseletter', constant("_MD_{$MYDIRNAME}_BROWSELETTER") );
$xoopsTpl -> assign ( 'lang_entcat', constant("_MD_{$MYDIRNAME}_ENTRYCATEGORY") );
$xoopsTpl -> assign ( 'lang_rubyl', constant("_MD_{$MYDIRNAME}_RUBYL") );
$xoopsTpl -> assign ( 'lang_rubyr', constant("_MD_{$MYDIRNAME}_RUBYR") );
$xoopsTpl -> assign ( 'lang_entref', constant("_MD_{$MYDIRNAME}_ENTRYREFERENCE") );
$xoopsTpl -> assign ( 'lang_enturl', constant("_MD_{$MYDIRNAME}_ENTRYRELATEDURL") );
$xoopsTpl -> assign ( 'lang_submitter', constant("_MD_{$MYDIRNAME}_SUBMITTEDBY") );
$xoopsTpl -> assign ( 'lang_submitted', constant("_MD_{$MYDIRNAME}_SUBMITTED") );
$xoopsTpl -> assign ( 'lang_count', constant("_MD_{$MYDIRNAME}_COUNT") );
$xoopsTpl -> assign ( 'lang_comment', constant("_MD_{$MYDIRNAME}_COMMENT") );
$xoopsTpl -> assign ( 'lang_amazon', constant("_MD_{$MYDIRNAME}_AMAZON") );
$xoopsTpl -> assign ( 'lang_amazonlink', constant("_MD_{$MYDIRNAME}_AMAZONLINK") );
$xoopsTpl -> assign ( 'lang_linkedterms', $myts -> makeTboxData4Show( $xoopsModuleConfig['linktermstitle'] ) );
$xoopsTpl -> assign ( 'xoops_pagetitle', $xoops_pagetitle);
$xoopsTpl -> assign ( 'alpha', $alpha );
$xoopsTpl -> assign ( 'publishedwords', $publishedwords );
$xoopsTpl -> assign ( 'multicats', intval($xoopsModuleConfig['multicats']) );
$xoopsTpl -> assign ( 'titleblockuse', intval($xoopsModuleConfig["titleblockuse"]) );
$xoopsTpl -> assign ( 'catsarrayuse', intval($xoopsModuleConfig["catsarrayuse"]) );
$xoopsTpl -> assign ( 'h1id', $myts -> makeTboxData4Show( $xoopsModuleConfig["h1id"] ) );
$xoopsTpl -> assign ( 'block0', catlinksArray () );
$xoopsTpl -> assign ( 'thisterm', $thisterm );
$xoopsTpl -> assign ( 'microlinks', $microlinks );
$xoopsTpl -> assign ( 'entryID', $entryID );
$xoopsTpl -> assign ( 'letterarray', $letterarray );
$xoopsTpl -> assign ( 'amazon_id', $myts -> makeTboxData4Show($xoopsModuleConfig["amazon_id"]));
$xoopsTpl -> assign ( 'searchstring', $searchstring);
$xoopsTpl -> assign ( 'submitterlink', intval($xoopsModuleConfig['submitterlink']) );
$xoopsTpl -> assign ( 'linkterms', intval($xoopsModuleConfig['linkterms']) );
$xoopsTpl -> assign ( 'linktermsposition', intval($xoopsModuleConfig['linktermsposition']) );

include( XOOPS_ROOT_PATH.'/include/comment_view.php' );
include_once( XOOPS_ROOT_PATH.'/footer.php' );
?>
