<?php

function attachfile_reqstr( $name )
{
	return preg_replace( '/[^a-zA-Z0-9_-]/' , '' , @$_REQUEST[$name] ) ;
}

function attachfile_reqint( $name )
{
	return intval( @$_REQUEST[$name] ) ;
}

?>
