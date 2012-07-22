<?php

$body_editor = @$xoopsModuleConfig['body_editor'] ;

if( $body_editor == 'common_fckeditor' && file_exists( XOOPS_ROOT_PATH.'/common/fckeditor/' ) ) {
	// FCKeditor in common/fckeditor/
	$wysiwyg_header = '
		<script type="text/javascript" src="'.XOOPS_URL.'/common/fckeditor/fckeditor.js"></script>
		<script type="text/javascript"><!--
			function fckeditor_exec() {
				var oFCKeditor = new FCKeditor( "'.$wysiwygs['name'].'" , "100%" , "500" , "Default" );
				
				oFCKeditor.BasePath = "'.XOOPS_URL.'/common/fckeditor/";
				
				oFCKeditor.ReplaceTextarea();
			}
			var FCKobj ;
			function FCKeditor_OnComplete( editorInstance ) {
				FCKobj = editorInstance ;
			}
		// --></script>
	' ;
	$wysiwyg_body = '<textarea id="'.$wysiwygs['name'].'" name="'.$wysiwygs['name'].'">'.$wysiwygs['value'].'</textarea><script>fckeditor_exec();</script>' ;
} else {
	// normal (xoopsdhtmltarea)
	$wysiwyg_header = '' ;
	$wysiwyg_body = '' ;
}

?>