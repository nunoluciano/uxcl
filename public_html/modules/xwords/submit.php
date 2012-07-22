<?php
/**
 * $Id: submit.php v 1.0 8 May 2004 hsalazar Exp $
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

if ( !is_object( $xoopsUser ) || $xoopsModuleConfig['allowsubmit'] == 0 )
	{
	redirect_header( "index.php", 1, _NOPERM );
	exit();
	}

$result = $xoopsDB -> query( "SELECT * FROM $cat_table" );
if ( $xoopsDB -> getRowsNum( $result ) == '0' && $xoopsModuleConfig['multicats'] == '1')
	{
	redirect_header( "index.php", 1, constant("_AM_{$MYDIRNAME}_NOCOLEXISTS") );
	exit();
	}

$op = !empty($_POST['op']) ? trim($_POST['op']) : 'form';
$entryID = !empty($_POST['entryID']) ? intval($_POST['entryID']) : '';

switch ( $op )
	{
	case 'post':

	// Ticket check
	if ( ! $xoopsGTicket->check() )
		{
		redirect_header(XOOPS_URL.'/',3,$xoopsGTicket->getErrors());
		}

	$uid = $xoopsUser -> getVar( 'uid' );
	$html = 0;
	$smiley = $xcodes = $xoopsModuleConfig['dhtmluse'] == '1' ? 1 : 0;
	$breaks = 1;
	$block = !empty( $_POST['block'] ) ? intval( $_POST['block'] ) : 0;
	$notifypub = !empty( $_POST['notifypub'] ) ? intval( $_POST['notifypub'] ) : 0;

//	if ( $xoopsModuleConfig['multicats'] == 1 )
//		{
		$categoryID = intval( $_POST['categoryID'] );
//		} 
//	else
//		{
//		$categoryID = 0;
//		}

	if ( !$_POST['term'] || !$_POST['proc'] )
		{
		$caution = '<ul>';
		$caution .= !$_POST['term'] ? '<li style="color:red;">'.constant("_MD_{$MYDIRNAME}_NOREQTERM").'</li>' : '';
		$caution .= !$_POST['proc'] ? '<li style="color:red;">'.constant("_MD_{$MYDIRNAME}_NOPROC").'</li>' : '';
		$caution .= '</ul>';

		$term = $myts -> stripSlashesGPC(htmlSpecialChars($_POST['term']));
		$proc = $myts -> stripSlashesGPC(htmlSpecialChars($_POST['proc']));
		$definition = $myts -> stripSlashesGPC(htmlSpecialChars( $_POST['definition'] ));
		$ref = $myts -> stripSlashesGPC(htmlSpecialChars( $_POST['ref'] ));
		$url = $myts -> stripSlashesGPC(htmlSpecialChars( $_POST['url'] ));

		$legendname = constant("_MD_{$MYDIRNAME}_SUB_SNEWNAME");

		if ($xoopsUser && $xoopsModuleConfig["autoapprove"] )
			{
			$legenddesc = constant("_MD_{$MYDIRNAME}_SUB_SNEWNAMEDESC3");
			}
		else
			{
			$legenddesc = constant("_MD_{$MYDIRNAME}_SUB_SNEWNAMEDESC4");
			}
		$xoopsOption['template_main'] = "{$mydirname}_submit.html";
		include( XOOPS_ROOT_PATH . '/header.php' );
		include( XOOPS_ROOT_PATH . '/modules/'.$xoopsModule->dirname().'/include/storyform.inc.php' );

		$xoopsTpl -> assign ( 'lang_modulename', $xoopsModule->name() );
		$xoopsTpl -> assign ( 'lang_moduledirname', $xoopsModule->dirname() );
		$xoopsTpl -> assign ( 'lang_legendname', $legendname );
		$xoopsTpl -> assign ( 'lang_legenddesc', $legenddesc );
		$xoopsTpl -> assign ( 'lang_home', constant("_MD_{$MYDIRNAME}_HOME") );
		$xoopsTpl -> assign ( 'lang_caution', $caution);
		$xoopsTpl -> assign ( 'titleblockuse', intval($xoopsModuleConfig["titleblockuse"]) );
		$xoopsTpl -> assign ( 'h1id', $myts -> makeTboxData4Show( $xoopsModuleConfig["h1id"] ) );

		include( XOOPS_ROOT_PATH . '/footer.php' );
		break;
		}

//	$init = $myts -> addSlashes(getInitial($_POST['term'],$_POST['proc']));
	$term = $myts -> addSlashes($_POST['term']);
	$proc = $myts -> addSlashes($_POST['proc']);
	$init = getInitial($term,$proc);
	$proc = getJsortCode($proc);
	$definition = !empty( $_POST['definition'] ) ? $myts -> addSlashes( $_POST['definition'] ) : '';
	$ref = !empty( $_POST['ref'] ) ? $myts -> addSlashes( $_POST['ref'] ) : '';
	$url = !empty( $_POST['url'] ) ? $myts -> addSlashes( $_POST['url'] ) : '';
	$datesub = time();
	$offline = $request = 0;

	if ( $xoopsModuleConfig['autoapprove'] == 1 )
		{
		$submit = 0;
		}
	else
		{
		$submit = 1;
		}

	// Save to database
	if ( !$entryID )
		{
		$entryID = $xoopsDB -> getInsertId();
		$result = $xoopsDB -> query( "INSERT INTO $ent_table (entryID, categoryID, term, proc, init, definition, ref, url, uid, submit, datesub, html, smiley, xcodes, breaks, block, offline, notifypub, request ) VALUES ('', '$categoryID', '$term', '$proc', '$init', '$definition', '$ref', '$url', '$uid', '$submit', '$datesub', '$html', '$smiley', '$xcodes', '$breaks', '$block', '$offline', '$notifypub', '$request')" );
		$xoopsDB->query( "UPDATE ".$xoopsDB->prefix('users')." SET posts=posts+1 WHERE uid='$uid'" ) ;
		}
	else	// That is, $entryID exists, thus were editing an entry
		{
		$result = $xoopsDB -> query( "UPDATE $ent_table SET term = '$term', proc = '$proc', categoryID = '$categoryID', init = '$init', definition = '$definition', ref = '$ref', url = '$url', submit = '$submit', datesub = '$datesub', html = '$html', smiley = '$smiley', xcodes = '$xcodes', breaks = '$breaks', block = '$block', offline = '$offline', notifypub = '$notifypub', request = '$request' WHERE entryID = '$entryID' AND uid = '$uid'" );
		}

	if ( $result )
		{ 
		include_once( XOOPS_ROOT_PATH . '/modules/'.$xoopsModule->dirname().'/entries_write.php' );	//okino
		$username = $xoopsUser->getVar("uname", "E");
		$result = $xoopsDB->query("select email from ".$xoopsDB->prefix("users")." where uname='$username'");
		list($usermail) = $xoopsDB->fetchRow($result);

		if ($xoopsModuleConfig['mailtoadmin'] == 1) 
			{

			$adminMessage = sprintf( constant("_MD_{$MYDIRNAME}_WHOSUBMITTED"), $username );
			$adminMessage .= $term."\n";
			$adminMessage .= constant("_MD_{$MYDIRNAME}_EMAILLEFT")." $usermail\n";
			$adminMessage .= "\n";
			if ($notifypub == '1')
				{
				$adminMessage .= constant("_MD_{$MYDIRNAME}_NOTIFYONPUB");
				}
			$adminMessage .= "\n".$_SERVER["HTTP_USER_AGENT"]."\n";
			$subject = $xoopsConfig['sitename']." - ".constant("_MD_{$MYDIRNAME}_DEFINITIONSUB");
			$xoopsMailer =& getMailer();
			$xoopsMailer->useMail();
			$xoopsMailer->setToEmails($xoopsConfig['adminmail']);
			$xoopsMailer->setFromEmail($usermail);
			$xoopsMailer->setFromName($username);
			$xoopsMailer->setSubject($subject);
			$xoopsMailer->setBody($adminMessage);
			$xoopsMailer->send();
			$messagesent = sprintf(constant("_MD_{$MYDIRNAME}_MESSAGESENT"),$xoopsConfig['sitename'])."<br />".constant("_MD_{$MYDIRNAME}_THANKS1");
			}

		if ( $xoopsModuleConfig['autoapprove'] == 1 )
			{
			redirect_header( "index.php", 2, constant("_MD_{$MYDIRNAME}_RECEIVEDANDAPPROVED") );
			}
		else
			{
			redirect_header( "index.php", 2, constant("_MD_{$MYDIRNAME}_RECEIVED") );
			}
		}
	else
		{
		redirect_header( "submit.php", 2, constant("_MD_{$MYDIRNAME}_ERRORSAVINGDB") );
		}
	break;

	case 'form':
	default:

	$entryID = !empty($_GET['entryID']) ? intval($_GET['entryID']) : '';
	$uid = $xoopsUser -> getVar( 'uid' );
	if ( $entryID )
		{
		$result = $xoopsDB -> query( "SELECT categoryID, term, proc, definition, ref, url, uid, submit, datesub, html, smiley, xcodes, breaks, block, offline, notifypub, request FROM $ent_table WHERE entryID = '$entryID' AND uid = '$uid'" );
		list( $categoryID, $term, $proc, $definition, $ref, $url, $uid, $submit, $datesub, $html, $smiley, $xcodes, $breaks, $block, $offline, $notifypub, $request ) = $xoopsDB -> fetchrow( $result );

		if ( !$xoopsDB -> getRowsNum( $result ) )
			{
			redirect_header( "index.php", 1, _NOPERM );
			}

		$term = $myts -> htmlSpecialChars($term);
		if ($proc)
			{
			list($temp,$proc) = explode(",",$proc);
			}
		$proc = $myts -> htmlSpecialChars($proc);
		$definition = $myts -> htmlSpecialChars($definition);
		$url = $myts -> htmlSpecialChars($url);
		$ref = $myts -> htmlSpecialChars($ref);
		$block = intval($block);
		$legendname = constant("_MD_{$MYDIRNAME}_SUB_SEDITNAME");

		if ($xoopsUser && $xoopsModuleConfig["autoapprove"] )
			{
			$legenddesc = constant("_MD_{$MYDIRNAME}_SUB_SNEWNAMEDESC1");
			}
		else
			{
			$legenddesc = constant("_MD_{$MYDIRNAME}_SUB_SNEWNAMEDESC2");
			}
	      $xoopsTpl -> assign ( 'entryID', $entryID ); //okino
		}
	else // therez no parameter, so were adding an entry
		{
		$categoryID = 0;
		$block = $notifypub = 0;
		$term = $proc = $definition = $ref = $url = '';
		$legendname = constant("_MD_{$MYDIRNAME}_SUB_SNEWNAME");

		if ($xoopsUser && $xoopsModuleConfig["autoapprove"] )
			{
			$legenddesc = constant("_MD_{$MYDIRNAME}_SUB_SNEWNAMEDESC3");
			}
		else
			{
			$legenddesc = constant("_MD_{$MYDIRNAME}_SUB_SNEWNAMEDESC4");
			}
		}

	$xoopsOption['template_main'] = "{$mydirname}_submit.html";
	include( XOOPS_ROOT_PATH . '/header.php' );
	include( XOOPS_ROOT_PATH . '/modules/'.$xoopsModule->dirname().'/include/storyform.inc.php' );

	$xoopsTpl -> assign ( 'lang_modulename', $xoopsModule->name() );
	$xoopsTpl -> assign ( 'lang_moduledirname', $xoopsModule->dirname() );
	$xoopsTpl -> assign ( 'lang_legendname', $legendname );
	$xoopsTpl -> assign ( 'lang_legenddesc', $legenddesc );
	$xoopsTpl -> assign ( 'lang_home', constant("_MD_{$MYDIRNAME}_HOME") );
	$xoopsTpl -> assign ( 'titleblockuse', intval($xoopsModuleConfig["titleblockuse"]) );
	$xoopsTpl -> assign ( 'h1id', $myts -> makeTboxData4Show( $xoopsModuleConfig["h1id"] ) );

	include( XOOPS_ROOT_PATH . '/footer.php' );
	break;
	}
exit();
?>
