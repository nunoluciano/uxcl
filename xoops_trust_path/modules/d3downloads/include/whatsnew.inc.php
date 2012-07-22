<?php

eval( '

function '.$mydirname.'_new( $limit=0, $offset=0 )
{
	return d3downloads_whatsnew_base( "'.$mydirname.'", $limit, $offset, "'.$category_option.'", "'.$intree.'" ) ;
}

' );

if ( ! function_exists('d3downloads_whatsnew_base') ) {
	function d3downloads_whatsnew_base( $mydirname, $limit=0, $offset=0, $category_option='', $intree=0 )
	{
		require_once dirname( dirname(__FILE__) ).'/class/item_build.php' ;
		$item_build = new Item_build( $mydirname ) ;

		$tree = ( $intree == 1 ) ? 1 : 0 ;
		return $item_build->get_Item( $category_option, $tree, $limit, $offset ) ;
	}
}

?>