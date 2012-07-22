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
// ------------------------------------------------------------------------- //
// XOOPS2 - Xwords 0.42
// WEBMASTER @ KANPYO.NET, 2005.

if( ! defined( 'XOOPS_ROOT_PATH' ) ) exit ;
$mydirname = basename( __FILE__, ".plugin.php" );
if( ! preg_match( '/^(\D+)(\d*)$/' , $mydirname , $regs ) ) echo ( "invalid dirname: " . htmlspecialchars( $mydirname ) ) ;
$mydirnumber = $regs[2] === '' ? '' : intval( $regs[2] ) ;

eval( '

function '.$mydirname.'_xwords_autolink($queryarray, $id)
{
	return wordpress_xwords_autolink_base( "'.$mydirname.'", "'.$mydirnumber.'", $queryarray, $id ) ;
}

' ) ;


if( ! function_exists( 'wordpress_xwords_autolink_base' ) )
	{
	function wordpress_xwords_autolink_base( $mydirname , $mydirnumber, $queryarray, $id )
		{
		$db =& Database::getInstance() ;

		$sql = "SELECT ID, post_title FROM ".$db->prefix( "wp{$mydirnumber}_posts" )." WHERE ID != '$id' AND post_status = 'publish' " ;

		$count = 0;
		if ( is_array($queryarray) && $count = count($queryarray) )
			{
			if (preg_match('/^[[:alnum:]]+$/',$queryarray[0]))
				{
				$sql .= "AND ((post_title LIKE '$queryarray[0]')";
				}
			else
				{
				$sql .= "AND ((post_title LIKE BINARY '$queryarray[0]')";
				}
			for ( $i = 1; $i < $count; $i++ )
				{
				$sql .= " OR ";
				if (preg_match('/^[[:alnum:]]+$/',$queryarray[$i]))
					{
					$sql .= "(post_title LIKE '$queryarray[$i]')";
					}
				else
					{
					$sql .= "(post_title LIKE BINARY '$queryarray[$i]')";
					}
				}
			$sql .= ") ";
			}
		$sql .= "ORDER BY ID ASC" ;
		$result = $db->query( $sql ) ;
		$ret = array() ;
		while( $myrow = $db->fetchArray($result) )
			{
			$ret[] = array(
				"image" => "wp-images/search.png" ,
				"link" => "index.php?p=".$myrow["ID"] ,
				"title" => $myrow["post_title"] ,
				) ;
			}
		return $ret ;
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