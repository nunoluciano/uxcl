<?php
/**
 * $Id: storyform.inc.php v 1.0 8 May 2004 hsalazar Exp $
 * Module: Wordbook
 * Version: v 1.00
 * Release Date: 8 May 2004
 * Author: hsalazar
 * Licence: GNU
 */
// XOOPS2 - Xwords 0.42
// WEBMASTER @ KANPYO.NET, 2005.

if( ! defined( 'XOOPS_ROOT_PATH' ) ) exit ;

include_once ( XOOPS_ROOT_PATH . "/class/xoopstree.php" );
include_once ( XOOPS_ROOT_PATH . "/class/xoopslists.php" );
include_once ( XOOPS_ROOT_PATH . "/class/xoopsformloader.php" );

$mytree = new XoopsTree( $cat_table, "categoryID", "0" );
$sform = new XoopsThemeForm( constant("_MD_{$MYDIRNAME}_SUB_SMNAME"), "storyform", xoops_getenv( 'PHP_SELF' ) );

if ($xoopsModuleConfig['multicats'] == '1')
	{
	if (!empty($xoopsUser))
		{
		ob_start();
//		$sform -> addElement( new XoopsFormHidden( 'categoryID', intval($categoryID) ) );
		$mytree -> makeMySelBox( "name", "weight", $categoryID );
		$sform -> addElement( new XoopsFormLabel( constant("_MD_{$MYDIRNAME}_CATEGORY"), ob_get_contents() ) );
		ob_end_clean();
		}
	}
// This part is common to edit/add
$sform -> addElement( new XoopsFormText( constant("_MD_{$MYDIRNAME}_ENTRY"), 'term', 40, 80, $term ), true );
$sform -> addElement( new XoopsFormText( constant("_MD_{$MYDIRNAME}_PROC").constant("_MD_{$MYDIRNAME}_HIRAGANA"), 'proc', 40, 80, $proc ), false );

if ( !$entryID && !$definition) // therez no entryID? Then itz a new entry
	{
	$definition = constant("_MD_{$MYDIRNAME}_WRITEHERE");
	}

if ( $xoopsModuleConfig['dhtmluse'] == '1' )
	{
	$def_block = new XoopsFormDhtmlTextArea( constant("_MD_{$MYDIRNAME}_DEFINITION").constant("_MD_{$MYDIRNAME}_DONTUSETAG"), 'definition', $definition, 10, 40 );
	}
else
	{
	$def_block = new XoopsFormTextArea( constant("_MD_{$MYDIRNAME}_DEFINITION").constant("_MD_{$MYDIRNAME}_DONTUSETAG"), 'definition', $definition, 10, 40 );
	}

$def_block -> setExtra( 'onfocus="this.select()"' );
$sform -> addElement ( $def_block );

$sform -> addElement( new XoopsFormTextArea( constant("_MD_{$MYDIRNAME}_REFERENCE"), 'ref', $ref, 5, 40 ), false );
$sform -> addElement( new XoopsFormText( constant("_MD_{$MYDIRNAME}_URL"), 'url', 40, 80, $url ), false );

$button_tray = new XoopsFormElementTray( '', '' );

if ( is_object( $xoopsUser ) )
	{
	$uid = $xoopsUser->getVar('uid');
	$hidden_uid = new XoopsFormHidden( 'uid', intval($uid) );
	$button_tray -> addElement( $hidden_uid );

	if ( $xoopsUser->isAdmin($xoopsModule->getVar('mid')) )
		{
		$notify_checkbox = new XoopsFormCheckBox( '', 'notifypub', intval($notifypub) );
		$notify_checkbox -> addOption( 1, constant("_MD_{$MYDIRNAME}_NOTIFY") );
		$sform -> addElement( $notify_checkbox );
		}
	}

$hidden = new XoopsFormHidden( 'op', 'post' );
$button_tray -> addElement( $hidden );

$hidden_id = new XoopsFormHidden( 'entryID', intval($entryID) );
$button_tray -> addElement( $hidden_id );

$hidden_html = new XoopsFormHidden( 'html', 0 );
$button_tray -> addElement( $hidden_html );

if ( $xoopsModuleConfig['dhtmluse'] == '1' )
	{
	$hidden_smiley = new XoopsFormHidden( 'smiley', 1 );
	$button_tray -> addElement( $hidden_smiley );
	$hidden_xcodes = new XoopsFormHidden( 'xcodes', 1 );
	$button_tray -> addElement( $hidden_xcodes );
	}
else
	{
	$hidden_smiley = new XoopsFormHidden( 'smiley', 0 );
	$button_tray -> addElement( $hidden_smiley );
	$hidden_xcodes = new XoopsFormHidden( 'xcodes', 0 );
	$button_tray -> addElement( $hidden_xcodes );
	}
$hidden_breaks = new XoopsFormHidden( 'breaks', 1 );
$button_tray -> addElement( $hidden_breaks );

//PREVIEW(ver0.31)
$butt_preview = new XoopsFormButton( '', '', constant("_MD_{$MYDIRNAME}_PREVIEWOPEN"), 'button' );
$butt_preview->setExtra('onclick="document.storyform.action=\'./preview.php\';document.storyform.target=\'_blank\';document.storyform.submit();"');
$button_tray->addElement( $butt_preview );

if ( !$entryID ) // therez no entryID? Then its a new entry
	{
	$butt_create = new XoopsFormButton( '', '', constant("_MD_{$MYDIRNAME}_CREATE"), 'submit' );
	$butt_create->setExtra('onclick="document.storyform.action=\'./submit.php\';document.storyform.target=\'_self\';this.form.elements.op.value=\'post\'"');
	$button_tray->addElement( $butt_create );

	$butt_clear = new XoopsFormButton( '', '', constant("_MD_{$MYDIRNAME}_CLEAR"), 'reset' );
	$button_tray->addElement( $butt_clear );

	$butt_cancel = new XoopsFormButton( '', '', constant("_MD_{$MYDIRNAME}_CANCEL"), 'button' );
	$butt_cancel->setExtra('onclick="history.go(-1)"');
	$button_tray->addElement( $butt_cancel );
	}
else // else, were editing an existing entry
	{
	$butt_create = new XoopsFormButton( '', '', constant("_MD_{$MYDIRNAME}_MODIFY"), 'submit' );
	$butt_create->setExtra('onclick="document.storyform.action=\'./submit.php\';document.storyform.target=\'_self\';this.form.elements.op.value=\'post\'"');
	$button_tray->addElement( $butt_create );

	$butt_cancel = new XoopsFormButton( '', '', constant("_MD_{$MYDIRNAME}_CANCEL"), 'button' );
	$butt_cancel->setExtra('onclick="history.go(-1)"');
	$button_tray->addElement( $butt_cancel );
	}

// render form as plain html
$button_tray->addElement( $xoopsGTicket->getTicketXoopsForm( __LINE__ ) );//GIJ

$sform -> addElement( $button_tray );
$sform -> assign($xoopsTpl);

?>