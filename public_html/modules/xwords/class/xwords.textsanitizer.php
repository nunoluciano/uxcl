<?php
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
// XOOPS2 - Xwords 0.46
// WEBMASTER @ KANPYO.NET, 2006.


if( ! class_exists( 'XwordsTextSanitizer' ) )
	{
	include_once( XOOPS_ROOT_PATH . '/class/module.textsanitizer.php' ) ;

	class XwordsTextSanitizer extends MyTextSanitizer
		{
		/*
		* Constructor of this class
		*
		* Gets allowed html tags from admin config settings
		* <br> should not be allowed since nl2br will be used
		* when storing data.
		*
		* @access	private
		*
		* @todo Sofar, this does nuttin ;-)
		*/
		function XwordsTextSanitizer()
			{
   			parent::MyTextSanitizer();
			}

		/**
		 * Access the only instance of this class
		*
		* @return	object
		*
		* @static
		* @staticvar   object
		*/
		function &getInstance()
			{
			static $instance;
			if (!isset($instance))
				{
				$instance = new XwordsTextSanitizer();
				}
			return $instance;
			}

		/**
		 * Filters textarea form data in DB for display
		 *
		 * @param   string  $text
		 * @param   bool    $html		allow html?
		 * @param   bool    $smiley		allow smileys?
		 * @param   bool    $xcode		allow xoopscode?
		 * @param   bool    $image		allow inline images?
		 * @param   bool    $br			convert linebreaks?
		 * @param   string  $mod_dir	module dirname
		 * @param   string  $id
		 * @return  string
		 **/
		function &displayTarea( $text, $html = 0, $smiley = 1, $xcode = 1, $image = 1, $br = 1, $mod_dir = "", $id = 0 )
			{
			if ($mod_dir)
				{
            			$text = $this->prepareXcode( $text ); //okino
            			$text = $this->postCodeDecode( parent::displayTarea( $text, $html, $smiley, 1, $image, $br ), $image ); //okino
			//okino	$text = $this->getAutoLinkTerms($text,$html,$mod_dir,$id);
				$html = 1;
				}

			if ($xcode)
				{
            			$text = $this->prepareXcode( $text ); //okino
            			$text = $this->postCodeDecode( parent::displayTarea( $text, $html, $smiley, 1, $image, $br ), $image ); //okino
				}
			//okino	$text = parent::displayTarea( $text , $html , $smiley , $xcode , $image , $br ) ;
			return $text;
			}

		/**
		 * Filters textarea form data submitted for preview
		 *
		 * @param   string  $text
		 * @param   bool    $html   allow html?
		 * @param   bool    $smiley allow smileys?
		 * @param   bool    $xcode  allow xoopscode?
		 * @param   bool    $image  allow inline images?
		 * @param   bool    $br     convert linebreaks?
		 * @return  string
		 **/
		function previewTarea( $text, $html = 0, $smiley = 1, $xcode = 1, $image = 1, $br = 1, $mod_dir = "", $id = 0 )
			{
			if ($mod_dir)
				{
            			$text = $this->prepareXcode( $text ); //okino
            			$text = $this->postCodeDecode( parent::displayTarea( $text, $html, $smiley, 1, $image, $br ), $image ); //okino
			//okino	$text = $this->getAutoLinkTerms($text,$html,$mod_dir,$id);
				$html = 1;
				}

			if ($xcode)
				{
            			$text = $this->prepareXcode( $text ); //okino
            			$text = $this->postCodeDecode( parent::displayTarea( $text, $html, $smiley, 1, $image, $br ), $image ); //okino
				}
			//okino	$text = parent::displayTarea( $text , $html , $smiley , $xcode , $image , $br ) ;
			return $text;
			}

//okino added from
    function prepareXcode( $text )
    {
        $patterns = array(
            '#\n?\[code\]\r?\n?#' ,
            '#\n?\[\/code\]\r?\n?#' ,
            '#\n?\[quote\]\r?\n?#' ,
            '#\n?\[\/quote\]\r?\n?#' ,
        ) ;
        $replacements = array(
            '[code]' ,
            '[/code]' ,
            '[quote]' ,
            '[/quote]' ,
        ) ;
        return preg_replace( $patterns, $replacements, $text );
    }

    function postCodeDecode( $text, $image )
    {
        $patterns = array();
        $replacements = array();

        // [siteimg]
        $patterns[] = "/\[siteimg align=(['\"]?)(left|center|right)\\1]([^\"\(\)\?\&'<>]*)\[\/siteimg\]/sU";
        $patterns[] = "/\[siteimg]([^\"\(\)\?\&'<>]*)\[\/siteimg\]/sU";
        if( $image ) {
            $replacements[] = '<img src="'.XOOPS_URL.'/\\3" align="\\2" alt="" />';

            $replacements[] = '<img src="'.XOOPS_URL.'/\\1" alt="" />';
        } else {
            $replacements[] = '<a href"'.XOOPS_URL.'/\\3" target="_blank">'.XOOPS_URL.'/\\3</a>';
            $replacements[] = '<a href"'.XOOPS_URL.'/\\1" target="_blank">'.XOOPS_URL.'/\\1</a>';
        }
        return preg_replace($patterns, $replacements, $text);
    }
//okino added to

		/**
		 *
		 *
		 * @param   string  $text
		 * @param   bool    $html		allow html?
		 * @param   string  $mod_dir
		 * @param   string  $id
		 * @return  string
		 **/
		function getAutoLinkTerms( $text, $html, $mod_dir = "", $id = 0, $addtext = 1 )
			{
			$modulelist = array();
			$queryarray = array();
			$glossaryterms = array();

			$modulelist = $this->getModulesList(intval($this->getModuleConfig()));
			$queryarray = $this->getSearchWordList($modulelist,$text);
			$glossaryterms = $this->getTermList($modulelist,$queryarray,$mod_dir,$id,intval($this->getModuleConfig()));
			$text = $this->getLinkedText($text,$glossaryterms,$html,$addtext);
//			print_r($queryarray);
//			print_r($glossaryterms);

			if ( !$addtext || $text )
				{
				$text = parent::displayTarea( $text,1,1,1,1,0 );
				}

			return $text;
			}


		/**
		 *
		 *
		 * @param   string  $text
		 * @param   array   $glossaryterms
		 * @param   bool    $html			allow html?
		 * @return  string
		 **/
		function getLinkedText( $text, $glossaryterms, $html ,$addtext )
			{
			#### matching ####
			$count = 0;
			$count = count( $glossaryterms );
			if ($count > 0 && is_array($glossaryterms))
				{
				if (!$html)
					{
					$text = parent::htmlSpecialChars( $text );
					}
				$q_arr = array();
				$parts = array();
				$text2 = array();
				$text3 = "";
				list($spatternf,$spatterne) = explode(",",$this->getModuleConfig("spattern"));
				$parts = explode(">", $text);
				foreach($parts as $key=>$part)
					{
					for ( $i = 0; $i < $count; $i++ )
						{
						foreach($glossaryterms[$i]['list'] as $md)
							{
							$q_arr1 = array();
							$q_arr2 = array();
							$q_arr3 = array();
							$search_term = array();
							$replace_term = $pattern = "";
							$title = $md['title'];
							if (!$md['title'])
								{
								continue;
								}
							if (!$html)
								{
								$title = $md['title'] = parent::htmlSpecialChars( $md['title'] );
								}
							if (!$md['image'])
								{
								$image_url = XOOPS_URL.'/images/icons/posticon2.gif';
								}
							else
								{
								$image_url = XOOPS_URL."/modules/".$glossaryterms[$i]['mod']."/".$md['image'];
								}
							$title = '<a href="'.XOOPS_URL.'/modules/'.$glossaryterms[$i]['mod'].'/'.$md['link'].'" title="'.parent::makeTboxData4Show($this->getModuleConfig("linktermstitle")).$glossaryterms[$i]['name'].'"><img src="'.$image_url.'" width="21" height="21" alt="'.parent::makeTboxData4Show($this->getModuleConfig("linktermstitle")).$glossaryterms[$i]['name'].'" />'.$title.'</a>';
							$md['title'] = preg_quote($md['title'],"/");
//							if (_CHARSET =="EUC-JP")
							if ($spatternf && $spatterne)
								{
//								$search_term[] = $pattern = "/(\xA1[\xAE\xC6\xC8\xCC\xCE\xD0\xD2\xD4\xD6\xD8\xDA])(".$md['title'].")(\xA1[\xAD\xC7\xC9\xCD\xCF\xD1\xD3\xD5\xD7\xD9\xDB])/i";
								$search_term[] = $pattern = "/($spatternf)(".$md['title'].")($spatterne)/i";
								if (preg_match($pattern,$parts[$key]))
									{
									$text2[] = $title;
									}
								}
							if (preg_match('/^[\x20-\x7e]+$/',$md['title']))
								{
								$md['title'] = $md['title']."|".$md['title']."s|".$md['title']."es";
								$search_term[] = $pattern = "/([\'\\\"`]|&quot;|&#039;)(".$md['title'].")(\\1)/i";
								if (preg_match($pattern,$parts[$key]))
									{
									$text2[] = $title;
									}
								}
							if ($this->getModuleConfig("linktermsposition"))
								{
//								$replace_term = '<a href="'.XOOPS_URL.'/modules/'.$glossaryterms[$i]['mod'].'/'.$md['link'].'"><img src="'.$image_url.'" width="21" height="21" alt="'.parent::makeTboxData4Show($this->getModuleConfig("linktermstitle")).$glossaryterms[$i]['name'].'" /></a>$1$2$3';
								$replace_term = '<a href="'.XOOPS_URL.'/modules/'.$glossaryterms[$i]['mod'].'/'.$md['link'].'"><img src="'.$image_url.'" width="21" height="21" alt="'.parent::makeTboxData4Show($this->getModuleConfig("linktermstitle")).$glossaryterms[$i]['name'].'" />$2</a>';
								$parts[$key] = preg_replace($search_term, $replace_term, $parts[$key]);
								}
							}
						}
					}
				$text = implode(">", $parts);
				$text2 = array_unique($text2);
				if ( $addtext )
					{
					$text3 = implode("&nbsp;&nbsp;", $text2);
					$text3 = ( $text3 != "" && !$this->getModuleConfig("linktermsposition")) ? "\n<p style='clear:both;margin:4em 0em 0em 0em;'>".parent::makeTboxData4Show($this->getModuleConfig("linktermstitle")).$text3."</p>" : "";
					$text = $text.$text3;
					}
				else
					{
					$text = implode("&nbsp;&nbsp;", $text2);
					}
				}
			elseif ( !$addtext )
				{
				$text = "";
				}

			return $text;
			}


		/**
		 *
		 *
		 * @param   array   $modulelist
		 * @param   string  $text
		 * @return  array
		 **/
		function getSearchWordList( $modulelist, $text )
			{
			$q_arr = array();
			$q_arr1 = array();
			$q_arr2 = array();
			$queryarray = array();
			list($spatternf,$spatterne) = explode(",",$this->getModuleConfig("spattern"));

			foreach ($modulelist as $mid=>$mod)
				{
				if (function_exists( $mod . "_xwords_StripCodes"))
					{
					$text = call_user_func($mod."_xwords_StripCodes",$text);
					}
				}

			$text = $this->StripXcodes( $text ) ;
			$text = $this->postCodeDecode($text,1) ;
			$text = strip_tags(parent::displayTarea($text,1,1,1,1,0));
			$count = 0;
			if (preg_match_all('/([\'\"`])(.+?)\\1/',$text,$q_arr1))
				{
				if ( is_array($q_arr1[2]) && $count = count($q_arr1[2]) )
					{
					for ( $i = 0; $i < $count; $i++ )
						{
						if (preg_match('/(^[0-9A-Za-z]{3,})s$/i',$q_arr1[2][$i]))
							{
							$q_arr1[2][] = preg_replace('/(^[[:alnum:]]{3,})s$/i', "$1", $q_arr1[2][$i]);
							$q_arr1[2][] = preg_replace('/(^[[:alnum:]]{3,})es$/i', "$1", $q_arr1[2][$i]);
							}
						}
					}		
				}
//			if (_CHARSET =="EUC-JP")
			if ($spatternf && $spatterne)
				{
//				preg_match_all('/\xA1[\xAE\xC6\xC8\xCC\xCE\xD0\xD2\xD4\xD6\xD8\xDA](.+?)\xA1[\xAD\xC7\xC9\xCD\xCF\xD1\xD3\xD5\xD7\xD9\xDB]/',$text,$q_arr2);
				preg_match_all("/$spatternf(.+?)$spatterne/",$text,$q_arr2);
				}
			$q_arr = array_unique(array_merge($q_arr1[2],$q_arr2[1]));
			sort($q_arr);
			reset($q_arr);

			$count = 0;
			if ( is_array($q_arr) && $count = count($q_arr) )
				{
				for ( $i = 0; $i < $count; $i++ )
					{
					if (preg_match('/\\\\/',$q_arr[$i]))
						{
						$q_arr[$i] = addslashes($q_arr[$i]);
						}
					$queryarray[] = addslashes($q_arr[$i]);
					}
				}
			return $queryarray;
			}


		/**
		 *
		 *
		 * @return  array
		 **/
		function getModulesList()
			{
			global $xoopsUser;

			$groups = array();
			$mids = array();
			$modulelist = array();

			$gperm_handler = & xoops_gethandler( 'groupperm' );
			$groups = ( $xoopsUser ) ? $xoopsUser -> getGroups() : array(XOOPS_GROUP_ANONYMOUS);

			$module_handler =& xoops_gethandler('module');
			$criteria = new CriteriaCompo(new Criteria('hassearch', 1));
			$criteria->add(new Criteria('isactive', 1));
			$mids =& array_keys($module_handler->getList($criteria));

			#### plugin load ####
			foreach ($mids as $mid)
				{
				if ( $gperm_handler->checkRight('module_read', $mid, $groups))
					{
					$module =& $module_handler->get($mid);
					$mod = $module->getVar('dirname') ;

					$mod_plugin_file = XOOPS_ROOT_PATH."/modules/$mod/include/myxwords.plugin.php";
					if( file_exists($mod_plugin_file) && intval($this->getModuleConfig()) >= 1 && !function_exists( $mod . "_xwords_autolink") )
						{
						include_once($mod_plugin_file);
						$modulelist[$mid] = $mod;
						continue;
						}

					$mod_plugin_file = XOOPS_ROOT_PATH."/modules/$mod/include/xwords.plugin.php";
					if( file_exists($mod_plugin_file) && intval($this->getModuleConfig()) >= 2 && !function_exists( $mod . "_xwords_autolink") )
						{
						include_once($mod_plugin_file);
						$modulelist[$mid] = $mod;
						continue;
						}

					$mydirname = basename( dirname( dirname( __FILE__ ) ) ) ;
					$mod_plugin_file = XOOPS_ROOT_PATH."/modules/$mydirname/plugins/{$mod}.plugin.php";
					if ( intval($this->getModuleConfig()) >= 2 && file_exists($mod_plugin_file) && !function_exists( $mod . "_xwords_autolink") )
						{
						include_once($mod_plugin_file);
						$modulelist[$mid] = $mod;
						continue;
						}

					if ( intval($this->getModuleConfig()) >= 3 )
						{
						$modulelist[$mid] = $mod;
						}
					}
				}
			return $modulelist;
			}


		/**
		 *
		 *
		 * @param   array   $modulelist
		 * @param   array   $queryarray
		 * @param   string  $mod_dir
		 * @param   string  $id
		 * @return  array
		 **/
		function getTermList( $modulelist, $queryarray, $mod_dir, $id )
			{
			$glossaryterms = array();
			$count = 0;
			if ( is_array($queryarray) && $count = count($queryarray) )
				{
				#### get match words list ####
				$module_handler =& xoops_gethandler('module');
				$i = 0;
				foreach ($modulelist as $mid=>$mod)
					{
					$module =& $module_handler->get($mid);
					$glossaryID = ($mod == $mod_dir) ? $id : 0;
					if (function_exists( $mod . "_xwords_autolink"))
						{
						$glossaryterms[$i]['mod'] = $mod;
						$glossaryterms[$i]['name'] = $module->getVar('name');
						$glossaryterms[$i]['list'] = call_user_func($mod."_xwords_autolink",$queryarray,$glossaryID);
						$i++;
						continue;
						}

					if ( intval($this->getModuleConfig()) >= 3 )
						{
						$glossaryterms[$i]['mod'] = $mod;
						$glossaryterms[$i]['name'] = $module->getVar('name');
						$glossaryterms[$i]['list'] = & $module->search($queryarray, 'OR', 0, 0, 0);
						$i++;
						}
					}
				unset($module);
				}
			return $glossaryterms;
			}


		/**
		 * Strip some appendix code
		 *
		 * @param   string  $text
		 * @return  string
		 **/
		function StripXcodes( $text )
			{
			$patterns = array();
			$replacements = '';

			$patterns[] = "/\[siteimg.*?\].*\[\/siteimg\]/sU";
			$patterns[] = "/\[flash\].*\[\/flash\]/sU";
			$patterns[] = "/\[img.*?\].*\[\/img\]/sU";

			return preg_replace($patterns, $replacements, $text);
			}



		/**
		 *
		 *
		 * @return  string
		 **/
		function getModuleConfig($confname="linkterms")
			{
			$mydirname = basename( dirname( dirname( __FILE__ ) ) ) ;
			$hModule =& xoops_gethandler('module');
			$hModConfig =& xoops_gethandler('config');
			$xwModule =& $hModule->getByDirname("$mydirname");
			$module_id = $xwModule -> getVar( 'mid' );
			$xwConfig =& $hModConfig->getConfigsByCat(0, $xwModule->getVar('mid'));

			return $xwConfig["$confname"];
			}


		// The End of Class
		}
	}
?>