<?php
require_once XOOPS_TRUST_PATH.'/modules/pico/include/common_functions.php' ;
require_once XOOPS_TRUST_PATH.'/modules/pico/class/pico.textsanitizer.php' ;
require_once XOOPS_TRUST_PATH.'/modules/pico/class/PicoUriMapper.class.php' ;
require_once XOOPS_TRUST_PATH.'/modules/pico/class/PicoPermission.class.php' ;
require_once XOOPS_TRUST_PATH.'/modules/pico/class/PicoModelCategory.class.php' ;
require_once XOOPS_TRUST_PATH.'/modules/pico/class/PicoModelContent.class.php' ;
require_once XOOPS_TRUST_PATH.'/modules/pico/blocks/content.php' ;

function smarty_function_pico_ef_get( $params , &$smarty )
{
	$mydirname = @$params['dir'] . @$params['dirname'] ;
	$content_id = @$params['id'] . @$params['content_id'] ;
	$var_name = @$params['item'] . @$params['assign'] ;

	if( empty( $mydirname ) ) $mydirname = $smarty->get_template_vars( 'mydirname' ) ;
	if( empty( $mydirname ) ) {
		echo 'error '.__FUNCTION__.' [specify dirname]';
		return ;
	}

	$content = b_pico_content_show( array( $mydirname , $content_id , '' , 'disable_renderer' => true ) ) ;
	$ef = pico_common_unserialize( $content['content']['extra_fields'] ) ;
	if( $var_name ) {
		// just assign
		$smarty->assign( $var_name , $ef ) ;
	} else {
		// display
		echo '<pre>' ;
		var_dump( @$ef ) ;
		echo '</pre>' ;
	}
}

?>