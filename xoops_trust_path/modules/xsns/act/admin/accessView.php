<?php
class Xsns_Access_View extends Xsns_Admin_View
{
function dispatch()
{
	require XSNS_FRAMEWORK_DIR.'/global.php';
	xoops_cp_header();
	
	include $mytrustdirpath.'/mymenu.php';
	
	echo "<h4><p style='text-align:center;'>"._AM_XSNS_TITLE_ACCESS_LOG."</p></h4>";
	
	$access_log = $this->context->getAttribute('access_log');
	
	if(count($access_log) > 0){
		
		$pager = $this->context->getAttribute('pager');
		
		echo "<div style='width:90%;margin-left:auto;margin-right:auto;'>";
		echo "<table class='outer' style='width:100%;'>";
		
		$header_list = array(
			_AM_XSNS_ACCESS_DATE,
			_AM_XSNS_ACCESS_COMMU,
			_AM_XSNS_ACCESS_USER,
		);
		$header_count = count($header_list);
		
		$pager_html = $this->getPageSelector($pager, $header_count);
		
		echo $pager_html;
		
		echo "<tr>";
		foreach($header_list as $header){
			echo "<th style='text-align:center;'>".$header."</th>";
		}
		echo "</tr>";
		
		echo "<colgroup style='text-align:center; width:20%;'></colgroup>".
			 "<colgroup span='2' style='text-align:left; width:35%;'></colgroup>";
		
		foreach($access_log as $access){
			echo "<tr class='even'>".
				 "<td>".date('Y-m-d H:i:s', $access['time'])."</td>".
				 "<td><a href='index.php?".XSNS_ACTION_ARG."=access&cid=".$access['commu_id']."'>".$access['commu_name']."</a></td>".
				 "<td><a href='index.php?".XSNS_ACTION_ARG."=access&uid=".$access['member_id']."'>".$access['member_name']."</a></td>".
				 "</tr>";
		}
		echo $pager_html;
		
		echo "</table>";
		echo "</div>";
	}
	
	xoops_cp_footer();
}

//------------------------------------------------------------------------------

}
?>
