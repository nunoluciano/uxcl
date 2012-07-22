<?php
class Xsns_Default_View extends Xsns_Admin_View
{
function dispatch()
{
	require XSNS_FRAMEWORK_DIR.'/global.php';
	xoops_cp_header();
	
	$perm_error = $this->context->getAttribute('perm_error');
	$gd_error = $this->context->getAttribute('gd_error');
	$notice = $this->context->getAttribute('notice');
	
	if(is_array($perm_error) && count($perm_error)>0){
		echo '<div class="error">'._AM_XSNS_PERM_ERR.'<br><ul>';
		foreach($perm_error as $msg){
			echo '<li>'.$msg.'</li>';
		}
		echo '</ul></div>';
	}
	else{
		include $mytrustdirpath.'/mymenu.php';
		
		if(is_array($gd_error) && count($gd_error)>0){
			echo '<div class="error"><ul>';
			foreach($gd_error as $msg){
				echo '<li>'.$msg.'</li>';
			}
			echo '</ul></div>';
		}
		
		if(is_array($notice) && count($notice)>0){
			echo '<div class="error"><ul>';
			foreach($notice as $msg){
				echo '<li>'.$msg.'</li>';
			}
			echo '</ul></div>';
		}
	}
	
	xoops_cp_footer();
}

}
?>
