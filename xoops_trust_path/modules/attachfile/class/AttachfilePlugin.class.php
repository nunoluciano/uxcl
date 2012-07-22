<?php

// abstract class for Attachfile plugins
class AttachfilePlugin {

var $mPlug = null ; // Plugin Permission object

function AttachfilePlugin( $attachfile_dirname , $target_dirname , $target_trustdirname = '' )
{

	$target_trustdirname = preg_replace( '/[^0-9a-zA-Z_]/' , '' , $target_trustdirname ) ; 

	// plugin_permission_class (read ef class and create the object)
	$plugin_class = empty( $target_dirname ) ? 'attachfileAttachfilePlugin' : 
		preg_replace( '/[^0-9a-zA-Z_]/' , '' , $target_trustdirname.'AttachfilePlugin' ) ;

	$plugin_file = dirname( dirname( __FILE__ ) ) .'/plugins/' . $target_trustdirname.'/permission.php' ;

	if( ! file_exists( $plugin_file ) ) {
		echo (_MD_ATTACHFILE_ERR_PLUGINNOTFOUND.' ('.$target_trustdirname.')') ;
		exit;
	}

	require_once $plugin_file ;

	$this->mPlug = new $plugin_class( $this ) ;

	$this->mPlug->attachfile_dirname =  !empty( $attachfile_dirname ) ? 
		preg_replace( '/[^0-9a-zA-Z_]/' , '' , $attachfile_dirname ) : 'attachfile' ; 
	$this->mPlug->attachfile_trustdirname =  !empty( $attachfile_trustdirname ) ? 
		preg_replace( '/[^0-9a-zA-Z_]/' , '' , $attachfile_trustdirname ) : 'attachfile' ; 
	$this->mPlug->target_dirname = !empty( $target_dirname ) ? 
		preg_replace( '/[^0-9a-zA-Z_]/' , '' , $target_dirname ) : 
		preg_replace( '/[^0-9a-zA-Z_]/' , '' , $target_trustdirname ) ; 
	$this->mPlug->target_trustdirname =  $target_trustdirname ;
	
}

function & getInstance( $attachfile_dirname , $target_dirname , $target_trustdirname )
{
	static $instance ;
	if( ! isset( $instance[$target_dirname] ) ) {
		$instance[$target_dirname] = new AttachfilePlugin( $attachfile_dirname , $target_dirname , $target_trustdirname ) ;
	}
	return $instance[$target_dirname] ;
}

}

?>