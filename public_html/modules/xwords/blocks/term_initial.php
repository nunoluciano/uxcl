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

if( ! defined( 'XOOPS_ROOT_PATH' ) ) exit ;
$mydirname = basename( dirname( dirname( __FILE__ ) ) ) ;

eval( '
	function '.$mydirname.'_b_entries_initial_show()
		{
		return xwords_b_entries_initial_show_base( "'.$mydirname.'" ) ;
		}
' ) ;


if( ! function_exists( 'xwords_b_entries_initial_show_base' ) )
	{
	function xwords_b_entries_initial_show_base( $mydirname )
		{
		$MYDIRNAME = strtoupper($mydirname);
		$xoopsDB =& Database::getInstance();
		$cat_table = $xoopsDB -> prefix ("{$mydirname}_cat") ;
		$ent_table = $xoopsDB -> prefix ("{$mydirname}_ent") ;

		global $xoopsConfig,$xoopsUser;

		$hModule =& xoops_gethandler('module');
		$hModConfig =& xoops_gethandler('config');
		$xwModule =& $hModule->getByDirname("$mydirname");
		$module_id = $xwModule -> getVar( 'mid' );
		$module_name = $xwModule -> getVar( 'dirname' );
		$xwConfig =& $hModConfig->getConfigsByCat(0, $xwModule->getVar('mid'));

		// include the default language file for the module interface
		if ( file_exists( XOOPS_ROOT_PATH . "/modules/$mydirname/language/" . $xoopsConfig['language'] . "/" . $xwConfig['letterformat']) )
			{
			include (XOOPS_ROOT_PATH . "/modules/$mydirname/language/" . $xoopsConfig['language'] . "/" . $xwConfig['letterformat'] );
			}
		else
			{
			include (XOOPS_ROOT_PATH . "/modules/$mydirname/language/japanese/letter.php");
			}

		$block = array();
		$letterlinks = array();
		$data = array();

		for ($n=0; $n < count($mb_id); $n++)
			{
			$data[$mb_linktext[$n]] = 0;
			}

		$result = $xoopsDB->query("SELECT init,COUNT(*) FROM $ent_table WHERE datesub < '".time()."' AND datesub > '0' AND submit = '0' AND offline = '0' AND request = '0' GROUP BY BINARY init");
		while($temp = $xoopsDB->fetchArray($result))
			{
			$data[$temp['init']] = $temp['COUNT(*)'];
			for ($n=0; $n < count($mb_id); $n++)
				{
				//if (ereg($mb_init[$n], $temp['init']))
				if (preg_match('/'.$mb_init[$n].'/', $temp['init']))
					{
					$data[$mb_linktext[$n]] = $temp['COUNT(*)'] + $data[$mb_linktext[$n]];
					}
				}
			}

//		print_r($data);

		for ($n=0; $n < count($mb_init); $n++)
			{
			if (isset($data[$mb_linktext[$n]]))
				{
				$letterlinks['total'] = $data[$mb_linktext[$n]];
				}
			else
				{
				$letterlinks['total'] = 0;
				}

			$letterlinks['id'] = $mb_id[$n];
			$letterlinks['linktext'] = $mb_linktext[$n];
			$letterlinks['separator'] = $mb_separator[$n];

			$block['initstuff'][] = $letterlinks;
			}
		$block['moduledirname'] = $mydirname;

		return $block;
		}
	}
?>