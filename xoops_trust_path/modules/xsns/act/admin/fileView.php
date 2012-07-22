<?php
class Xsns_File_View extends Xsns_Admin_View
{

function dispatch()
{
	require XSNS_FRAMEWORK_DIR.'/global.php';
	xoops_cp_header();
	
	include $mytrustdirpath.'/mymenu.php';
	
	$file_list = $this->context->getAttribute('file_list');
	$pager = $this->context->getAttribute('pager');
	
	echo "<h4><p style='text-align:center;'>"._AM_XSNS_TITLE_FILE_CONFIG."</p></h4>";
	
	if(count($file_list) > 0){
		
		$header_list = array(
			_AM_XSNS_FILE_NAME,
			_AM_XSNS_FILE_SIZE,
			_AM_XSNS_POST_DATE,
			_AM_XSNS_FILE_AUTHOR,
			_AM_XSNS_FILE_REF,
			_AM_XSNS_FILE_DELETE,
		);
		$header_count = count($header_list);
		
		echo "<div style='width:90%; margin-left:auto; margin-right:auto;'>";
		echo "<table class='outer' style='width:100%; text-align:center;'>";
		echo "<form action='index.php' method='post'>".
			 "<input type='hidden' name='".XSNS_ACTION_ARG."' value='file_del_exec'>";
		
		$pager_html = $this->getPageSelector($pager, $header_count);
		
		echo "<tr>";
		foreach($header_list as $header){
			echo "<th>".$header."</th>";
		}
		echo "</tr>";
		
		echo "<colgroup style='text-align:left;'></colgroup>".
			 "<colgroup style='text-align:right; width:150px;'></colgroup>".
			 "<colgroup style='width:120px;'></colgroup>".
			 "<colgroup style='text-align:left; width:150px;'></colgroup>".
			 "<colgroup style='width:40px;'></colgroup>".
			 "<colgroup style='width:40px;'></colgroup>";
		
		foreach($file_list as $file){
			echo "<tr class='even' style='text-align:center;'>".
					"<td><a href='".$file['url']."'>".$file['filename']."</a></td>".
					"<td>".$file['size']." bytes</td>".
					"<td>".$file['time']."</td>".
					"<td>".$file['author']."</td>".
					"<td>".$file['ref_link']."</td>".
					"<td><input type='checkbox' name='delete[]' value='".$file['id']."'></td>".
				 "</tr>";
		}
		echo $pager_html;
		
		$token_handler = new XoopsMultiTokenHandler();
		$token =& $token_handler->create('FILE_DELETE');
		
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
	xoops_cp_footer();
}
//------------------------------------------------------------------------------

}
?>
