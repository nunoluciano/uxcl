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
$mydirname = basename( __FILE__, ".plugin.php" );

eval( '
function '.$mydirname.'_xwords_autolink($queryarray,$id)
	{
	return myalbum_xwords_autolink_base( "'.$mydirname.'" , $queryarray, $id ) ;
	}
' ) ;

if( ! function_exists( 'myalbum_xwords_autolink_base' ) )
	{
	function myalbum_xwords_autolink_base( $mydirname , $queryarray, $id )
		{
		global $xoopsDB ;
		$table_photos = $xoopsDB -> prefix ("{$mydirname}_photos") ;

		$sql = "SELECT lid,cid,title FROM $table_photos WHERE lid != '$id' AND status > '0' " ;

		$count = 0;
		if ( is_array($queryarray) && $count = count($queryarray) )
			{
			if (preg_match('/^[[:alnum:]]+$/',$queryarray[0]))
				{
				$sql .= "AND ((title LIKE '$queryarray[0]')";
				}
			else
				{
				$sql .= "AND ((title LIKE BINARY '$queryarray[0]')";
				}
			for ( $i = 1; $i < $count; $i++ )
				{
				$sql .= " OR ";
				if (preg_match('/^[[:alnum:]]+$/',$queryarray[$i]))
					{
					$sql .= "(title LIKE '$queryarray[$i]')";
					}
				else
					{
					$sql .= "(title LIKE BINARY '$queryarray[$i]')";
					}
				}
			$sql .= ") ";
			}
		$sql .= "ORDER BY lid DESC";
		$result = $xoopsDB->query( $sql ) ;
		$ret = array() ;
		while( $myrow = $xoopsDB->fetchArray($result) )
			{
			$ret[] = array(
				"image" => "images/pict.gif" ,
				"link" => "photo.php?lid=".$myrow["lid"]."&amp;cid=".$myrow["cid"] ,
				"title" => $myrow["title"] ,
				) ;
			}
		return $ret;
		}
	}
/*
eval( '
function '.$mydirname.'_xwords_StripCodes( $text )
	{
	return $text;
	}
' ) ;
*/
?>