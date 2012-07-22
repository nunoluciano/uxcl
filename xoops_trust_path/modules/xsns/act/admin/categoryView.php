<?php
class Xsns_Category_View extends Xsns_Admin_View
{
function dispatch()
{
	require XSNS_FRAMEWORK_DIR.'/global.php';
	xoops_cp_header();
	
	// 中カテゴリ
	$category_p = $this->context->getAttribute('category_p');
	$category = $this->context->getAttribute('category');
	
	include $mytrustdirpath.'/mymenu.php';
	
	echo "<h4><p style='text-align:center;'>"._AM_XSNS_TITLE_CATEGORY_CONFIG."</p></h4><br>";
	
	echo "<div style='width:500px; margin-left:auto; margin-right:auto;'>";
	echo "<div style='text-align:center; font-size:14px; padding-bottom:15px;'><b>"._AM_XSNS_CATEGORY1._AM_XSNS_CATEGORY_LIST."</b></div>";
	echo "<table border='1' cellpadding='8' style='width:100%; text-align:center;'>";
	
	echo "<colgroup style='width:120px;'></colgroup>".
		 "<colgroup style='width:80px;'></colgroup>".
		 "<colgroup span='2' style='width:50px;'></colgroup>".
		 "<colgroup style='width:70px;'></colgroup>";
	
	echo "<th colspan='5'>"._AM_XSNS_CATEGORY1."</th>";
	
	echo "<tr class='head'>".
			"<td>"._AM_XSNS_CATEGORY_NAME."</td>".
			"<td>"._AM_XSNS_CATEGORY_ORDER."</td>".
			"<td colspan='2'>"._AM_XSNS_CATEGORY_OPERATION."</td>".
			"<td>"._AM_XSNS_CATEGORY2."</td>".
		 "</tr>";
		 
	foreach($category_p as $cat_p){
		$pid = $cat_p['c_commu_category_parent_id'];
		
		echo "<form action='index.php' method='post'>";
		echo "<input type='hidden' name='".XSNS_ACTION_ARG."' value='category_edit_exec'>";
		echo "<input type='hidden' name='mode' value='parent'>";
		echo "<input type='hidden' name='pid' value='".$pid."'>";
		
		echo "<tr class='even'>".
				"<td><input type='text' name='title".$pid."' value='".$cat_p['name']."'></td>".
				"<td><input type='text' name='order".$pid."' size='10' value='".$cat_p['sort_order']."'></td>".
				"<td><input type='submit' name='edit' value='"._AM_XSNS_CATEGORY_EDIT."'></td>".
				"<td><input type='submit' name='delete' value='"._AM_XSNS_CATEGORY_DEL."' onclick=\"javascript:return confirm('"._AM_XSNS_CATEGORY_DEL_CONFIRM."');\"></td>".
				"<td><a href='index.php?".XSNS_ACTION_ARG."=category#".$pid."'>"._AM_XSNS_CATEGORY_LIST."</a></td>".
			 "</tr>";
		
		echo "</form>";
	}
	
	echo "<form action='index.php' method='post'>";
	echo "<input type='hidden' name='".XSNS_ACTION_ARG."' value='category_add_exec'>";
	echo "<input type='hidden' name='mode' value='parent'>";
	
	echo "<tr>".
			"<td><input type='text' name='title'></td>".
			"<td><input type='text' name='order' size='10' value='0'></td>".
			"<td colspan='2'><input type='submit' name='add' value='"._AM_XSNS_CATEGORY_ADD."'></td>".
			"<td></td>".
		 "</tr>";
	echo "</form>";
	
	echo "</table>";
	
	echo "</div>";
	
	echo "<br><br><br>";
	
	echo "<div style='width:400px; margin-left:auto; margin-right:auto;'>";
	
	// 小カテゴリ
	echo "<div style='text-align:center; font-size:14px; padding-bottom:15px;'><b>"._AM_XSNS_CATEGORY2._AM_XSNS_CATEGORY_LIST."</b></div>";
	
	$token_handler = new XoopsMultiTokenHandler();
	$token_add =& $token_handler->create('CATEGORY_ADD');
	$token_edit =& $token_handler->create('CATEGORY_EDIT');
	
	foreach($category_p as $cat_p){
		$pid = $cat_p['c_commu_category_parent_id'];
		
		echo "<table border='1' cellpadding='8' style='width:100%; text-align:center;'>";
		
		echo "<tr>".
				"<th colspan='4'><a name='".$pid."'>".$cat_p['name']."</a></th>".
			 "</tr>";
			 
		echo "<colgroup style='width:120px;'></colgroup>".
			 "<colgroup style='width:80px;'></colgroup>".
			 "<colgroup span='2' style='width:50px;'></colgroup>";
		
		echo "<tr class='head'>".
				"<td>"._AM_XSNS_CATEGORY_NAME."</td>".
				"<td>"._AM_XSNS_CATEGORY_ORDER."</td>".
				"<td colspan='2'>"._AM_XSNS_CATEGORY_OPERATION."</td>".
			 "</tr>";
		
		if(isset($category[$pid])){
			foreach($category[$pid] as $cat){
				$id = $cat['c_commu_category_id'];
				
				echo "<form action='index.php' method='post'>";
				echo "<input type='hidden' name='".XSNS_ACTION_ARG."' value='category_edit_exec'>";
				echo "<input type='hidden' name='id' value='".$id."'>";
				echo $token_edit->getHtml();
				echo "<tr class='even'>".
						"<td><input type='text' name='title".$id."' value='".$cat['name']."'></td>".
						"<td><input type='text' name='order".$id."' size='10' value='".$cat['sort_order']."'></td>".
						"<td><input type='submit' name='edit' value='"._AM_XSNS_CATEGORY_EDIT."'></td>".
						"<td><input type='submit' name='delete' value='"._AM_XSNS_CATEGORY_DEL."'></td>".
					 "</tr>";
				echo "</form>";
			}
		}
		
		echo "<form action='index.php' method='post'>";
		echo "<input type='hidden' name='".XSNS_ACTION_ARG."' value='category_add_exec'>";
		echo "<input type='hidden' name='pid' value='".$pid."'>";
		echo $token_add->getHtml();
		echo "<tr>".
				"<td><input type='text' name='title'></td>".
				"<td><input type='text' name='order' size='10' value='0'></td>".
				"<td colspan='2'><input type='submit' name='add' value='"._AM_XSNS_CATEGORY_ADD."'></td>".
			 "</tr>";
		echo "</table>";
		echo "</form>";
		
		echo "<br><br>";
	}
	
	echo "</div>";
	
	xoops_cp_footer();
}

}
?>
