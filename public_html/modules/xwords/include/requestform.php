<?php 
/**
 * $Id: index.php v 1.0 8 May 2004 hsalazar Exp $
 * Module: Wordbook - a multicategory glossary
 * Version: v 1.00
 * Release Date: 8 May 2004
 * Author: hsalazar
 * Licence: GNU
 */
// XOOPS2 - Xwords 0.42
// Presented by WEBMASTER @ KANPYO.NET, 2005.

if( ! defined( 'XOOPS_ROOT_PATH' ) ) exit ;
include_once( XOOPS_ROOT_PATH.'/class/xoopsformloader.php' );

$rform = new XoopsThemeForm(constant("_MD_{$MYDIRNAME}_REQUESTFORM"), 'requestform', 'request.php');

if (empty($_POST['username']))
	{
	$username_v = !empty($xoopsUser) ? $xoopsUser->getVar("uname", "E") : constant("_MD_{$MYDIRNAME}_ANONYMOUS");
	}
else
	{
	$username_v = $myts->stripSlashesGPC(htmlSpecialChars($_POST['username']));
	}
$name_text = new XoopsFormText(constant("_MD_{$MYDIRNAME}_USERNAME"), 'username', 35, 100, $username_v);
$rform->addElement($name_text, false);

if (empty($_POST['usermail']))
	{
	$usermail_v = !empty($xoopsUser) ? $xoopsUser->getVar("email", "E") : "";
	}
else
	{
	$usermail_v = $myts->stripSlashesGPC(htmlSpecialChars($_POST['usermail']));
	}
$email_text = new XoopsFormText(constant("_MD_{$MYDIRNAME}_USERMAIL"), 'usermail', 40, 100, $usermail_v);
$rform->addElement($email_text, false);

if (empty($_POST['reqterm']))
	{
	$reqterm_v = "";
	}
else
	{
	$reqterm_v = $myts->stripSlashesGPC(htmlSpecialChars($_POST['reqterm']));
	}
$reqterm_text = new XoopsFormText(constant("_MD_{$MYDIRNAME}_REQTERM"), 'reqterm', 40, 150, $reqterm_v);
$rform->addElement($reqterm_text, true);

if ( is_object( $xoopsUser ) )
	{
	if ( $xoopsUser->isAdmin($xoopsModule->getVar('mid')) )
		{
		$notify_checkbox = new XoopsFormCheckBox( '', 'notifypub', 0 );
		$notify_checkbox -> addOption( 1, constant("_MD_{$MYDIRNAME}_NOTIFY") );
		$rform -> addElement( $notify_checkbox );
		}
	}

$button_tray = new XoopsFormElementTray('' , '') ;
$button_tray->addElement(new XoopsFormButton('', 'submit', constant("_MD_{$MYDIRNAME}_SUBMIT"), 'submit'));

// render form as plain html
$button_tray->addElement( $xoopsGTicket->getTicketXoopsForm( __LINE__ ) );//GIJ
$rform->addElement($button_tray);

$rform->assign($xoopsTpl);
?>