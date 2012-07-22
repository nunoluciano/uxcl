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

function bluesbb_xwords_autolink($queryarray, $id)
	{
	$db =& Database::getInstance();
	global $xoopsUser,$member_handler;
	$sql = "SELECT b.topic_id,b.thread_id,b.res_id,b.title FROM ".$db->prefix("bluesbb")." b LEFT JOIN ".$db->prefix("bluesbb_topic")." t ON t.topic_id=b.topic_id WHERE b.topic_id != '$id' AND";
	if ( is_object($xoopsUser) )
		{
		$sql .= " (t.topic_access = '1' OR t.topic_access = '2' OR t.topic_access = '3' OR t.topic_access = '4' OR t.topic_access = '5'";
		$groups =& $member_handler->getGroupsByUser($xoopsUser->getVar('uid'),true);
		foreach ($groups as $group)
			{
			$sql .= " OR t.topic_group = '".$group->getVar('groupid')."'";
			}
		if ( $xoopsUser->isAdmin() )
			{
			$sql .= " OR t.topic_access = '6'";
			}
		}
	else
		{
		$sql .= " (t.topic_access = '1' OR t.topic_access = '2' OR t.topic_access = '5'";
		}
	$sql .= ")";

	$count = 0;
	if ( is_array($queryarray) && $count = count($queryarray) )
		{
		if (preg_match('/^[[:alnum:]]+$/',$queryarray[0]))
			{
			$sql .= "AND ((b.title LIKE '$queryarray[0]')";
			}
		else
			{
			$sql .= "AND ((b.title LIKE BINARY '$queryarray[0]')";
			}
		for ( $i = 1; $i < $count; $i++ )
			{
			$sql .= " OR ";
			if (preg_match('/^[[:alnum:]]+$/',$queryarray[$i]))
				{
				$sql .= "(b.title LIKE '$queryarray[$i]')";
				}
			else
				{
				$sql .= "(b.title LIKE BINARY '$queryarray[$i]')";
				}
			}
		$sql .= ") ";
		}
	$sql .= "ORDER BY b.topic_id DESC";
	$result = $db->query($sql);
	$ret = array();
	$i = 0;
	while($myrow = $db->fetchArray($result))
		{
		++$myrow['res_id'];
		$ret[$i]['image'] = "";
		$ret[$i]['link'] = "thread.php?top=".$myrow['topic_id']."&amp;thr=".$myrow['thread_id']."&amp;num=".$myrow['res_id'];
		$ret[$i]['title'] = $myrow['title'];
		$i++;
		}
	return $ret;
	}
?>