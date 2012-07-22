<?php

// for Topview , Cateview , Singleview etc.

if( ! class_exists( 'MyDownload' ) )
{
	require_once dirname( dirname(__FILE__) ).'/class/d3downloads.textsanitizer.php' ;

	class MyDownload
	{
		var $db ;
		var $table ;
		var $whr ;
		var $order = "" ;
		var $lid ;
		var $cid ;
		var $title ;
		var $url ;
		var $filename ;
		var $ext ;
		var $file2 ;
		var $filename2 ;
		var $ext2 ;
		var $homepage ;
		var $homepagetitle ;
		var $version ;
		var $size ;
		var $platform ;
		var $license ;
		var $logourl ;
		var $description ;
		var $html ;
		var $smiley ;
		var $br ;
		var $xcode ;
		var $filters ;
		var $extra ;
		var $submitter ;
		var $date ;
		var $expired ;
		var $hits ;
		var $rating ;
		var $votes ;
		var $mylink ;
		var $visible ;
		var $cancomment ;
		var $comments ;
		var $category ;
		var $downdata=array() ;

		function MyDownload( $mydirname, $whr='', $lid= 0 )
		{
			global $xoopsUser ;
			include_once dirname( dirname(__FILE__) ).'/include/mytable.php' ;

			$this->db =& Database::getInstance() ;
			$this->myts =& d3downloadsTextSanitizer::getInstance() ;
			$this->mydirname = $mydirname ;
			$this->mod_url = XOOPS_URL.'/modules/'.$mydirname ;
			$this->table = $this->db->prefix( "{$mydirname}_downloads" ) ;
			$this->cat_table = $this->db->prefix( "{$mydirname}_cat" ) ;
			$this->mylink_table = $this->db->prefix( "{$mydirname}_mylink" ) ;
			$columns = 'd.'.implode( ',d.' , $GLOBALS['d3download_tables']['downloads'] ) ;
			$columns .= ', c.title AS category';
			$this->columns = $columns ;
			$module_handler =& xoops_gethandler('module') ;
			$config_handler =& xoops_gethandler('config') ;
			$module =& $module_handler->getByDirname( $mydirname ) ;
			$mod_config =& $config_handler->getConfigsByCat( 0, $module->getVar( 'mid' ) ) ;
			$this->mod_config = $mod_config ;
			if( is_object( $xoopsUser ) ) {
				$this->xoops_isuser = true ;
				$this->xoops_userid = $xoopsUser->getVar('uid') ;
				$mid = $module->getVar('mid') ;
				$this->xoops_isadmin = $xoopsUser->isAdmin( $mid ) ;
			} else {
				$this->xoops_isuser = false ;
				$this->xoops_userid = 0 ;
				$this->xoops_isadmin = false ;
			}
			if( ! empty( $lid ) ) {
				$this->GetMyDownload( $whr, $lid ) ;
			}
		}

		function GetMyDownload( $whr='', $lid )
		{
			$where = "d.lid='".$lid."'" ;
			if( ! $this->xoops_isadmin ) $where .= " AND ".$this->whr_append()."" ;
			if( ! empty( $whr ) )        $where .= " AND ( $whr )" ;

			$sql = $this->default_sql() ." WHERE $where" ;
			$result = $this->db->query( $sql ) ;
			if ( $this->db->getRowsNum( $result ) == 0 ) {
				return '';
			}
			$this->getData( $result ) ;
		}

		function getData( $result )
		{
			$array = $this->db->fetchArray( $result ) ;
			foreach ( $array as $key=>$value ){
				$this->$key = $value;
			}
		}

		function return_lid()
		{
			return intval( $this->lid ) ;
		}

		function return_cid()
		{
			return intval( $this->cid ) ;
		}

		function return_title( $mode )
		{
			switch( $mode ) {
				case 'Show' :
					return $this->myts->makeTboxData4Show( $this->title ) ;
				case 'Edit' :
					return $this->myts->makeTboxData4Edit( $this->title ) ;
			}
		}

		function return_url( $mode, $noreal=0 )
		{
			switch( $mode ) {
				case 'Show' :
					return $this->return_url_show( $noreal ) ;
				case 'Edit' :
					return $this->return_url_edit() ;
			}
		}

		function return_url_show( $noreal=0 )
		{
			switch( $noreal ) {
				case false :
					return $this->myts->makeTboxData4URLShow( $this->Real_path( $this->url ) ) ;
				case true :
					return $this->myts->makeTboxData4URLShow( $this->url ) ;
			}
		}

		function return_url_edit()
		{
			if ( preg_match('/^'.preg_quote( XOOPS_ROOT_PATH, '/' ).'/i', $this->url ) ) {
				$str = preg_replace( '/^'.preg_quote( XOOPS_ROOT_PATH, '/' ).'/i', 'XOOPS_ROOT_PATH', $this->url ) ;
				return $this->myts->makeTboxData4Edit( $str ) ;
			} else {
				return $this->myts->makeTboxData4Edit( $this->url ) ;
			}
		}

		function return_filename( $mode )
		{
			switch( $mode ) {
				case 'Show' :
					return $this->myts->MyhtmlSpecialChars( $this->filename ) ;
				case 'Edit' :
					return $this->myts->makeTboxData4Edit( $this->filename ) ;
			}
		}

		function return_ext( $mode )
		{
			switch( $mode ) {
				case 'Show' :
					return $this->myts->MyhtmlSpecialChars( $this->ext ) ;
				case 'Edit' :
					return $this->myts->makeTboxData4Edit( $this->ext ) ;
			}
		}

		function return_file2( $mode, $noreal=0 )
		{
			switch( $mode ) {
				case 'Show' :
					return $this->return_file2_show( $noreal ) ;
				case 'Edit' :
					return $this->myts->makeTboxData4Edit( $this->file2 ) ;
			}
		}

		function return_file2_show( $noreal=0 )
		{
			switch( $noreal ) {
				case false :
					return $this->myts->MyhtmlSpecialChars( $this->Real_path( $this->file2 ) ) ;
				case true :
					return $this->myts->MyhtmlSpecialChars( $this->file2 ) ;
			}
		}

		function return_filename2( $mode )
		{
			switch( $mode ) {
				case 'Show' :
					return $this->myts->MyhtmlSpecialChars( $this->filename2 ) ;
				case 'Edit' :
					return $this->myts->makeTboxData4Edit( $this->filename2 ) ;
			}
		}

		function return_ext2( $mode )
		{
			switch( $mode ) {
				case 'Show' :
					return $this->myts->MyhtmlSpecialChars( $this->ext2 ) ;
				case 'Edit' :
					return $this->myts->makeTboxData4Edit( $this->ext2 ) ;
			}
		}

		function return_homepage( $mode )
		{
			switch( $mode ) {
				case 'Show' :
					return $this->myts->makeTboxData4URLShow( $this->homepage ) ;
				case 'Edit' :
					return $this->myts->makeTboxData4Edit( $this->homepage ) ;
			}
		}

		function return_homepagetitle( $mode )
		{
			switch( $mode ) {
				case 'Show' :
					return  $this->myts->makeTboxData4Show( $this->homepagetitle ) ;
				case 'Edit' :
					return $this->myts->makeTboxData4Edit( $this->homepagetitle ) ;
			}
		}

		function return_version( $mode )
		{
			switch( $mode ) {
				case 'Show' :
					return $this->myts->makeTboxData4Show( $this->version ) ;
				case 'Edit' :
					return $this->myts->makeTboxData4Edit( $this->version ) ;
			}
		}

		function return_size()
		{
			return intval( $this->size ) ;
		}

		function return_platform( $mode )
		{
			switch( $mode ) {
				case 'Show' :
					return $this->myts->makeTboxData4Show( $this->platform ) ;
				case 'Edit' :
					return $this->myts->makeTboxData4Edit( $this->platform ) ;
			}
		}

		function return_license( $mode )
		{
			switch( $mode ) {
				case 'Show' :
					return $this->myts->makeTboxData4Show( $this->license ) ;
				case 'Edit' :
					return $this->myts->makeTboxData4Edit( $this->license ) ;
			}
		}

		function return_logourl( $mode )
		{
			switch( $mode ) {
				case 'Show' :
					return $this->myts->makeTboxData4Show( $this->logourl ) ;
				case 'Edit' :
					return $this->myts->makeTboxData4Edit( $this->logourl ) ;
			}
		}

		function return_description( $mode )
		{
			switch( $mode ) {
				case 'Show' :
					return $this->replace_current_data( $this->description ) ; //no sanitize
				case 'Edit' :
					return $this->myts->makeTareaData4Edit( $this->description ) ;
			}
		}

		function return_html()
		{
			return $this->html ? 1 : 0 ;
		}

		function return_smiley()
		{
			return $this->smiley ? 1 : 0 ;
		}

		function return_br()
		{
			return $this->br ? 1 : 0 ;
		}

		function return_xcode()
		{
			return $this->xcode ? 1 : 0 ;
		}

		function return_filters()
		{
			return $this->myts->makeTboxData4Show( $this->filters ) ;
		}

		function return_extra( $mode, $single=0, $block=0, $forpreview=0 )
		{
			switch( $mode ) {
				case 'Show' :
					return empty( $this->extra ) ? array() : $this->extra_array( $this->extra, $single, $block, $forpreview ) ;
				case 'Edit' :
					return $this->myts->makeTareaData4Edit( $this->extra ) ;
			}
		}

		function return_submitter()
		{
			return intval( $this->submitter ) ;
		}

		function return_date()
		{
			return intval( $this->date ) ;
		}

		function return_createable()
		{
			return $this->date > time() ? 1 : 0 ;
		}

		function return_expired()
		{
			return $this->expired ? intval( $this->expired ) : time() ;
		}

		function return_expiredable()
		{
			return $this->expired ? 1 : 0 ;
		}

		function return_hits()
		{
			return intval( $this->hits ) ;
		}

		function return_rating()
		{
			return intval( $this->rating ) ;
		}

		function return_votes()
		{
			return intval( $this->votes ) ;
		}

		function return_mylink()
		{
			return intval( $this->mylink ) ;
		}

		function return_cancomment()
		{
			return $this->cancomment ? 1 : 0 ;
		}

		function return_visible()
		{
			return $this->visible ? 1 : 0 ;
		}

		function return_comments()
		{
			return intval( $this->comments ) ;
		}

		function return_category( $mode )
		{
			switch( $mode ) {
				case 'Show' :
					return $this->myts->makeTboxData4Show( $this->category ) ;
				case 'Edit' :
					return $this->myts->makeTboxData4Edit( $this->category ) ;
			}
		}

		function default_sql()
		{
			return "SELECT $this->columns FROM ".$this->table." d LEFT JOIN ".$this->cat_table." c ON d.cid=c.cid" ;
		}

		function whr_period( $mode='' )
		{
			switch( $mode ) {
				case 'Single' :
					return "date <= ".time()." AND date > 0 AND ( expired = 0 OR expired >= ".time()." )" ;
				default :
					return "d.date <= ".time()." AND d.date > 0 AND ( d.expired = 0 OR d.expired >= ".time()." )" ;
			}
		}

		function whr_append( $mode='' )
		{
			switch( $mode ) {
				case 'Single' :
					return "visible = '1' AND ( ".$this->whr_period( 'Single' )." )" ;
				default :
					return "d.visible = '1' AND ( ".$this->whr_period()." )" ;
			}
		}

		function get_whr_from_array( $array, $mode='', $name='cid' )
		{
			$ids = implode( ",", array_unique( array_diff( $array, array( 0 ) ) ) ) ;
			switch( $mode ) {
				case 'Single' :
					return $name." IN ( ".$ids." )" ;
				default :
					return "d.".$name." IN ( ".$ids." )" ;
			}
		}

		function get_whr_categories( $cid, $intree='', $mode='', $mycategory='', $cids_child='' )
		{
			if( $cid == 0 ) return "1" ;
			else switch( $intree ) {
				case true :
					return $this->whr_categories_intree( $cid, $mode, $mycategory, $cids_child ) ;
				case false :
					return ( $mode == 'Single' ) ? "cid IN ( '".$cid."' )"  : "d.cid IN ( '".$cid."' )" ;
			}
		}

		function whr_categories_from_cids( $category_option, $mode='' )
		{
			$categories = $this->get_cids( $category_option ) ;

			if( $categories === array() ) return "1" ;
			else return $this->get_whr_from_array( $categories, $mode ) ; 
		}

		function whr_categories_intree( $cid, $mode='', $mycategory='', $cids_child='' )
		{
			$tree_arr = $this->get_tree_array( $cid, $mycategory, $cids_child ) ; 
			return $this->get_whr_from_array( $tree_arr, $mode ) ; 
		}

		function whr_categories_intree_from_cids( $category_option, $mode='', $mycategory='', $cids_child='' )
		{
			$categories = $this->get_cids( $category_option ) ;

			if( $categories === array() ) return "1" ;
			$cids = array() ;
			foreach( $categories as $cid ) {
				$cids = array_merge( $cids, $this->get_tree_array( $cid, $mycategory, $cids_child ) ) ;
			}
			return $this->get_whr_from_array( $cids, $mode ) ; 
		}

		function get_cids( $category_option )
		{
			return ( ! is_array ( $category_option ) ) ? $this->myts->idarray_by_explode( $category_option ) : $this->myts->MyIntval( $category_option ) ;
		}

		function get_tree_array( $cid, $mycategory='', $cids_child='' )
		{
			if( empty( $mycategory ) ){
				include_once dirname( dirname(__FILE__) ).'/class/mycategory.php' ;
				$mycategory = new MyCategory( $this->mydirname, 'Show' ) ;
			} 
			return $mycategory->getMycidsIntreeArray( $cid, '', $cids_child ) ; 
		}

		function Total_Num( $whr='', $cid=0, $all=0, $invisible=0, $intree=0 )
		{
			switch( $invisible ) {
				case false :
					$where = ( empty( $all ) ) ? $this->whr_append( 'Single' ) : "( visible = '0' OR visible = '1' )" ;
					break ;
				case true :
					$where = "( visible = '0' OR date > ".time()." OR ( expired > 0 AND expired < ".time().") )" ;
					break ;
			}
			if( ! empty( $whr ) ) $where .= " AND ( $whr )" ;
			$where .= " AND ( ".$this->get_whr_categories( $cid, $intree, 'Single' )." )" ;

			$sql = "SELECT COUNT( lid ) FROM ".$this->table." WHERE $where" ;
			$result = $this->db->query( $sql ) ;
			list( $count ) = $this->db->fetchRow( $result ) ;

			return intval( $count ) ;
		}

		function get_downdata_for_catview( $cid, $whr, $order, $perpage, $current_start, $submitter=0, $mypost=0, $intree=0 )
		{
			switch( $mypost ) {
				case false :
					$where = "( ".$this->get_whr_categories( $cid, $intree )." )" ;
					break ;
				case true :
					$where = "d.submitter IN ( '".$submitter."' )" ;
					break ;
			}
			$where .= " AND ".$this->whr_append()." AND ( $whr ) " ;
			$sql = $this->default_sql() ." WHERE $where ORDER BY $order" ;
			$result = $this->db->query( $sql, $perpage, $current_start ) ;

			if ( $this->db->getRowsNum( $result ) == 0 ) return '';
			else return $this->get_downdata( $result ) ;
		}

		function get_downdata_for_topview( $whr, $limit )
		{
			$cache_time = 86400 ;
			$site_salt = substr( md5( XOOPS_URL ) , -4 ) ;
			$cache = XOOPS_TRUST_PATH.'/cache/'.$this->mydirname.'_topview_'.$site_salt.'.php' ;

			$cache_postponement = ( ! $this->xoops_isuser ) ? $this->cache_postponement( $cache_time ) : 0 ;

			switch( true ) {
				case ( $this->xoops_isuser || ! file_exists( XOOPS_TRUST_PATH.'/cache/' ) || ! empty( $cache_postponement ) )  :
					return $this->get_data_of_topview( $whr, $limit ) ;
				case ( file_exists( $cache ) && filemtime( $cache ) + $cache_time > time() ) :
					$data = @unserialize( join( '', file( $cache ) ) ) ;
					return ( is_array( $data ) ) ? $data : $this->get_data_of_topview( $whr, $limit ) ;
				default :
					$data = $this->get_data_of_topview( $whr, $limit ) ;
					if ( $fp = @fopen( $cache, 'wb' ) ){
						fputs( $fp, serialize( $data ) ) ;
						fclose( $fp ) ;
					}
					return $data ;
			}
		}

		function cache_postponement( $time )
		{
			$limit = time() + $time ;
			$sql  = "SELECT COUNT( lid ) FROM ".$this->table." WHERE visible = '1'" ;
			$sql .= " AND ( ( date > ".time()." AND date < ".$limit.")" ;
			$sql .= " OR ( expired > 0 AND expired > ".time()." AND expired < ".$limit.") )" ;

			$result = $this->db->query( $sql ) ;
			list( $count ) = $this->db->fetchRow( $result ) ;

			return intval( $count ) ;
		}

		function get_data_of_topview( $whr, $limit )
		{
			$sql = $this->default_sql() ." WHERE ".$this->whr_append()." AND ( $whr ) ORDER BY d.date DESC" ;
			$result = $this->db->query( $sql, $limit, 0 ) ;

			if ( $this->db->getRowsNum( $result ) == 0 ) return '';
			else return $this->get_downdata( $result, 'Top' ) ;
		}

		function get_downdata_for_mylink( $cid, $whr, $order, $perpage, $current_start, $intree=0 )
		{
			$idarray = $this->get_mylink_idarray() ;
			if( empty( $idarray ) ) return '';

			$sql  = $this->default_sql() ." WHERE ( ".$this->get_whr_categories( $cid, $intree )." ) AND ( $whr )" ;
			$sql .= " AND ".$this->whr_append()." AND ( ".$this->get_whr_mylink( $idarray )." ) ORDER BY $order" ;
			$result = $this->db->query( $sql, $perpage, $current_start ) ;

			if ( $this->db->getRowsNum( $result ) == 0 ) return '';
			else return $this->get_downdata( $result ) ;
		}

		function get_downdata( $result, $mode='' )
		{
			global $xoopsConfig ;

			$idarray = $this->get_mylink_idarray() ;
			while( $array = $this->db->fetchArray( $result ) ) {
				foreach ( $array as $key=>$value ){
					$this->$key = $value;
				}
				$id          = $this->return_lid() ;
				$cid         = $this->return_cid() ;
				$title       = $this->return_title('Show') ;
				$url         = $this->return_url('Show') ;
				$submitter   = $this->return_submitter() ;
				$filename    = $this->return_filename('Show') ;
				$ext         = $this->return_ext('Show') ;
				$file_info   = $this->file_link( $id, $cid, $title, $url, $filename, $ext ) ;
				$file2       = $this->return_file2('Show') ;
				$filename2   = $this->return_filename2('Show') ;
				$ext2        = $this->return_ext2('Show') ;
				$file_info2  = $this->file_link( $id, $cid, $title, $file2, $filename2, $ext2, 0, 1 ) ;
				$logourl     = $this->return_logourl('Show') ;
				$html        = $this->return_html() ;
				$smiley      = $this->return_smiley() ;
				$xcode       = $this->return_xcode() ;
				$br          = $this->return_br() ;
				$filters     = $this->return_filters() ;
				$body        = $this->myts->displayTarea( $this->return_description('Show'), $html, $smiley, $xcode, 1, $br, $filters ) ;
				$date        = $this->return_date() ;
				$hits        = $this->return_hits() ;
				$downdata[] = array(
					'id'           => $id ,
					'cid'          => $cid ,
					'category'     => $this->return_category('Show') ,
					'title'        => $title ,
					'url'          => $url ,
					'filename'     => $filename ,
					'filelink'     => $file_info['filelink'] ,
					'broken_link'  => $file_info['broken_link'] ,
					'gif_image'    => $file_info['gif_image']  ,
					'md5'          => $file_info['md5']  ,
					'filename2'    => $filename2 ,
					'filelink2'    => $file_info2['filelink'] ,
					'broken_link2' => $file_info2['broken_link'] ,
					'gif_image2'   => $file_info2['gif_image']  ,
					'md5_2'        => $file_info2['md5']  ,
					'homepage'     => $this->getlink_for_homepage() ,
					'version'      => $this->return_version('Show') ,
					'size'         => $this->PrettySize( $this->return_size() ) ,
					'platform'     => $this->return_platform('Show') ,
					'license'      => $this->return_license('Show') ,
					'description'  => $this->return_body( $id, $cid, $body, 0, 0 ) ,
					'extra'        => $this->return_extra('Show') ,
					'submitter'    => $submitter ,
					'postname'     => $this->getlink_for_postname( $submitter ) ,
					'user_url'     => $this->return_user_url( $submitter ) ,
					'mypost_more'  => $this->return_mypost_more( $submitter ) ,
					'updated'      => formatTimestamp( intval( $date ),'s', $xoopsConfig['default_TZ'] ) ,
					'date'         => $date ,
					'hits'         => $hits ,
					'rating'       => $this->return_rating() ,
					'votes'        => $this->return_votes() ,
					'mylink'       => $this->return_mylink() ,
					'd3comment'    => $this->config_d3comment() ,
					'cancomment'   => $this->return_cancomment() ,
					'comments'     => $this->return_comments() ,
					'canedit'      => $this->can_edit_for_cat( $cid, $submitter ) ,
					'new'          => $this->newdownloadgraphic( $date, $id ) ,
					'pop'          => $this->popgraphic( $hits ) ,
					'shots'        => $this->shots_link( $cid, $url, $file_info['filelink'], $logourl ) ,
					'mail_link'    => $this->mail_link( $id, $cid ) ,
					'is_mylink'    => $this->is_mylink_lid( $id, $idarray, $mode ) ,
				) ;
			}
			return $downdata;
		}

		function get_downdata_for_singleview( $whr='', $lid, $cid=0, $single=0, $novisit=0, $block=0 )
		{
			global $xoopsConfig ;

			$where = "d.lid='".$lid."'" ;
			if( ! empty( $cid ) ) $where .= " AND d.cid='".$cid."'" ;
			if( ! empty( $whr ) ) $where .= " AND ( $whr )" ;
			if( ! $this->xoops_isadmin || ( $this->xoops_isadmin && ! empty( $block ) ) ) $where .= " AND ".$this->whr_append()."" ;

			$sql = $this->default_sql() ." WHERE $where" ;
			$result = $this->db->query( $sql ) ;
			if ( $this->db->getRowsNum( $result ) == 0 ) {
				return '';
			}
			$this->getData( $result ) ;
			$id          = $this->return_lid() ;
			$cid         = $this->return_cid() ;
			$title       = $this->return_title('Show') ;
			$url         = $this->return_url('Show') ;
			$submitter   = $this->return_submitter() ;
			$filename    = $this->return_filename('Show') ;
			$ext         = $this->return_ext('Show') ;
			$file_info   = $this->file_link( $id, $cid, $title, $url, $filename, $ext, $novisit, 0, $block ) ;
			$file2       = $this->return_file2('Show') ;
			$filename2   = $this->return_filename2('Show') ;
			$ext2        = $this->return_ext2('Show') ;
			$file_info2  = $this->file_link( $id, $cid, $title, $file2, $filename2, $ext2, $novisit, 1, $block ) ;
			$logourl     = $this->return_logourl('Show') ;
			$html        = $this->return_html() ;
			$smiley      = $this->return_smiley() ;
			$xcode       = $this->return_xcode() ;
			$br          = $this->return_br() ;
			$filters     = $this->return_filters() ;
			$body        = $this->myts->displayTarea( $this->return_description('Show'), $html, $smiley, $xcode, 1, $br, $filters ) ;
			$date        = $this->return_date() ;
			$hits        = $this->return_hits() ;
			$downdata = array(
				'id'           => $id ,
				'cid'          => $cid ,
				'category'     => $this->return_category('Show') ,
				'title'        => $title ,
				'url'          => $url ,
				'filename'     => $filename ,
				'filelink'     => $file_info['filelink'] ,
				'broken_link'  => $file_info['broken_link'] ,
				'gif_image'    => $file_info['gif_image']  ,
				'md5'          => $file_info['md5']  ,
				'filename2'    => $filename2 ,
				'filelink2'    => $file_info2['filelink']  ,
				'broken_link2' => $file_info2['broken_link'] ,
				'gif_image2'   => $file_info2['gif_image']  ,
				'md5_2'        => $file_info2['md5']  ,
				'homepage'     => $this->getlink_for_homepage() ,
				'version'      => $this->return_version('Show') ,
				'size'         => $this->PrettySize( $this->return_size() , $block ) ,
				'platform'     => $this->return_platform('Show') ,
				'license'      => $this->return_license('Show') ,
				'description'  => $this->return_body( $id, $cid, $body, $single, $block ) ,
				'extra'        => $this->return_extra('Show', 1, $block ) ,
				'submitter'    => $submitter ,
				'postname'     => $this->getlink_for_postname( $submitter ) ,
				'user_url'     => $this->return_user_url( $submitter ) ,
				'mypost_more'  => $this->return_mypost_more( $submitter, $block ) ,
				'updated'      => formatTimestamp( $date,'s', $xoopsConfig['default_TZ'] ) ,
				'date'         => $date ,
				'hits'         => $hits ,
				'rating'       => $this->return_rating() ,
				'votes'        => $this->return_votes() ,
				'mylink'       => $this->return_mylink() ,
				'd3comment'    => $this->config_d3comment() ,
				'cancomment'   => $this->return_cancomment() ,
				'comments'     => $this->return_comments() ,
				'canedit'      => $this->can_edit_for_cat( $cid, $submitter ) ,
				'new'          => $this->newdownloadgraphic( $date, $id, $block ) ,
				'pop'          => $this->popgraphic( $hits, $block ) ,
				'shots'        => $this->shots_link( $cid, $url, $file_info['filelink'], $logourl ) ,
				'singlelink'   => true ,
				'mail_link'    => $this->mail_link( $id, $cid, $block ) ,
				'is_mylink'    => $this->is_mylink_lid( $id, $this->get_mylink_idarray() ) ,
			) ;
			return $downdata;
		}

		function get_downdata_for_topten( $whr, $order )
		{
			include_once dirname( dirname(__FILE__) ).'/class/mycategory.php' ;
			$mycategory = new MyCategory( $this->mydirname, 'Show' ) ;

			$e = 0 ;
			$sql  = "SELECT cid AS catid, title AS category, cids_child FROM ".$this->cat_table."" ;
			$sql .= " WHERE pid='0' AND ( $whr ) ORDER BY cat_weight ASC" ;

			$result = $this->db->query( $sql ) ;
			while( $array = $this->db->fetchArray( $result ) ) {
				foreach ( $array as $key=>$value ){
					$this->$key = $value ;
				}
				$catid = intval( $this->catid ) ;
				$category= $this->return_category('Show') ;
				$downdata[$e]['title'] = sprintf( _MD_D3DOWNLOADS_TOP_TEN_TOP10 , $category ) ;

				$columns = "d.lid, d.cid, d.title, d.hits, d.rating, d.votes, c.path" ;
				$sql  = "SELECT $columns FROM ".$this->table." d LEFT JOIN ".$this->cat_table." c ON d.cid=c.cid WHERE ".$this->whr_append()."" ;
				$sql .= " AND ( ".$this->whr_categories_intree( $catid, '', $mycategory, $this->cids_child )." ) ORDER BY $order DESC" ;
				$trs = $this->db->query( $sql, 10, 0 ) ;
				$rank = 1 ;
				while( $array = $this->db->fetchArray( $trs ) ) {
					foreach ( $array as $key=>$value ){
						$this->$key = $value ;
					}
					$cid        = $this->return_cid() ;
					$path_array = $mycategory->unserialize_my_path( $cid, $whr, $this->path ) ; 
					$downdata[$e]['file'][] = array(
						'id'       => $this->return_lid() ,
						'cid'      => $cid ,
						'rank'     => $rank ,
						'title'    => $this->return_title('Show') ,
						'category' => $mycategory->getPathArrayFromId( $cid, $whr, $path_array ) ,
						'hits'     => $this->return_hits() ,
						'rating'   => number_format( $this->return_rating(), 2 ) ,
						'votes'    => $this->return_votes() ,
					) ;
					$rank++ ;
				}
				$e++ ;
			}

			return $downdata ;
		}

		function get_downdata_for_filelist( $cid=0, $whr, $order, $perpage, $current_start, $intree=0 )
		{
			global $xoopsConfig ;

			$sql  = $this->default_sql() ." WHERE ".$this->whr_append()." AND ( $whr )" ;
			$sql .= " AND ( ".$this->get_whr_categories( $cid, $intree )." ) ORDER BY $order" ;
			$result = $this->db->query( $sql, $perpage, $current_start ) ;
			if ( $this->db->getRowsNum( $result ) == 0 ) {
				return '';
			}

			while( $array = $this->db->fetchArray( $result ) ) {
				foreach ( $array as $key=>$value ){
					$this->$key = $value;
				}
				$submitter = $this->return_submitter() ;
				$date      = $this->return_date() ;
				$filters   = $this->return_filters() ;
				$downdata[] = array(
					'id'        => $this->return_lid() ,
					'cid'       => $this->return_cid() ,
					'category'  => $this->return_category('Show') ,
					'title'     => $this->return_title('Show') ,
					'version'   => $this->return_version('Show') ,
					'size'      => $this->PrettySize( $this->return_size() ) ,
					'platform'  => $this->return_platform('Show') ,
					'license'   => $this->return_license('Show') ,
					'summary'   => $this->return_summary( $this->return_description('Show'), $filters ) ,
					'submitter' => $submitter ,
					'postname'  => $this->getlink_for_postname( $submitter ) ,
					'user_url'  => $this->return_user_url( $submitter ) ,
					'updated'   => formatTimestamp( $date,'s', $xoopsConfig['default_TZ'] ) ,
					'date'      => $date ,
					'hits'      => $this->return_hits() ,
					'rating'    => $this->return_rating() ,
					'votes'     => $this->return_votes() ,
					'mylink'    => $this->return_mylink() ,
					'd3comment' => $this->config_d3comment() ,
					'comments'  => $this->return_comments() ,
				) ;
			}

			return $downdata;
		}

		function getlink_for_homepage()
		{
			$url = $this->return_homepage( 'Show' ) ;
			$title = $this->return_homepagetitle( 'Show' ) ;
			if( empty( $title ) && $url == XOOPS_URL.'/' ) {
				global $xoopsConfig ;
				$title = $xoopsConfig['sitename'] ;
			}

			switch( true ) {
				case ( ! empty( $url ) && $url != 'http://' && ! empty( $title ) ) :
					return '<a href="'.$url.'" target="_blank" title="'.$title.'" >'.$title.'</a>' ;
				case ( ! empty( $url ) && $url != 'http://' && empty( $title ) ) :
					return '<a href="'.$url.'" target="_blank" title="'.$url.'" >'.$url.'</a>' ;
				case ( ( empty( $url ) || $url == 'http://' ) && ! empty( $title ) ) :
					return $title ;
				default :
					return '' ;
			}
		}

		function replace_current_data( $text )
		{
			global $xoopsConfig ;

			$expired = ( $this->expired ) ? formatTimestamp( $this->return_expired(), 'l', $xoopsConfig['default_TZ'] ) : '' ;

			$searches = array(
				'[title]' ,
				'[filename]' ,
				'[filename2]' ,
				'[expired]' ,
			) ;
			$replacements = array(
				$this->return_title('Show') ,
				$this->return_filename('Show') ,
				$this->return_filename2('Show') ,
				$expired ,
			) ;
			return str_replace( $searches , $replacements , $text ) ;
		}

		function return_body( $id, $cid, $body, $single, $block=0, $rss=0 )
		{
			switch( $single ) {
				case false :
					if ( strstr ( $body , '[pagebreak]' ) ) $body = $this->division_by_pagebreak( $id, $cid, $body, $block ) ;
					break ;
				case true :
					if ( strstr ( $body , '[pagebreak]' ) ) $body = str_replace( '[pagebreak]','', $body ) ;
					break ;
			}
			$searches = '`<a href="#`i' ;
			$replacements = '<a href="'.$this->mod_url.'/index.php?page=singlefile&amp;cid='.$cid.'&lid='.$id.'#' ;
			$body = preg_replace( $searches , $replacements , $body ) ;

			if( ! empty( $rss ) ) $body = $this->replace_tags( $body ) ;
			return $body;
		}

		function division_by_pagebreak( $id, $cid, $text, $block=0 )
		{
			list( $str ) = explode( '[pagebreak]', $text , 2 ) ;
			$text  = $str.'<br /><div align="right"><a href="'.$this->mod_url.'/index.php?page=singlefile&amp;cid='.$cid.'&lid='.$id.'">' ;
			$text .= ( empty( $block ) ) ? _MD_D3DOWNLOADS_SHOWSINGLEFILE : _MB_D3DOWNLOADS_LANG_SHOWSINGLEFILE ;
			$text .= '</a></div>' ;

			return $text ;
		}

		function replace_tags( $text )
		{
			$text = str_replace( ']]>', ']]&gt;', $text ) ;
			$text = preg_replace( '`<(script|form|embed|object).+?/\\1>`is', '',$text ) ;

			return $text ;
		}

		function return_summary( $body, $filters )
		{
			$str = strip_tags( $this->myts->displayTarea( strip_tags( $body ), 0, 1, 1, 1, 1, $filters ) ) ;

			if ( strstr ( $str , '[pagebreak]' ) ){
				return str_replace( '[pagebreak]','', $str ) ;
			} else {
				return $str ;
			}
		}

		function Real_path( $text )
		{
			$searches     = array( '`XOOPS_TRUST_PATH`i' , '`XOOPS_ROOT_PATH`i', '`XOOPS_URL`i' ) ;
			$replacements = array( XOOPS_TRUST_PATH , XOOPS_ROOT_PATH, XOOPS_URL ) ;
			$text         = preg_replace( $searches , $replacements , $text ) ;

			return $text ;
		}

		function get_postname( $submitter )
		{
			if ( $submitter > 0 ) {
				return $this->get_user_postname( $submitter ) ;
			} else {
				global $xoopsConfig;
				return $xoopsConfig['anonymous'] ;
			}
		}

		function get_user_postname( $submitter )
		{
			$member_handler =& xoops_gethandler('member') ;
			$member =& $member_handler->getUser( $submitter ) ;
			if ( $member ) $postname = ( $member->getvar('name') ) ? $member->getvar('name') : $member->getvar('uname') ;
			else $postname = 'No User';
			return $postname ;
		}

		function getlink_for_postname( $submitter )
		{
			$postname = $this->get_postname( $submitter ) ;
			if ( $submitter > 0 && $postname != 'No User' ){
				return '<a href="'.$this->return_user_url( $submitter ).'">'.$postname.'</a>';
			} else {
				return $postname ;
			}
		}

		function return_user_url( $submitter )
		{
			if ( $submitter > 0 ) {
				return XOOPS_URL."/userinfo.php?uid=".$submitter ;
			} else {
				return '' ;
			}
		}

		function get_user_email( $submitter )
		{
			$member_handler =& xoops_gethandler('member') ;
			$member =& $member_handler->getUser( $submitter ) ;
			return ( $member ) ? $member->getvar('email') : '' ;
		}

		function return_mypost_more( $submitter, $block=0 )
		{
			$postname = $this->get_postname( $submitter ) ;
			$mypost_more = ( empty( $block ) ) ? _MD_D3DOWNLOADS_MYPOST_MORE : _MB_D3DOWNLOADS_MYPOST_MORE ;
			$mypost_link = sprintf( $mypost_more , $postname ) ;

			return '<a href="'.$this->mod_url.'/index.php?submitter='.$submitter.'">'.$mypost_link.'</a>' ;
		}

		function return_gif_image( $ext )
		{
			if( $ext == 'gz' ) $ext = 'tgz' ;
			elseif( $ext == 'tbz' ) $ext = 'bz2' ;

			switch( $ext ) {
				case 'zip':
					return 'zip.gif' ;
				case 'lzh':
					return 'lzh.gif' ;
				case 'tgz':
					return 'tgz.gif' ;
				case 'cab':
					return 'cab.gif' ;
				case 'bz2':
					return 'bz2.gif' ;
				case 'xls':
					return 'xls.gif' ;
				case 'doc':
					return 'doc.gif' ;
				case 'pdf':
					return 'pdf.gif' ;
			}
			
			$image_path = XOOPS_ROOT_PATH.'/modules/'.$this->mydirname.'/images/'. $ext .'.gif';

			if( file_exists( $image_path ) ) return $ext .'.gif' ;
			else return 'download.gif' ;
		}

		function newdownloadgraphic( $time, $id, $block=0 )
		{

			$count = $this->mod_config['newmark'] ;
			$new = '';
			$startdate = ( time() - ( 86400 * $count ) ) ;

			$sql = "SELECT COUNT(*) FROM ".$this->db->prefix( $this->mydirname."_downloads_history" )." WHERE date < ".$time." AND lid= ".$id."" ;
			list( $count ) = $this->db->fetchRow( $this->db->query( $sql ) ) ;

			if ( $startdate < $time ) {
				if( empty( $count ) ){
					$new = '&nbsp;<img src="'.$this->mod_url.'/images/newred.gif"';
					$newthisweek = ( empty( $block ) ) ? _MD_D3DOWNLOADS_NEWTHISWEEK : _MB_D3DOWNLOADS_NEWTHISWEEK ;
					$new .= ' alt="'.$newthisweek.'" title="'.$newthisweek.'" />';
				} else {
					$new = '&nbsp;<img src="'.$this->mod_url.'/images/update.gif"';
					$upthisweek = ( empty( $block ) ) ? _MD_D3DOWNLOADS_UPTHISWEEK : _MB_D3DOWNLOADS_UPTHISWEEK ;
					$new .= ' alt="'.$upthisweek.'" title="'.$upthisweek.'" />';
				}
			}

			return $new ;
		}

		function popgraphic( $hits, $block=0 )
		{
			$pop = '';

			if ( $hits >= $this->mod_config['popular'] ) {
				$pop = '&nbsp;<img src ="'.$this->mod_url.'/images/pop.gif"';
				$popular = ( empty( $block ) ) ? _MD_D3DOWNLOADS_POPULAR : _MB_D3DOWNLOADS_POPULAR ;
				$pop .= ' alt="'.$popular.'" title="'.$popular.'" />';
			}

			return $pop;
		}

		function Exception_extension()
		{
			return array( 'arj' , 'bz2' , 'cab' , 'gz' , 'jar' , 'lzh' , 'rar' , 'tar' , 'taz' , 'tbz' , 'tgz' , 'z' , 'zip' ) ;
		}

		function file_link( $id, $cid, $title='', $url, $filename, $ext, $novisit=0, $second = 0, $block=0 )
		{
			$broken_link = 0 ;
			$filelink = $md5 = '' ;
			$exception = '\.'.implode( '|\.',$this->Exception_extension() ) ;

			$visit     =  $this->mod_url.'/index.php?page=visit&cid='.$cid.'&lid='.$id ;
			$visit_url =  $this->mod_url.'/index.php?page=visit_url&cid='.$cid.'&lid='.$id ;

			if ( ! preg_match("`^(https?|ftp)://`i", $url ) ) {
				if( ! $this->check_file( $url ) ){
					// ファイル破損の場合はリンクを表示しない
					$broken_link = 1 ;
					$gif_image = "" ;
				} else {
					if( empty( $filename ) ){
						$f_info   = $this->get_filename( $url ) ;
						$filename = $f_info['filename'] ;
						$ext      = $f_info['extension'] ;
					}

					$titleattribute = ( ! empty( $filename ) ) ? $filename : $this->title_attribute( $title, $ext, $block ) ;

					switch( $second ) {
						case false :
							if( empty( $novisit ) ) $filelink .=  '<a href="'.$visit.'" title="'.$titleattribute.'" >' ;
							else $filelink =  '<a href="'.$visit_url.'">' ;
							break ;
						case true :
							if( empty( $novisit ) ) $filelink =  '<a href="'.$visit.'&second=1" title="'.$titleattribute.'" >' ;
							else $filelink =  '<a href="'.$visit_url.'&second=1">' ;
							break ;
					}

					$gif_image = ( ! empty( $ext ) ) ? $this->return_gif_image( $ext ) : 'download.gif' ;
					$md5       = $this->get_md5_hash( $url, $filename, $block ) ;
				}
			} elseif ( preg_match('`('.$exception.')$`i', $url ) ) {
				switch( $novisit ) {
					case false :
						$filelink =  '<a href="'.$visit.'" title="'.$title.'" >' ;
						break ;
					case true :
						$filelink =  '<a href="'.$visit_url.'">' ;
						break ;
				}
				$gif_image = 'download.gif';
			} else {
				switch( $novisit ) {
					case false :
						$filelink =  '<a href="'.$visit.'" target="_blank" title="'.$title.'" >' ;
						break ;
					case true :
						$filelink =  '<a href="'.$visit_url.'" target="_blank">' ;
						break ;
				}
				$gif_image = 'download.gif';
			}

			return array(
				'broken_link' => $broken_link ,
				'filelink'    => $filelink ,
				'gif_image'   => $gif_image ,
				'md5'         => $md5 ,
			) ;
		}

		function get_filename( $file )
		{
			$f_info  = pathinfo( $file ) ;
			return array(
				'filename'  => ( ! empty( $f_info['basename'] ) ) ? $f_info['basename'] : '' ,
				'extension' => ( ! empty( $f_info['extension'] ) ) ? strtolower( $f_info['extension'] ) : '' ,
			) ;
		}

		function check_file( $file )
		{
			return ( ! is_file( $file ) || filesize( $file ) == 0 ) ? false : true ;
		}

		function title_attribute( $title, $ext, $block )
		{
			if( empty( $ext ) ) return $title ;

			$str  = $title .' ( '.$ext ;
			$str .= ( empty( $block ) ) ? _MD_D3DOWNLOADS_FILE.' )' : _MB_D3DOWNLOADS_FILE.' )' ;
			return $str ;
		}

		function get_md5_hash( $url, $filename, $block=0 )
		{
			$md5str = ( empty( $block ) ) ? _MD_D3DOWNLOADS_MD5 : _MB_D3DOWNLOADS_MD5 ;
			return sprintf( $md5str , $filename, md5_file( $url ) ) ;
		}

		function can_useshots()
		{
			return  ! empty( $this->mod_config['useshots'] ) ? 1 : 0 ;
		}

		function myalbum_dirname()
		{
			return htmlspecialchars( $this->mod_config['albumselect'] , ENT_QUOTES ) ;
		}

		function album_module()
		{
			return htmlspecialchars( $this->mod_config['album_module_select'] , ENT_QUOTES ) ;
		}

		function can_albumselect( $dirname='' )
		{
			$usealbum = 0 ;

			if( empty( $dirname ) ){
				$dirname = $this->myalbum_dirname() ;
			}
			if( ! empty( $this->mod_config['usealbum'] )  && ! empty( $this->mod_config['albumselect'] ) ){
				$myalbum_path = XOOPS_ROOT_PATH .'/modules/'.$dirname ;
				$usealbum = file_exists( $myalbum_path ) ? 1 : 0 ;
			}

			return $usealbum;
		}

		function shots_link( $cid, $url, $filelink, $logourl )
		{
			$exception = '\.'.implode( '|\.',$this->Exception_extension() ) ;
			$maxwidth = intval( $this->mod_config['shotwidth'] ) ;
			$myalbum_dirname = $this->myalbum_dirname() ;
			$usealbum = $this->can_albumselect( $myalbum_dirname ) ;

			if( preg_match ('/(\.gif|\.jpe?g|\.png)$/i', $logourl ) ){
				$shots_link = $this->shots_img_link( $cid, $url, $filelink, $logourl, $maxwidth ) ;
			} elseif ( ! empty( $logourl ) &&  ! empty( $usealbum ) ){
				$shots_link = $this->get_album_link( $myalbum_dirname, $logourl, $maxwidth ) ;
			} elseif( empty( $logourl ) && preg_match('/('.$exception.')$/i', $url ) ) {
				$shots_link = '';
			} elseif( ! empty( $this->mod_config['shotselect'] ) && preg_match ('/^https?:\/\/.+\..+/i', $url ) ) {
				$shots_link = $filelink.'<img src="http://mozshot.nemui.org/shot/large?'.$url.'" class="d3downloads_imgurl_frame" width="'.$maxwidth.'" height="'.$maxwidth.'" align="left"></a>';
			} else {
				$shots_link = '';
			}

			return $shots_link ;
		}

		function shots_img_link( $cid, $url, $filelink, $logourl, $maxwidth )
		{
			include_once dirname( dirname(__FILE__) ).'/class/mycategory.php' ;
			$mycategory = new MyCategory( $this->mydirname, 'Show', $cid ) ;

			$cate_shotsdir = $mycategory->return_shotsdir() ;
			if( ! empty( $cate_shotsdir ) && file_exists( XOOPS_ROOT_PATH.'/'.$cate_shotsdir ) ){
				$shots_dir = XOOPS_URL.'/'.$cate_shotsdir . $logourl;
				$shots_path = XOOPS_ROOT_PATH.'/'.$cate_shotsdir . $logourl ;
			} else {
				$shots_dir = $this->mod_url.'/images/shots/'.$logourl;
				$shots_path = XOOPS_ROOT_PATH.'/modules/'.$this->mydirname.'/images/shots/'.$logourl ;
			}

			if ( file_exists( $shots_path ) ){
				list( $width , $height ) = $this->get_imagesize( $shots_path, $maxwidth ) ;
				return $filelink.'<img src="'.$shots_dir.'" class="d3downloads_imgurl_frame" width="'.$width.'" height="'.$height.'" align="left"></a>';
			}
		}

		function get_imagesize( $image_path, $maxwidth='' )
		{
			list( $file_width , $file_height ) = getimagesize( $image_path ) ;

			if ( empty( $maxwidth ) ) $maxwidth = intval( $this->mod_config['shotwidth'] ) ;

			$width  = ( ! empty( $file_width ) ) ? intval( $file_width ) : $maxwidth ;
			$height = ( ! empty( $file_height ) ) ? intval( $file_height ) : 0 ;
			if ( $width > $maxwidth ){
				$showsize = $maxwidth / $width ;
				$width    = $width * $showsize ;
				$height   = $height * $showsize ;
			}
			return array( $width ,$height ) ;
		}

		function get_album_link( $dirname, $logourl, $maxwidth )
		{
			switch( $this->album_module() ) {
				case "myAlbum-P":
					return $this->get_myalbum_p_link( $dirname, $logourl, $maxwidth ) ;
				case "GnaviD3":
					return $this->get_gnavi_link( $dirname, $logourl, $maxwidth ) ;
				case "webphoto":
					return $this->get_webphoto_link( $dirname, $logourl, $maxwidth ) ;
			}
		}

		function get_myalbum_p_link( $dirname, $id, $maxwidth )
		{
			$myalbum_path = XOOPS_ROOT_PATH .'/modules/'. $dirname;
			if ( ! file_exists( $myalbum_path .'/include/read_configs.php' ) ) return '' ;
			include $myalbum_path .'/include/read_configs.php';

			$photo_array = $photo = array() ;

			$album_lid= intval( $id ) ;
			if ( empty( $album_lid ) ) return '' ;

			$photo_array = $this->get_myalbum_photo_array( $table_photos, $album_lid ) ;
			if ( empty( $photo_array ) ) return '' ;
			$photo = array(
				'id'    => $photo_array['lid'] ,
				'name'  => $photo_array['title'] ,
				'ext'   => $photo_array['ext'] ,
				'res_x' => $photo_array['res_x'] ,
				'res_y' => $photo_array['res_y']
			) ;

			return $this->get_album_link_execution( $dirname, $maxwidth, $photos_url, $thumbs_url, $thumbs_dir, $photo ) ;
		}

		function get_gnavi_link( $mydirname, $logourl, $maxwidth )
		{
			if ( ! file_exists( XOOPS_TRUST_PATH.'/modules/gnavi/include/read_configs.php' ) ) return '' ;
			include XOOPS_TRUST_PATH.'/modules/gnavi/include/read_configs.php' ;

			$photo_array = $photo = array() ;
			list( $id ) = explode( '_', $logourl , 2 ) ;
			$album_lid= intval( $id ) ;
			if ( empty( $album_lid ) ) return '' ;

			$photo_array = $this->get_myalbum_photo_array( $table_photos, $album_lid ) ;
			if ( empty( $photo_array ) ) return '' ;

			if( preg_match ('/^[0-9]+$/', $logourl ) ) $photo = array(
				'id'    => $photo_array['lid'] ,
				'name'  => ( empty( $photo_array['caption'] ) ) ? $photo_array['title'] .'( 1 )' : $photo_array['caption'] ,
				'ext'   => $photo_array['ext'] ,
				'res_x' => $photo_array['res_x'] ,
				'res_y' => $photo_array['res_y']
			) ;
			elseif ( strpos ( $logourl , '_1' ) ) $photo = array(
				'id'    =>$photo_array['lid'] .'_1',
				'name'  => ( empty( $photo_array['caption1'] ) ) ? $photo_array['title'] .'( 2 )' : $photo_array['caption1'] ,
				'ext'   => $photo_array['ext1'] ,
				'res_x' => $photo_array['res_x1'] ,
				'res_y' => $photo_array['res_y1']
			) ;
			elseif ( strpos ( $logourl , '_2' ) ) $photo = array(
				'id'    => $photo_array['lid'] .'_2' ,
				'name'  => ( empty( $photo_array['caption2'] ) ) ? $photo_array['title'] .'( 3 )' : $photo_array['caption2'] ,
				'ext'   => $photo_array['ext2'] ,
				'res_x' => $photo_array['res_x2'] ,
				'res_y' => $photo_array['res_y2']
			) ;

			return $this->get_album_link_execution( $mydirname, $maxwidth, $photos_url, $thumbs_url, $thumbs_dir, $photo ) ;
		}

		function get_webphoto_link( $dirname, $id, $maxwidth )
		{
			if ( ! file_exists( XOOPS_TRUST_PATH.'/modules/webphoto/' ) ) return '' ;

			$item_array = $cont_array = $thumb_array = $photo = array() ;

			$item_id= intval( $id ) ;
			if ( empty( $item_id ) ) return '' ;

			$item_array = $this->get_webphoto_item_array( $dirname, $item_id ) ;
			if ( empty( $item_array ) ) return '' ;
			$cont_array  = $this->get_webphoto_file_array_by_kind( $dirname, $item_array, 1 ) ;
			$thumb_array = $this->get_webphoto_file_array_by_kind( $dirname, $item_array, 2 ) ;

			$photo = array(
				'id'          => $item_array['item_id'] ,
				'name'        => $item_array['item_title'] ,
				'file_url'    => $cont_array['file_url'] ,
				'res_x'       => $cont_array['file_width'] ,
				'res_y'       => $cont_array['file_height'] ,
				'thumbs_url'  => $thumb_array['file_url'] ,
				'thumbs_path' => XOOPS_ROOT_PATH .$thumb_array['file_path'] ,
				'ext'         => $thumb_array['file_ext']
			) ;

			return $this->get_album_link_execution( $dirname, $maxwidth, '', '', '', $photo, 'webphoto' ) ;
		}

		function get_myalbum_photo_array( $table_photos, $album_lid=0 )
		{
			$sql = "SELECT * FROM $table_photos WHERE status > 0" ;
			if ( ! empty( $album_lid ) ) $sql .= " AND lid='".$album_lid."'" ;
			else $sql .= " ORDER BY date DESC, lid DESC" ;

			return $this->get_array_from_sql( $sql, $album_lid ) ;
		}

		function get_webphoto_item_array( $dirname, $item_id=0 )
		{
			$table_item = $this->db->prefix( "{$dirname}_item" ) ;

			$sql = "SELECT * FROM $table_item WHERE item_status > 0" ;
			if ( ! empty( $item_id ) ) $sql .= " AND item_id='".$item_id."'" ;
			else $sql .= " ORDER BY item_time_update DESC, item_id DESC" ;

			return $this->get_array_from_sql( $sql, $item_id ) ;
		}

		function get_webphoto_file_array_by_kind( $dirname, $item_array, $kind )
		{
			$name = 'item_file_id_'.$kind;
			$table_file = $this->db->prefix( "{$dirname}_file" ) ;

			if ( isset( $item_array[ $name ] ) ) $id = intval( $item_array[ $name ] ) ;
			if ( $id > 0 ) {
				$sql = "SELECT * FROM $table_file WHERE file_id='".$id."'" ;
				return $this->get_array_from_sql( $sql, $id ) ;
			} 
		}

		function get_array_from_sql( $sql, $id=0 )
		{
			$result = $this->db->query( $sql ) ;
			if ( $this->db->getRowsNum( $result ) == 0 ) {
				return '' ;
			}

			switch( $id ) {
				case true :
					return $this->db->fetchArray( $result ) ;
				case false :
					$arr = array() ;
					while ( $array = $this->db->fetchArray( $result ) ){
						$arr[] = $array ;
					}
					return $arr ;
			}
		}

		function get_album_link_execution( $dirname, $maxwidth, $photos_url='', $thumbs_url='', $thumbs_dir='', $photo, $mode='' )
		{
			$myalbum_path = XOOPS_ROOT_PATH .'/modules/'. $dirname;

			$id    = $this->myts->makeTboxData4Show( $photo['id'] ) ;
			$title = $this->myts->makeTboxData4Show( $photo['name'] ) ;
			$ext   = $this->myts->makeTboxData4Show( $photo['ext'] ) ;

			$window_x = intval( $photo['res_x'] ) ;
			$window_y = intval( $photo['res_y'] ) ;

			$image_target = ( $mode != 'webphoto' ) ? $photos_url .'/'. $id .'.'. $ext : $this->myts->makeTboxData4URLShow( $photo['file_url'] ) ;
			$thumbs_path  = ( $mode != 'webphoto' ) ? $thumbs_dir .'/'. $id .'.'. $ext : $this->myts->makeTboxData4Show( $photo['thumbs_path'] ) ;
			if( $mode != 'webphoto' ) $icons_path = $myalbum_path .'/icons/'. $ext .'.gif' ;

			if ( file_exists( $thumbs_path ) ){
				$image_url = ( $mode != 'webphoto' ) ? $thumbs_url .'/'. $id .'.'. $ext : $this->myts->makeTboxData4Show( $photo['thumbs_url'] ) ;

				list( $width , $height ) = $this->get_imagesize( $thumbs_path, $maxwidth ) ;
				switch( $this->option_config( 'use_lightbox' ) ) {
					case true :
						$link = '<a href="'.$image_target.'" target="_blank"  rel="lightbox[]">';
						break ;
					case false :
						$link = '<a href="'.$image_target.'" target="_blank" onClick="window.open(\''.$image_target.'\',\'\',\'width='.$window_x.',height='.$window_y.'\') ;return(false) ;">';
						break ;
				}

				$link .= '<img src="'.$image_url.'" class="d3downloads_imgurl_frame" width="'.$width.'" height="'.$height.'" alt="'.$title.'" title="'.$title.'" align="left" /></a>';
				return $link ;
			} elseif ( file_exists( $icons_path ) && $mode != 'webphoto' ){
				$image_url = XOOPS_URL .'/modules/'. $dirname.'/icons/'. $ext .'.gif' ;

				list( $width , $height ) = $this->get_imagesize( $icons_path, $maxwidth ) ;
				return '<a href="'.$image_target.'" target="_blank"><img src="'.$image_url.'" class="d3downloads_imgurl_frame" width="'.$width.'" height="'.$height.'" alt="'.$title.'" title="'.$title.'" align="left" /></a>';
			}
		}

		function can_edit_for_cat( $cid, $submitter )
		{
			if( $this->xoops_isadmin ){
				$canedit = true ;
			} elseif( $submitter == $this->xoops_userid &&  $this->xoops_isuser ){
				include_once dirname( dirname(__FILE__) ).'/class/user_access.php' ;
				$user_access = new user_access( $this->mydirname ) ;
				if( in_array( $cid, $user_access->can_edit() ) ) return true ;
			} else {
				$canedit = false ;
			}

			return $canedit;
		}

		function config_d3comment()
		{
			// コメント統合の設定をしていない場合は「コメント」のリンクを表示しない
			if ( ! empty ( $this->mod_config['comment_dirname'] ) && ! empty ( $this->mod_config['comment_forum_id'] ) ){
				return true ;
			} else {
				return false ;
			}
		}

		function mail_link( $id, $cid, $block=0 )
		{
			global $xoopsConfig ;

			$intartfound = ( empty( $block ) ) ? _MD_D3DOWNLOADS_INTARTFOUND : _MB_D3DOWNLOADS_INTARTFOUND ;
			if( $this->mod_config['use_tell_a_frined'] ){
				return XOOPS_URL.'/modules/tellafriend/index.php?target_uri='.rawurlencode( "$this->mod_url/index.php?page=singlefile&cid=$cid&lid=$id" ).'&amp;subject='.rawurlencode( sprintf( $intartfound, $xoopsConfig['sitename'] ) ) ;
			} else {
				$intarticle = ( empty( $block ) ) ? _MD_D3DOWNLOADS_INTARTICLE : _MB_D3DOWNLOADS_INTARTICLE ;
				return 'mailto:?subject='.$this->mailto_escape( sprintf( $intarticle, $xoopsConfig['sitename'] ) ).'&amp;body='.$this->mailto_escape( sprintf( $intartfound, $xoopsConfig['sitename'] ) ).'%0A'. rawurlencode( $this->mod_url.'/index.php?page=singlefile&cid='.$cid.'&lid='.$id ) ;
			}
		}

		function mailto_escape( $text )
		{
			if( defined( '_MD_D3DOWNLOADS_MAILTOENCODING' ) ){
				if ( ! extension_loaded( 'mbstring' ) && ! class_exists( 'HypMBString' ) ) {
					require_once dirname( dirname( __FILE__ ) ).'/class/mbemulator/mb-emulator.php' ;
				}
				$text = mb_convert_encoding( $text , _MD_D3DOWNLOADS_MAILTOENCODING ) ;
			}

			return rawurlencode( $text ) ;
		}
/*
		function PrettySize( $size, $block=0 )
		{
			$mb = 1024 * 1024;
			if ( $size > $mb ) {
				$mysize = sprintf ("%01.2f",$size/$mb) . " MB" ;
			} elseif ( $size >= 1024 ) {
				$mysize = sprintf ("%01.2f",$size/1024) . " KB" ;
			} else {
				$numbytes = ( empty( $block ) ) ? _MD_D3DOWNLOADS_NUMBYTES : _MB_D3DOWNLOADS_NUMBYTES ;
				$mysize = sprintf( $numbytes , $size ) ;
			}

			return $mysize ;
		}
*/
		function PrettySize( $size, $block=0 )
		{
			$gb = 1024 * 1024 * 1024;
			$mb = 1024 * 1024;
			if ( $size > $gb ) {
				$mysize = sprintf ("%01.2f",$size/$gb) . " GB" ;
			} elseif ( $size > $mb ) {
				$mysize = sprintf ("%01.2f",$size/$mb) . " MB" ;
			} elseif ( $size >= 1024 ) {
				$mysize = sprintf ("%01.2f",$size/1024) . " KB" ;
			} else {
				$numbytes = ( empty( $block ) ) ? _MD_D3DOWNLOADS_NUMBYTES : _MB_D3DOWNLOADS_NUMBYTES ;
				$mysize = sprintf( $numbytes , $size ) ;
			}

			return $mysize ;
		}

		function is_sameValue( $str1, $str2 )
		{
			 return ( strcmp( $str1, $str2 ) == 0 ) ? true : false ;
		}

		function extra_array( $text, $single=0, $block=0, $forpreview=0 )
		{
			$ret = array() ;

			$value = $this->division_extra_by_pagebreak( $text, $single, $block ) ;
			$count = strpos ( $value , "<<" ) ;

			if ( $count === false || strpos ( $value , ">>" ) === false ) return array() ;

			$array = explode ( "<<", substr( $value, $count + 2 ) ) ;
			
			if( ! empty( $array ) ) foreach( $array as $item ){
				list( $title, $str ) = explode( ">>", $item ) ;
				if( empty( $title ) ) continue ;
				$desc = ( empty( $forpreview ) ) ? trim( $this->replace_current_data( $str ) ) : trim( $str ) ;
				$ret[]=array(
					'title' => $this->myts->makeTboxData4Show( trim( $title ) ) ,
					'desc'  => $this->myts->displayTarea( $desc , 0, 1, 1, 1, 1 ) ,
				) ;
			}
			return $ret ;
		}

		function division_extra_by_pagebreak( $text, $single=0, $block=0 )
		{
			if( ! empty( $single ) && empty( $block ) ) $str = str_replace( '[pagebreak]','', $text ) ;
			else list( $str ) = explode( '[pagebreak]', $text , 2 ) ;
			return trim( $str ) ;
		}

		function mylink_cookie_name()
		{
			return '_' . $this->mydirname ;
		}

		function mylink_cookie()
		{
			return isset( $_COOKIE[ $this->mylink_cookie_name() ] ) ? $_COOKIE[ $this->mylink_cookie_name() ] : '' ;
		}

		function cookie_path()
		{
			$cookie_path = defined( 'XOOPS_COOKIE_PATH' ) ? XOOPS_COOKIE_PATH : preg_replace( '?http://[^/]+(/.*)$?' , "$1" , XOOPS_URL ) ;
			if( $cookie_path == XOOPS_URL ) $cookie_path = '/' ;
			return $cookie_path ;
		}

		function mylink_cookie_expire()
		{
			return time() + ( 86400 * 365 ) ; // one year
		}

		function is_mylink()
		{
			if( $this->xoops_isuser ){
				$result = $this->db->query( "SELECT * FROM ".$this->mylink_table." WHERE uid='".$this->xoops_userid."'" ) ;
				if ( $this->db->getRowsNum( $result ) > 0 ) return true ;
				else return false ;
			} else {
				if ( $this->mylink_cookie() ) return true ;
				else return false ;
			}
		}

		function is_mylink_lid( $lid, $idarray, $mode='' )
		{
			if( empty( $idarray ) ) return false ;
			switch( $mode ) {
				case 'Top' :
					if( $this->xoops_isuser && in_array( $lid, $idarray ) ) return true ;
					else return false ;
				default :
					if( in_array( $lid, $idarray ) ) return true ;
					else return false ;
			}
		}

		function total_mylink( $cid, $whr='', $intree=0, $idarray='' )
		{
			if( $idarray === '' ) $idarray = $this->get_mylink_idarray() ;
			if( empty( $idarray ) ) return 0 ;

			$sql = "SELECT COUNT( lid ) FROM ".$this->table." WHERE ( ". $this->get_whr_mylink( $idarray, 'Single' )." )" ;
			$sql .= " AND ( ".$this->get_whr_categories( $cid, $intree, 'Single' )." ) AND ".$this->whr_append( 'Single' )."" ;
			if ( ! empty( $whr ) ) $sql .= " AND ( $whr )" ;
			$result = $this->db->query( $sql ) ;
			list( $count ) = $this->db->fetchRow( $result ) ;
			return intval( $count ) ;
		}

		function mylink_categories_selbox( $whr )
		{
			include_once dirname( dirname(__FILE__) ).'/class/mycategory.php' ;
			$mycategory = new MyCategory( $this->mydirname, 'Show' ) ;

			$category = array() ;
			$idarray = $this->get_mylink_idarray() ;
			if( empty( $idarray ) ) return array() ;

			$sql  = "SELECT d.cid, c.path FROM ".$this->table." d LEFT JOIN ".$this->cat_table." c ON d.cid=c.cid" ;
			$sql .= " WHERE ( d.".$whr." ) AND ( ". $this->get_whr_mylink( $idarray )." ) ORDER BY c.cat_weight ASC" ;
			$result = $this->db->query( $sql ) ;
			while( $array = $this->db->fetchArray( $result ) ) {
				foreach ( $array as $key=>$value ){
					$$key = $value;
				}
				$catid = intval( $cid ) ;
				$path_array = $mycategory->unserialize_my_path( $catid, $whr, $path ) ;
				$category[ $catid ]  = $mycategory->getPathFromId( $catid, $whr , $path_array ) ;
				$category[ $catid ] .= "&nbsp;(".$this->total_mylink( $catid, $whr, 0, $idarray ).")" ;
			}
			return $category ;
		}

		function get_mylink_idarray()
		{
			$mylink = ( $this->xoops_isuser ) ? $this->get_mylink_from_db() : $this->mylink_cookie() ;
			return $this->myts->idarray_by_explode( $mylink ) ;
		}

		function get_mylink_from_db()
		{
			$result = $this->db->query( "SELECT cids FROM ".$this->mylink_table." WHERE uid='".$this->xoops_userid."'" ) ;
			list( $cids ) = $this->db->fetchRow( $result ) ;
			return $cids ;
		}

		function get_whr_mylink( $idarray='', $mode='' )
		{
			if( $idarray === '' ) $idarray = $this->get_mylink_idarray() ;
			return $this->get_whr_from_array( $idarray, $mode, 'lid' ) ; 
		}

		function add_mylink( $lid )
		{
			$error = 0 ;
			$idarray = array() ;

			$result = $this->lid_check_for_mylink( $lid ) ;
			if ( $result ) return $lid ;

			$idarray = $this->get_mylink_idarray() ;
			if( ! in_array( $lid, $idarray ) ) array_push( $idarray, $lid ) ;
			$new_mylink = $this->get_new_mylink( $idarray ) ;

			$error = $this->insert_new_mylink( $lid, $new_mylink ) ;
			$this->mylink_countup( $lid ) ;

			return $error ;
		}

		function del_mylink( $lid )
		{
			$error = 0 ;
			$idarray = array() ;

			$result = $this->lid_check_for_mylink( $lid ) ;
			if ( $result ) return $lid ;

			$idarray = array_diff( $this->get_mylink_idarray(), array( $lid ) ) ;
			$new_mylink = $this->get_new_mylink( $idarray ) ;

			$error = $this->insert_new_mylink( $lid, $new_mylink ) ;
			$this->mylink_countdown( $lid ) ;

			return $error ;
		}

		function lid_check_for_mylink( $lid )
		{
			$result = $this->db->query( "SELECT * FROM ".$this->table." WHERE lid='".$lid."' AND ".$this->whr_append( 'Single' )."" ) ;
			if ( $this->db->getRowsNum( $result ) == 0 ) return $lid ;
		}

		function insert_new_mylink( $lid, $new_mylink )
		{
			$error = 0 ;
			$error = ( $this->xoops_isuser ) ? $this->mylink_insert_db( $lid, $new_mylink ) : $this->mylink_setcookie( $lid, $new_mylink ) ;
			return $error ;
		}

		function all_delete_mylink()
		{
			$error = 0 ;
			foreach ( $this->get_mylink_idarray() as $lid ) {
				$this->mylink_countdown( $lid ) ;
			}

			$error = ( $this->xoops_isuser ) ? $this->delete_mylink_by_sql() : $this->delete_mylink_by_setcookie() ;
			return $error ;
		}

		function get_new_mylink( $idarray )
		{
			return implode( ',', $this->limit_idarray( $idarray ) ) ;
		}

		function limit_idarray( $idarray, $limit = 1000 )
		{
			$count = count( $idarray ) - $limit ;
			if( $count > 0 ) array_splice( $idarray, 0, $count ) ;
			return $idarray ;
		}

		function delete_mylink_by_sql()
		{
			$error = false ;
			$sql = "DELETE FROM ".$this->mylink_table." WHERE uid='".$this->xoops_userid."'" ;
			$result = $this->db->query( $sql ) ;
			if( ! $result ) $error = true ;
			return $error ;
		}

		function delete_mylink_by_setcookie()
		{
			$error = false ;
			$result = setcookie( $this->mylink_cookie_name(), '', $this->mylink_cookie_expire() , $this->cookie_path(), '', 0 ) ;
			if( ! $result ) $error = true ;
			return $error ;
		}

		function mylink_insert_db( $lid, $new_mylink )
		{
			$error = 0 ;

			$this->delete_mylink_by_sql() ;

			if( ! empty( $new_mylink ) ){
				$set4sql  = "uid='".$this->xoops_userid."'" ;
				$set4sql .= ",cids='".addslashes( $new_mylink )."'" ;
				$set4sql .= ",date='".time()."'" ;
				$result = $this->db->query( "INSERT INTO ".$this->mylink_table." SET $set4sql" ) ;

				if( ! $result ) $error = $lid ;
			}
			return $error ;
		}

		function mylink_setcookie( $lid, $new_mylink )
		{
			$error = 0 ;
			$result = setcookie( $this->mylink_cookie_name(), $new_mylink, $this->mylink_cookie_expire(), $this->cookie_path(), '', 0 ) ;
			if( ! $result ) $error = $lid ;
			return $error ;
		}

		function mylink_countup( $lid )
		{
			$sql = "UPDATE ".$this->table." SET mylink = mylink+1 WHERE lid = '".$lid."'" ;
			$this->db->query( $sql ) ;
		}

		function mylink_countdown( $lid )
		{
			$result = $this->db->query( "SELECT mylink FROM ".$this->table." WHERE lid = '".$lid."'" ) ;
			list( $mylink ) = $this->db->fetchRow( $result ) ;
			if( intval( $mylink ) > 0 ) {
				$sql = "UPDATE ".$this->table." SET mylink = mylink-1 WHERE lid = '".$lid."'" ;
				$this->db->query( $sql ) ;
			}
		}

		function redirect_message( $message )
		{
			if( ! empty( $_SESSION["{$this->mydirname}_uri4return"] ) ) {
				redirect_header( $_SESSION["{$this->mydirname}_uri4return"] , 4 , $message ) ;
				unset( $_SESSION["{$this->mydirname}_uri4return"] ) ;
			} else {
				redirect_header( XOOPS_URL."/modules/$this->mydirname/" , 4 , $message ) ;
			}
		}

		function Is_Visible( $lid, $invisible=0 )
		{
			if( empty( $lid ) ) $lid = $this->return_lid() ;
			$sql = "SELECT COUNT( lid ) FROM ".$this->table." WHERE lid='".$lid."'" ;
			switch( $invisible ) {
				case false :
					$sql .= " AND ".$this->whr_append( 'Single' )."" ;
					break ;
				case true :
					$sql .= " AND ( visible = '0' OR date > ".time()." OR ( expired > 0 AND expired < ".time().") )" ;
					break ;
			}
			$result = $this->db->query( $sql ) ;
			list( $isvisible ) = $this->db->fetchRow( $result ) ;

			return intval( $isvisible ) ;
		}

		function Invisible_Info( $visible=0, $date=0, $expired=0 )
		{
			if( empty( $visible ) ) $visible = $this->return_visible() ;
			if( empty( $date ) )    $date = $this->return_date() ;
			if( empty( $expired ) ) $expired = $this->return_expired() ;

			if( empty( $visible ) ) return '<span style="color: #CC0000;font-weight: bold;">'._MD_D3DOWNLOADS_INVISIBLEINFO.'</span>' ;
			elseif( $date > time() ) return '<span style="color: #CC0000;font-weight: bold;">'._MD_D3DOWNLOADS_WAITINGRELEASEINFO.'</span>' ;
			elseif( $expired < time() && ! empty( $expired ) ) return '<span style="color: #CC0000;font-weight: bold;">'._MD_D3DOWNLOADS_EXPIREDINFO.'</span>' ;

			else return '' ;
		}

		function Invisible_Num( $cid=0, $intree=0 )
		{
			$invisible_num = $this->Total_Num( '', $cid, 0, 1, $intree ) ;

			return array(
				'num' => $invisible_num ,
				'link' => '<a href="'.$this->mod_url.'/admin/index.php?page=filemanager&amp;cid='.$cid.'&amp;invisible=1">'.sprintf( _MD_D3DOWNLOADS_INVISIBLE_NUM , $invisible_num ).'</a>' ,
			) ;
		}

		function Total_Mypost( $whr='', $submitter, $cid=0, $all=0, $intree=0 )
		{
			$where = "submitter='".$submitter."' AND ( ".$this->get_whr_categories( $cid, $intree, 'Single' )." )" ;
			if( empty( $all ) )   $where .= " AND ".$this->whr_append( 'Single' )."" ;
			if( ! empty( $whr ) ) $where .= " AND ( $whr )" ;

			$sql = "SELECT COUNT( lid ) FROM ".$this->table." WHERE $where" ;
			$result = $this->db->query( $sql ) ;
			list( $mypost ) = $this->db->fetchRow( $result ) ;

			return intval( $mypost ) ;
		}

		function Hits_Count( $lid )
		{
			$sql = "UPDATE ".$this->table." SET hits = hits+1 WHERE lid = ".$lid."  AND visible = '1'" ;
			$this->db->queryF( $sql ) ;
		}

		function submitter_select_box( $whr='', $all=0 )
		{
			$select_box = array() ;

			$where = ( empty( $all ) ) ? $this->whr_append( 'Single' ) : "( visible = '0' OR visible = '1' )" ;
			if( ! empty( $whr ) ) $where .= " AND ( $whr )" ;

			$sql = "SELECT submitter FROM ".$this->table." WHERE $where ORDER BY submitter ASC" ;
			$result = $this->db->query( $sql ) ;
			if ( $this->db->getRowsNum( $result ) == 0 ) return array() ;

			while( list( $uid ) = $this->db->fetchRow( $result ) ) {
				$submitter = intval( $uid ) ;
				$select_box[$submitter] = sprintf( _MD_D3DOWNLOADS_MYPOST_TITLE , $this->get_postname( $submitter ) ) ;
			}

			return $select_box ;
		}

		function file_link_for_post( $id, $cid, $url, $filename, $second = 0 )
		{
			$filelink = $filenamelink = '';

			$exception = '\.'.implode( '|\.',$this->Exception_extension() ) ;
			$link = $this->mod_url.'/index.php?page=visit_url&cid='.$cid.'&lid='.$id ;

			if ( ! preg_match("`^(https?|ftp)://`i", $url ) ) {
				if( ! $this->check_file( $url ) ){
					$filelink = '( <span class="d3downloads_broken_message">broken file !!</span> )';
					$filenamelink = $filename.'&nbsp;&nbsp;( <span class="d3downloads_broken_message">broken file !!</span> )';
				} else {
					switch( $second ) {
						case false :
							$filelink     =  '[<a href="'.$link.'">'._MD_D3DOWNLOADS_SUBMIT_DOWNLOAD.'</a>]' ;
							$filenamelink = '<a href="'.$link.'">'.$filename.'</a>';
							break ;
						case true :
							$filelink     =  '[<a href="'.$link.'&second=1">'._MD_D3DOWNLOADS_SUBMIT_DOWNLOAD.'</a>]' ;
							$filenamelink = '<a href="'.$link.'&second=1">'.$filename.'</a>';
							break ;
					}
				}
			} elseif ( preg_match('/('.$exception.')$/i', $url ) ) {
				$filelink =  '[<a href="'.$link.'">'._MD_D3DOWNLOADS_SUBMIT_ACCESS_URL.'</a>]' ;
			} else {
				$filelink =  '[<a href="'.$link.'" target="_blank">'._MD_D3DOWNLOADS_SUBMIT_ACCESS_URL.'</a>]' ;
			}

			return array(
				'filelink'     => $filelink ,
				'filenamelink' => $filenamelink ,
			) ;
		}

		function Select_Platform()
		{
			$normal_platform = array(
				'Windows' ,
				'Unix' ,
				'Mac' ,
				'Xoops 2.0x' ,
				'XOOPS Cube Legacy 2.1x'
			) ;

			if( empty( $this->mod_config['select_platform'] ) ) {
				$platform_array = $normal_platform ;
			} else {
				$platform_array = $this->myts->textarray_by_explode( $this->mod_config['select_platform'] ) ;
			}

			$select_platform = array() ;
			$select_platform[''] = '------' ;

			foreach ( $platform_array as $platform ) {
				$select_platform[ $platform ] = $platform ;
			}

			return $select_platform ;
		}

		function Select_License()
		{
			if( empty( $this->mod_config['use_license'] ) ) {
				return '' ;
			} else {
				$normal_license = array(
					'BSD License',
					'Common Public License' ,
					'GPL v. 1.0' ,
					'GPL v. 2.0' ,
					'LGPL v. 2.1' ,
					'LGPL v. 2.0'
				) ;

				if( empty( $this->mod_config['select_license'] ) ) {
					$license_array = $normal_license ;
				} else {
					$license_array = $this->myts->textarray_by_explode( $this->mod_config['select_license'] ) ;
				}

				$select_license = array() ;
				$select_license[''] = '------' ;

				foreach ( $license_array as $license ) {
					$select_license[ $license ] = $license ;
				}

				return $select_license ;
			}
		}

		function get_MyFilter( $currentdata ='' )
		{
			$filters = array() ;
			$mytrustdirpath = dirname( dirname( __FILE__ ) ) ;
			$mytrustdirname = basename( $mytrustdirpath ) ;
			$filters_path = opendir( XOOPS_TRUST_PATH.'/modules/'.$mytrustdirname.'/filters/enabled' ) ;

			while( ( $file = readdir( $filters_path ) ) !== false ) {
				if( preg_match( '/^d3downloads\_(.*)\.php$/' , $file , $regs ) ) {
					$name = $regs[1] ;
					$constpref = '_MD_D3DOWNLOADS_FILTERS_' . strtoupper( $name ) ;
					require_once dirname( dirname(__FILE__) ).'/filters/enabled/d3downloads_'.$name.'.php' ;
					$filters[ $name ] = array(
						'title'   => defined( $constpref.'_TITLE' ) ? constant( $constpref.'_TITLE' ) : $name ,
						'desc'    => defined( $constpref.'_DESC' ) ? constant( $constpref.'_DESC' ) : '' ,
						'enabled' => false ,
					) ;
				}
			}

			if( ! empty( $currentdata ) ) {
				$current_filters = explode( '|' , $currentdata ) ;
				foreach( $current_filters as $my_filter ) {
					if( ! empty( $filters[ $my_filter ] ) ) {
						$filters[ $my_filter ]['enabled'] = true ;
					}
				}
			}

			return $filters ;
		}

		function shots_link_for_post( $cid, $logourl )
		{
			$dirname = $this->myalbum_dirname() ;
			$usealbum = $this->can_albumselect( $dirname ) ;

			if( preg_match ('/(\.gif|\.jpe?g|\.png)$/i', $logourl ) ) return $this->shots_img_link_for_post( $cid, $logourl ) ;
			elseif ( ! empty( $logourl ) &&  ! empty( $usealbum ) ) return $this->get_album_link_for_post( $dirname, $logourl ) ;
		}

		function shots_img_link_for_post( $cid, $logourl )
		{
			return XOOPS_URL.'/'.$this->shots_dir( $cid ) . $logourl ;
		}

		function shots_dir( $cid )
		{
			include_once dirname( dirname(__FILE__) ).'/class/mycategory.php' ;
			$mycategory = new MyCategory( $this->mydirname, 'Show', $cid ) ;

			$cate_shotsdir = $mycategory->return_shotsdir() ;
			if( ! empty( $cate_shotsdir ) && file_exists( XOOPS_ROOT_PATH.'/'.$cate_shotsdir ) ){
				return $cate_shotsdir ;
			} else {
				return 'modules/'.$this->mydirname.'/images/shots/' ;
			}
		}

		function get_album_link_for_post( $dirname, $logourl )
		{
			switch( $this->album_module() ) {
				case "myAlbum-P":
					return $this->get_myalbum_p_link_for_post( $dirname, $logourl ) ;
				case "GnaviD3":
					return $this->get_gnavi_link_for_post( $dirname, $logourl ) ;
				case "webphoto":
					return $this->get_webphoto_link_for_post( $dirname, $logourl ) ;
			}
		}

		function get_myalbum_p_link_for_post( $dirname, $id, $ajax=0 )
		{
			$myalbum_path = XOOPS_ROOT_PATH .'/modules/'. $dirname;
			if ( ! file_exists( $myalbum_path .'/include/read_configs.php' ) ) return '' ;
			include $myalbum_path .'/include/read_configs.php';

			$photo_array = $photo = array() ;

			$album_lid= intval( $id ) ;
			$photo_array = $this->get_myalbum_photo_array( $table_photos, $album_lid ) ;
			if ( empty( $photo_array ) ) return '' ;
			$photo = array(
				'id'  => $photo_array['lid'] ,
				'ext' => $photo_array['ext']
			) ;

			if ( empty( $ajax ) ) return $this->get_album_link_for_post_execution( $dirname, $thumbs_url, $thumbs_dir, $photo ) ;
			else return $this->get_album_link_for_ajax_execution( $dirname, $thumbs_dir, $myalbum_photospath, $myalbum_thumbspath, $photo, 'usealbum' ) ;
		}

		function get_gnavi_link_for_post( $mydirname, $logourl, $ajax=0 )
		{
			if ( ! file_exists( XOOPS_TRUST_PATH.'/modules/gnavi/include/read_configs.php' ) ) return '' ;
			include XOOPS_TRUST_PATH.'/modules/gnavi/include/read_configs.php' ;

			$photo_array = $photo = array() ;
			list( $id ) = explode( '_', $logourl , 2 ) ;
			$album_lid= intval( $id ) ;

			$photo_array = $this->get_myalbum_photo_array( $table_photos, $album_lid ) ;
			if ( empty( $photo_array ) ) return '' ;

			if( preg_match ('/^[0-9]+$/', $logourl ) ) $photo = array(
				'id'  => $photo_array['lid'] ,
				'ext' => $photo_array['ext']
			) ;
			elseif ( strpos ( $logourl , '_1' ) ) $photo =  array(
				'id'  => $photo_array['lid'] .'_1',
				'ext' => $photo_array['ext1']
			) ;
			elseif ( strpos ( $logourl , '_2' ) ) $photo =  array(
				'id'  => $photo_array['lid'] .'_2' ,
				'ext' => $photo_array['ext2']
			) ;

			if ( empty( $ajax ) ) return $this->get_album_link_for_post_execution( $mydirname, $thumbs_url, $thumbs_dir, $photo ) ;
			else return $this->get_album_link_for_ajax_execution( $mydirname, $thumbs_dir, $gnavi_photospath, $gnavi_thumbspath, $photo, 'usealbum' ) ;
		}

		function get_webphoto_link_for_post( $dirname, $id, $ajax=0 )
		{
			if ( ! file_exists( XOOPS_TRUST_PATH.'/modules/webphoto/' ) ) return '' ;

			$item_array = $thumb_array = $photo = array() ;

			$item_id= intval( $id ) ;
			$item_array = $this->get_webphoto_item_array( $dirname, $item_id ) ;
			if ( empty( $item_array ) ) return '' ;
			$cont_array  = $this->get_webphoto_file_array_by_kind( $dirname, $item_array, 1 ) ;
			$thumb_array = $this->get_webphoto_file_array_by_kind( $dirname, $item_array, 2 ) ;

			$photo = array(
				'file_url'    => $thumb_array['file_url'] ,
				'file_path'   => $cont_array['file_path'] ,
				'thumbs_path' => $thumb_array['file_path'] ,
				'ext'         => $thumb_array['file_ext']
			) ;

			if ( empty( $ajax ) ) return $this->get_album_link_for_post_execution( $dirname, '', '', $photo, 'webphoto' ) ;
			else return $this->get_album_link_for_ajax_execution( $dirname, '', '', '', $photo, 'webphoto' ) ;
		}

		function get_album_link_for_post_execution( $dirname, $thumbs_url='', $thumbs_dir='', $photo, $mode='' )
		{
			$myalbum_path = XOOPS_ROOT_PATH .'/modules/'.$dirname ;

			if( $mode != 'webphoto' ) $id = $this->myts->makeTboxData4Show( $photo['id'] ) ;

			$ext = $this->myts->makeTboxData4Show( $photo['ext'] ) ;
			$thumbs_path = ( $mode != 'webphoto' ) ? $thumbs_dir .'/'. $id .'.'. $ext : XOOPS_ROOT_PATH . $this->myts->makeTboxData4Show( $photo['thumbs_path'] ) ;
			if( $mode != 'webphoto' ) $icons_path = $myalbum_path .'/icons/'. $ext .'.gif' ;
			if ( file_exists( $thumbs_path ) ){
				if( $mode != 'webphoto' ) return  $thumbs_url .'/'. $id .'.'. $ext ;
				else return $this->myts->makeTboxData4URLShow( $photo['file_url'] ) ;
			} elseif ( file_exists( $icons_path ) && $mode != 'webphoto' ){
				return  XOOPS_URL .'/modules/'. $dirname.'/icons/'. $ext .'.gif' ;
			}
		}

		function shots_img_ar( $cid, $shots_dir )
		{
			switch( $this->can_albumselect() ) {
				case false :
					return $this->shots_dir_img_list( $cid, $shots_dir ) ;
				case true :
					return $this->get_album_list( $cid, $this->myalbum_dirname() ) ;
			}
		}

		function shots_dir_img_list( $cid, $shots_dir )
		{
			$img_ar = array() ;
			$img_ar[0] = '------';

			if ( file_exists( $shots_dir ) ){
				$downimg_array = $this->get_img_list( $shots_dir ) ;
	
				foreach ( $downimg_array as $image ) {
					$img_ar[ $image ] = $image ;
				}
			}
			return array(
				'img_ar'              => $img_ar ,
				'showlogourlselected' => $this->make_js_for_logourl( $cid, 'shots_dir' ) ,
			) ;
		}

		function get_img_list( $dirname, $prefix='' )
		{
			$filelist = array() ;

			if ( $handle = opendir( $dirname ) ) {
				while ( false !== ( $file = readdir( $handle ) ) ) {
					if ( ! preg_match( "/^[\.]{1,2}$/", $file ) && preg_match( "/(\.gif|\.jpe?g|\.png)$/i",$file ) ) {
						$file = $prefix . $file ;
						$filelist[ $file ] = $file ;
					}
				}
				closedir( $handle ) ;
				asort( $filelist ) ;
				reset( $filelist ) ;
			}

			return $filelist ;
		}

		function get_album_list( $cid, $dirname )
		{
			switch( $this->album_module() ) {
				case "myAlbum-P":
					return $this->get_myalbum_p_list( $cid, $dirname ) ;
				case "GnaviD3":
					return $this->get_gnavi_list( $cid, $dirname ) ;
				case "webphoto":
					return $this->get_webphoto_list( $cid, $dirname ) ;
			}
		}

		function get_myalbum_p_list( $cid, $dirname )
		{
			$myalbum_path = XOOPS_ROOT_PATH .'/modules/'.$dirname ;
			if ( ! file_exists( $myalbum_path .'/include/read_configs.php' ) ) return array() ;
			include $myalbum_path .'/include/read_configs.php';

			$img_ar = $photo_array = $photo_ext = array() ;
			$img_ar[0] = '------';

			$photo_array = $this->get_myalbum_photo_array( $table_photos ) ;
			if ( empty( $photo_array ) ) array() ;
			foreach ( $photo_array as $photo ){
				$id = intval( $photo['lid'] ) ;
				$img_ar[ $id ] = sprintf( '%06d', $id ).' : '.$this->myts->makeTboxData4Show( $photo['title'] ) ;
				$photo_ext[ $id ] = $photo['ext'] ;
			}

			return array(
				'img_ar'              => $img_ar ,
				'showlogourlselected' => $this->make_js_for_logourl( $cid, 'usealbum' ) ,
			) ;
		}

		function get_gnavi_list( $cid, $mydirname )
		{
			if ( ! file_exists( XOOPS_TRUST_PATH.'/modules/gnavi/include/read_configs.php' ) ) return array() ;
			include XOOPS_TRUST_PATH.'/modules/gnavi/include/read_configs.php' ;

			$img_ar = $photo_array = $photo_ext = array() ;
			$img_ar[0] = '------';

			$photo_array = $this->get_myalbum_photo_array( $table_photos ) ;
			if ( empty( $photo_array ) ) array() ;
			foreach ( $photo_array as $photo ){
				$id = intval( $photo['lid'] ) ;

				$title_1 = ( empty( $photo['caption'] ) ) ? $photo['title'] .'( 1 )' : $photo['caption'] ;
				$img_ar[ $id ] = sprintf( '%06d', $id ).' : '.$this->myts->makeTboxData4Show( $title_1 ) ;

				if( ! empty( $photo['ext1'] ) ){
					$title_2 = ( empty( $photo['caption1'] ) ) ? $photo['title'] .'( 2 )' : $photo['caption1'] ;
					$img_ar[ $id.'_1' ] = sprintf( '%06d', $id ).' : '.$this->myts->makeTboxData4Show( $title_2 ) ;
				}

				if( ! empty( $photo['ext2'] ) ){
					$title_3 = ( empty( $photo['caption2'] ) ) ? $photo['title'] .'( 3 )' : $photo['caption2'] ;
					$img_ar[ $id.'_2' ] = sprintf( '%06d', $id ).' : '.$this->myts->makeTboxData4Show( $title_3 ) ;
				}

				$photo_ext[ $id ] = $photo['ext'] ;
				if( ! empty( $photo['ext1'] ) ) $photo_ext[ $id.'_1' ] = $photo['ext1'] ;
				if( ! empty( $photo['ext2'] ) ) $photo_ext[ $id.'_2' ] = $photo['ext2'] ;
			}

			return array(
				'img_ar'              => $img_ar ,
				'showlogourlselected' => $this->make_js_for_logourl( $cid, 'usealbum' ) ,
			) ;
		}

		function get_webphoto_list( $cid, $dirname )
		{
			if ( ! file_exists( XOOPS_TRUST_PATH.'/modules/webphoto/' ) ) return array() ;

			$img_ar = $item_array = $thumb_array = $file = array() ;
			$img_ar[0] = '------';

			$item_array = $this->get_webphoto_item_array( $dirname ) ;
			if ( empty( $item_array ) ) return array() ;
			foreach ( $item_array as $item ){
				$id = intval( $item['item_id'] ) ;
				$img_ar[ $id ] = sprintf( '%06d', $id ).' : '.$this->myts->makeTboxData4Show( $item['item_title'] ) ;
				$cont_array  = $this->get_webphoto_file_array_by_kind( $dirname, $item, 1 ) ;
				$thumb_array = $this->get_webphoto_file_array_by_kind( $dirname, $item, 2 ) ;
				$file[] = array(
					'id'          => $id ,
					'file_path'   => $cont_array['file_path'] ,
					'thumbs_path' => $thumb_array['file_path'] ,
					'ext'         => $thumb_array['file_ext']
				) ;
			}
			return array(
				'img_ar'              => $img_ar ,
				'showlogourlselected' => $this->make_js_for_logourl( $cid, 'usealbum' ) ,
			) ;
		}

		function make_js_for_logourl( $cid, $mode )
		{
			$html  = $this->make_showlogourlSelected( $cid, $mode ) ;
			$html .= "\n" ;
			$html .= $this->make_appendCode( $cid, $mode ) ;
			
			return $html ;
		}

		function make_showlogourlSelected( $cid, $mode )
		{
			$html  = "
			<script type=\"text/javascript\">
			function showlogourlSelected(imgId, selectId, showhideId, url)
			{
			    showlogourlSelected_load('".$mode."', '".$this->shots_dir( $cid )."', '".XOOPS_URL."', imgId, selectId, showhideId, url);
			}
			</script>
			" ;

			return $html ;
		}

		function make_appendCode( $cid, $mode )
		{
			$html  = "
			<script type=\"text/javascript\">
			function appendCode(targetId, selectId, align, url)
			{
			    appendCode_load('".$mode."', '".$this->shots_dir( $cid )."', targetId, selectId, align, url);
			}
			</script>
			" ;

			return $html ;
		}

		function get_album_link_for_ajax( $id )
		{
			$dirname = $this->myalbum_dirname() ;

			switch( $this->album_module() ) {
				case 'myAlbum-P':
					return $this->get_myalbum_p_link_for_post( $dirname, $id, 1 ) ;
				case 'GnaviD3':
					return $this->get_gnavi_link_for_post( $dirname, $id, 1 ) ;
				case 'webphoto':
					return $this->get_webphoto_link_for_post( $dirname, $id, 1 ) ;
			}
		}

		function get_album_link_for_ajax_execution( $dirname, $thumbs_dir='', $photospath='', $thumbspath='', $photo, $mode='' )
		{
			$photodir = ( $mode != 'webphoto' ) ? substr( $photospath , 1 ) : '' ;
			$thumbdir = ( $mode != 'webphoto' ) ? substr( $thumbspath , 1 ) : '' ;

			if( $mode != 'webphoto' ) {
				$id = $this->myts->makeTboxData4Show( $photo['id'] ) ;
				$ext = $this->myts->makeTboxData4Show( $photo['ext'] ) ;
				$icons_path = XOOPS_ROOT_PATH .'/modules/'.$dirname  .'/icons/'. $ext .'.gif' ;
			}

			$thumbs_path = ( $mode != 'webphoto' ) ? $thumbs_dir .'/'. $id .'.'. $ext : XOOPS_ROOT_PATH .$this->myts->makeTboxData4Show( $photo['thumbs_path'] ) ;

			if ( file_exists( $thumbs_path ) ) switch( $mode ) {
				case 'usealbum':
					$thumb = $thumbdir .'/'. $id .'.'. $ext ;
					$photo = $photodir .'/'. $id .'.'. $ext ;
					break ;
				case 'webphoto':
					$thumb = $this->myts->makeTboxData4Show( substr( $photo['thumbs_path'] , 1 ) ) ;
					$photo = $this->myts->makeTboxData4Show( substr( $photo['file_path'] , 1 ) ) ;
					break ;
			} elseif ( file_exists( $icons_path ) && $mode != 'webphoto' ) {
				$thumb = 'modules/'. $dirname.'/icons/'. $ext .'.gif' ;
				$photo = $photodir .'/'. $id .'.'. $ext ;
			}

			$item .='<?xml version="1.0" encoding="UTF-8"?>
			<item>
			<thumb>'.$thumb.'</thumb>
			<photo>'.$photo.'</photo>
			</item>
			';

			return $item ;
		}

		function option_config( $key, $config='option_config', $config_array='' )
		{
			$option_config = ( $config_array === '' ) ? $this->get_option_config( $config ) : $config_array ;

			switch( $option_config === '' || $option_config[ $key ] != 0 ) {
				case true :
					return  true ;
				case false :
					return false ;
			}
		}

		function get_option_config( $config='option_config' )
		{
			$mytrustdirpath = dirname( dirname( __FILE__ ) ) ;
			$mytrustdirname = basename( $mytrustdirpath ) ;

			$config_file =  array(
				 XOOPS_ROOT_PATH.'/modules/'.$this->mydirname.'/include/config.inc.php' ,
				 XOOPS_TRUST_PATH.'/modules/'.$mytrustdirname.'/config/enabled/config.inc.php'
			) ;

			$int_array =  array( 'option_config' , 'submenu_option' ) ;

			foreach ( $config_file as $file_path ){
				if( file_exists( $file_path ) ) {
					include $file_path ;
					$my_config = ( in_array( $config, $int_array ) ) ? $this->myts->MyIntval( $$config ) : $this->myts->Delete_ControlCode( $$config ) ;
					break ;
				}
			}
			return ( ! empty( $my_config ) ) ? $my_config : '' ;
		}
	}
}

?>