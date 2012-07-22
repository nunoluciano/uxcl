<?php
/**
 * $Id: functions.php v 1.0 8 May 2004 hsalazar Exp $
 * Module: Wordbook
 * Version: v 1.00
 * Release Date: 8 May 2004
 * Author: hsalazar
 * Licence: GNU
 */

// XOOPS2 - Xwords 0.46
// WEBMASTER @ KANPYO.NET, 2006.

if( ! defined( 'XOOPS_ROOT_PATH' ) ) exit ;

function calculateTotals()
	{
	$mydirname = basename( dirname( dirname( __FILE__ ) ) ) ;
	$xoopsDB =& Database::getInstance();
	$cat_table = $xoopsDB -> prefix ("{$mydirname}_cat") ;
	$ent_table = $xoopsDB -> prefix ("{$mydirname}_ent") ;
	$newcount = array();

	$result = $xoopsDB->query("SELECT categoryID,COUNT(*) FROM $ent_table WHERE datesub < '".time()."' AND datesub > '0' AND submit = '0' AND offline = '0' AND request = '0' GROUP BY categoryID ORDER BY categoryID ASC");
	while (list ( $categoryID, $total ) = $xoopsDB -> fetchRow ( $result ))
		{
		$newcount[$categoryID] = $total;
		}

	$result01 = $xoopsDB -> query( "SELECT categoryID, total FROM $cat_table ORDER BY categoryID ASC" );
//	list ( $totalcategories ) = $xoopsDB -> getRowsNum( $result01 );
	while (list ( $categoryID, $total ) = $xoopsDB -> fetchRow ( $result01 ))
		{
//		$newcount = countByCategory ( $categoryID );
//		if ($newcount != $total)
		if ($newcount[$categoryID] != $total)
			{
			$xoopsDB -> queryF( "UPDATE $cat_table SET total = '$newcount[$categoryID]' WHERE categoryID = '$categoryID'");
			}
		}
	}

function countByCategory( $c )
	{
	$mydirname = basename( dirname( dirname( __FILE__ ) ) ) ;
	$xoopsDB =& Database::getInstance();
	$ent_table = $xoopsDB -> prefix ("{$mydirname}_ent") ;
	$count = array();

/*
	$sql = $xoopsDB -> query( "SELECT * FROM $ent_table WHERE datesub < '".time()."' AND datesub > '0' AND submit = '0' AND offline = '0' AND request = '0' AND categoryID = '$c'" );
	$count = $xoopsDB -> getRowsNum( $sql );

	while ( $myrow = $xoopsDB -> fetchArray( $sql ) )
		{
		$count++;
		} 
	return $count;
*/

	$sql = $xoopsDB -> query( "SELECT COUNT(*) FROM $ent_table WHERE datesub < '".time()."' AND datesub > '0' AND submit = '0' AND offline = '0' AND request = '0' AND categoryID = '$c'" );
	$count = $xoopsDB -> fetchRow ( $sql );

	return $count[0];
	}

function countCats ()
	{
	$mydirname = basename( dirname( dirname( __FILE__ ) ) ) ;
	$xoopsDB =& Database::getInstance();
	$cat_table = $xoopsDB -> prefix ("{$mydirname}_cat") ;

//	$cats = $xoopsDB -> query( "SELECT * FROM $cat_table" );
//	$totalcats = $xoopsDB -> getRowsNum( $cats );
//	return $totalcats;

	$cats = $xoopsDB -> query( "SELECT COUNT(*) FROM $cat_table" );
	$totalcats = $xoopsDB -> fetchRow ( $cats );

	return $totalcats[0];
	}

function catlinksArray ()
	{
	$mydirname = basename( dirname( dirname( __FILE__ ) ) ) ;
	$xoopsDB =& Database::getInstance();
	$cat_table = $xoopsDB -> prefix ("{$mydirname}_cat") ;

	if( ! class_exists( 'XwordsTextSanitizer' ) )
		{
		include_once( XOOPS_ROOT_PATH . "/modules/$mydirname/class/xwords.textsanitizer.php" ) ;
		}
	$myts = & XwordsTextSanitizer::getInstance();
//	$myts =& MyTextSanitizer::getInstance();

	$block0 = array();
	$catlinks = array();

	$resultcat = $xoopsDB -> query ( "SELECT categoryID, name, description, total FROM $cat_table ORDER BY weight ASC" );
	while (list( $catID, $name, $description,$total) = $xoopsDB->fetchRow($resultcat))
		{
		$catlinks['id'] = $catID;
		$catlinks['total'] = intval($total);
		$catlinks['linktext'] = $myts -> makeTboxData4Show( $name );
		$catlinks['desc'] = $myts -> displayTarea( $description,1,1,1,1,1,1);
//		$catlinks['desc'] = $myts -> makeTboxData4Show( $description );

		$block0['categories'][] = $catlinks;
		}
	return $block0;
	}

function countWords ()
	{
	$mydirname = basename( dirname( dirname( __FILE__ ) ) ) ;
	$xoopsDB =& Database::getInstance();
	$ent_table = $xoopsDB -> prefix ("{$mydirname}_ent") ;
	$datesubwords = array();

//	$pubwords = $xoopsDB -> query( "SELECT * FROM $ent_table WHERE datesub < '".time()."' AND datesub > '0' AND submit = '0' AND offline = '0' AND request = '0' " );
//	$datesubwords = $xoopsDB -> getRowsNum ( $pubwords );
//	return $datesubwords;

	$pubwords = $xoopsDB -> query( "SELECT COUNT(*) FROM $ent_table WHERE datesub < '".time()."' AND datesub > '0' AND submit = '0' AND offline = '0' AND request = '0' " );
	$datesubwords = $xoopsDB -> fetchRow ( $pubwords );

	return $datesubwords[0];
	}

function getInitial($term = '',$proc = '')
	{
	$mydirname = basename( dirname( dirname( __FILE__ ) ) ) ;

	$hModule =& xoops_gethandler('module');
	$hModConfig =& xoops_gethandler('config');
	$xwModule =& $hModule->getByDirname("$mydirname");
	$module_id = $xwModule -> getVar( 'mid' );
	$module_name = $xwModule -> getVar( 'dirname' );
	$xwConfig =& $hModConfig->getConfigsByCat(0, $xwModule->getVar('mid'));

	$term = stripslashes($term);
	$proc = stripslashes($proc);
	$init_t = $init_p = '';

	if (preg_match('/^[[:graph:]]/',$term) && $term)
		{
		$init_t = substr($term, 0, 1);
		}
	elseif (!preg_match('/^[[:blank:]]|[[:cntrl:]]/',$term) && $term)
		{
		$init_t = substr($term, 0, 2);
		}
	$init_t = $xwConfig['letterformat'] == "letter_format11.php" ? "":$init_t;

	if (preg_match('/^[[:graph:]]/',$proc) && $proc)
		{
		$init_p = substr($proc, 0, 1);
		}
	elseif (!preg_match('/^[[:blank:]]|[[:cntrl:]]/',$proc) && $proc)
		{
		$init_p = substr($proc, 0, 2);
		}

	return addslashes($init_p.$init_t);
	}

function getJsortCode($mystring)
	{
	global $patterns1,$replace1,$patterns2,$replace2;
	$n = 0;
	$yomi = $mystring;
	$mystring1 = preg_replace ($patterns1, $replace1, $mystring); 
	$mystring2 = '';
	while($mystring2 != $mystring1 && $n < 60 )
		{
		$mystring2 = $mystring1; 
		$mystring1 = preg_replace ($patterns1, $replace1, $mystring1); 
		$n++;
		}
	$jsortstring = preg_replace($patterns2, $replace2, $mystring1);

	return xoops_substr($jsortstring , 0 , 122 , "").",".xoops_substr($yomi , 0 , 122 , "");
	}


function alphaArray ($categoryID=0)
	{
	$mydirname = basename( dirname( dirname( __FILE__ ) ) ) ;
	$xoopsDB =& Database::getInstance();
	$ent_table = $xoopsDB -> prefix ("{$mydirname}_ent") ;

	global $xoopsConfig,$xoopsUser;

	$hModule =& xoops_gethandler('module');
	$hModConfig =& xoops_gethandler('config');
	$xwModule =& $hModule->getByDirname("$mydirname");
	$module_id = $xwModule -> getVar( 'mid' );
	$module_name = $xwModule -> getVar( 'dirname' );
	$xwConfig =& $hModConfig->getConfigsByCat(0, $xwModule->getVar('mid'));

	// include the default language file for the module interface
	if ( file_exists( XOOPS_ROOT_PATH . "/modules/$mydirname/language/" . $xoopsConfig['language'] . "/" . $xwConfig['letterformat']) )
		{
		include (XOOPS_ROOT_PATH . "/modules/$mydirname/language/" . $xoopsConfig['language'] . "/" . $xwConfig['letterformat'] );
		}
	else
		{
		include (XOOPS_ROOT_PATH . "/modules/$mydirname/language/japanese/letter.php");
		}
	$alpha = array();
	$letterlinks = array();
	$data = array();
	$cID = $categoryID ? "categoryID = '$categoryID' AND" : '';

	for ($n=0; $n < count($mb_id); $n++)
		{
		$data[$mb_linktext[$n]] = 0;
		}

	$result = $xoopsDB->query("SELECT init,COUNT(*) FROM $ent_table WHERE $cID datesub < '".time()."' AND datesub > '0' AND submit = '0' AND offline = '0' AND request = '0' GROUP BY BINARY init ORDER BY BINARY init ASC");
	while($temp = $xoopsDB->fetchArray($result))
		{
		$data[$temp['init']] = $temp['COUNT(*)'];
		for ($n=0; $n < count($mb_id); $n++)
			{
			//if (ereg($mb_init[$n],$temp['init']))
			if (preg_match('/'.$mb_init[$n].'/', $temp['init']))
				{
				$data[$mb_linktext[$n]] = $temp['COUNT(*)'] + $data[$mb_linktext[$n]];
				}
			}
		}

//	print_r($data);

	for ($n=0; $n < count($mb_init); $n++)
		{
		if (isset($data[$mb_linktext[$n]]))
			{
			$letterlinks['total'] = $data[$mb_linktext[$n]];
			}
		else
			{
			$letterlinks['total'] = 0;
			}
		$letterlinks['id'] = $mb_id[$n];
		$letterlinks['linktext'] = $mb_linktext[$n];
		$letterlinks['separator'] = $mb_separator[$n];

		$alpha['initial'][] = $letterlinks;
		}

/*
	for ($n=0; $n < count($mb_init); $n++)
		{
		$sql = $xoopsDB->query("SELECT * FROM $ent_table WHERE init regexp binary '".$mb_init[$n]."' AND $cID datesub < '".time()."' AND datesub > '0' AND submit = '0' AND offline = '0' AND request = '0'");
//		$sql = $xoopsDB -> query ( "SELECT * FROM " . $xoopsDB -> prefix ( "wbentries") . " WHERE init = '$initial' " );
		$letterlinks['total'] = $xoopsDB -> getRowsNum( $sql );
		$letterlinks['id'] = $mb_id[$n];
		$letterlinks['linktext'] = $mb_linktext[$n];
		$letterlinks['separator'] = $mb_separator[$n];
		$alpha['initial'][] = $letterlinks;
		}
*/

	return $alpha;
	}


function NewEntriesArray ($categoryID=0)
	{
	global $xoopsModuleConfig;
	$mydirname = basename( dirname( dirname( __FILE__ ) ) ) ;
	$xoopsDB =& Database::getInstance();
	$ent_table = $xoopsDB -> prefix ("{$mydirname}_ent") ;
	$myts = & MyTextSanitizer :: getInstance();
	$cID = $categoryID ? "categoryID = '$categoryID' AND" : '';
	$block1 = array();

	$result05 = $xoopsDB -> query( "SELECT entryID, categoryID, term, datesub FROM $ent_table WHERE $cID datesub < '".time()."' AND datesub > '0' AND submit = '0' AND offline = '0' AND request = '0' ORDER BY datesub DESC", intval($xoopsModuleConfig['blocksperpage']), 0 );
//	if ( $xoopsDB -> getRowsNum( $xoopsDB -> query( "SELECT * FROM $ent_table WHERE $cID datesub < '".time()."' AND datesub > '0' AND submit = '0' AND offline = '0' AND request = '0'" ) ) )
	if ( $xoopsDB -> getRowsNum( $result05 ) )
		{
		while (list( $entryID, $categoryID, $term, $datesub ) = $xoopsDB->fetchRow($result05))
			{
			$newentries['linktext'] = $myts -> makeTboxData4Show( $term );
			$newentries['id'] = intval($entryID);
			$newentries['categoryID'] = intval($categoryID);
			$newentries['date'] = formatTimestamp( $datesub, "s" );	

			$block1['newstuff'][] = $newentries;
			}
		}
	return $block1;
	}


function PopEntriesArray ($categoryID=0)
	{
	global $xoopsModuleConfig;
	$mydirname = basename( dirname( dirname( __FILE__ ) ) ) ;
	$xoopsDB =& Database::getInstance();
	$ent_table = $xoopsDB -> prefix ("{$mydirname}_ent") ;
	$myts = & MyTextSanitizer :: getInstance();
	$cID = $categoryID ? "categoryID = '$categoryID' AND" : '';
	$block2 = array();

	$result06 = $xoopsDB -> query( "SELECT entryID, categoryID, term, counter FROM $ent_table WHERE $cID datesub < '".time()."' AND datesub > '0' AND submit = '0' AND offline = '0' AND request = '0' ORDER BY counter DESC", intval($xoopsModuleConfig['blocksperpage']), 0 );

//	if ( $xoopsDB -> getRowsNum( $xoopsDB -> query( "SELECT * FROM $ent_table WHERE $cID datesub < '".time()."' AND datesub > '0' AND submit = '0' AND offline = '0' AND request = '0'" ) ) )
	if ( $xoopsDB -> getRowsNum( $result06 ) )
		{
		while (list( $entryID, $categoryID, $term, $counter ) = $xoopsDB->fetchRow($result06))
			{
			$popentries['linktext'] = $myts -> makeTboxData4Show( $term );
			$popentries['id'] = intval($entryID);
			$popentries['categoryID'] = intval($categoryID);
			$popentries['counter'] = intval( $counter );

			$block2['popstuff'][] = $popentries;
			}
		}
	return $block2;
	}


function serviceLinks ( $variable ,$uid )
	{
	global $xoopsUser, $xoopsModuleConfig, $xoopsConfig;
	$mydirname = basename( dirname( dirname( __FILE__ ) ) ) ;
	$MYDIRNAME = strtoupper($mydirname);
	$xoopsDB =& Database::getInstance();
	$xoopsModule = XoopsModule::getByDirname("$mydirname");
	// Functional links
	$srvlinks = "";
	if ( is_object($xoopsUser) ) 
		{
		if ( $xoopsUser->isAdmin($xoopsModule->getVar('mid')) ) 
			{
			$srvlinks = "<a href=\"".XOOPS_URL."/modules/".$xoopsModule->getVar('dirname')."/admin/entry.php?op=mod&amp;entryID=".$variable."\" target=\"_blank\"><img src=\"".XOOPS_URL."/modules/".$xoopsModule->getVar('dirname')."/images/edit.gif\" border=\"0\" alt=\"".constant("_MD_{$MYDIRNAME}_EDITTERM")."\" width=\"15\" height=\"11\" /></a>&nbsp;<a href=\"".XOOPS_URL."/modules/".$xoopsModule->getVar('dirname')."/admin/entry.php?op=del&amp;entryID=".$variable."\" target=\"_blank\"><img src=\"".XOOPS_URL."/modules/".$xoopsModule->getVar('dirname')."/images/delete.gif\" border=\"0\" alt=\"".constant("_MD_{$MYDIRNAME}_DELTERM")."\" width=\"15\" height=\"11\" /></a>&nbsp;";
			}
		elseif ( $uid == $xoopsUser -> getVar( 'uid' ) && $xoopsModuleConfig["allowsubmit"] )	//ver 0.06
			{
			$srvlinks = "<a href=\"".XOOPS_URL."/modules/".$xoopsModule->getVar('dirname')."/submit.php?entryID=".$variable."\" target=\"_blank\"><img src=\"".XOOPS_URL."/modules/".$xoopsModule->getVar('dirname')."/images/edit.gif\" border=\"0\" alt=\"".constant("_MD_{$MYDIRNAME}_EDITTERM")."\" width=\"15\" height=\"11\" /></a>";
			}
		}
	return $srvlinks;
	}

function showSearchForm($query='',$type='',$catID='',$andor='')
	{
	global $xoopsUser, $xoopsModuleConfig, $xoopsConfig;
	$mydirname = basename( dirname( dirname( __FILE__ ) ) ) ;
	$MYDIRNAME = strtoupper($mydirname);
	$xoopsDB =& Database::getInstance();
	$cat_table = $xoopsDB -> prefix ("{$mydirname}_cat") ;
	$ent_table = $xoopsDB -> prefix ("{$mydirname}_ent") ;
	$xoopsModule = XoopsModule::getByDirname("$mydirname");
	$myts =& MyTextSanitizer::getInstance();

	$query = $myts->htmlSpecialChars($query);

	$typeop1 = ($type == 1) ? " selected='selected'" : '';
	$typeop2 = ($type == 2) ? " selected='selected'" : '';
	$typeop3 = ($type == 3) ? " selected='selected'" : '';
	$typeop4 = ($type == 4) ? " selected='selected'" : '';

	$andorop1 = ($andor == "AND") ? " selected='selected'" : '';
	$andorop2 = ($andor == "OR") ? " selected='selected'" : '';
	$andorop3 = ($andor == "EXACT") ? " selected='selected'" : '';

	$searchform  = "<form name='op' style='margin:1em 0em;padding:0em;text-align:left;' id='op' action='search.php' method='get'>\n";
	$searchform .= "<dl style='margin:1em 0em;padding:0em;'>\n";


	$searchform .= "<dt style='width:25%;margin-right:0.5em;text-align:right;font-size:1em;float:left;'>".constant("_MD_{$MYDIRNAME}_LOOKON")."</dt>\n";
	$searchform .= "<dd style='margin:0em:padding:0em;font-size:1em;text-align:left;clear:right;'>\n";
	$searchform .= "<select name='type' style='margin:0em:padding:0em;font-size:1em;'>\n";
	$searchform .= "<option value='1'$typeop1>".constant("_MD_{$MYDIRNAME}_TERMS")."</option>\n";
	$searchform .= "<option value='2'$typeop2>".constant("_MD_{$MYDIRNAME}_PROCS")."</option>\n";
	$searchform .= "<option value='3'$typeop3>".constant("_MD_{$MYDIRNAME}_DEFINS")."</option>\n";
	$searchform .= "<option value='4'$typeop4>".constant("_MD_{$MYDIRNAME}_TERMSDEFS")."</option>\n";
	$searchform .= "</select>\n";
	$searchform .= "</dd>\n";

	if ($xoopsModuleConfig['multicats'] == 1)
		{
		$searchform .= "<dt style='width:25%;margin-right:0.5em;text-align:right;font-size:1em;float:left;'>".constant("_MD_{$MYDIRNAME}_CATEGORY")."</dt>\n";
		$searchform .= "<dd style='margin:0em:padding:0em;font-size:1em;text-align:left;clear:right;'>\n";
		$searchform .= "<select name='catID' style='margin:0em:padding:0em;font-size:1em;'>\n";
		if ($catID > 0)
			{
			$searchform .= "<option value='0'>";
			}
		else
			{
			$searchform .= "<option value='0' selected='selected'>";
			}
		$searchform .= constant("_MD_{$MYDIRNAME}_ALLOFTHEM")."</option>\n";

		$resultcat = $xoopsDB -> query ( "SELECT categoryID, name FROM $cat_table ORDER BY weight ASC" );
		while (list( $categoryID, $name) = $xoopsDB->fetchRow($resultcat))
			{
			if ($categoryID == $catID)
				{
				$searchform .= "<option value='".$categoryID."' selected='selected'>";
				}
			else
				{
				$searchform .= "<option value='".$categoryID."'>";
				}
			$searchform .= "$name</option>\n";
			}
		$searchform .= "</select>\n</dd>\n";
		}

	$searchform .= "<dt style='width:25%;margin-right:0.5em;text-align:right;font-size:1em;float:left;'>".constant("_MD_{$MYDIRNAME}_SEARCHTYPE")."</dt>\n";
	$searchform .= "<dd style='margin:0em:padding:0em;font-size:1em;text-align:left;clear:right;'>\n";
	$searchform .= "<select name='andor' style='margin:0em:padding:0em;font-size:1em;'>\n";
	$searchform .= "<option value='AND'$andorop1>".constant("_MD_{$MYDIRNAME}_SEARCHALL")."</option>\n";
	$searchform .= "<option value='OR'$andorop2>".constant("_MD_{$MYDIRNAME}_SEARCHANY")."</option>\n";
	$searchform .= "<option value='EXACT'$andorop3>".constant("_MD_{$MYDIRNAME}_SEARCHEXACT")."</option>\n";
	$searchform .= "</select>\n";
	$searchform .= "</dd>\n";

	$searchform .= "<dt style='width:25%;margin-right:0.5em;text-align:right;font-size:1em;float:left;'>".constant("_MD_{$MYDIRNAME}_TERM")."</dt>\n";
	$searchform .= "<dd style='margin:0em:padding:0em;font-size:1em;text-align:left;clear:right;'>\n";
	$searchform .= "<input type='text' name='term' style='margin-right:0.5em;padding:0em;font-size:1em;height:1.2em;' value='".$query."' /><input class='formButton' style='margin:0em;padding:0em;font-size:0.8em;' type='submit' value='".constant("_MD_{$MYDIRNAME}_SEARCH")."' /></dd>\n";

	$searchform .= "</dl>\n";
	$searchform .= "<input style='font-size:1em;margin:0em:padding:0em;' type='hidden' name='dummy' value='".constant("_MD_{$MYDIRNAME}_DUMMY")."' />\n";
	$searchform .= "</form>\n";

	return $searchform;
	}

function getHTMLHighlight($needle, $haystack, $hlS, $hlE, $html)
	{
	$myts =& MyTextSanitizer::getInstance();
	$count = count( $needle );
	$parts = explode(">", $haystack);
	foreach($parts as $key=>$part)
		{
		for ( $i = 0; $i < $count; $i++ )
			{
			if (!$html) $needle[$i] = $myts->htmlSpecialChars($needle[$i]);

			$pL = "";
			$pR = "";

			if(($pos = strpos($part, "<")) === false)
				{
				$pL = $part;
				}
			elseif($pos > 0)
				{
				$pL = substr($part, 0, $pos);
				$pR = substr($part, $pos, strlen($part));
				}
			if($pL != "")
				{
				$parts[$key] = preg_replace('|('.quotemeta($needle[$i]).')|iU', $hlS.'\\1'.$hlE, $pL) . $pR;
				}
			}
		}
	return(implode(">", $parts));
	}

function adminMenu ( $currentoption = 0, $breadcrumb = '' )
	{
	global $xoopsConfig, $xoopsModuleConfig,$mydirname;
	$xoopsModule = XoopsModule::getByDirname("$mydirname");

	$tblColors = Array();
	$tblColors[0]=$tblColors[1]=$tblColors[2]=$tblColors[3]=$tblColors[4]=$tblColors[5]=$tblColors[6]=$tblColors[7]=$tblColors[8]='#DDE';
	$tblColors[$currentoption] = '#FFF';
	if (file_exists(XOOPS_ROOT_PATH.'/modules/'.$xoopsModule->getVar('dirname').'/language/'.$xoopsConfig['language'].'/modinfo.php'))
		{
		include_once '../language/'.$xoopsConfig['language'].'/modinfo.php';
		}
	else
		{
		include_once '../language/english/modinfo.php';
		}
	echo '<div style="font-size: 10px; text-align: right; color: #2F5376; margin: 0 0 8px 0; padding: 2px 6px; line-height: 18px; border: 1px solid #e7e7e7;"><b>'.$xoopsModule->name().'</b>&nbsp;:&nbsp;'.$breadcrumb.'</div>';	
	}


function getSetTimeForm($datesub)
	{
	$mydirname = basename( dirname( dirname( __FILE__ ) ) ) ;
	$MYDIRNAME = strtoupper($mydirname);
	$timeform = "<select name='autoyear'>\n";
	if (isset($_POST['autoyear']))
		{
		$autoyear = intval($_POST['autoyear']);
		}
	elseif (isset($datesub))
		{
		$autoyear = date('Y', $datesub);
		}
	else
		{
		$autoyear = date('Y');
		}

	$cyear = date('Y');
	for ($xyear=($autoyear-8); $xyear < ($cyear+8); $xyear++)
		{
		if ($xyear == $autoyear)
			{
			$sel = 'selected="selected"';
			}
		else
			{
			$sel = '';
			}
		$timeform .= "<option value='$xyear' $sel>$xyear</option>\n";
		}
	$timeform .= "</select>&nbsp;".constant("_AM_{$MYDIRNAME}_CURRENTTIME_Y");

	$timeform .= "&nbsp;<select name='automonth'>\n";
	if (isset($_POST['automonth']))
		{
		$automonth = intval($_POST['automonth']);
		}
	elseif (isset($datesub))
		{
		$automonth = date('m', $datesub);
		}
	else
		{
		$automonth = date('m');
		}
	for ($xmonth=1; $xmonth<13; $xmonth++)
		{
		if ($xmonth == $automonth)
			{
			$sel = 'selected="selected"';
			}
		else
			{
			$sel = '';
			}
		$timeform .= "<option value='$xmonth' $sel>$xmonth</option>\n";
		}
	$timeform .= "</select>&nbsp;".constant("_AM_{$MYDIRNAME}_CURRENTTIME_M")."\n";

	$timeform .= "&nbsp;<select name='autoday'>\n";
	if (isset($_POST['autoday']))
		{
		$autoday = intval($_POST['autoday']);
		}
	elseif (isset($datesub))
		{
		$autoday = date('d', $datesub);
		}
	else
		{
		$autoday = date('d');
		}

	for ($xday=1; $xday<32; $xday++)
		{
		if ($xday == $autoday)
			{
			$sel = 'selected="selected"';
			}
		else
			{
			$sel = '';
			}
		$timeform .= "<option value='$xday' $sel>$xday</option>\n";
		}
	$timeform .= "</select>".constant("_AM_{$MYDIRNAME}_CURRENTTIME_D")."\n";

	$timeform .= "&nbsp;<select name='autohour'>\n";
	if (isset($_POST['autohour']))
		{
		$autohour = intval($_POST['autohour']);
		}
	elseif (isset($datesub))
		{
		$autohour = date('H', $datesub);
		}
	else
		{
		$autohour = date('H');
		}

	for ($xhour=0; $xhour<24; $xhour++)
		{
		if ($xhour == $autohour)
			{
			$sel = 'selected="selected"';
			}
		else
			{
			$sel = '';
			}
		$timeform .= "<option value='$xhour' $sel>$xhour</option>\n";
		}
	$timeform .= "</select>&nbsp;".constant("_AM_{$MYDIRNAME}_CURRENTTIME_J")."\n";

	$timeform .= "&nbsp;<select name='automin'>\n";
	if (isset($_POST['automin']))
		{
		$automin = intval($_POST['automin']);
		}
	elseif (isset($datesub))
		{
		$automin = date('i', $datesub);
		}
	else
		{
		$automin = date('i');
		}

	for ($xmin=0; $xmin<61; $xmin++)
		{
		if ($xmin == $automin)
			{
			$sel = 'selected="selected"';
			}
		else
			{
			$sel = '';
			}
		$xxmin = $xmin;
		if ($xxmin < 10)
			{
			$xxmin = "0$xmin";
			}
		$timeform .= "<option value='$xmin' $sel>$xxmin</option>\n";
		}
	$timeform .= "</select>&nbsp;".constant("_AM_{$MYDIRNAME}_CURRENTTIME_H")."\n";

	return $timeform;
	}

function formatTimestampJ($datesub)
	{
	global $week;
	$mydirname = basename( dirname( dirname( __FILE__ ) ) ) ;
	$MYDIRNAME = strtoupper($mydirname);
	list($sec,$min,$hour,$dy,$mon,$year,$wday,$yday,$isdst) = localtime($datesub);
	$year += 1900 ;
	$mon = $mon + 1;
	$date = "{$year}".constant("_MD_{$MYDIRNAME}_Y")."{$mon}".constant("_MD_{$MYDIRNAME}_M")."{$dy}".constant("_MD_{$MYDIRNAME}_D")."({$week[$wday]})";

	return $date;
	}
?>