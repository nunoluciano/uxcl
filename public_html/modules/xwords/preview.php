<?php
//  ------------------------------------------------------------------------ //
//  This program is free software; you can redistribute it and/or modify     //
//  it under the terms of the GNU General Public License as published by     //
//  the Free Software Foundation; either version 2 of the License, or        //
//  (at your option) any later version.                                      //
//                                                                           //
//  You may not change or alter any portion of this comment or credits       //
//  of supporting developers from this source code or any supporting         //
//  source code which is considered copyrighted (c) material of the          //
//  original comment or credit authors.                                      //
//                                                                           //
//  This program is distributed in the hope that it will be useful,          //
//  but WITHOUT ANY WARRANTY; without even the implied warranty of           //
//  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the            //
//  GNU General Public License for more details.                             //
//                                                                           //
//  You should have received a copy of the GNU General Public License        //
//  along with this program; if not, write to the Free Software              //
//  Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307 USA //
//  ------------------------------------------------------------------------ //
// XOOPS2 - Xwords 0.42
// WEBMASTER @ KANPYO.NET, 2005.

include "./header.php";
global $xoopsUser;

if ( !is_object( $xoopsUser ) )
	{
	redirect_header( "index.php", 1, _NOPERM );
	exit();
	}

$entryID = !empty($_POST['entryID']) ? intval($_POST['entryID']) : 0;
$html = !empty($_POST['html']) ? intval($_POST['html']) : 0;
$smiley = !empty($_POST['smiley']) ? intval($_POST['smiley']) : 0;
$xcodes = !empty($_POST['xcodes']) ? intval($_POST['xcodes']) : 0;
$breaks = !empty($_POST['breaks']) ? intval($_POST['breaks']) : 0;
$definition = !empty($_POST['definition']) ? trim($_POST['definition']) : '';

if ( !$xoopsModuleConfig['linktermsposition'] )
	{
	$definition = $myts->previewTarea( $definition, $html, $smiley, $xcodes, 1, $breaks );
	$linkedterms = $myts->getAutoLinkTerms( $definition, intval($html), $mydirname, $entryID, 0 );
	}
else
	{
	$definition = $myts->previewTarea( $definition, $html, $smiley, $xcodes, 1, $breaks, $mydirname, $entryID );
	}

$term = !empty($_POST['term']) ? $myts->stripSlashesGPC(htmlSpecialChars( $_POST['term'] ) ) : constant("_MD_{$MYDIRNAME}_PREVIEW_NOTERM");
$proc = !empty($_POST['proc']) ? $myts->stripSlashesGPC(htmlSpecialChars( $_POST['proc'] ) ) : constant("_MD_{$MYDIRNAME}_PREVIEW_NOPROC");
$ref = !empty($_POST['ref']) ? $myts->stripSlashesGPC(htmlSpecialChars($_POST['ref']) ) : '';
$url = !empty($_POST['url']) ? $myts->makeClickable(formatURL($myts->stripSlashesGPC(htmlSpecialChars($_POST['url']) )), $allowimage = 0) : '';

// Various strings
$xoopsOption['template_main'] = "{$mydirname}_preview.html";
include_once( XOOPS_ROOT_PATH . '/header.php' );

$xoopsTpl -> assign ( 'lang_modulename', $xoopsModule->name() );
$xoopsTpl -> assign ( 'lang_moduledirname', $xoopsModule->dirname() );
$xoopsTpl -> assign ( 'lang_home', constant("_MD_{$MYDIRNAME}_HOME") );
$xoopsTpl -> assign ( 'lang_rubyl', constant("_MD_{$MYDIRNAME}_RUBYL") );
$xoopsTpl -> assign ( 'lang_rubyr', constant("_MD_{$MYDIRNAME}_RUBYR") );
$xoopsTpl -> assign ( 'lang_entref', constant("_MD_{$MYDIRNAME}_ENTRYREFERENCE") );
$xoopsTpl -> assign ( 'lang_enturl', constant("_MD_{$MYDIRNAME}_ENTRYRELATEDURL") );
$xoopsTpl -> assign ( 'lang_previewdsc', constant("_MD_{$MYDIRNAME}_PREVIEW_DSC") );
$xoopsTpl -> assign ( 'lang_close', constant("_MD_{$MYDIRNAME}_PREVIEW_CLOSE") );
$xoopsTpl -> assign ( 'lang_linkedterms', $myts -> makeTboxData4Show( $xoopsModuleConfig['linktermstitle'] ) );
$xoopsTpl -> assign ( 'definition', $definition );
$xoopsTpl -> assign ( 'linkedterms', $linkedterms );
$xoopsTpl -> assign ( 'term', $term );
$xoopsTpl -> assign ( 'proc', $proc );
$xoopsTpl -> assign ( 'ref', $ref );
$xoopsTpl -> assign ( 'url', $url );
$xoopsTpl -> assign ( 'titleblockuse', intval($xoopsModuleConfig["titleblockuse"]) );
$xoopsTpl -> assign ( 'h1id', $myts -> makeTboxData4Show( $xoopsModuleConfig["h1id"] ) );
$xoopsTpl -> assign ( 'linkterms', intval($xoopsModuleConfig['linkterms']) );
$xoopsTpl -> assign ( 'linktermsposition', intval($xoopsModuleConfig['linktermsposition']) );

include_once( XOOPS_ROOT_PATH.'/footer.php' );
?>