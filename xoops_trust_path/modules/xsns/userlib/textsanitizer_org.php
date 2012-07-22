<?php
// $Id: module.textsanitizer.php,v 1.8 2006/07/27 00:17:17 onokazu Exp $
//  ------------------------------------------------------------------------ //
//                XOOPS - PHP Content Management System                      //
//                    Copyright (c) 2000 XOOPS.org                           //
//                       <http://www.xoops.org/>                             //
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


require_once XOOPS_ROOT_PATH.'/class/module.textsanitizer.php';

define('XSNS_URL_LENGTH_MAX', 55);


class XsnsTextSanitizer extends MyTextSanitizer
{
//	var $url_len_max = XSNS_URL_LENGTH_MAX;
	
	function &getInstance()
	{
		static $instance;
		if (!isset($instance)) {
			$instance = new XsnsTextSanitizer();
		}
		return $instance;
	}
	
	function codePreConv($text, $xcode = 1)
	{
		return $text;
	}
	
    function codeConv($text, $xcode = 1, $image = 1)
    {
		return $text;
	}
	
	function &xoopsCodeDecode(&$text, $allowimage = 1)
	{
		$patterns = array();
		$replacements = array();
		
		$patterns[] = "/\[color=(['\"]?)([a-zA-Z0-9]*)\\1](.*)\[\/color\]/sU";
		$replacements[] = '<span style="color: #\\2;">\\3</span>';
		$patterns[] = "/\[size=(['\"]?)([a-z0-9-]*)\\1](.*)\[\/size\]/sU";
		$replacements[] = '<span style="font-size: \\2;">\\3</span>';
		$patterns[] = "/\[font=(['\"]?)([^;<>\*\(\)\"']*)\\1](.*)\[\/font\]/sU";
		$replacements[] = '<span style="font-family: \\2;">\\3</span>';
		$patterns[] = "/\[b](.*)\[\/b\]/sU";
		$replacements[] = '<b>\\1</b>';
		$patterns[] = "/\[i](.*)\[\/i\]/sU";
		$replacements[] = '<i>\\1</i>';
		$patterns[] = "/\[u](.*)\[\/u\]/sU";
		$replacements[] = '<u>\\1</u>';
		$patterns[] = "/\[d](.*)\[\/d\]/sU";
		$replacements[] = '<del>\\1</del>';
		
		$ret = preg_replace($patterns, $replacements, $text);
		return $ret;
	}
	
	function stripXoopsCode(&$text)
	{
		$patterns = array();
		$replacements = array();
		
		$patterns[] = "/\[color=(['\"]?)([a-zA-Z0-9]*)\\1](.*)\[\/color\]/sU";
		$replacements[] = '\\3';
		$patterns[] = "/\[size=(['\"]?)([a-z0-9-]*)\\1](.*)\[\/size\]/sU";
		$replacements[] = '\\3';
		$patterns[] = "/\[font=(['\"]?)([^;<>\*\(\)\"']*)\\1](.*)\[\/font\]/sU";
		$replacements[] = '\\3';
		$patterns[] = "/\[b](.*)\[\/b\]/sU";
		$replacements[] = '\\1';
		$patterns[] = "/\[i](.*)\[\/i\]/sU";
		$replacements[] = '\\1';
		$patterns[] = "/\[u](.*)\[\/u\]/sU";
		$replacements[] = '\\1';
		$patterns[] = "/\[d](.*)\[\/d\]/sU";
		$replacements[] = '\\1';
		
		$ret = preg_replace($patterns, $replacements, $text);
		$ret = $this->breakLongHalfString($ret);
		
		return $this->htmlSpecialChars($ret);
	}
	
	function breakLongHalfString($text)
	{
		$url_pattern = "/[-_.!~*'()a-zA-Z0-9;\/?:@&=+$,%#]{45}/i";
		$url_replacement = "\\0\n";
		return preg_replace($url_pattern, $url_replacement, $text);
	}
/*	
	function &makeClickable(&$text)
	{
		$patterns = array();
		$replacements = array();
		
		$patterns[] = "/(^|[^]_a-z0-9-=\"'\/])([a-z]+?):\/\/([^, \r\n\"\(\)'<>]+)/i";
		$replacements[] = array(&$this, '_callback_replace_link');
//		  $replacements[] = "\\1<a href=\"\\2://\\3\" target=\"_blank\">\\2://\\3</a>";

		$patterns[] = "/(^|[^]_a-z0-9-=\"'\/])www\.([a-z0-9\-]+)\.([^, \r\n\"\(\)'<>]+)/i";
		$replacements[] = array(&$this, '_callback_replace_http');
//		  $replacements[] = "\\1<a href=\"http://www.\\2.\\3\" target=\"_blank\">www.\\2.\\3</a>";

		$patterns[] = "/(^|[^]_a-z0-9-=\"'\/])ftp\.([a-z0-9\-]+)\.([^, \r\n\"\(\)'<>]+)/i";
		$replacements[] = array(&$this, '_callback_replace_ftp');
//		  $replacements[] = "\\1<a href=\"ftp://ftp.\\2.\\3\" target=\"_blank\">ftp.\\2.\\3</a>";

		$patterns[] = "/(^|[^]_a-z0-9-=\"'\/:\.])([a-z0-9\-_\.]+?)@([^, \r\n\"\(\)'<>\[\]]+)/i";
		$replacements[] = array(&$this, '_callback_replace_mailto');
//		  $replacements[] = "\\1<a href=\"mailto:\\2@\\3\">\\2@\\3</a>";
		
		for($i=0; $i<count($patterns); $i++){
			$text = preg_replace_callback($patterns[$i], $replacements[$i], $text);
		}
		return $text;
	}
	
	function _callback_replace_link($matches)
	{
		$url = $matches[2]."://".$matches[3];
		$dot = (strlen($url) > $this->url_len_max) ? "..." : "";
		return $matches[1]."<a href=\"".$url."\" target=\"_blank\">".substr($url, 0, $this->url_len_max).$dot."</a>";
	}
	
	function _callback_replace_http($matches)
	{
		$url = "www.".$matches[2].".".$matches[3];
		$dot = (strlen($url) > $this->url_len_max) ? "..." : "";
		return $matches[1]."<a href=\"http://".$url."\" target=\"_blank\">".substr($url, 0, $this->url_len_max).$dot."</a>";
	}
	
	function _callback_replace_ftp($matches)
	{
		$url = "ftp.".$matches[2].".".$matches[3];
		$dot = (strlen($url) > $this->url_len_max) ? "..." : "";
		return $matches[1]."<a href=\"ftp://".$url."\" target=\"_blank\">".substr($url, 0, $this->url_len_max).$dot."</a>";
	}

	function _callback_replace_mailto($matches)
	{
		$url = $matches[2]."@".$matches[3];
		$dot = (strlen($url) > $this->url_len_max) ? "..." : "";
		return $matches[1]."<a href=\"mailto:".$url."\">".substr($url, 0, $this->url_len_max).$dot."</a>";
	}
*/
}

?>