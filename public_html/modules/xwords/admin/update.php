<?php
// XOOPS2 - Xwords 0.42
// WEBMASTER @ KANPYO.NET, 2005.

include( "./admin_header.php" );

$op = !empty( $_POST['op'] ) ? trim( $_POST['op'] ) : 'default';

if ($op == 'default')
	{
	$result1 = $xoopsDB -> query( "SELECT * FROM $ent_table WHERE length(init) > '2' AND request = '0'");
	$total1 = $xoopsDB -> getRowsNum( $result1 );
	if ($total1)
		{
		$result2 = $xoopsDB -> query( "SELECT * FROM $ent_table WHERE length(init) <= '2' AND request = '0'");
		$total2 = $xoopsDB -> getRowsNum( $result2 );
		if ($total2)
			{
			xoops_cp_header();
			xoops_confirm(array('op' => 'update'), 'update.php', intval(($total1/($total1 + $total2))*100) . '%UPDATE... continue?');
			xoops_cp_footer();
			exit();
			}
		else
			{
			xoops_cp_header();
			xoops_error('100%UPDATE... Finish!');
			xoops_cp_footer();
			exit();
			}
		}
	else
		{
		$result3 = $xoopsDB -> queryF( "ALTER TABLE $ent_table MODIFY init VARCHAR( 10 ) DEFAULT '0' NOT NULL");
		if (!$result3)
			{
			xoops_cp_header();
			xoops_error('ERROR... ALTER TABLE');
			xoops_cp_footer();
			exit();
			}
		else
			{
			$result4 = $xoopsDB -> query( "SELECT * FROM $ent_table WHERE length(init) <= '2'");
			$total4 = $xoopsDB -> getRowsNum( $result4 );
			if ($total4)
				{
				xoops_cp_header();
				xoops_confirm(array('op' => 'update'), 'update.php', "UPDATE Start!");
				xoops_cp_footer();
				exit();
				}
			}
		}
	}

if ($_POST['op'] == 'update')
	{
	$result4 = $xoopsDB -> query( "SELECT entryID, term, proc FROM $ent_table WHERE length(init) <= '2' AND request = '0' LIMIT 100");
	if ($result4)
		{
		while (list( $entryID , $term, $proc ) = $xoopsDB->fetchRow($result4))
			{
			if (ereg(",",$proc))
				{
				list($temp,$proc) = explode(",",$proc);
				}
			$init = getInitial($term,$proc) ;
			$proc = $myts -> addSlashes(getJsortCode($proc));
			$result5 = $xoopsDB->query("UPDATE $ent_table SET init='".$init."', proc='".$proc."' WHERE entryID = '".intval($entryID))."'";
			if (!$result5)
				{
				xoops_cp_header();
				xoops_error("ERROR entryID $entryID");
				xoops_cp_footer();
				exit();
				}
			}
		redirect_header('update.php',1,constant("_AM_{$MYDIRNAME}_CATMODIFIED"));
		exit();
		}
	else
		{
		xoops_cp_header();
		xoops_error('ERROR... ALTER TABLE?');
		xoops_cp_footer();
		exit();
		}
	}
?>