<?php
/**
 * $Id: entry.php v 1.0 8 May 2004 hsalazar Exp $
 * Module: Wordbook - a multicategory glossary
 * Version: v 1.00
 * Release Date: 8 May 2004
 * Author: hsalazar
 * Licence: GNU
 */
// XOOPS2 - Xwords 0.43
// WEBMASTER @ KANPYO.NET, 2005.

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
function entryEdit( $entryID = '' )
	{
	global $xoopsUser,$xoopsConfig,$xoopsModuleConfig,$mydirname,$MYDIRNAME,$spaw_root,$cat_table,$ent_table,$xoopsGTicket; 
	$xoopsDB =& Database::getInstance();
	$xoopsModule = XoopsModule::getByDirname("$mydirname");
	$myts =& MyTextSanitizer::getInstance();

	$op = 'default';
	if ( !empty( $_GET['op'] ) ) $op = trim($_GET['op']);
	if ( !empty( $_POST['op'] ) ) $op = trim($_POST['op']);
	$entryID = !empty( $_GET['entryID'] ) ? intval($_GET['entryID']) : '';
	/**
	 * Clear all variables before we start
	 */
	if(!isset($block)) { $block = 0; }
	if(!isset($html)) { $html = 0; }
	if(!isset($smiley)) { $smiley = 0; }
	if(!isset($xcodes)) { $xcodes = 0; }
	if(!isset($breaks)) { $breaks = 0; }
	if(!isset($offline)) { $offline = 0; }
	if(!isset($submit)) { $submit = 0; }
	if(!isset($request)) { $request = 0; }
	if(!isset($notifypub)) { $notifypub = 0; }
	if(!isset($categoryID)) { $categoryID = 0; }
	if(!isset($term)) { $term = ""; }
	if(!isset($proc)) { $proc = ""; }
	if(!isset($definition)) 
		{
		$definition = constant("_AM_{$MYDIRNAME}_WRITEHERE");	
		}
	if(!isset($ref)) { $ref = ""; }
	if(!isset($url)) { $url = ""; }
	if(!isset($renewdate)) { $renewdate = 0; }
	if(!isset($datesub)) { $datesub = 0; }

	// If there is a parameter, and the id exists, retrieve data: were editing an entry
	if ( $entryID > 0 )
		{
		$result = $xoopsDB -> query( "SELECT categoryID, term, proc, definition, ref, url, uid, submit, datesub, html, smiley, xcodes, breaks, block, offline, notifypub, request FROM $ent_table WHERE entryID = '$entryID'" );
		list( $categoryID, $term, $proc, $definition, $ref, $url, $uid, $submit, $datesub, $html, $smiley, $xcodes, $breaks, $block, $offline, $notifypub, $request ) = $xoopsDB -> fetchrow( $result );

		if ( !$xoopsDB -> getRowsNum( $result ) )
			{
			redirect_header( "index.php", 1, constant("_AM_{$MYDIRNAME}_NOENTRYTOEDIT") );
			}

		$term = $myts -> htmlspecialchars($term);
		if ($proc)
			{
			list($temp,$proc) = explode(",",$proc);
			}
		$proc = $myts -> htmlSpecialChars($proc);
		$ref = $myts -> htmlSpecialChars($ref);
		$url = $myts -> htmlSpecialChars($url);

		$datesub = intval( $datesub );
		$block = intval( $block );
		$html = intval( $html );
		$smiley = intval( $smiley );
		$xcodes = intval( $xcodes );
		$breaks = intval( $breaks );
		$notifypub = intval( $notifypub );

		xoops_cp_header();
		adminMenu(2, constant("_AM_{$MYDIRNAME}_ENTRIES")."&nbsp;&raquo;&nbsp;".constant("_AM_{$MYDIRNAME}_MODIFY"));
		include('./mymenu.php');
		echo "<fieldset style='margin:1em 0em 0em 0em;border:1px solid #778;'><legend style='font-weight: bold; color: #900;'>" . constant("_AM_{$MYDIRNAME}_ENTRIES") . "</legend><br />\n";
		$sform = new XoopsThemeForm( constant("_AM_{$MYDIRNAME}_MODENTRY") . ": " .$myts -> htmlSpecialChars($term) , "op", xoops_getenv( 'PHP_SELF' ) );
		} 
	else // there's no parameter, so we're adding an entry
		{
		$result01 = $xoopsDB -> query( "SELECT COUNT(*) FROM $cat_table" );
		list( $totalcats ) = $xoopsDB -> fetchRow( $result01 );
		if ( $totalcats == 0 && $xoopsModuleConfig['multicats'] == 1 )
			{
			redirect_header( "index.php", 1, constant("_AM_{$MYDIRNAME}_NEEDONECOLUMN") );
			}
		xoops_cp_header();
		adminMenu(2, constant("_AM_{$MYDIRNAME}_ENTRIES")."&nbsp;&raquo;&nbsp;".constant("_AM_{$MYDIRNAME}_ADMINENTRYMNGMT"));
		include('./mymenu.php');
		echo "<fieldset style='margin:1em 0em 0em 0em;border:1px solid #778;'><legend style='font-weight: bold; color: #900;'>" . constant("_AM_{$MYDIRNAME}_ENTRIES") . "</legend><br />\n";
		$uid = $xoopsUser->getVar('uid');
		$sform = new XoopsThemeForm( constant("_AM_{$MYDIRNAME}_NEWENTRY"), "op", xoops_getenv( 'PHP_SELF' ) );
		$html = $smiley = $xcodes = $breaks = 1;
		}

	$sform -> setExtra( 'enctype="multipart/form-data"' );

	// Author selector
	ob_start();
	echo	xoops_getLinkedUnameFromId( intval($uid) );
	$sform -> addElement( new XoopsFormLabel( constant("_AM_{$MYDIRNAME}_AUTHOR"), ob_get_contents() ) );
	ob_end_clean();

	// Category selector
	if ($xoopsModuleConfig['multicats'] == 1)
		{
		$mytree = new XoopsTree( $cat_table, "categoryID" , "0" );

		ob_start();
//okino		$sform -> addElement( new XoopsFormHidden( 'categoryID', intval($categoryID) ) );
		$mytree -> makeMySelBox( "name", "weight", $categoryID );
		$sform -> addElement( new XoopsFormLabel( constant("_AM_{$MYDIRNAME}_CATNAME"), ob_get_contents() ) );
		ob_end_clean();
		}

	// Term, definition, reference and related URL
	$sform -> addElement( new XoopsFormText( constant("_AM_{$MYDIRNAME}_ENTRYTERM"), 'term', 50, 80, $term), true );
	$sform -> addElement( new XoopsFormText( constant("_AM_{$MYDIRNAME}_ENTRYPROC"), 'proc', 50, 80, $proc), true );

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
	if ($definition == constant("_AM_{$MYDIRNAME}_WRITEHERE"))
		{
		$def_block -> setExtra( 'onfocus="this.select()"' );
		}
	$sform -> addElement ( $def_block );

	if ($xoopsModuleConfig['allowedtypes'])
		{
		$butt_upfile = new XoopsFormButton( constant("_AM_{$MYDIRNAME}_UPFILES"), '', constant("_AM_{$MYDIRNAME}_UPLOADOPEN"), 'button' );
		$butt_upfile->setExtra('onclick="window.open (\'upload.php\', \'wbupload\', \'width=550,height=360,location=0,menubar=0,resizable=1,scrollbars=yes,status=1,toolbar=0\')"');
		$sform->addElement( $butt_upfile );
		}

	$sform -> addElement( new XoopsFormTextArea( constant("_AM_{$MYDIRNAME}_ENTRYREFERENCE"), 'ref', $ref, 5, 60 ), false );
	$sform -> addElement( new XoopsFormText( constant("_AM_{$MYDIRNAME}_ENTRYURL"), 'url', 50, 80, $url ), false );

	// Code to take entry offline, for maintenance purposes
	$offline_radio = new XoopsFormRadioYN(constant("_AM_{$MYDIRNAME}_SWITCHOFFLINE"), 'offline', intval($offline), ' '.constant("_AM_{$MYDIRNAME}_YES").'', ' '.constant("_AM_{$MYDIRNAME}_NO").'');
	$sform -> addElement($offline_radio);

	// Code to put entry in block
//	$block_radio = new XoopsFormRadioYN( _AM_XWORDS_BLOCK, 'block', $block , ' ' . _AM_XWORDS_YES . '', ' ' . _AM_XWORDS_NO . '' );
//	$sform -> addElement( $block_radio );

	if ( $entryID > 0)
		{
		$renewdate_checkbox = new XoopsFormCheckBox( constant("_AM_{$MYDIRNAME}_ENTRYCREATED")."<br /><span style='font-size: xx-small; font-weight: normal;'>(".constant("_AM_{$MYDIRNAME}_RENEWDATE_DEFAULT").formatTimestamp($datesub).")</span>", 'renewdate', $renewdate );
		$renewdate_checkbox -> addOption( 1, constant("_AM_{$MYDIRNAME}_RENEWDATE")."<br />".getSetTimeForm($datesub) );
		}
	else
		{
		$renewdate_checkbox = new XoopsFormCheckBox( constant("_AM_{$MYDIRNAME}_ENTRYCREATED")."<br /><span style='font-size: xx-small; font-weight: normal;'>(".constant("_AM_{$MYDIRNAME}_RENEWDATE_DEFAULT").formatTimestamp(time()).")</span>", 'renewdate', $renewdate );
		$renewdate_checkbox -> addOption( 1, constant("_AM_{$MYDIRNAME}_SETNEWDATE")."<br />".getSetTimeForm(time()) );
		}
	$sform -> addElement( $renewdate_checkbox );

	// VARIOUS OPTIONS
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
	$hidden = new XoopsFormHidden( 'op', 'addentry' );
	$button_tray -> addElement( $hidden );

	$hidden_date = new XoopsFormHidden( 'datesub', $datesub );
	$button_tray -> addElement( $hidden_date );

	$hidden_id = new XoopsFormHidden( 'entryID', $entryID );
	$button_tray -> addElement( $hidden_id );

	$hidden_uid = new XoopsFormHidden( 'uid', $uid );
	$button_tray -> addElement( $hidden_uid );

	$hidden_block = new XoopsFormHidden( 'block', $block );
	$button_tray -> addElement( $hidden_block );

	if ( !$entryID)
		{
		$hidden_renewdate = new XoopsFormHidden( 'renewdate', 1 );
		$button_tray -> addElement( $hidden_renewdate );
		}

	//PREVIEW(ver0.31)
	$butt_preview = new XoopsFormButton( '', '', constant("_AM_{$MYDIRNAME}_PREVIEWOPEN"), 'button' );
	$butt_preview->setExtra('onclick="document.op.action=\'../preview.php\';document.op.target=\'_blank\';document.op.submit();"');
	$button_tray->addElement( $butt_preview );

	if ( !$entryID ) // therez no entryID? Then its a new entry
		{
		$butt_create = new XoopsFormButton( '', '', constant("_AM_{$MYDIRNAME}_CREATE"), 'submit' );
		$butt_create->setExtra('onclick="document.op.action=\'./entry.php\';document.op.target=\'_self\';this.form.elements.op.value=\'addentry\'"');
		$button_tray->addElement( $butt_create );

		$butt_clear = new XoopsFormButton( '', '', constant("_AM_{$MYDIRNAME}_CLEAR"), 'reset' );
		$button_tray->addElement( $butt_clear );

		$butt_cancel = new XoopsFormButton( '', '', constant("_AM_{$MYDIRNAME}_CANCEL"), 'button' );
		$butt_cancel->setExtra('onclick="history.go(-1)"');
		$button_tray->addElement( $butt_cancel );
		} 
	else // else, were editing an existing entry
		{
		$butt_create = new XoopsFormButton( '', '', constant("_AM_{$MYDIRNAME}_MODIFY"), 'submit' );
		$butt_create->setExtra('onclick="document.op.action=\'./entry.php\';document.op.target=\'_self\';this.form.elements.op.value=\'addentry\'"');
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


function entrySave ($entryID = '')
	{
	global $xoopsUser,$xoopsConfig,$mydirname,$MYDIRNAME,$cat_table,$ent_table,$xoopsGTicket;

	// Ticket check
	if ( ! $xoopsGTicket->check() ) {
		redirect_header(XOOPS_URL.'/',3,$xoopsGTicket->getErrors());
	}

	$xoopsDB =& Database::getInstance();
	$xoopsModule = XoopsModule::getByDirname("$mydirname");
	$myts =& MyTextSanitizer::getInstance();

	$categoryID = !empty($_POST['categoryID']) ? intval($_POST['categoryID']) : '';
	$uid = !empty($_POST['uid']) ? intval($_POST['uid']) : '';
	$datesub = !empty($_POST['renewdate']) ? mktime( intval($_POST['autohour']), intval($_POST['automin']), 0, intval($_POST['automonth']), intval($_POST['autoday']), intval($_POST['autoyear']) ) : intval($_POST['datesub']);

	$html = !empty($_POST['html']) ? intval($_POST['html']) : 0;
	$smiley = !empty($_POST['smiley']) ? intval($_POST['smiley']) : 0;
	$xcodes = !empty($_POST['xcodes']) ? intval($_POST['xcodes']) : 0;
	$breaks = !empty($_POST['breaks']) ? intval($_POST['breaks']) : 0;

	$term = !empty($_POST['term']) ? $myts->addSlashes($_POST['term']) : '';
	$proc = !empty($_POST['proc']) ? $myts->addSlashes($_POST['proc']) : '';
	$init = getInitial($term,$proc);

	$definition = !empty($_POST['definition']) ? $myts -> addSlashes( $_POST['definition'] ) : '';
	$ref = !empty($_POST['ref']) ? $myts->addSlashes($_POST['ref']) : '';
	$url = !empty($_POST['url']) ? $myts->addSlashes($_POST['url']) : '';

	$block = !empty($_POST['block']) ? intval($_POST['block']) : 0;
	$offline = !empty($_POST['offline']) ? intval($_POST['offline']) : 0;
	$submit = 0;
	$notifypub = 0;
	$request = 0;
	$proc = getJsortCode($proc);

// Save to database
	if ( $entryID > 0 )
		{
		if ( $xoopsDB -> query( "UPDATE $ent_table SET term = '$term', proc = '$proc', categoryID = '$categoryID', init = '$init', definition = '$definition', ref = '$ref', url = '$url', uid = '$uid', submit = '$submit', datesub = '$datesub', html = '$html', smiley = '$smiley', xcodes = '$xcodes', breaks = '$breaks', block = '$block', offline = '$offline', notifypub = '$notifypub', request = '$request' WHERE entryID = '$entryID'" ) )
			{
			include_once( XOOPS_ROOT_PATH . '/modules/'.$xoopsModule->dirname().'/entries_write.php' );	//okino
				calculateTotals();
			redirect_header( "index.php", 1, constant("_AM_{$MYDIRNAME}_ENTRYMODIFIED") );
			}
		else
			{
			redirect_header( "index.php", 1, constant("_AM_{$MYDIRNAME}_ENTRYNOTUPDATED") );
			}
		}
	else  // That is, $entryID exists, thus were editing an entry
		{
		$date = !empty($_POST['renewdate']) ? $datesub : time();
		$uid = $xoopsUser -> uid();
		if ( $xoopsDB -> query( "INSERT INTO $ent_table (entryID, categoryID, term, proc, init, definition, ref, url, uid, submit, datesub, html, smiley, xcodes, breaks, block, offline, notifypub, request ) VALUES ('', '$categoryID', '$term', '$proc', '$init', '$definition', '$ref', '$url', '$uid', '$submit', '$date', '$html', '$smiley', '$xcodes', '$breaks', '$block', '$offline', '$notifypub', '$request' )" ) )
			{
			include_once( XOOPS_ROOT_PATH . '/modules/'.$xoopsModule->dirname().'/entries_write.php' );	//okino
		//posts count up
			$xoopsDB->query( "UPDATE ".$xoopsDB->prefix('users')." SET posts=posts+1 WHERE uid='$uid'" ) ;
			calculateTotals();
			redirect_header( "index.php", 1, constant("_AM_{$MYDIRNAME}_ENTRYCREATEDOK") );
			}
		else
			{
			redirect_header( "index.php", 1, constant("_AM_{$MYDIRNAME}_ENTRYNOTCREATED") );
			}
		}
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
		redirect_header( "index.php", 2, constant("_AM_{$MYDIRNAME}_NOENTRY") );
		}

	list( $entryID, $term ) = $xoopsDB -> fetchrow( $result );

	xoops_cp_header();
	adminMenu(0, constant("_AM_{$MYDIRNAME}_ENTRIES")."&nbsp;&raquo;&nbsp;".constant("_AM_{$MYDIRNAME}_DELETE"));
	include('./mymenu.php');
	echo "<br />\n";
	$term = $myts -> htmlSpecialChars($term);
	xoops_confirm(array('op' => 'delentry', 'entryID' => $entryID, 'ok' => 1, 'term' => $term ) + $xoopsGTicket->getTicketArray( __LINE__ ), 'entry.php', constant("_AM_{$MYDIRNAME}_DELETETHISENTRY") . "<br /><br />" . $term, constant("_AM_{$MYDIRNAME}_DELETE") );
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

	$ok = !empty($_POST['ok']) ? intval($_POST['ok']) : 0;
	$term = !empty($_POST['term']) ? $myts -> htmlSpecialChars($_POST['term']) : "";

	// confirmed, so delete 
	if ( $ok != 1 && $entryID < 0 )
		{
		redirect_header( "index.php", 2, constant("_AM_{$MYDIRNAME}_NOENTRY") );
		}

	if ( $xoopsDB -> query( "DELETE FROM $ent_table WHERE entryID = '$entryID'") )
		{
		// delete comments
		xoops_comment_delete($xoopsModule->getVar('mid'), $entryID);
		calculateTotals();
		redirect_header("index.php",1,sprintf( constant("_AM_{$MYDIRNAME}_ENTRYISDELETED"), $term ) );
		}
	else
		{
		redirect_header( "index.php", 2, constant("_AM_{$MYDIRNAME}_NOTUPDATED") );
		}
	}


/* -- Available operations -- */
switch ( $op )
	{
	case "mod":
		entryEdit($entryID);
		break;

	case "addentry":
		entrySave($entryID);
		break;

	case "del":
		entryDelete($entryID);
		break;

	case "delentry":
		entryDeletego($entryID);
		break;

	case "default":
	default:
		entryEdit();
		break;
	}
exit();

?>
