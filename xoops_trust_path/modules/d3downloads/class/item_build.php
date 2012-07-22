<?php

// for RSS & Atom Data,whatsnew module Data.

if( ! class_exists( 'Item_build' ) )
{
	include_once dirname( dirname(__FILE__) ).'/class/mydownload.php' ;
	require_once dirname( dirname(__FILE__) ).'/class/d3downloads.textsanitizer.php' ;

	class Item_build extends MyDownload
	{
		var $db ;
		var $table ;
		var $lid ;
		var $cid ;
		var $title ;
		var $description ;
		var $html ;
		var $smiley ;
		var $br ;
		var $xcode ;
		var $filters ;
		var $submitter ;
		var $date ;
		var $comments ;
		var $category ;

		function Item_build( $mydirname )
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
			$this->module_handler =& xoops_gethandler('module') ;
			$this->module =& $this->module_handler->getByDirname( $mydirname ) ;
			$this->mid = $this->module->getVar('mid') ;
			if( is_object( $xoopsUser ) ) {
				$this->xoops_isuser = true ;
				$this->xoops_userid = $xoopsUser->getVar('uid') ;
				$this->xoops_isadmin = $xoopsUser->isAdmin( $this->mid ) ;
			} else {
				$this->xoops_isuser = false ;
				$this->xoops_userid = 0 ;
				$this->xoops_isadmin = false ;
			}
		}

		function get_Item( $category_option, $intree=0, $limit=0, $offset=0, $rss=0, $mylink=0 )
		{
			require_once dirname( dirname(__FILE__) ).'/class/user_access.php';
			$user_access = new user_access( $this->mydirname ) ;

			$item = array() ;
			$permit = ( empty( $rss ) ) ? $this->get_permit() : false ;

			$whr = "d.cid IN (".implode(",", $user_access->can_read( $permit ) ).")" ;
			$where = "( $whr ) AND ".$this->whr_append()."" ;

			// categories
			switch( $intree ) {
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
				if( empty( $idarray ) ) return $this->return_category_title( $category_option ) ;
				else $where .= " AND ( ". $this->get_whr_mylink( $idarray )." )" ;
			}

			$sql = $this->default_sql() ." WHERE $where ORDER BY d.date DESC" ;
			$result = $this->db->query( $sql, $limit, $offset ) ;
			if ( $this->db->getRowsNum( $result ) == 0 ) switch( $rss ) {
				case true :
					return $this->return_category_title( $category_option ) ;
				case false :
					return array() ;
			}
			$i = 0 ;
			while( $array = $this->db->fetchArray( $result ) ) {
				foreach ( $array as $key=>$value ){
					$this->$key = $value ;
				}
				$lid                     = $this->return_lid() ;
				$cid                     = $this->return_cid() ;
				$item[$i]['link']        = $this->mod_url."/index.php?page=singlefile&amp;cid=".$cid."&amp;lid=".$lid ;
				$item[$i]['cat_link']    = $this->mod_url."/index.php?cid=".$cid ;
				$item[$i]['title']       = $this->return_title('Show') ;
				$item[$i]['cat_name']    = $this->return_category('Show') ;
				$item[$i]['time']        = $this->return_date() ;
				$item[$i]['uid']         = $this->return_submitter() ;
				$item[$i]['hits']        = $this->return_hits() ;
				$item[$i]['id']          = $lid ;
				$item[$i]['cid']         = $cid ;
				$item[$i]['replies']     = $this->return_comments() ;
				$html                    = $this->return_html() ;
				$smiley                  = $this->return_smiley() ;
				$xcode                   = $this->return_xcode() ;
				$br                      = $this->return_br() ;
				$filters                 = $this->return_filters() ;
				$body                    = $this->myts->displayTarea( $this->return_description('Show'), $html, $smiley, $xcode, 1, $br, $filters ) ;
				$item[$i]['description'] = $this->return_body( $lid, $cid, $body , 1, 0, $rss ) ;
				$i++ ;
			}
			return $item ;
		}

		function return_category_title( $category_option )
		{
			include_once dirname( dirname(__FILE__) ).'/class/mycategory.php' ;
			$mycategory = new MyCategory( $this->mydirname, 'Show', $category_option ) ;
			$ret = array() ;
			$ret[0]['cat_name'] = $mycategory->return_title() ;
			return $ret ;
		}

		function get_permit()
		{
			if( $this->xoops_isuser ) {
				return false ;
			} else {
				$groups = intval( XOOPS_GROUP_ANONYMOUS ) ;

				$moduleperm_handler =& xoops_gethandler('groupperm') ;
				$whatsnew_dir = 'whatsnew' ;
				if ( $moduleperm_handler->checkRight( 'module_read', $this->mid, $groups ) ){
					return false ;
				} elseif( file_exists( XOOPS_ROOT_PATH.'/modules/'.$whatsnew_dir ) ) {
					$whatsnew_module =& $this->module_handler->getByDirname( $whatsnew_dir ) ;
					$whatsnew_ver = intval( $whatsnew_module->getVar('version') ) ;
					if ( $whatsnew_ver >= 240 ){
						$table_whatsnew = $this->db->prefix( "{$whatsnew_dir}_module" ) ;
						$sql = "SELECT COUNT(*) FROM $table_whatsnew WHERE mid = '".$this->mid."' AND permit = '1'" ;
						$result = $this->db->query( $sql ) ;
						list( $permit ) = $this->db->fetchRow( $result ) ;
					}
					if ( ! empty( $permit ) ){
						return true ;
					} else {
						return false ;
					}
				}
			}
		}
	}
}

?>