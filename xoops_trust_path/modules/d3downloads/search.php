<?php

eval( '

function '.$mydirname.'_global_search( $keywords , $andor , $limit , $offset , $userid )
{
    return d3downloads_global_search_base( "'.$mydirname.'" , $keywords , $andor , $limit , $offset , $userid ) ;
}

' ) ;

if( ! function_exists( 'd3downloads_global_search_base' ) ) {
	function d3downloads_global_search_base( $mydirname, $keywords, $andor, $limit, $offset, $userid )
	{
		require_once dirname( __FILE__ ).'/class/d3downloads.textsanitizer.php' ;
		include_once dirname( __FILE__ ).'/class/mydownload.php' ;
		include_once dirname( __FILE__ ).'/class/user_access.php' ;

		$myts =& d3downloadsTextSanitizer::getInstance() ;
		$db =& Database::getInstance() ;

		$showcontext = isset( $_GET['showcontext'] ) ? $_GET['showcontext'] : 0 ;
		$mydownload = new MyDownload( $mydirname ) ;
		$user_access = new user_access( $mydirname ) ;
		$whr = "cid IN ( ".implode( ",", $user_access->can_read() )." )" ;
		
		if( $showcontext == 1 ){
			$sql = "SELECT lid, cid, title, description, submitter, date FROM ".$db->prefix( $mydirname."_downloads" )."" ;
		} else {
			$sql = "SELECT lid, cid, title, submitter, date, title FROM ".$db->prefix( $mydirname."_downloads" )."" ;
		}
		$sql .= " WHERE ".$mydownload->whr_append( 'Single' )." AND ( $whr )" ;
		if ( $userid != 0 ) $sql .= " AND submitter=".$userid." ";

		// because count() returns 1 even if a supplied variable
		// is not an array, we must check if $querryarray is really an array
		if ( is_array( $keywords ) && $count = count( $keywords ) ) {
			$sql .= " AND ( ( title LIKE '%$keywords[0]%' OR description LIKE '%$keywords[0]%' )" ;
			for( $i=1; $i<$count; $i++ ){
				$sql .= " $andor " ;
				$sql .= "( title LIKE '%$keywords[$i]%' OR description LIKE '%$keywords[$i]%' )" ;
			}
			$sql .= ") " ;
		}
		$sql .= "ORDER BY date DESC" ;
		$result = $db->query( $sql, $limit, $offset ) ;
		$ret = array();
		while( $myrow = $db->fetchArray( $result ) )
		{
			$lid = intval( $myrow['lid'] ) ;
			$cid = intval( $myrow['cid'] ) ;
			$title = $myts->makeTboxData4Show( $myrow['title'] ) ;
			$date = intval( $myrow['date'] ) ;
			$submitter = intval( $myrow['submitter'] ) ;
			$context = '' ;
			// get context for module "search"
			if( function_exists( 'search_make_context' ) && $showcontext ) {
				$body = $myts->displayTarea( $myrow['description'], 0, 1, 1, 1, 1 ) ;
				if ( strstr ( $body , '[pagebreak]' ) ){
					$str = explode( '[pagebreak]', $body , 2 ) ;
					$body = $str[0] ;
				}
				$full_context = strip_tags( $body ) ;
				if( function_exists( 'easiestml' ) ) $full_context = easiestml( $full_context ) ;
				$context = search_make_context( $full_context , $keywords ) ;
			}
			$ret[] = array(
				'link' => "index.php?page=singlefile&amp;cid=$cid&amp;lid=$lid" ,
				'title' => $title ,
				'time' => $date ,
				'uid' => $submitter ,
				'context' => $context ,
			) ;
		}
		return $ret ;
	}
}

?>