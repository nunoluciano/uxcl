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
function newbb_xwords_autolink($queryarray, $id)
	{
	global $xoopsDB;

	$sql = "SELECT p.post_id,p.topic_id,p.forum_id,p.subject FROM ".$xoopsDB->prefix("bb_posts")." p LEFT JOIN ".$xoopsDB->prefix("bb_forums")." f ON f.forum_id=p.forum_id WHERE p.post_id != '$id' AND f.forum_type = '0' ";

	$count = 0;
	if ( is_array($queryarray) && $count = count($queryarray) )
		{
		if (preg_match('/^[[:alnum:]]+$/',$queryarray[0]))
			{
			$sql .= " AND ((p.subject LIKE '$queryarray[0]')";
			}
		else
			{
			$sql .= " AND ((p.subject LIKE BINARY '$queryarray[0]')";
			}
		for($i=1;$i<$count;$i++)
			{
			$sql .= " OR ";
			if (preg_match('/^[[:alnum:]]+$/',$queryarray[$i]))
				{
				$sql .= "(p.subject LIKE '$queryarray[$i]')";
				}
			else
				{
				$sql .= "(p.subject LIKE BINARY '$queryarray[$i]')";
				}
			}
		$sql .= ") ";
		}
	$sql .= "ORDER BY post_id DESC";
	$result = $xoopsDB->query($sql);
	$ret = array();
	$i = 0;
 	while($myrow = $xoopsDB->fetchArray($result))
 		{
		$ret[$i]['image'] = "";
		$ret[$i]['link'] = "viewtopic.php?topic_id=".$myrow['topic_id']."&amp;forum=".$myrow['forum_id']."&amp;post_id=".$myrow['post_id']."#forumpost".$myrow['post_id'];
		$ret[$i]['title'] = $myrow['subject'];
		$i++;
		}
	return $ret;
	}
?>