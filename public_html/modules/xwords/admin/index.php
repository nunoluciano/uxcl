<?php
/**
 * $Id: index.php v 1.0 8 May 2004 hsalazar Exp $
 * Module: Wordbook - a multicategory glossary
 * Version: v 1.00
 * Release Date: 8 May 2004
 * Author: hsalazar
 * Licence: GNU
 */

// XOOPS2 - Xwords 0.44
// WEBMASTER @ KANPYO.NET, 2006.

include( "./admin_header.php" );
include_once( XOOPS_ROOT_PATH . '/class/pagenav.php' );

$startentry = !empty( $_GET['startentry'] ) ? intval( $_GET['startentry'] ) : 0;
$startcat = !empty( $_GET['startcat'] ) ? intval( $_GET['startcat'] ) : 0;
$startsub = !empty( $_GET['startsub'] ) ? intval( $_GET['startsub'] ) : 0;
$datesub = !empty( $_GET['datesub'] ) ? intval( $_GET['datesub'] ) : 0;
$entryID = !empty( $_GET['entryID'] ) ? intval( $_GET['entryID'] ) : 0;

xoops_cp_header();
adminMenu(0, constant("_AM_{$MYDIRNAME}_INDEX"));
include('./mymenu.php');

$result01 = $xoopsDB -> query( "SELECT COUNT(*) FROM $cat_table" );
list( $totalcategories ) = $xoopsDB -> fetchRow( $result01 );
$result02 = $xoopsDB -> query( "SELECT COUNT(*) FROM $ent_table WHERE submit = '0' AND request = '0'" );
list( $totalpublished ) = $xoopsDB -> fetchRow( $result02 );
$result03 = $xoopsDB -> query( "SELECT COUNT(*) FROM $ent_table WHERE submit = '1'" );
list( $totalsubmitted ) = $xoopsDB -> fetchRow( $result03 );
$result04 = $xoopsDB -> query( "SELECT COUNT(*) FROM $ent_table WHERE request = '1'" );
list( $totalrequested ) = $xoopsDB -> fetchRow( $result04 );

echo "<fieldset style='margin:1em 0em 0em 0em;border:1px solid #778;'><legend style='font-weight: bold; color: #900;'>" . constant("_AM_{$MYDIRNAME}_INVENTORY") . "</legend>";
echo "<div style='padding: 12px;'>\n" . constant("_AM_{$MYDIRNAME}_TOTALENTRIES") . " <b>".intval($totalpublished)."</b>&nbsp;|&nbsp;";
if ($xoopsModuleConfig['multicats'] == 1)
	{
	echo constant("_AM_{$MYDIRNAME}_TOTALCATS") . "<b>".intval($totalcategories)."</b>&nbsp;|&nbsp;";
	}
echo constant("_AM_{$MYDIRNAME}_TOTALSUBM") . "<b>".intval($totalsubmitted)."</b>&nbsp;|&nbsp;";
echo constant("_AM_{$MYDIRNAME}_TOTALREQ") . "<b>".intval($totalrequested)."</b>";
if ($totalrequested || $totalsubmitted)
	{
	echo "&nbsp;|&nbsp;<a href='" . XOOPS_URL . "/modules/" . $xoopsModule->dirname() . "/admin/submissions.php'>" .constant("_AM_{$MYDIRNAME}_GOAUTHORIZE") . "</a>";
	}
echo "</div>\n</fieldset><br />";

/* -- Code to show existing terms -- */
echo "<fieldset style='margin:1em 0em 0em 0em;border:1px solid #778;'><legend style='font-weight: bold; color: #900;'>" . constant("_AM_{$MYDIRNAME}_SHOWENTRIES") . "</legend><br />";
echo "<a style='border: 1px solid #5E5D63; color: #000000; font-size: 1em; padding: 4px 8px; text-align:center;' href='" . XOOPS_URL . "/modules/" . $xoopsModule->dirname() . "/admin/entry.php'>".constant("_AM_{$MYDIRNAME}_CREATEENTRY")."</a><br /><br />";

// To create existing terms table
echo "<table width='100%' cellspacing='1' cellpadding='3' border='0' class='outer'>";
echo "<tr>";
echo "<td width='40' class='bg3' align='center'><b>" . constant("_AM_{$MYDIRNAME}_ENTRYID") . "</b></td>";
if ($xoopsModuleConfig['multicats'] == 1)
	{
	echo "<td width='20%' class='bg3' align='center'><b>" . constant("_AM_{$MYDIRNAME}_ENTRYCATNAME") . "</b></td>";
	$colspan = 7;
	}
else
	{
	$colspan = 6;
	}
echo "<td class='bg3' align='center'><b>" . constant("_AM_{$MYDIRNAME}_ENTRYTERM") . "</b></td>";
echo "<td width='90' class='bg3' align='center'><b>" . constant("_AM_{$MYDIRNAME}_SUBMITTER") . "</b></td>";
echo "<td width='90' class='bg3' align='center'><b>" . constant("_AM_{$MYDIRNAME}_ENTRYCREATED") . "</b></td>";
echo "<td width='30' class='bg3' align='center'><b>" . constant("_AM_{$MYDIRNAME}_STATUS") . "</b></td>";
echo "<td width='60' class='bg3' align='center'><b>" . constant("_AM_{$MYDIRNAME}_ACTION") . "</b></td>";
echo "</tr>";

$resultA1 = $xoopsDB -> query( "SELECT COUNT(*) FROM $ent_table WHERE submit = '0' AND request = '0'" );
list( $numrows ) = $xoopsDB -> fetchRow( $resultA1 );

if ( $numrows > 0 ) // That is, if there ARE entries in the system
	{
	$sql = "SELECT e.entryID, e.categoryID, e.term, e.uid, e.datesub, e.offline, c.name FROM $ent_table e LEFT JOIN $cat_table c ON e.categoryID = c.categoryID WHERE submit = '0' AND request = '0' ORDER BY entryID DESC";
	$resultA2 = $xoopsDB -> query( $sql, $xoopsModuleConfig['perpage'], $startentry );

	while ( list( $entryID, $categoryID, $term, $uid, $created, $offline, $name ) = $xoopsDB -> fetchrow( $resultA2 ) )
		{
		$entryID = intval($entryID);
		$sentby = xoops_getLinkedUnameFromId($uid);
		$catname = $myts -> htmlSpecialChars( $name );
		$term = $myts -> htmlSpecialChars( $term );
		$modify = "<a href='" . XOOPS_URL . "/modules/" . $xoopsModule->dirname() . "/admin/entry.php?op=mod&amp;entryID=" . $entryID . "'><img src='" . XOOPS_URL . "/modules/" . $xoopsModule->dirname() . "/images/icon/edit.gif' border='0' width='20' height='20' alt='".constant("_AM_{$MYDIRNAME}_EDITENTRY")."' /></a>";
		$delete = "<a href='" . XOOPS_URL . "/modules/" . $xoopsModule->dirname() . "/admin/entry.php?op=del&amp;entryID=" . $entryID . "'><img src='" . XOOPS_URL . "/modules/" . $xoopsModule->dirname() . "/images/icon/delete.gif' border='0' width='20' height='20' alt='".constant("_AM_{$MYDIRNAME}_DELETEENTRY")."' /></a>";

		if ( $offline == 0 )
			{
			$status = "<img src='" . XOOPS_URL . "/modules/" . $xoopsModule->dirname() . "/images/icon/on.gif' border='0' width='20' height='20' alt='".constant("_AM_{$MYDIRNAME}_ENTRYISON")."' />";
			$term = "<a href='" . XOOPS_URL . "/modules/" . $xoopsModule->dirname() . "/entry.php?entryID=" . $entryID . "'> $term </a>";
			}
		else
			{
			$status = "<img src='" . XOOPS_URL . "/modules/" . $xoopsModule->dirname() . "/images/icon/off.gif' border='0' width='20' height='20' alt='".constant("_AM_{$MYDIRNAME}_ENTRYISOFF")."' />";
			}

		if ( $created > time() )
			{
			$status = "<img src='" . XOOPS_URL . "/modules/" . $xoopsModule->dirname() . "/images/icon/add.gif' border='0' width='20' height='20' alt='".constant("_AM_{$MYDIRNAME}_ENTRYISFUTURE")."' />";
			}
			
		$created = formatTimestamp( $created, 's' );
		echo "<tr>";
		echo "<td class='head' align='center'>" . $entryID . "</td>";
		if ($xoopsModuleConfig['multicats'] == 1)
			{
			echo "<td class='even' align='left'>" . $catname . "</td>";
			}
		echo "<td class='even' align='left'>" . $term . "</td>";
		echo "<td class='even' align='center'>" . $sentby . "</td>";
		echo "<td class='even' align='center'>" . $created . "</td>";
		echo "<td class='even' align='center'>" . $status . "</td>";
		echo "<td class='even' align='center'> $modify $delete </td>";
		echo "</tr>";
		}
	}
else // that is, $numrows = 0, therez no entries yet
	{
	echo "<tr>";
	echo "<td class='head' align='center' colspan='".$colspan."'>".constant("_AM_{$MYDIRNAME}_NOTERMS")."</td>";
	echo "</tr>";
	} 
echo "</table>\n";
$pagenav = new XoopsPageNav( $numrows, $xoopsModuleConfig['perpage'], $startentry, 'startentry', 'entryID =' . $entryID );
echo "<div style='text-align:right;'>" . $pagenav -> renderNav() . "</div>";
echo "</fieldset>";
echo "<br />\n";


/* -- Code to show existing categories -- */
if ($xoopsModuleConfig['multicats'] == 1)
	{
	echo "<fieldset style='margin:1em 0em 0em 0em;border:1px solid #778;'><legend style='font-weight: bold; color: #900;'>" . constant("_AM_{$MYDIRNAME}_SHOWCATS") . "</legend><br />";
	echo "<a style='border: 1px solid #5E5D63; color: #000000; font-size: 1em; padding: 4px 8px; text-align:center;' href='" . XOOPS_URL . "/modules/" . $xoopsModule->dirname() . "/admin/category.php'>".constant("_AM_{$MYDIRNAME}_CREATECAT")."</a><br /><br />";
	echo "<table width='100%' cellspacing='1' cellpadding='3' border='0' class=' outer'>";
	echo "<tr>";
	echo "<td width='40' class='bg3' align='center'><b>" . constant("_AM_{$MYDIRNAME}_ID") . "</b></td>";
	echo "<td width='40' class='bg3' align='center'><b>" . constant("_AM_{$MYDIRNAME}_CATPOSIT") . "</b></td>";
	echo "<td width='20%' class='bg3' align='center'><b>" . constant("_AM_{$MYDIRNAME}_CATNAME") . "</b></td>";
	echo "<td class='bg3' align='center'><b>" . constant("_AM_{$MYDIRNAME}_DESCRIP") . "</b></td>";
	echo "<td width='40' class='bg3' align='center'><b>" . constant("_AM_{$MYDIRNAME}_OPENDATA") . "</b></td>";
	echo "<td width='60' class='bg3' align='center'><b>" . constant("_AM_{$MYDIRNAME}_ACTION") . "</b></td>";
	echo "</tr>";

	// To create existing columns table
	$resultC1 = $xoopsDB -> query( "SELECT COUNT(*) FROM $cat_table" );
	list( $numrows ) = $xoopsDB -> fetchRow( $resultC1 );

	if ( $numrows > 0 ) // That is, if there ARE columns in the system
		{
		$sql = "SELECT * FROM $cat_table ORDER BY weight";
		$resultC2 = $xoopsDB -> query( $sql, $xoopsModuleConfig['perpage'], $startcat );

		while ( list( $categoryID, $name, $description, $total, $weight, ) = $xoopsDB -> fetchrow( $resultC2 ) )
			{
			$categoryID = intval($categoryID);
			$name = $myts -> htmlSpecialChars( $name );
			$description = $myts -> htmlSpecialChars( $description );
			$weight = intval($weight);
			$total = intval($total);
			$modify = "<a href='" . XOOPS_URL . "/modules/" . $xoopsModule->dirname() . "/admin/category.php?op=mod&amp;categoryID=" . $categoryID . "'><img src='" . XOOPS_URL . "/modules/" . $xoopsModule->dirname() . "/images/icon/edit.gif' border='0' width='20' height='20' alt='".constant("_AM_{$MYDIRNAME}_EDITCAT")."' /></a>";
			$delete = "<a href='" . XOOPS_URL . "/modules/" . $xoopsModule->dirname() . "/admin/category.php?op=del&amp;categoryID=" . $categoryID . "'><img src='" . XOOPS_URL . "/modules/" . $xoopsModule->dirname() . "/images/icon/delete.gif' border='0' width='20' height='20' alt='".constant("_AM_{$MYDIRNAME}_DELETECAT")."' /></a>";
			echo "<tr>";
			echo "<td class='head' align='center'> $categoryID </td>";
			echo "<td class='even' align='center'> $weight </td>";
			echo "<td class='even' align='lefet'> $name </td>";
			echo "<td class='even' align='left'> $description </td>";
			echo "<td class='even' align='center'> $total </td>";
			echo "<td class='even' align='center'> $modify $delete </td>";
			echo "</tr>";
			}
		}
	else // that is, $numrows = 0, therez no columns yet
		{
		echo "<tr>";
		echo "<td class='head' align='center' colspan='6'>".constant("_AM_{$MYDIRNAME}_NOCATS")."</td>";
		echo "</tr>";
		$categoryID = 0;
		}
	echo "</table>\n";
	$pagenav = new XoopsPageNav( $numrows, $xoopsModuleConfig['perpage'], $startcat, 'startcat', 'categoryID=' . $categoryID );
	echo "<div style='text-align:right;'>" . $pagenav -> renderNav() . "</div>";
	echo "</fieldset>";
	echo "<br />\n";
	}

/* -- Code to show future entries -- */
echo "<fieldset style='margin:1em 0em 0em 0em;border:1px solid #778;'><legend style='font-weight: bold; color: #900;'>" . constant("_AM_{$MYDIRNAME}_FUTUREENTRY") . "</legend><br />";

echo "<table width='100%' cellspacing='1' cellpadding='3' border='0' class='outer'>";
echo "<tr>";
echo "<td width='40' class='bg3' align='center'><b>" . constant("_AM_{$MYDIRNAME}_ENTRYID") . "</b></td>";
if ($xoopsModuleConfig['multicats'] == 1)
	{
	echo "<td width='20%' class='bg3' align='center'><b>" . constant("_AM_{$MYDIRNAME}_ENTRYCATNAME") . "</b></td>";
	$colspan = 6;
	}
else
	{
	$colspan = 5;
	}	
echo "<td class='bg3' align='center'><b>" . constant("_AM_{$MYDIRNAME}_ENTRYTERM") . "</b></td>";
echo "<td width='90' class='bg3' align='center'><b>" . constant("_AM_{$MYDIRNAME}_SUBMITTER") . "</b></td>";
echo "<td width='90' class='bg3' align='center'><b>" . constant("_AM_{$MYDIRNAME}_OPENSCHEDULE") . "</b></td>";
echo "<td width='60' class='bg3' align='center'><b>" . constant("_AM_{$MYDIRNAME}_ACTION") . "</b></td>";
echo "</tr>";

$resultS1 = $xoopsDB -> query("SELECT COUNT(*) FROM $ent_table WHERE datesub > ".time()."");
list( $numrows ) = $xoopsDB -> fetchRow( $resultS1 );

if ( $numrows > 0 ) // That is, if there ARE submitted entries in the system
	{
	$sql = "SELECT e.entryID, e.categoryID, e.term, e.uid, e.datesub, c.name FROM $ent_table e LEFT JOIN $cat_table c ON e.categoryID = c.categoryID WHERE datesub > '".time()."' ORDER BY datesub DESC";
	$resultS2 = $xoopsDB -> query( $sql, $xoopsModuleConfig['perpage'], $startsub );

	while ( list( $entryID, $categoryID, $term, $uid, $created, $name ) = $xoopsDB -> fetchrow( $resultS2 ) )
		{
		$sentby = xoops_getLinkedUnameFromId(intval($uid));
		$entryID = intval($entryID);
		$categoryID = intval($categoryID);
		$catname = $myts -> htmlSpecialChars( $name );
		$term = $myts -> htmlSpecialChars( $term );
		$created = formatTimestamp( $created, 'Y-m-d H:i' );
		$modify = "<a href='" . XOOPS_URL . "/modules/" . $xoopsModule->dirname() . "/admin/entry.php?op=mod&amp;entryID=" . $entryID . "'><img src='" . XOOPS_URL . "/modules/" . $xoopsModule->dirname() . "/images/icon/edit.gif' border='0' width='20' height='20' alt='".constant("_AM_{$MYDIRNAME}_EDITSUBM")."' /></a>";
		$delete = "<a href='" . XOOPS_URL . "/modules/" . $xoopsModule->dirname() . "/admin/entry.php?op=del&amp;entryID=" . $entryID . "'><img src='" . XOOPS_URL . "/modules/" . $xoopsModule->dirname() . "/images/icon/delete.gif' border='0' width='20' height='20' alt='".constant("_AM_{$MYDIRNAME}_DELETESUBM")."' /></a>";
		echo "<tr>";
		echo "<td class='head' align='center'> $entryID </td>";
		if ($xoopsModuleConfig['multicats'] == 1)
			{
			echo "<td class='even' align='left'> $catname </td>";
			}
		echo "<td class='even' align='left'> $term </td>";
		echo "<td class='even' align='center'> $sentby </td>";
		echo "<td class='even' align='center'> $created </td>";
		echo "<td class='even' align='center'> $modify $delete </td>";
		echo "</tr>";
		}
	}
else // that is, $numrows = 0, therez no columns yet
	{
	echo "<tr>";
	echo "<td class='head' align='center' colspan='".$colspan."'>".constant("_AM_{$MYDIRNAME}_NOFUTUREENTRY")."</td>";
	echo "</tr>";
	}
echo "</table>";
$pagenav = new XoopsPageNav( $numrows, $xoopsModuleConfig['perpage'], $startsub, 'startsub', 'entryID =' . $entryID );
echo "<div style='text-align:right;'>" . $pagenav -> renderNav() . "</div>";
echo "</fieldset>";
echo "<br />";

/* -- Code to show hidden entries -- */
echo "<fieldset style='margin:1em 0em 0em 0em;border:1px solid #778;'><legend style='font-weight: bold; color: #900;'>" . constant("_AM_{$MYDIRNAME}_HIDDENENTRY") . "</legend><br />";

echo "<table width='100%' cellspacing='1' cellpadding='3' border='0' class='outer'>";
echo "<tr>";
echo "<td width='40' class='bg3' align='center'><b>" . constant("_AM_{$MYDIRNAME}_ENTRYID") . "</b></td>";
if ($xoopsModuleConfig['multicats'] == 1)
	{
	echo "<td width='20%' class='bg3' align='center'><b>" . constant("_AM_{$MYDIRNAME}_ENTRYCATNAME") . "</b></td>";
	$colspan = 6;
	}
else
	{
	$colspan = 5;
	}
echo "<td class='bg3' align='center'><b>" . constant("_AM_{$MYDIRNAME}_ENTRYTERM") . "</b></td>";
echo "<td width='90' class='bg3' align='center'><b>" . constant("_AM_{$MYDIRNAME}_SUBMITTER") . "</b></td>";
echo "<td width='90' class='bg3' align='center'><b>" . constant("_AM_{$MYDIRNAME}_ENTRYCREATED") . "</b></td>";
echo "<td width='60' class='bg3' align='center'><b>" . constant("_AM_{$MYDIRNAME}_ACTION") . "</b></td>";
echo "</tr>";

$resultS1 = $xoopsDB -> query("SELECT COUNT(*) FROM $ent_table WHERE offline = '1'");
list( $numrows ) = $xoopsDB -> fetchRow( $resultS1 );

if ( $numrows > 0 ) // That is, if there ARE submitted entries in the system
	{
	$sql = "SELECT e.entryID, e.categoryID, e.term, e.uid, e.datesub, c.name FROM $ent_table e LEFT JOIN $cat_table c ON e.categoryID = c.categoryID WHERE offline = '1' ORDER BY datesub DESC";
	$resultS2 = $xoopsDB -> query( $sql, $xoopsModuleConfig['perpage'], $startsub );

	while ( list( $entryID, $categoryID, $term, $uid, $created, $name ) = $xoopsDB -> fetchrow( $resultS2 ) )
		{
		$sentby = xoops_getLinkedUnameFromId(intval($uid));
		$entryID = intval($entryID);
		$categoryID = intval($categoryID);
		$catname = $myts -> htmlSpecialChars( $name );
		$term = $myts -> htmlSpecialChars( $term );
		$created = formatTimestamp( $created, 's' );
		$modify = "<a href='" . XOOPS_URL . "/modules/" . $xoopsModule->dirname() . "/admin/entry.php?op=mod&amp;entryID=" . $entryID . "'><img src='" . XOOPS_URL . "/modules/" . $xoopsModule->dirname() . "/images/icon/edit.gif' border='0' width='20' height='20' alt='".constant("_AM_{$MYDIRNAME}_EDITSUBM")."' /></a>";
		$delete = "<a href='" . XOOPS_URL . "/modules/" . $xoopsModule->dirname() . "/admin/entry.php?op=del&amp;entryID=" . $entryID . "'><img src='" . XOOPS_URL . "/modules/" . $xoopsModule->dirname() . "/images/icon/delete.gif' border='0' width='20' height='20' alt='".constant("_AM_{$MYDIRNAME}_DELETESUBM")."' /></a>";
		echo "<tr>";
		echo "<td class='head' align='center'> $entryID </td>";
		if ($xoopsModuleConfig['multicats'] == 1)
			{
			echo "<td class='even' align='left'> $catname </td>";
			}
		echo "<td class='even' align='left'> $term </td>";
		echo "<td class='even' align='center'> $sentby </td>";
		echo "<td class='even' align='center'> $created </td>";
		echo "<td class='even' align='center'> $modify $delete </td>";
		echo "</tr>";
		}
	}
else // that is, $numrows = 0, therez no columns yet
	{
	echo "<tr>";
	echo "<td class='head' align='center' colspan='".$colspan."'>".constant("_AM_{$MYDIRNAME}_NOHIDDENENTRY")."</td>";
	echo "</tr>";
	}
echo "</table>";
$pagenav = new XoopsPageNav( $numrows, $xoopsModuleConfig['perpage'], $startsub, 'startsub', 'entryID =' . $entryID );
echo "<div style='text-align:right;'>" . $pagenav -> renderNav() . "</div>";
echo "</fieldset>";
echo "<br />";

xoops_cp_footer();
?>