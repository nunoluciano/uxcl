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
// XOOPS2 - Xwords 0.42
// WEBMASTER @ KANPYO.NET, 2005.

$mydirname = basename(dirname(dirname(__FILE__)));

eval( '

function '.$mydirname.'_xwords_autolink($queryarray,$entryID)
	{
	return xwords_autolink_base("'.$mydirname.'",$queryarray,$entryID) ;
	}

' ) ;


if( ! function_exists( 'xwords_autolink_base' ) )
	{
	function xwords_autolink_base($mydirname,$queryarray,$entryID)
		{
		$xoopsDB =& Database::getInstance();
		$ent_table = $xoopsDB -> prefix ("{$mydirname}_ent") ;
		$xoopsModule = XoopsModule::getByDirname("$mydirname");

		$searchtype = "";
		$count = 0;
		if ( is_array($queryarray) && $count = count($queryarray) )
			{
			if (preg_match('/^[[:alnum:]]+$/',$queryarray[0]))
				{
				$searchtype = " ((term LIKE '$queryarray[0]')";
				}
			else
				{
				$searchtype = " ((term LIKE BINARY '$queryarray[0]')";
				}
			for ( $i = 1; $i < $count; $i++ )
				{
				if (preg_match('/^[[:alnum:]]+$/',$queryarray[$i]))
					{
					$searchtype .= " OR (term LIKE '$queryarray[$i]')";
					}
				else
					{
					$searchtype .= " OR (term LIKE BINARY '$queryarray[$i]')";
					}
				}
			$searchtype .= ")";
			}

		$i = 0;
		$glossaryterms = array();
		$searchquery = $xoopsDB -> query ("SELECT * FROM $ent_table WHERE entryID != '$entryID' AND datesub < '".time()."' AND datesub > '0' AND submit = '0' AND offline = '0' AND request = '0' AND $searchtype ORDER BY term");
		$results = $xoopsDB -> getRowsNum ( $searchquery );
		if ($results)
			{
			$queryA = $xoopsDB -> query ("SELECT entryID, categoryID, term FROM $ent_table WHERE entryID != '$entryID' AND datesub < '".time()."' AND datesub > '0' AND submit = '0' AND offline = '0' AND request = '0' AND $searchtype ORDER BY term");
			while ( list( $glossaryentryID, $categoryID, $glossaryterm ) = $xoopsDB->fetchRow($queryA))
				{
				$glossaryterms[$i]['image'] = 'images/xw.gif';
				$glossaryterms[$i]['title'] = $glossaryterm;
				$glossaryterms[$i]['link'] = "entry.php?entryID=".$glossaryentryID."&amp;categoryID=".$categoryID;
				$i++;
				}
			}
		return $glossaryterms;
		}
	}
?>