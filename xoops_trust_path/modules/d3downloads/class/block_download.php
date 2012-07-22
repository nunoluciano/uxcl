<?php

// for block_view

if( ! class_exists( 'block_download' ) )
{
	include_once dirname( dirname(__FILE__) ).'/class/mydownload.php' ;
	require_once dirname( dirname(__FILE__) ).'/class/d3downloads.textsanitizer.php' ;

	class block_download extends MyDownload
	{
		var $db;
		var $table;
		var $whr;
		var $entry = 10;
		var $title_size = 25;
		var $date_format = 'Y/m/d';
		var $order = 'd.date DESC';
		var $lid ;
		var $cid ;
		var $title ;
		var $url ;
		var $filename ;
		var $ext ;
		var $homepage ;
		var $version ;
		var $size ;
		var $platform ;
		var $logourl ;
		var $description ;
		var $html ;
		var $smiley ;
		var $br ;
		var $xcode ;
		var $filters ;
		var $submitter ;
		var $date ;
		var $expired ;
		var $hits ;
		var $rating ;
		var $votes ;
		var $cancomment ;
		var $comments ;
		var $category ;
		var $downdata=array();

		function block_download( $mydirname )
		{
			global $xoopsUser ;
			include_once dirname( dirname(__FILE__) ).'/include/mytable.php' ;

			$this->db =& Database::getInstance();
			$this->myts =& d3downloadsTextSanitizer::getInstance() ;
			$this->table = $this->db->prefix( "{$mydirname}_downloads" ) ;
			$this->cat_table = $this->db->prefix( "{$mydirname}_cat" ) ;
			$this->mylink_table = $this->db->prefix( "{$mydirname}_mylink" ) ;
			$this->mydirname = $mydirname ;
			$this->mod_url = XOOPS_URL.'/modules/'.$mydirname ;
			$columns = 'd.'.implode( ',d.' , $GLOBALS['d3download_tables']['downloads'] ) ;
			$columns .= ', c.title AS category';
			$this->columns = $columns ;
			$module_handler =& xoops_gethandler('module') ;
			$module =& $module_handler->getByDirname( $mydirname ) ;
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
		}

		function get_downdata_for_block( $whr, $entry, $title_size, $date_format, $order, $category_option='', $intree=0, $mylink=0, $pickup=0, $file_ids='' )
		{
			$where = "( $whr ) AND ".$this->whr_append()."" ;

			// categories
			if ( empty( $pickup ) ) switch( $intree ) {
				case true :
					$where .= " AND ( ". $this->whr_categories_intree_from_cids( $category_option )." )" ;
					break ;
				case false :
					$where .= " AND ( ". $this->whr_categories_from_cids( $category_option )." )" ;
					break ;
			}

			// mylink
			if ( ! empty( $mylink ) ){
				$idarray = $this->get_mylink_idarray() ;
				if( empty( $idarray ) ) return '';
				else $where .= " AND ( ". $this->get_whr_mylink( $idarray )." )" ;
			}

			// pickup
			if ( ! empty( $pickup ) ){
				$file_ids = $this->myts->idarray_by_explode( $file_ids ) ;
				if( empty( $file_ids ) ) return '';
				else $where .= " AND ( ".$this->get_whr_from_array( $file_ids, '', 'lid' )." )" ;
			}

			$sql = $this->default_sql() ." WHERE $where ORDER BY $order";
			$result = $this->db->query( $sql, $entry, 0 );
			if ( $this->db->getRowsNum( $result ) == 0 ) {
				return '';
			} else {
				return $this->get_downdata( $result, $title_size, $date_format );
			}
		}

		function get_downdata( $result, $title_size, $date_format )
		{
			global $xoopsConfig ;

			while( $array = $this->db->fetchArray( $result ) ) {
				foreach ( $array as $key=>$value ){
					$this->$key = $value;
				}
				$lid       = $this->return_lid() ;
				$cid       = $this->return_cid() ;
				$title     = $this->return_title('Show') ;
				if ( $title_size && strlen( $title ) >=  $title_size ) {
					$title = xoops_substr( $title,  0 , ( $title_size -1 ) ) ;
				}
				$submitter = $this->return_submitter() ;
				$date      = $this->return_date() ;
				$html      = $this->return_html() ;
				$smiley    = $this->return_smiley() ;
				$xcode     = $this->return_xcode() ;
				$br        = $this->return_br() ;
				$filters   = $this->return_filters() ;
				$body      = $this->myts->displayTarea( $this->return_description('Show'), $html, $smiley, $xcode, 1, $br, $filters ) ;
				$downdata[] = array(
					'lid'         => $lid,
					'cid'         => $cid,
					'title'       => $title,
					'category'    => $this->return_category('Show'),
					'url'         => $this->return_url('Show') ,
					'homepage'    => $this->getlink_for_homepage() ,
					'version'     => $this->return_version('Show') ,
					'size'        => $this->PrettySize( $this->return_size(), 1 ),
					'platform'    => $this->return_platform('Show') ,
					'logourl'     => $this->return_logourl('Show') ,
					'description' => $this->return_summary( $this->return_description('Show'), $filters ) ,
					'body'        => $this->return_body( $lid, $cid, $body, 0, 1 ),
					'postname'    => $this->getlink_for_postname( $submitter ),
					'updated'     => formatTimestamp( $date, $date_format, $xoopsConfig['default_TZ'] ),
					'date'        => $date ,
					'hits'        => $this->return_hits() ,
					'rating'      => $this->return_rating() ,
					'votes'       => $this->return_votes() ,
					'comments'    => $this->return_comments() ,
				);
			}
			return $downdata;
		}

		function get_categories_list( $top=0 )
		{
			require_once dirname( dirname(__FILE__) ).'/class/mycategory.php' ;
			$mycategory = new MyCategory( $this->mydirname, 'Show' ) ;

			$ret = array() ;
			$ret[''] = '------' ;
			$result = $this->db->query( "SELECT cid, title, child FROM ".$this->cat_table." WHERE pid='0' ORDER BY cat_weight ASC" ) ;
			while( $array = $this->db->fetchArray( $result ) ) {
				foreach ( $array as $key=>$value ){
					$$key = $value;
				}
				$id =intval( $cid ) ;
				$ret[ $id ] = $this->myts->makeTboxData4Show( $title ) ;
				if( empty( $top ) ) {
					$arr = $mycategory->unserialize_my_child( $id, '', $child ) ;
					foreach ( $arr as $child ) {
						$child_id = intval( $child['cid'] ) ;
						$child['prefix'] = str_replace( ".","--", $child['prefix'] ) ;
						$ret[ $child_id ] = $child['prefix']."&nbsp;" . $this->myts->makeTboxData4Show( $child['title'] ) ;
					}
				}
			}
			return $ret ;
		}

		function get_downloads_list()
		{
			$ret = array() ;
			$ret[''] = '------' ;
			$sql  = "SELECT lid, title FROM ".$this->table." ORDER BY date DESC, lid DESC" ;
			$result = $this->db->query( $sql ) ;
			while( $array = $this->db->fetchArray( $result ) ) {
				foreach ( $array as $key=>$value ){
					$$key = $value;
				}
				$id =intval( $lid ) ;
				$ret[ $id ] = sprintf('%06d',$id).': '.$this->myts->makeTboxData4Show( $title ) ;
			}
			return $ret ;
		}
	}
}

?>