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
// WEBMASTER @ KANPYO.NET, 2005.

include "./header.php";
include_once( XOOPS_ROOT_PATH . '/modules/'.$xoopsModule->dirname().'/include/gtickets.php' );

global $xoopsUser;

if ( !$xoopsModuleConfig['allowreq'])
	{
	redirect_header( "index.php", 1, _NOPERM );
	exit();
	}

if ( empty($_POST['submit']) )
	{
	$xoopsOption['template_main'] = "{$mydirname}_request.html";
	include( XOOPS_ROOT_PATH.'/header.php' );
	include( XOOPS_ROOT_PATH.'/modules/'.$xoopsModule->dirname().'/include/requestform.php' );
	$xoopsTpl -> assign ( 'lang_modulename', $xoopsModule->name() );
	$xoopsTpl -> assign ( 'lang_moduledirname', $xoopsModule->dirname() );
	$xoopsTpl -> assign ( 'lang_home', constant("_MD_{$MYDIRNAME}_HOME") );
	$xoopsTpl -> assign ( 'lang_askfordef', constant("_MD_{$MYDIRNAME}_ASKFORDEF") );
	$xoopsTpl -> assign ( 'lang_intro', constant("_MD_{$MYDIRNAME}_INTROREQUEST") );
	$xoopsTpl -> assign ( 'titleblockuse', intval($xoopsModuleConfig["titleblockuse"]) );
	$xoopsTpl -> assign ( 'h1id', $myts -> makeTboxData4Show( $xoopsModuleConfig["h1id"] ) );

	include( XOOPS_ROOT_PATH.'/footer.php' );
	}
else
	{
	// Ticket check
	if ( ! $xoopsGTicket->check() )
		{
		redirect_header(XOOPS_URL.'/',3,$xoopsGTicket->getErrors());
		exit();
		}

	if ( empty($_POST['username']) || empty($_POST['usermail']) || empty($_POST['reqterm']) )
		{
		$caution = '<ul>';
		$caution .= empty($_POST['username']) ? '<li style="color:red;">'.constant("_MD_{$MYDIRNAME}_NOUSERNAME").'</li>' : '';
		$caution .= empty($_POST['usermail']) ? '<li style="color:red;">'.constant("_MD_{$MYDIRNAME}_NOUSERMAIL").'</li>' : '';
		$caution .= empty($_POST['reqterm']) ? '<li style="color:red;">'.constant("_MD_{$MYDIRNAME}_NOREQTERM").'</li>' : '';
		$caution .= '</ul>';

		$xoopsOption['template_main'] = "{$mydirname}_request.html";
		include( XOOPS_ROOT_PATH.'/header.php' );
		include( XOOPS_ROOT_PATH.'/modules/'.$xoopsModule->dirname().'/include/requestform.php' );

		$xoopsTpl->assign('lang_modulename', $xoopsModule->name());
		$xoopsTpl->assign('lang_moduledirname', $xoopsModule->dirname());
		$xoopsTpl->assign('lang_home', constant("_MD_{$MYDIRNAME}_HOME"));
		$xoopsTpl->assign('lang_askfordef', constant("_MD_{$MYDIRNAME}_ASKFORDEF"));
		$xoopsTpl->assign('lang_intro', constant("_MD_{$MYDIRNAME}_INTROREQUEST"));
		$xoopsTpl->assign('lang_caution', $caution);
		$xoopsTpl->assign('titleblockuse',intval($xoopsModuleConfig["titleblockuse"]));
		$xoopsTpl->assign('h1id',$myts->makeTboxData4Show($xoopsModuleConfig["h1id"]));

		include( XOOPS_ROOT_PATH.'/footer.php' );
		exit();
		}

	$logname = $myts->addSlashes($_POST['username']) ;
	$address = $myts->addSlashes($_POST['usermail']) ;
	$reqterm = $myts->addSlashes($_POST['reqterm']) ;
	$notifypub = !empty($_POST['notifypub']) ? intval($_POST['notifypub']) : 0;
	$user = is_object($xoopsUser) ? $xoopsUser -> getVar ("uid") : 0;
	$date = time();
	$definition = $logname.constant("_MD_{$MYDIRNAME}_DEFINITIONREQ");

	$result = $xoopsDB -> query ( "INSERT INTO $ent_table (entryID, term, proc, init, definition, ref, url, uid, submit, datesub, html, smiley, xcodes, offline, notifypub, request ) VALUES ('', '$reqterm', '', '', '$definition', '', '', '$user', '0', '$date', '0', '0', '0', '0', '$notifypub', '1' )");

	if ( $result )
		{
		$messagesent = constant("_MD_{$MYDIRNAME}_THANKS2")."<br />";
		$reqterm = stripslashes($reqterm);

		if ($xoopsModuleConfig['mailtoadmin'] == 1)
			{
			$adminMessage = sprintf( constant("_MD_{$MYDIRNAME}_WHOASKED"), $logname );
			$adminMessage .= $reqterm."\n";
			$adminMessage .= constant("_MD_{$MYDIRNAME}_EMAILLEFT")." $address\n";
			$adminMessage .= "\n";
			if ($notifypub == '1')
				{
				$adminMessage .= constant("_MD_{$MYDIRNAME}_NOTIFYONPUB");
				}
			$adminMessage .= "\n".$_SERVER["HTTP_USER_AGENT"]."\n";
			$subject = $logname.constant("_MD_{$MYDIRNAME}_DEFINITIONREQ");
			$xoopsMailer =& getMailer();
			$xoopsMailer->useMail();
			$xoopsMailer->setToEmails($xoopsConfig['adminmail']);
			$xoopsMailer->setFromEmail($address);
			$xoopsMailer->setFromName($logname);
			$xoopsMailer->setSubject($subject);
			$xoopsMailer->setBody($adminMessage);
			$xoopsMailer->send();
			$messagesent .= sprintf(constant("_MD_{$MYDIRNAME}_MESSAGESENT"),$xoopsConfig['sitename'])."<br />";
			}

		if ($xoopsModuleConfig['reqreply'] && $address)
			{
			$conf_subject = constant("_MD_{$MYDIRNAME}_THANKS2");
			$userMessage = sprintf(constant("_MD_{$MYDIRNAME}_GOODDAY2"), $logname);
			$userMessage .= "\n\n";
			$userMessage .= sprintf(constant("_MD_{$MYDIRNAME}_THANKYOU"),$reqterm);
			$userMessage .= "\n";
			$userMessage .= sprintf(constant("_MD_{$MYDIRNAME}_REQUESTSENT"),$xoopsConfig['sitename']);
			$userMessage .= "\n\n";
			$userMessage .= "--------------\n";
			$userMessage .= $xoopsConfig['sitename']." ".constant("_MD_{$MYDIRNAME}_WEBMASTER")."\n"; 
			$userMessage .= "e-mail ".$xoopsConfig['adminmail']."";
			$xoopsMailer =& getMailer();
			$xoopsMailer->useMail();
			$xoopsMailer->setToEmails($address);
			$xoopsMailer->setFromEmail($xoopsConfig['adminmail']);
			$xoopsMailer->setFromName($xoopsConfig['sitename']);
			$xoopsMailer->setSubject($conf_subject);
			$xoopsMailer->setBody($userMessage);
			$xoopsMailer->send();
			$messagesent .= sprintf(constant("_MD_{$MYDIRNAME}_SENTCONFIRMMAIL"),$address);
			}
		redirect_header("index.php", 10, $messagesent );
		exit();
		}
	else
		{
		redirect_header("index.php", 10, constant("_MD_{$MYDIRNAME}_ERRORSAVINGDB") );
		exit();
		}
	}
?>