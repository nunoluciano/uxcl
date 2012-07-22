<?php
/**
 * $Id: submissions.php v 1.0 8 May 2004 hsalazar Exp $
 * Module: Wordbook
 * Version: v 1.00
 * Release Date: 8 May 2004
 * Author: hsalazar
 * Licence: GNU
 */
// XOOPS2 - Xwords 0.44
// WEBMASTER @ KANPYO.NET, 2006.

include( "./admin_header.php" );

$op = 'default';
if ( !empty( $_GET['op'] ) ) $op = trim($_GET['op']);
if ( !empty( $_POST['op'] ) ) $op = trim($_POST['op']);
$entryID = !empty( $_POST['entryID'] ) ? intval($_POST['entryID']) : '';

$spaw_root = $spaw_dir = '';
if (file_exists(XOOPS_ROOT_PATH.'/common/spaw/spaw_control.class.php'))
	{
	$spaw_root = XOOPS_ROOT_PATH.'/common/spaw/';
	$spaw_dir = preg_replace('|^'.XOOPS_ROOT_PATH.'|', XOOPS_URL , $spaw_root);
	}

include_once( XOOPS_ROOT_PATH . '/modules/'.$xoopsModule->dirname().'/include/gtickets.php' );

// -- Edit function -- //
function editentry( $entryID = '' )
	{
	global $xoopsUser,$xoopsConfig,$xoopsModuleConfig,$xoopsModule,$cat_table,$ent_table,$xoopsGTicket,$spaw_root,$MYDIRNAME; 
	$xoopsDB =& Database::getInstance();
	$myts =& MyTextSanitizer::getInstance();

	$op = 'default';
	if ( !empty( $_GET['op'] ) ) $op = trim($_GET['op']);
	if ( !empty( $_POST['op'] ) ) $op = trim($_POST['op']);
	$entryID = !empty( $_GET['entryID'] ) ? intval($_GET['entryID']) : '';
	//Initialize all variables before we start
	$block = $html = $smiley = $xcodes = $breaks = $offline = $submit = $categoryID = 0;
	$term = $proc = $definition = $ref = $url = '';

	// Since this is a submission, the id exists, so retrieve data: were editing an entry
	$result = $xoopsDB -> query( "SELECT categoryID, term, proc, definition, ref, url, uid, submit, datesub, html, smiley, xcodes, breaks, block, offline, notifypub, request FROM $ent_table WHERE entryID = '$entryID' AND ( submit = '1' OR request = '1' )" );

	if ( $xoopsDB -> getRowsNum( $result ) == 0 )
		{
		redirect_header( "submissions.php", 1, constant("_AM_{$MYDIRNAME}_NOTUPDATED") );
		}

	list( $categoryID, $term, $proc, $definition, $ref, $url, $uid, $submit, $datesub, $html, $smiley, $xcodes, $breaks, $block, $offline, $notifypub, $request ) = $xoopsDB -> fetchrow( $result );

	$query = $xoopsDB -> query ( "SELECT name FROM $cat_table WHERE categoryID = '$categoryID' ");
	list($name) = $xoopsDB->fetchRow($query);

	$term = isset( $term ) ? $myts -> htmlspecialchars($term) : '';
	if ($proc)
		{
		list($temp,$proc) = explode(",",$proc);
		}
	$proc = isset( $proc ) ? $myts -> htmlSpecialChars($proc) : '';
//	$definition = isset( $definition ) ? $myts -> htmlSpecialChars($definition) : '';
	$ref = isset( $ref ) ? $myts -> htmlSpecialChars($ref) : '';
	$url = isset( $url ) ? $myts -> htmlSpecialChars($url) : '';

	xoops_cp_header();
	adminMenu(3, constant("_AM_{$MYDIRNAME}_AUTHORIZE")."&nbsp;&raquo;&nbsp;".$term);
	include('./mymenu.php');
	$sform = new XoopsThemeForm( constant("_AM_{$MYDIRNAME}_AUTHENTRY") . ": $term" , "op", xoops_getenv( 'PHP_SELF' ) );

	$sform -> setExtra( 'enctype="multipart/form-data"' );

	// Author selector
	ob_start();
	if (!$uid)
		{
		$uid = $xoopsUser -> getVar ("uid");
		}
	echo	xoops_getLinkedUnameFromId( intval($uid) );
	$sform -> addElement( new XoopsFormLabel( constant("_AM_{$MYDIRNAME}_AUTHOR"), ob_get_contents() ) );
	ob_end_clean();

	if ($xoopsModuleConfig['multicats'] == 1)
		{
		$mytree = new XoopsTree( $cat_table, "categoryID" , "0" );

		ob_start();
		$sform -> addElement( new XoopsFormHidden( 'categoryID', $categoryID ) );
		$mytree -> makeMySelBox( "name", "weight", $categoryID );
		$sform -> addElement( new XoopsFormLabel( constant("_AM_{$MYDIRNAME}_CATNAME"), ob_get_contents() ) );
		ob_end_clean();
		}

	$sform -> addElement( new XoopsFormText( constant("_AM_{$MYDIRNAME}_ENTRYTERM"), 'term', 50, 80, $term), true );
	$sform -> addElement( new XoopsFormText( constant("_AM_{$MYDIRNAME}_ENTRYPROC"), 'proc', 50, 80, $proc), true );
//	$sform -> addElement( new XoopsFormDhtmlTextArea( constant("_AM_{$MYDIRNAME}_ENTRYDEF"), 'definition', $definition, 15, 60 ) );
	if( !empty( $_GET['usespaw'] ) && $spaw_root )
		{
		// SPAW Config
		include_once $spaw_root."spaw_control.class.php";
		ob_start() ;
		$sw = new SPAW_Wysiwyg( 'definition', $definition, _LANGCODE, 'full', 'default', '100%', '400px' );
		$def_block = new XoopsFormLabel( constant("_AM_{$MYDIRNAME}_ENTRYDEF")."[<a href=\"".xoops_getenv( 'PHP_SELF')."?op=$op&amp;entryID=$entryID\" title=\"".constant("_AM_{$MYDIRNAME}_BB")."\">".constant("_AM_{$MYDIRNAME}_SPAWTOBB")."</a>]" , $sw->getHtml() ) ;
		ob_end_clean() ;
		}
	elseif( $spaw_root )
		{
		$def_block = new XoopsFormDhtmlTextArea( constant("_AM_{$MYDIRNAME}_ENTRYDEF")."[<a href=\"".xoops_getenv( 'PHP_SELF')."?op=$op&amp;entryID=$entryID&amp;usespaw=1\" title=\"".constant("_AM_{$MYDIRNAME}_SPAW")."\">".constant("_AM_{$MYDIRNAME}_BBTOSPAW")."</a>]", 'definition', $myts -> htmlSpecialChars($definition), 15, 60 );
		}
	else
		{
		$def_block = new XoopsFormDhtmlTextArea( constant("_AM_{$MYDIRNAME}_ENTRYDEF"), 'definition', $myts -> htmlSpecialChars($definition), 15, 60 );
		}
	$sform -> addElement ( $def_block );
	$sform -> addElement( new XoopsFormTextArea( constant("_AM_{$MYDIRNAME}_ENTRYREFERENCE"), 'ref', $ref, 5, 60 ), false );
	$sform -> addElement( new XoopsFormText( constant("_AM_{$MYDIRNAME}_ENTRYURL"), 'url', 50, 80, $url ), false );

	$options_tray = new XoopsFormElementTray(constant("_AM_{$MYDIRNAME}_OPTIONS"),'<br />');

	$html_checkbox = new XoopsFormCheckBox( '', 'html', intval($html) );
	$html_checkbox -> addOption( 1, constant("_AM_{$MYDIRNAME}_DOHTML") );
	$options_tray -> addElement( $html_checkbox );

	$smiley_checkbox = new XoopsFormCheckBox( '', 'smiley', intval($smiley) );
	$smiley_checkbox -> addOption( 1, constant("_AM_{$MYDIRNAME}_DOSMILEY") );
	$options_tray -> addElement( $smiley_checkbox );

	$xcodes_checkbox = new XoopsFormCheckBox( '', 'xcodes', intval($xcodes) );
	$xcodes_checkbox -> addOption( 1, constant("_AM_{$MYDIRNAME}_DOXCODE") );
	$options_tray -> addElement( $xcodes_checkbox );

	$breaks_checkbox = new XoopsFormCheckBox( '', 'breaks', intval($breaks) );
	$breaks_checkbox -> addOption( 1, constant("_AM_{$MYDIRNAME}_BREAKS") );
	$options_tray -> addElement( $breaks_checkbox );

	$sform -> addElement( $options_tray );

	$button_tray = new XoopsFormElementTray( '', '' );
	$hidden = new XoopsFormHidden( 'op', 'authentry' );
	$button_tray -> addElement( $hidden );

	$hidden_id = new XoopsFormHidden( 'entryID', intval($entryID) );
	$button_tray -> addElement( $hidden_id );

	$hidden_uid = new XoopsFormHidden( 'uid', intval($uid) );
	$button_tray -> addElement( $hidden_uid );

	$hidden_block = new XoopsFormHidden( 'block', intval($block) );
	$button_tray -> addElement( $hidden_block );

	//PREVIEW(ver0.31)
	$butt_preview = new XoopsFormButton( '', '', constant("_AM_{$MYDIRNAME}_PREVIEWOPEN"), 'button' );
	$butt_preview->setExtra('onclick="document.op.action=\'../preview.php\';document.op.target=\'_blank\';document.op.submit();"');
	$button_tray->addElement( $butt_preview );

	$butt_save = new XoopsFormButton( '', '', constant("_AM_{$MYDIRNAME}_AUTHORIZE"), 'submit' );
//	$butt_save->setExtra('onclick="this.form.elements.op.value=\'authentry\'"');
	$butt_save->setExtra('onclick="document.op.action=\'./submissions.php\';document.op.target=\'_self\';this.form.elements.op.value=\'authentry\'"');
	$button_tray->addElement( $butt_save );

	$butt_cancel = new XoopsFormButton( '', '', constant("_AM_{$MYDIRNAME}_CANCEL"), 'button' );
	$butt_cancel->setExtra('onclick="history.go(-1)"');
	$button_tray->addElement( $butt_cancel );

	$button_tray->addElement( $xoopsGTicket->getTicketXoopsForm( __LINE__ ) );//GIJ
	$sform -> addElement( $button_tray );
	$sform -> display();
	unset( $hidden );
	xoops_cp_footer();
	}


function entryDelete($entryID = '') 
	{
	global $cat_table,$ent_table,$xoopsConfig,$xoopsModuleConfig,$xoopsModule,$xoopsGTicket,$MYDIRNAME; 
	$xoopsDB =& Database::getInstance();
	$myts =& MyTextSanitizer::getInstance();

	$entryID = !empty( $_GET['entryID'] ) ? intval($_GET['entryID']) : '';
	$result = $xoopsDB -> query( "SELECT entryID, term FROM $ent_table WHERE entryID = '$entryID'" );

	if ( !$xoopsDB -> getRowsNum( $result ) )
		{
		redirect_header( "submissions.php", 2, constant("_AM_{$MYDIRNAME}_NOENTRY") );
		exit();
		}

	list( $entryID, $term ) = $xoopsDB -> fetchrow( $result );

	xoops_cp_header();
	adminMenu(0, constant("_AM_{$MYDIRNAME}_AUTHORIZE")."&nbsp;&raquo;&nbsp;".constant("_AM_{$MYDIRNAME}_DELETE"));
	include('./mymenu.php');
	echo "<br />";

	$term = $myts -> htmlSpecialChars($term);
	xoops_confirm( array( 'op' => 'delentry', 'entryID' => $entryID, 'confirm' => 1, 'term' => $term ) + $xoopsGTicket->getTicketArray( __LINE__ ), 'submissions.php', constant("_AM_{$MYDIRNAME}_DELETETHISENTRY") . "<br /><br />" . $term, constant("_AM_{$MYDIRNAME}_DELETE") );
	xoops_cp_footer();
	}


function entryDeletego($entryID = '') 
	{
	global $cat_table,$ent_table,$xoopsConfig,$xoopsModuleConfig,$xoopsModule,$xoopsGTicket,$MYDIRNAME; 

	// Ticket check
	if ( ! $xoopsGTicket->check() ) {
		redirect_header(XOOPS_URL.'/',3,$xoopsGTicket->getErrors());
	}

	$xoopsDB =& Database::getInstance();
	$myts =& MyTextSanitizer::getInstance();

	$confirm = !empty($_POST['confirm']) ? intval($_POST['confirm']) : 0;
	$term = !empty($_POST['term']) ? $myts -> htmlSpecialChars($_POST['term']) : "";

	if ( $confirm != 1 || $entryID < 0 )
		{
		redirect_header( "submissions.php", 2, constant("_AM_{$MYDIRNAME}_NOENTRY") );
		exit();
		}

	if ( $xoopsDB -> query( "DELETE FROM $ent_table WHERE entryID = $entryID" ) )
		{
		// delete comments
		xoops_comment_delete($xoopsModule->getVar('mid'), $entryID);
		redirect_header( "submissions.php", 1, sprintf( constant("_AM_{$MYDIRNAME}_ENTRYISDELETED"), $term ) );
		}
	else
		{
		redirect_header( "index.php", 2, constant("_AM_{$MYDIRNAME}_NOTUPDATED") );
		}
	}


function entrySave($entryID = '')
	{
	global $cat_table,$ent_table,$xoopsGTicket,$MYDIRNAME; 

	// Ticket check
	if ( ! $xoopsGTicket->check() ) {
		redirect_header(XOOPS_URL.'/',3,$xoopsGTicket->getErrors());
	}

	$xoopsDB =& Database::getInstance();
	$myts =& MyTextSanitizer::getInstance();


	$entryID = !empty($_POST['entryID']) ? intval($_POST['entryID']) : 0;
	$categoryID = !empty($_POST['categoryID']) ? intval($_POST['categoryID']) : 0;
	$block = !empty($_POST['block']) ? intval($_POST['block']) : 0;
	$offline = !empty($_POST['offline']) ? intval($_POST['offline']) : 0;
	$breaks = !empty($_POST['breaks']) ? intval($_POST['breaks']) : 0;
	$html = !empty($_POST['html']) ? intval($_POST['html']) : 0;
	$smiley = !empty($_POST['smiley']) ? intval($_POST['smiley']) : 0;
	$xcodes = !empty($_POST['xcodes']) ? intval($_POST['xcodes']) : 0;
	$uid = !empty($_POST['uid']) ? intval($_POST['uid']) : 1;

//	$init = $myts -> addSlashes(getInitial($_POST['term'],$_POST['proc']));
	$term = !empty($_POST['term']) ? $myts -> addSlashes($_POST['term']) : '';
	$proc = !empty($_POST['proc']) ? $myts -> addSlashes($_POST['proc']) : '';
	$init = getInitial($term,$proc);

	$definition = !empty($_POST['definition']) ? $myts -> addSlashes($_POST['definition']) : '';
	$ref = !empty($_POST['ref']) ? $myts -> addSlashes($_POST['ref']) : '';
	$url = !empty($_POST['url']) ? $myts -> addSlashes($_POST['url']) : '';
	$notifypub = !empty($_POST['notifypub']) ? intval($_POST['notifypub']) : 0;
	$date = time();
	$proc = getJsortCode($proc);

	if ( $xoopsDB -> query( "UPDATE $ent_table SET term = '$term', proc = '$proc', init = '$init', categoryID = '$categoryID', definition = '$definition', ref = '$ref', url = '$url', uid = '$uid', submit = '0', datesub = '$date', html = '$html', smiley = '$smiley', xcodes = '$xcodes', breaks = '$breaks', block = '$block', offline = '0', notifypub = '$notifypub', request = '0' WHERE entryID = '$entryID'" ) )
		{
		//posts count up
		$xoopsDB->query( "UPDATE ".$xoopsDB->prefix('users')." SET posts=posts+1 WHERE uid='$uid'" ) ;
		redirect_header( "submissions.php", 1, constant("_AM_{$MYDIRNAME}_ENTRYAUTHORIZED") );
		}
	else
		{
		redirect_header( "submissions.php", 1, constant("_AM_{$MYDIRNAME}_ENTRYNOTUPDATED") );
		}
	}


function entryz()
	{
	include_once( XOOPS_ROOT_PATH . '/class/pagenav.php' );
	global $cat_table,$ent_table,$xoopsConfig,$xoopsModuleConfig,$xoopsModule,$MYDIRNAME; 
	$xoopsDB =& Database::getInstance();
	$myts =& MyTextSanitizer::getInstance();

	$startsub = !empty( $_GET['startsub'] ) ? intval( $_GET['startsub'] ) : 0;
	$entryID = !empty( $_GET['entryID'] ) ? intval($_GET['entryID']) : 0;
	xoops_cp_header();
	adminMenu(0, constant("_AM_{$MYDIRNAME}_AUTHORIZE"));
	include('./mymenu.php');

	/* -- Code to show submitted entries -- */
	echo "<fieldset style='margin:1em 0em 0em 0em;border:1px solid #778;'><legend style='font-weight: bold; color: #900;'>" . constant("_AM_{$MYDIRNAME}_SHOWSUBMISSIONS") . "</legend><br />";

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

	$resultS1 = $xoopsDB -> query("SELECT COUNT(*) FROM $ent_table WHERE submit = '1'");
	list( $numrows ) = $xoopsDB -> fetchRow( $resultS1 );

	if ( $numrows > 0 ) // That is, if there ARE submitted entries in the system
		{
		$sql = "SELECT e.entryID, e.categoryID, e.term, e.uid, e.datesub, c.name FROM $ent_table e LEFT JOIN $cat_table c ON e.categoryID = c.categoryID WHERE submit = '1' ORDER BY datesub DESC";
		$resultS2 = $xoopsDB -> query( $sql, $xoopsModuleConfig['perpage'], $startsub );

		while ( list( $entryID, $categoryID, $term, $uid, $created, $name ) = $xoopsDB -> fetchrow( $resultS2 ) )
			{
			$sentby = xoops_getLinkedUnameFromId(intval($uid));
			$entryID = intval($entryID);
			$categoryID = intval($categoryID);
			$catname = $myts -> htmlSpecialChars( $name );
			$term = $myts -> htmlSpecialChars( $term );
			$created = formatTimestamp( $created, 's' );
			$modify = "<a href='" . XOOPS_URL . "/modules/" . $xoopsModule->dirname() . "/admin/submissions.php?op=mod&amp;entryID=" . $entryID . "'><img src='" . XOOPS_URL . "/modules/" . $xoopsModule->dirname() . "/images/icon/edit.gif' border='0' width='20' height='20' alt='".constant("_AM_{$MYDIRNAME}_EDITSUBM")."' /></a>";
			$delete = "<a href='" . XOOPS_URL . "/modules/" . $xoopsModule->dirname() . "/admin/submissions.php?op=del&amp;entryID=" . $entryID . "'><img src='" . XOOPS_URL . "/modules/" . $xoopsModule->dirname() . "/images/icon/delete.gif' border='0' width='20' height='20' alt='".constant("_AM_{$MYDIRNAME}_DELETESUBM")."' /></a>";
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
		echo "<td class='head' align='center' colspan='".$colspan."'>".constant("_AM_{$MYDIRNAME}_NOSUBMISSYET")."</td>";
		echo "</tr>";
		}
	echo "</table>";
	$pagenav = new XoopsPageNav( $numrows, $xoopsModuleConfig['perpage'], $startsub, 'startsub', 'entryID =' . $entryID );
	echo "<div style='text-align:right;'>" . $pagenav -> renderNav() . "</div>";
	echo "</fieldset>";
	echo "<br />";

	/* -- Code to show requested entries -- */
	echo "<fieldset style='margin:1em 0em 0em 0em;border:1px solid #778;'><legend style='font-weight: bold; color: #900;'>" . constant("_AM_{$MYDIRNAME}_SHOWREQUESTS") . "</legend><br />";

	echo "<table width='100%' cellspacing='1' cellpadding='3' border='0' class='outer'>";
	echo "<tr>";
	echo "<td width='40' class='bg3' align='center'><b>" . constant("_AM_{$MYDIRNAME}_ENTRYID") . "</b></td>";
	echo "<td class='bg3' align='center'><b>" . constant("_AM_{$MYDIRNAME}_ENTRYTERM") . "</b></td>";
	echo "<td width='90' class='bg3' align='center'><b>" . constant("_AM_{$MYDIRNAME}_SUBMITTER") . "</b></td>";
	echo "<td width='90' class='bg3' align='center'><b>" . constant("_AM_{$MYDIRNAME}_ENTRYCREATED") . "</b></td>";
	echo "<td width='60' class='bg3' align='center'><b>" . constant("_AM_{$MYDIRNAME}_ACTION") . "</b></td>";
	echo "</tr>";

	$resultS2 = $xoopsDB -> query( "SELECT COUNT(*) FROM $ent_table WHERE request = '1'" );
	list( $numrowsX ) = $xoopsDB -> fetchRow( $resultS2 );

	if ( $numrowsX > 0 ) // That is, if there ARE unauthorized articles in the system
		{
		$sql4 = "SELECT entryID, term, uid, datesub FROM $ent_table WHERE request = '1' ORDER BY datesub DESC";
		$resultS4 = $xoopsDB -> query( $sql4, $xoopsModuleConfig['perpage'], $startsub );

		while ( list( $entryID, $term, $uid, $created) = $xoopsDB -> fetchrow( $resultS4 ) )
			{
			$sentby = xoops_getLinkedUnameFromId(intval($uid));
			$entryID = intval($entryID);
			$term = $myts -> htmlSpecialChars( $term );
			$created = formatTimestamp( $created, 's' );
			$modify = "<a href='" . XOOPS_URL . "/modules/" . $xoopsModule->dirname() . "/admin/submissions.php?op=mod&amp;entryID=" . $entryID . "'><img src='" . XOOPS_URL . "/modules/" . $xoopsModule->dirname() . "/images/icon/edit.gif' border='0' width='20' height='20' alt='".constant("_AM_{$MYDIRNAME}_EDITSUBM")."' /></a>";
			$delete = "<a href='" . XOOPS_URL . "/modules/" . $xoopsModule->dirname() . "/admin/submissions.php?op=del&amp;entryID=" . $entryID . "'><img src='" . XOOPS_URL . "/modules/" . $xoopsModule->dirname() . "/images/icon/delete.gif' border='0' width='20' height='20' alt='".constant("_AM_{$MYDIRNAME}_DELETESUBM")."' /></a>";
			echo "<tr>";
			echo "<td class='head' align='center'> $entryID </td>";
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
		echo "<td class='head' align='center' colspan='5'>".constant("_AM_{$MYDIRNAME}_NOREQSYET")."</td>";
		echo "</tr>";
		}
	echo "</table>";
	$pagenav = new XoopsPageNav( $numrows, $xoopsModuleConfig['perpage'], $startsub, 'startsub', 'entryID =' . $entryID );
	echo "<div style='text-align:right;'>" . $pagenav -> renderNav() . "</div>";
	echo "</fieldset>";
	echo "<br />";

	xoops_cp_footer();
	}


/* -- Available operations -- */
switch ( $op )
	{
	case "mod":
	editentry( $entryID );
	break;

	case "authentry":
	entrySave( $entryID );
	break;

	case "del":
	entryDelete( $entryID );
	break;

	case "delentry":
	entryDeletego( $entryID );
	break;

	case "default":
	default:
	entryz();
	break;
	}
exit();
?>