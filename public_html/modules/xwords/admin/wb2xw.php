<?php
// XOOPS2 - Xwords 0.42
// WEBMASTER @ KANPYO.NET, 2005.

include( "./admin_header.php" );

$op = !empty( $_POST['op'] ) ? trim( $_POST['op'] ) : 'default';

if ($op == 'convert')
	{
	$sql1 = $xoopsDB -> query( "SELECT MAX(categoryID) categoryID FROM $cat_table" );
	$result1 = $xoopsDB -> getRowsNum( $sql1 );
	if ($result1)
		{
		while ($myrow1 = $xoopsDB->fetchArray($sql1))
			{
			$maxcategoryID = intval($myrow1['categoryID']);
			}
		}

	$sql2 = $xoopsDB -> query("SELECT * FROM ".$xoopsDB->prefix("wbcategories")." WHERE categoryID > '$maxcategoryID' ORDER BY categoryID LIMIT 100");

	$result2 = $xoopsDB -> getRowsNum( $sql2 );
	if ($result2)
		{
		while ($row1 = $xoopsDB->fetchArray( $sql2 ))
			{
			$categoryID  = intval($row1['categoryID']);
			$name        = $myts -> addSlashes($row1['name']);
			$description = $myts -> addSlashes($row1['description']);
			$total       = intval($row1['total']);
			$weight      = intval($row1['weight']);

			$ret = $xoopsDB->queryF("INSERT INTO $cat_table (categoryID, name, description, total, weight) VALUES ('$categoryID', '$name', '$description', '$total', '$weight')");

			}
		}

	$sql3 = $xoopsDB -> query( "SELECT MAX(entryID) entryID FROM $ent_table" );
	$result3 = $xoopsDB -> getRowsNum( $sql3 );
	if ($result3)
		{
		while ($myrow2 = $xoopsDB->fetchArray( $sql3 ))
			{
			$maxentryID = intval($myrow2['entryID']);
			}
		}

	$sql4 = $xoopsDB -> query("SELECT * FROM ".$xoopsDB->prefix("wbentries")." WHERE entryID > '$maxentryID' ORDER BY entryID LIMIT 100");

	$result4 = $xoopsDB -> getRowsNum( $sql4 );
	if ($result4)
		{
		while ($row2 = $xoopsDB->fetchArray( $sql4 ))
			{
			$entryID     = intval($row2['entryID']);
			$categoryID  = intval($row2['categoryID']);
			$term        = $myts -> addSlashes($row2['term']);
			$proc        = "";
			$init        = $myts -> addSlashes($row2['init']);
			$definition  = $myts -> addSlashes($row2['definition']);
			$ref         = $myts -> addSlashes($row2['ref']);
			$url         = $myts -> addSlashes($row2['url']);
			$uid         = intval($row2['uid']);
			$submit      = intval($row2['submit']);
			$datesub     = intval($row2['datesub']);
			$counter     = intval($row2['counter']);
			$html        = intval($row2['html']);
			$smiley      = intval($row2['smiley']);
			$xcodes      = intval($row2['xcodes']);
			$breaks      = intval($row2['breaks']);
			$block       = intval($row2['block']);
			$offline     = intval($row2['offline']);
			$notifypub   = intval($row2['notifypub']);
			$request     = intval($row2['request']);

			$ret = $xoopsDB->queryF("INSERT INTO $ent_table (entryID, categoryID, term, proc, init, definition, ref, url, uid, submit, datesub, counter, html, smiley, xcodes, breaks, block, offline, notifypub, request) VALUES ('$entryID', '$categoryID', '$term', '$proc', '$init', '$definition', '$ref', '$url', '$uid', '$submit', '$datesub', '$counter', '$html', '$smiley', '$xcodes', '$breaks', '$block', '$offline', '$notifypub', '$request' )");

			}
		}

	redirect_header('wb2xw.php',5,constant("_AM_{$MYDIRNAME}_CATMODIFIED"));
	exit();

	}


if ($op == 'default')
	{
	$sql5 = $xoopsDB -> query( "SELECT * FROM $cat_table" );
	$result5 = $xoopsDB -> getRowsNum( $sql5 );

	$sql6 = $xoopsDB -> query( "SELECT * FROM " . $xoopsDB -> prefix("wbcategories") );
	$result6 = $xoopsDB -> getRowsNum( $sql6 );

	$sql7 = $xoopsDB -> query( "SELECT * FROM $ent_table" );
	$result7 = $xoopsDB -> getRowsNum( $sql7 );

	$sql8 = $xoopsDB -> query( "SELECT * FROM " . $xoopsDB -> prefix("wbentries") );
	$result8 = $xoopsDB -> getRowsNum( $sql8 );

	if ( $result5 != $result6 || $result7 != $result8 )
		{
		xoops_cp_header();
		xoops_confirm(array('op' => 'convert'), 'wb2xw.php', intval((($result5 + $result7)/($result6 + $result8))*100) . '% data copy Wordbook -> Xwords ... continue?');
		xoops_cp_footer();
		}
	else
		{
		xoops_cp_header();
		xoops_error('data copy Wordbook -> Xwords ... Finish!');
		xoops_cp_footer();
		}

	exit();
	}

?>