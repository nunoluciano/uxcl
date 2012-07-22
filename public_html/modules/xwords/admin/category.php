<?php
/**
 * $Id: category.php v 1.0 8 May 2004 hsalazar Exp $
 * Module: Wordbook - a multicategory glossary
 * Version: v 1.00
 * Release Date: 8 May 2004
 * Author: hsalazar
 * Licence: GNU
 */
// XOOPS2 - Xwords 0.43
// WEBMASTER @ KANPYO.NET, 2005.

include( "./admin_header.php" );

if ($xoopsModuleConfig['multicats'] != 1)
	{
	redirect_header( "index.php", 1, sprintf( constant("_AM_{$MYDIRNAME}_SINGLECAT"), '' ) );
	}

include_once( XOOPS_ROOT_PATH . '/modules/'.$xoopsModule->dirname().'/include/gtickets.php' );

function categoryEdit( $categoryID = '' )
	{
	global $mydirname,$MYDIRNAME,$cat_table,$ent_table,$xoopsConfig,$xoopsGTicket; 
	$xoopsDB =& Database::getInstance();
	$xoopsModule = XoopsModule::getByDirname("$mydirname");
	$myts =& MyTextSanitizer::getInstance();

	$categoryID = !empty( $_GET['categoryID'] ) ? intval($_GET['categoryID']) : '';
	// If there is a parameter, and the id exists, retrieve data: were editing a column
	if ( $categoryID > 0 )
		{
		$result = $xoopsDB -> query( "SELECT categoryID, name, description, total, weight FROM $cat_table WHERE categoryID = '$categoryID'" );
		if ( $xoopsDB -> getRowsNum( $result ) == 0 )
			{
			redirect_header( "index.php", 1, constant("_AM_{$MYDIRNAME}_NOTUPDATED") );
			}

		list( $categoryID, $name, $description, $total, $weight ) = $xoopsDB -> fetchrow( $result );

		$categoryID = intval($categoryID);
		$name = $myts -> htmlSpecialChars( $name );
		$description = $myts -> htmlSpecialChars( $description );
		$total = intval($total);
		$weight = intval($weight);

		xoops_cp_header();
		adminMenu(1, constant("_AM_{$MYDIRNAME}_CATS")."&nbsp;&raquo;&nbsp;".constant("_AM_{$MYDIRNAME}_MODIFY"));
		include('./mymenu.php');
		echo "<fieldset style='margin:1em 0em 0em 0em;border:1px solid #778;'><legend style='font-weight: bold; color: #900;'>" . constant("_AM_{$MYDIRNAME}_CATS") . "</legend><br />\n";
		$sform = new XoopsThemeForm( constant("_AM_{$MYDIRNAME}_MODCAT") . ": $name" , "op", xoops_getenv( 'PHP_SELF' ) );
		}
	else
		{
		$weight = 1;
		$name = $description = '';

		xoops_cp_header();
		adminMenu(1, constant("_AM_{$MYDIRNAME}_CATS")."&nbsp;&raquo;&nbsp;".constant("_AM_{$MYDIRNAME}_CREATE"));
		include('./mymenu.php');
		echo "<fieldset style='margin:1em 0em 0em 0em;border:1px solid #778;'><legend style='font-weight: bold; color: #900;'>" . constant("_AM_{$MYDIRNAME}_CATS") . "</legend><br />\n";
		$sform = new XoopsThemeForm( constant("_AM_{$MYDIRNAME}_NEWCAT"), "op", xoops_getenv( 'PHP_SELF' ) );
		}

	$sform -> setExtra( 'enctype="multipart/form-data"' );
	$sform -> addElement( new XoopsFormText( constant("_AM_{$MYDIRNAME}_CATNAME"), 'name', 50, 80, $name ), true );
	$sform -> addElement( new XoopsFormDhtmlTextArea( constant("_AM_{$MYDIRNAME}_CATDESCRIPT"), 'description', $description, 7, 60 ) );
//	$sform -> addElement( new XoopsFormTextArea( constant("_AM_{$MYDIRNAME}_CATDESCRIPT"), 'description', $description, 7, 60 ) );
	$sform -> addElement( new XoopsFormText( constant("_AM_{$MYDIRNAME}_CATPOSIT"), 'weight', 4, 4, $weight ), true );
	$sform -> addElement( new XoopsFormHidden( 'categoryID', $categoryID ) );

	$button_tray = new XoopsFormElementTray( '', '' );
	$hidden = new XoopsFormHidden( 'op', 'addcat' );
	$button_tray -> addElement( $hidden );

	// No ID for column -- then itz new column, button says 'Create'
	if ( !$categoryID )
		{
		$butt_create = new XoopsFormButton( '', '', constant("_AM_{$MYDIRNAME}_CREATE"), 'submit' );
		$butt_create->setExtra('onclick="this.form.elements.op.value=\'addcat\'"');
		$button_tray->addElement( $butt_create );

		$butt_clear = new XoopsFormButton( '', '', constant("_AM_{$MYDIRNAME}_CLEAR"), 'reset' );
		$button_tray->addElement( $butt_clear );

		$butt_cancel = new XoopsFormButton( '', '', constant("_AM_{$MYDIRNAME}_CANCEL"), 'button' );
		$butt_cancel->setExtra('onclick="history.go(-1)"');
		$button_tray->addElement( $butt_cancel );
		}
	else // button says 'Update'
		{
		$butt_create = new XoopsFormButton( '', '', constant("_AM_{$MYDIRNAME}_MODIFY"), 'submit' );
		$butt_create->setExtra('onclick="this.form.elements.op.value=\'addcat\'"');
		$button_tray->addElement( $butt_create );

		$butt_cancel = new XoopsFormButton( '', '', constant("_AM_{$MYDIRNAME}_CANCEL"), 'button' );
		$butt_cancel->setExtra('onclick="history.go(-1)"');
		$button_tray->addElement( $butt_cancel );
		}

	$button_tray->addElement( $xoopsGTicket->getTicketXoopsForm( __LINE__ ) );//GIJ
	$sform -> addElement( $button_tray );
	$sform -> display();
	unset( $hidden );
	echo "</fieldset>\n";
	xoops_cp_footer();
	}


function categoryDelete($categoryID = '') 
	{
	global $cat_table,$ent_table,$xoopsConfig,$xoopsModuleConfig,$xoopsModule,$xoopsGTicket,$MYDIRNAME;
	$xoopsDB =& Database::getInstance();
	$myts =& MyTextSanitizer::getInstance();

	$result = $xoopsDB -> query( "SELECT categoryID, name FROM $cat_table WHERE categoryID = '$categoryID'" );

	if ( !$xoopsDB -> getRowsNum( $result ) )
		{
		redirect_header( "index.php", 2, constant("_AM_{$MYDIRNAME}_NOCAT") );
		}

	list( $categoryID, $name ) = $xoopsDB -> fetchrow( $result );

	xoops_cp_header();
	adminMenu(0, constant("_AM_{$MYDIRNAME}_CATS")."&nbsp;&raquo;&nbsp;".constant("_AM_{$MYDIRNAME}_DELETE"));
	include('./mymenu.php');
	echo "<br />\n";

	$name = $myts -> htmlSpecialChars($name);
	xoops_confirm(array('op' => 'delcat', 'categoryID' => $categoryID, 'ok' => 1, 'name' => $name ) + $xoopsGTicket->getTicketArray( __LINE__ ), 'category.php', constant("_AM_{$MYDIRNAME}_DELETETHISCAT") . "<br /><br />" . $name, constant("_AM_{$MYDIRNAME}_DELETE") );
	xoops_cp_footer();
	}


function categoryDeletego($categoryID = '') 
	{
	global $cat_table,$ent_table,$xoopsConfig,$xoopsModuleConfig,$xoopsModule,$xoopsGTicket,$MYDIRNAME;

	// Ticket check
	if ( ! $xoopsGTicket->check() ) {
		redirect_header(XOOPS_URL.'/',3,$xoopsGTicket->getErrors());
	}

	$xoopsDB =& Database::getInstance();
	$myts =& MyTextSanitizer::getInstance();

	$ok = !empty($_POST['ok']) ? intval($_POST['ok']) : 0;
	$name = !empty($_POST['name']) ? $myts -> htmlSpecialChars($_POST['name']) : "";
	// confirmed, so delete 
	if ( $ok != 1 && $categoryID < 0 ) 
		{
		redirect_header( "index.php", 2, constant("_AM_{$MYDIRNAME}_NOTUPDATED") );
		}

	$resultA2 = $xoopsDB -> query( "SELECT entryID FROM $ent_table WHERE categoryID = '$categoryID'" );
	if ( $xoopsDB -> getRowsNum( $resultA2 ) )
		{
		while ( list( $entryID ) = $xoopsDB -> fetchrow( $resultA2 ) )
			{
			xoops_comment_delete($xoopsModule->getVar('mid'), $entryID);
			}
		$xoopsDB -> query( "DELETE FROM $ent_table WHERE categoryID = '$categoryID'");
		}

	if ( !$xoopsDB -> queryF( "DELETE FROM $cat_table WHERE categoryID = '$categoryID'") )
		{
		redirect_header( "index.php", 2, constant("_AM_{$MYDIRNAME}_NOTUPDATED") );
		}
	else
		{
		redirect_header("index.php",1,sprintf( constant("_AM_{$MYDIRNAME}_CATISDELETED"), $name ) );
		}
	}


function categorySave ($categoryID = '')
	{
	global $cat_table,$ent_table,$xoopsGTicket,$MYDIRNAME; 

	// Ticket check
	if ( ! $xoopsGTicket->check() ) {
		redirect_header(XOOPS_URL.'/',3,$xoopsGTicket->getErrors());
	}

	$xoopsDB =& Database::getInstance();
	$myts =& MyTextSanitizer::getInstance();

	$weight = !empty($_POST['weight'] ) ? intval($_POST['weight']) : 0;
	$name = !empty($_POST['name'] ) ? $myts->addSlashes($_POST['name']) : '';
	$description = !empty($_POST['description'] ) ? $myts->addSlashes($_POST['description']) : '';

	// Run the query and update the data
	if ( $categoryID > 0 )
		{
		if ( $xoopsDB -> queryF( "UPDATE $cat_table SET name = '$name', description = '$description', weight = '$weight' WHERE categoryID = '$categoryID'" ) )
			{
			redirect_header( "index.php", 1, constant("_AM_{$MYDIRNAME}_CATMODIFIED") );
			}
		else
			{
			redirect_header( "index.php", 1, constant("_AM_{$MYDIRNAME}_NOTUPDATED") );
			}
		}
	else
		{
		if ( $xoopsDB -> query( "INSERT INTO $cat_table (categoryID, name, description, weight) VALUES ('', '$name', '$description', '$weight')" ) )
			{
			redirect_header( "index.php", 1, constant("_AM_{$MYDIRNAME}_CATCREATED") );
			}
		else
			{
			redirect_header( "index.php", 1, constant("_AM_{$MYDIRNAME}_NOTUPDATED") );
			}
		}
	}

$op = 'default';
$categoryID = '';
if ( !empty( $_GET['op'] ) ) $op = trim($_GET['op']);
if ( !empty( $_POST['op'] ) ) $op = trim($_POST['op']);
if ( !empty( $_GET['categoryID'] ) ) $categoryID = intval($_GET['categoryID']);
if ( !empty( $_POST['categoryID'] ) ) $categoryID = intval($_POST['categoryID']);

switch ( $op )
	{
	case "mod":
	categoryEdit( $categoryID );
	break;

	case "addcat":
	categorySave( $categoryID );
	break;

	case "del":
	categoryDelete( $categoryID );
	break;

	case "delcat":
	categoryDeletego( $categoryID );
	break;

	case "cancel":
	redirect_header( "index.php", 1, sprintf( constant("_AM_{$MYDIRNAME}_BACK2IDX"), '' ) );
	break;

	case "default":
	default:
	categoryEdit();
	break;
	}
exit();
?>