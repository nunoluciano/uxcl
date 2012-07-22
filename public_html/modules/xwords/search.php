<?PHP
/**
 * $Id: search.php v 1.0 8 May 2004 hsalazar Exp $
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

global $searchtype;

// Check if search is enabled site-wide
$xoopsOption['pagetype'] = "search";

$config_handler =& xoops_gethandler('config');
$xoopsConfigSearch =& $config_handler->getConfigsByCat(XOOPS_CONF_SEARCH);
if ($xoopsConfigSearch['enable_search'] != 1)
	{
	header('Location: '.XOOPS_URL.'/index.php');
	exit();
	}

$rndlength = !empty($xoopsModuleConfig['rndlength']) ? intval($xoopsModuleConfig['rndlength']) : 100 ;
$query = "";
$catID = 0;
$type = 4;
$andor = "EXACT";
if ( !empty($_GET['term'])) $query = $myts ->stripSlashesGPC(trim($_GET['term']));
if ( !empty($_POST['term'])) $query = $myts ->stripSlashesGPC(trim($_POST['term']));
if ( !empty( $_GET['catID'] ) ) $catID = intval($_GET['catID']);
if ( !empty( $_POST['catID'] ) ) $catID = intval($_POST['catID']);
if ( !empty( $_GET['andor'] ) ) $andor = trim($_GET['andor']);
if ( !empty( $_POST['andor'] ) ) $andor = trim($_POST['andor']);
if ( !empty( $_GET['type'] ) ) $type = intval($_GET['type']);
if ( !empty( $_POST['type'] ) ) $type = intval($_POST['type']);
$start = !empty($_GET['start']) ? intval($_GET['start']) : 0;

if ($andor != "AND" && $andor != "OR" && $andor != "EXACT" && ($type < 0 || $type > 4))
	{
	redirect_header( "index.php", 1, constant("_MD_{$MYDIRNAME}_NORESULTS") );
	exit();
	}

$queryarray = array();
$resultset = array();
$eachresult = array();
$andcatid="";

// Configure search parameters according to selector
if ($andor == "EXACT")
	{
	$binary = "BINARY";
	if (preg_match('/^[[:alnum:]]+$/',$query))
		{
		$binary = "";
		}
	if ($type == 1) $searchtype = " term LIKE $binary '%".addslashes($query)."%' ";
	if ($type == 2) $searchtype = " proc LIKE $binary '%,%".addslashes($query)."%' ";
	if ($type == 3) $searchtype = " definition LIKE $binary '%".addslashes($query)."%' ";
	if ($type == 4) $searchtype = " term LIKE $binary '%".addslashes($query)."%' OR proc LIKE $binary '%,%".addslashes($query)."%' OR definition LIKE $binary '%".addslashes($query)."%' ";
	$queryarray[] = $query;
	}
else
	{
	$query	= str_replace(constant("_MD_{$MYDIRNAME}_NBSP"), " ", $query);
	$queryarray = preg_split ('/[\s,]+/', $query);
	$count = count( $queryarray );
	if ( $count > 0 && is_array( $queryarray ) )
		{
		$binary = "BINARY";
		if (preg_match('/^[[:alnum:]]+$/',$queryarray[0]))
			{
			$binary = "";
			}
		if ($type == 1) $searchtype = " ((term LIKE $binary '%".addslashes($queryarray[0])."%')";
		if ($type == 2) $searchtype = " ((proc LIKE $binary '%,%".addslashes($queryarray[0])."%')";
		if ($type == 3) $searchtype = " ((definition LIKE $binary '%".addslashes($queryarray[0])."%')";
		if ($type == 4) $searchtype = " ((term LIKE $binary '%".addslashes($queryarray[0])."%' OR proc LIKE $binary '%,%".addslashes($queryarray[0])."%' OR definition LIKE $binary '%".addslashes($queryarray[0])."%')";

		for ( $i = 1; $i < $count; $i++ )
			{
			$binary = "BINARY";
			if (preg_match('/^[[:alnum:]]+$/',$queryarray[$i]))
				{
				$binary = "";
				}
			$searchtype .= " $andor ";
			if ($type == 1) $searchtype .= " (term LIKE $binary '%".addslashes($queryarray[$i])."%')";
			if ($type == 2) $searchtype .= " (proc LIKE $binary '%,%".addslashes($queryarray[$i])."%')";
			if ($type == 3) $searchtype .= " (definition LIKE $binary '%".addslashes($queryarray[$i])."%')";
			if ($type == 4) $searchtype .= " (term LIKE $binary '%".addslashes($queryarray[$i])."%' OR proc LIKE $binary '%,%".addslashes($queryarray[$i])."%' OR definition LIKE $binary '%".addslashes($queryarray[$i])."%')";

			}
		$searchtype .= ")";
		}
	}

if ($xoopsModuleConfig['multicats'] == 1)
	{
	// If the look is in a particular category
	if ($catID > 0 )
		{
		$andcatid = "AND categoryID = '$catID'";
		}
	}

// If therez no term here (calling directly search page)
if (!$query)
	// Display message saying therez no term and explaining how to search
	{
	$intro = constant("_MD_{$MYDIRNAME}_NOSEARCHTERM") ;
	}
else
	{
	// IF there IS term, count number of results
	$searchquery = $xoopsDB -> query ("SELECT * FROM $ent_table WHERE datesub < '".time()."' AND datesub > '0' AND submit = '0' AND offline = '0' AND request = '0' AND ($searchtype) ".$andcatid."");
	$results = $xoopsDB -> getRowsNum ( $searchquery );

	if ($results == 0)
		{
		// Therez been no correspondences with the searched terms
		$intro = constant("_MD_{$MYDIRNAME}_NORESULTS") ;
		}
	else
		{
		// $results > 0 -> there were search results
		// Show paginated list of results
		// How many results will we show in this page?
		$queryA = "SELECT entryID, categoryID, term, proc, init, definition, html, smiley, xcodes, breaks, uid FROM $ent_table WHERE datesub < '".time()."' AND datesub > '0' AND submit = '0' AND offline = '0' AND request = '0' AND ".$searchtype." ".$andcatid." ORDER BY binary proc ASC";
		$resultA = $xoopsDB -> query ($queryA, $xoopsModuleConfig['indexperpage'], $start );

		while (list( $entryID, $categoryID, $term, $proc, $init, $definition, $html, $smiley, $xcodes, $breaks, $uid ) = $xoopsDB->fetchRow($resultA))
			{
			$eachresult['dir'] = $xoopsModule->dirname();
			$eachresult['id'] = intval($entryID);
			$eachresult['categoryID'] = intval($categoryID);
			$eachresult['term'] = $myts -> makeTboxData4Show( $term );
			if ($proc)
				{
				list($temp,$proc) = explode(",",$proc);
				}
			$eachresult['proc'] = $myts -> makeTboxData4Show( $proc );
			$definition = strip_tags( $myts -> displayTarea ( $definition, intval($html), intval($smiley), intval($xcodes), 1, intval($breaks) ) );
			if ( !XOOPS_USE_MULTIBYTES )
				{
				$tempdef = substr ( $definition, 0, $rndlength -1 ) . "...";
				}
			else
				{
				$tempdef = xoops_substr( $definition, 0, $rndlength +2 );
				}
			$eachresult['definition'] = getHTMLHighlight( $queryarray, $tempdef, '<b style="background-color: yellow; ">', '</b>', intval($html) );

			// Functional links
			$eachresult['microlinks'] = serviceLinks ( $eachresult['id'] ,intval($uid) );
			$resultset['match'][] = $eachresult;
			}

		// Msg: therez # results
		$intro = sprintf( constant("_MD_{$MYDIRNAME}_THEREWERE"),$results );
		$searchterm = urlencode($query);
		$linkstring = "term=".$searchterm."&amp;type=".$type."&amp;andor=".$andor."&amp;catID=".$catID."&amp;start";
		$pagenav = new XoopsPageNav( $results, $xoopsModuleConfig['indexperpage'], $start, $linkstring );
		$resultset['navbar'] = $pagenav -> renderNav();

		}
	}

// amazon keyword link
$amazon = $searchstring = '';
if (extension_loaded('mbstring') && $xoopsModuleConfig['amazon_id'] && _CHARSET !="UTF-8" && $query)
	{
	$searchstring = preg_replace('/\xA1[\xA2-\xC5]|\,|\./', ' ', $query);
	$searchstring = urlencode (mb_convert_encoding($searchstring, "UTF-8", _CHARSET));
	}
elseif ($xoopsModuleConfig['amazon_id'] && _CHARSET == "UTF-8" && $query)
	{
	$searchstring = urlencode($query);
	}

// Assign variables and close
$xoopsOption['template_main'] = "{$mydirname}_search.html";
include(XOOPS_ROOT_PATH.'/header.php');

$xoopsTpl -> assign ( 'lang_modulename', $xoopsModule->name() );
$xoopsTpl -> assign ( 'lang_moduledirname', $xoopsModule->dirname() );
$xoopsTpl -> assign ( 'lang_config', intval($xoopsModuleConfig["allowsubmit"]) );
$xoopsTpl -> assign ( 'lang_home', constant("_MD_{$MYDIRNAME}_HOME") );
$xoopsTpl -> assign ( 'lang_seachhead', constant("_MD_{$MYDIRNAME}_SEARCHHEAD") );
$xoopsTpl -> assign ( 'lang_still', constant("_MD_{$MYDIRNAME}_STILLNOTHINGHERE") );
$xoopsTpl -> assign ( 'lang_1st', constant("_MD_{$MYDIRNAME}_READMEFIRST") );
$xoopsTpl -> assign ( 'lang_now', constant("_MD_{$MYDIRNAME}_NOW") );
$xoopsTpl -> assign ( 'lang_defs', constant("_MD_{$MYDIRNAME}_DEFS") );
$xoopsTpl -> assign ( 'lang_cats', constant("_MD_{$MYDIRNAME}_CATS") );
$xoopsTpl -> assign ( 'lang_seachent', constant("_MD_{$MYDIRNAME}_SEARCHENTRY") );
$xoopsTpl -> assign ( 'lang_rubyl', constant("_MD_{$MYDIRNAME}_RUBYL") );
$xoopsTpl -> assign ( 'lang_rubyr', constant("_MD_{$MYDIRNAME}_RUBYR") );
$xoopsTpl -> assign ( 'lang_yomi', constant("_MD_{$MYDIRNAME}_ENTRYYOMI") );
$xoopsTpl -> assign ( 'lang_letterdef', constant("_MD_{$MYDIRNAME}_LETTERDEFINS") );
$xoopsTpl -> assign ( 'lang_return', constant("_MD_{$MYDIRNAME}_RETURN") );
$xoopsTpl -> assign ( 'lang_index', constant("_MD_{$MYDIRNAME}_RETURN2INDEX") );
$xoopsTpl -> assign ( 'config_req', intval($xoopsModuleConfig["allowreq"]) );
$xoopsTpl -> assign ( 'amazon_id', $myts -> makeTboxData4Show($xoopsModuleConfig["amazon_id"] ));
$xoopsTpl -> assign ( 'searchstring', $searchstring );
$xoopsTpl -> assign ( 'config_readme', $myts -> displayTarea($xoopsModuleConfig["readme1st"],1,1,1,1,1) );
$xoopsTpl -> assign ( 'titleblockuse', intval($xoopsModuleConfig["titleblockuse"]) );
$xoopsTpl -> assign ( 'h1id', $myts -> makeTboxData4Show( $xoopsModuleConfig["h1id"] ) );
$xoopsTpl -> assign ( 'searchform', showSearchForm($query,$type,$catID,$andor));
$xoopsTpl -> assign ( 'totalcats', countCats() );
$xoopsTpl -> assign ( 'publishedwords', countWords() );
$xoopsTpl -> assign ( 'intro', $intro );
$xoopsTpl -> assign ( 'multicats', $xoopsModuleConfig['multicats'] );
$xoopsTpl -> assign ( 'resultset', $resultset );

include(XOOPS_ROOT_PATH.'/footer.php');
?>