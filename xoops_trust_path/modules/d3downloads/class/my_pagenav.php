<?php

// for get pagenavi.

if( ! class_exists( 'My_PageNav' ) )
{
	include_once( XOOPS_ROOT_PATH . '/class/pagenav.php' ) ;

	class My_PageNav extends XoopsPageNav
	{
		var $total ;
		var $perpage ;
		var $current ;

		function My_PageNav( $total_items, $items_perpage, $current_start, $start_name='start', $extra_arg='' )
		{
			$this->total   = intval( $total_items ) ;
			$this->perpage = intval( $items_perpage ) ;
			$this->current = intval( $current_start ) ;
			if ( $extra_arg != '' && ( substr( $extra_arg, -5 ) != '&amp;' || substr( $extra_arg, -1 ) != '&' ) ) $extra_arg .= '&amp;' ;
			$this->url = xoops_getenv( 'PHP_SELF' ).'?'.$extra_arg.trim( $start_name ).'=' ;
		}

		function renderNav( $offset = 4, $prev_page='Prev', $next_page='Next', $class='d3downloads_pagenav' )
		{
			$ret = '' ;
			if ( $this->total <= $this->perpage ) return $ret ;
			$total_pages = ceil( $this->total / $this->perpage ) ;
			if ( $total_pages > 1 ) {
				$ret .= '<ul class="'.$class.'">' ;
				$prev = $this->current - $this->perpage ;
				if ( $prev >= 0 ) $ret .= '<li class="prepage"><a href="'.$this->url.$prev.'" title="'.$prev_page.'">'.$prev_page.'</a></li>' ;
				$counter = 1 ;
				$current_page = intval( floor( ( $this->current + $this->perpage ) / $this->perpage ) ) ;
				while ( $counter <= $total_pages ) {
					if ( $counter == $current_page ) {
						$ret .= '<li class="currentpage">'.$counter.'</li>' ;
					} elseif ( ( $counter > $current_page - $offset && $counter < $current_page + $offset ) || $counter == 1 || $counter == $total_pages ) {
						if ( $counter == $total_pages && $current_page < $total_pages - $offset ) $ret .= '<li class="pageskip">...</li>' ;
						$ret .= '<li><a href="'.$this->url.( ( $counter - 1 ) * $this->perpage ).'" title="page '.$counter.'">'.$counter.'</a></li> ' ;
						if ( $counter == 1 && $current_page > 1 + $offset ) $ret .= '<li class="pageskip">...</li>' ;
					}
					$counter++ ;
				}
				$next = $this->current + $this->perpage ;
				if ( $this->total > $next ) $ret .= '<li class="nextpage"><a href="'.$this->url.$next.'" title="'.$next_page.'">'.$next_page.'</a></li>' ;
			}
			$ret .= '</ul>' ;
			return $ret ;
		}
	}
}

?>