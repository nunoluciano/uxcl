<?php
class Xsns_Image_View extends Xsns_Admin_View
{

function dispatch()
{
	require XSNS_FRAMEWORK_DIR.'/global.php';
	xoops_cp_header();
	
	include $mytrustdirpath.'/mymenu.php';
	
	$image_list = $this->context->getAttribute('image_list');
	$pager = $this->context->getAttribute('pager');
	
	echo "<h4><p style='text-align:center;'>"._AM_XSNS_TITLE_IMAGE_CONFIG."</p></h4>";
	
	if(count($image_list) > 0){
		
		$header_list = array(
			_AM_XSNS_IMAGE,
			_AM_XSNS_IMAGE_SIZE,
			_AM_XSNS_POST_DATE,
			_AM_XSNS_IMAGE_AUTHOR,
			_AM_XSNS_IMAGE_REF,
			_AM_XSNS_IMAGE_DELETE,
		);
		$header_count = count($header_list);
		
		echo "<div style='width:90%; margin-left:auto; margin-right:auto;'>";
		echo "<table class='outer' style='width:100%; text-align:center;'>";
		echo "<form action='index.php' method='post'>".
			 "<input type='hidden' name='".XSNS_ACTION_ARG."' value='image_del_exec'>";
		
		echo "<colgroup style='width:90px;'></colgroup>".
			 "<colgroup style='width:150px;'></colgroup>".
			 "<colgroup style='width:120px;'></colgroup>".
			 "<colgroup style='text-align:left;'></colgroup>".
			 "<colgroup style='width:40px;'></colgroup>".
			 "<colgroup style='width:40px;'></colgroup>";
		
		$pager_html = $this->getPageSelector($pager, $header_count);
		
		echo "<tr>";
		foreach($header_list as $header){
			echo "<th>".$header."</th>";
		}
		echo "</tr>";
		
		foreach($image_list as $image){
			echo "<tr class='even' style='text-align:center;'>".
					"<td><a href='".$image['url']."' target='_blank'><img src='".$image['link']."' alt=''></a></td>".
					"<td>".$image['width']." x ".$image['height']."<br><br>".$image['size']." bytes</td>".
					"<td>".$image['time']."</td>".
					"<td>".$image['author']."</td>".
					"<td>".$image['ref_link']."</td>".
					"<td><input type='checkbox' name='delete[]' value='".$image['id']."'></td>".
				 "</tr>";
		}
		echo $pager_html;
		
		$token_handler = new XoopsMultiTokenHandler();
		$token =& $token_handler->create('IMAGE_DELETE');
		
		echo "<tr class='foot'>".
			 "<td colspan='".$header_count."' style='text-align:center; padding:15px 0 15px 0;'>".
			 "<input type='submit' value='"._SUBMIT."'>".
			 $token->getHtml().
			 "</td>".
			 "</tr>";
		
		echo "</form>";
		echo "</table>";
		echo "</div>";
	}
	else{
	
	}
	
	xoops_cp_footer();
}
//------------------------------------------------------------------------------

}
?>
