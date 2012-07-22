<?php

if( ! defined( 'PICAL_COMMENT_FUNCTIONS_INCLUDED' ) ) {

define( 'PICAL_COMMENT_FUNCTIONS_INCLUDED' , 1 ) ;

// comment callback functions

function pical_comments_update( $event_id , $total_num ) {

	// record total_num
	global $xoopsDB , $cal ;

	if( is_object( $cal ) ) {
		$tablename = $cal->table ;
	} else {
		$mydirname = basename( dirname( dirname( __FILE__ ) ) ) ;
		if( ! preg_match( '/^(\D+)(\d*)$/' , $mydirname , $regs ) ) echo ( "invalid dirname: " . htmlspecialchars( $mydirname ) ) ;
		$mydirnumber = $regs[2] === '' ? '' : intval( $regs[2] ) ;
		$tablename = $xoopsDB->prefix("pical{$mydirnumber}_event") ;
	}

	$ret = $xoopsDB->query( "UPDATE $tablename SET comments=$total_num WHERE id=$event_id" ) ;
	return $ret ;
}

function pical_comments_approve( &$comment )
{
	// notification mail here
}

}

?>