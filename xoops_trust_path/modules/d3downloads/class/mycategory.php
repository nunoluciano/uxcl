<?php

// for Category_Data , Edit , set4sql etc.

if( ! class_exists( 'MyCategory' ) )
{
	require_once dirname( dirname(__FILE__) ).'/class/d3downloads.textsanitizer.php' ;

	class MyCategory
	{
		var $mode = "" ;
		var $db ;
		var $cat_table ;
		var $cid ;
		var $pid ;
		var $title ;
		var $imgurl ;
		var $description ;
		var $shotsdir ;
		var $cat_weight ;
		var $submit_message ;
		var $child ;
		var $path ;
		var $cids_child ;
		var $categorydata = array();
		var $requests_int = array( 'cid' , 'pid' , 'cat_weight' ) ;
		var $requests_text = array( 'title' , 'imgurl' , 'description' , 'shotsdir' , 'submit_message' ) ;
		var $title_length = 50 ;
		var $imgurl_length = 150 ;
		var $shotsdir_length = 150 ;
		var $cat_weight_length = 5 ;

		function MyCategory( $mydirname, $mode='', $cid= 0, $whr='' )
		{
			include_once dirname( dirname(__FILE__) ).'/include/mytable.php' ;

			$this->db =& Database::getInstance();
			$this->myts =& d3downloadsTextSanitizer::getInstance() ;
			$this->mydirname = $mydirname ;
			$this->cat_table = $this->db->prefix( "{$mydirname}_cat" ) ;
			$this->downloads_table = $this->db->prefix( "{$mydirname}_downloads" ) ;
			$this->user_access_table = $this->db->prefix( "{$mydirname}_user_access" ) ;
			$this->columns = implode( ',' , $GLOBALS['d3download_tables']['cat'] ) ;
			if( ! empty( $mode ) ) $this->mode = $mode ;
			$this->selectid = ( $cid > 0 ) ? $cid : 0 ;
			if( $mode == 'Show' && ! empty( $cid ) ) {
				$this->GetMyCategory( $cid, $whr ) ;
			}
			if( $mode == 'Edit') {
				require_once dirname( dirname(__FILE__) ).'/class/post_check.php' ;
				$this->post_check = new Post_Check() ;

				// Delete_Nullbyte
				$_POST = $this->myts->Delete_Nullbyte( $_POST ) ;
			}
		}

		function GetMyCategory( $cid, $whr='' )
		{
			$sql = "SELECT $this->columns FROM ".$this->cat_table." WHERE cid='".$cid."'";
			if ( $whr != '' ) {
				$sql .= " AND ( $whr )";
			}
			$result = $this->db->query( $sql );
			if ( $this->db->getRowsNum( $result ) == 0 ) {
				return '';
			}
			$this->getData( $result );
		}

		function getData( $result )
		{
			$array = $this->db->fetchArray( $result ) ;
			foreach ( $array as $key=>$value ){
				$this->$key = $value;
			}
		}

		function return_cid()
		{
			return intval( $this->cid ) ;
		}

		function return_pid()
		{
			return intval( $this->pid ) ;
		}

		function return_title( $mode='' )
		{
			if( empty( $mode ) ) $mode = $this->mode ; 
			switch( $mode ) {
				case 'Show' :
					return $this->myts->makeTboxData4Show( $this->title ) ;
				case 'Edit' :
					return $this->myts->makeTboxData4Edit( $this->title ) ;
			}
		}

		function return_imgurl( $mode='' )
		{
			if( empty( $mode ) ) $mode = $this->mode ; 
			switch( $mode ) {
				case 'Show' :
					return $this->myts->makeTboxData4Show( $this->imgurl ) ;
				case 'Edit' :
					return $this->myts->makeTboxData4Edit( $this->imgurl ) ;
			}
		}

		function return_description( $mode='' )
		{
			if( empty( $mode ) ) $mode = $this->mode ; 
			switch( $mode ) {
				case 'Show' :
					return $this->myts->displayTarea( $this->description , 1, 1, 1, 1, 1 ) ;
				case 'Edit' :
					return $this->myts->makeTareaData4Edit( $this->description ) ;
			}
		}

		function return_shotsdir( $mode='' )
		{
			if( empty( $mode ) ) $mode = $this->mode ; 
			switch( $mode ) {
				case 'Show' :
					return $this->myts->makeTboxData4Show( $this->shotsdir ) ;
				case 'Edit' :
					return $this->myts->makeTboxData4Edit( $this->shotsdir ) ;
			}
		}

		function return_cat_weight()
		{
			return intval( $this->cat_weight ) ;
		}

		function return_submit_message( $mode='' )
		{
			if( empty( $mode ) ) $mode = $this->mode ; 
			switch( $mode ) {
				case 'Show' :
					return $this->myts->displayTarea( $this->submit_message , 1, 1, 1, 1, 1 ) ;
				case 'Edit' :
					return $this->myts->makeTareaData4Edit( $this->submit_message ) ;
			}
		}

		function return_child()
		{
			return $this->unserialize_my_child( $this->selectid, '', $this->child ) ;
		}

		function return_path()
		{
			return $this->unserialize_my_path( $this->selectid, '', $this->path ) ;
		}

		function return_cids_child()
		{
			return $this->getAllChildId( $this->selectid, '', $this->cids_child ) ;
		}

		function category_sum( $whr='' )
		{
			$sql = "SELECT cid FROM ".$this->cat_table."";
			if ( $whr != '' ) {
				$sql .= " WHERE ( $whr )";
			}
			$result = $this->db->query( $sql );
			$count = $this->db->getRowsNum( $result ) ;
			return intval( $count ) ;
		}

		function subcategory_sum( $selectid=0, $whr='' )
		{
			$cid = ( empty( $selectid ) ) ? $this->selectid : $selectid ; 
			$child_array =  $this->unserialize_my_child( $cid, $whr ) ;
			if( empty( $child_array ) ) return 0 ;
			else return count( $child_array ) ;
		}

		function subcategory_sum_by_recursive( $selectid=0, $whr='' )
		{
			$count = 0 ;
			$cid = ( empty( $selectid ) ) ? $this->selectid : $selectid ; 
			$sql = "SELECT cid FROM ".$this->cat_table." WHERE pid ='".$cid."'";
			if ( $whr != '' ) {
				$sql .= " AND ( $whr )";
			}
			$result = $this->db->query( $sql );
			$count += $this->db->getRowsNum( $result ) ;
			while ( $row = $this->db->fetchArray( $result ) ) {
				$count += $this->subcategory_sum_by_recursive( intval( $row['cid'] ), $whr ) ;
			}
			return $count ;
		}

		function get_maxid( $topcat=0 )
		{
			$sql = "SELECT MAX( cid ) FROM ".$this->cat_table."" ;
			if( ! empty( $topcat ) ) $sql .= " WHERE pid='0'" ;
			$mrs = $this->db->query( $sql ) ;
			list( $maxid ) = $this->db->fetchRow( $mrs ) ;
			return intval( $maxid ) ;
		}

		function get_minid( $topcat=0 )
		{
			$sql = "SELECT MIN( cid ) FROM ".$this->cat_table."" ;
			if( ! empty( $topcat ) ) $sql .= " WHERE pid='0'" ;
			$mrs = $this->db->query( $sql ) ;
			list( $minid ) = $this->db->fetchRow( $mrs ) ;
			return intval( $minid ) ;
		}

		function get_max_weight( $topcat=0 )
		{
			$sql = "SELECT MAX( cat_weight ) FROM ".$this->cat_table."" ;
			if( ! empty( $topcat ) ) $sql .= " WHERE pid='0'" ;
			$mrs = $this->db->query( $sql ) ;
			list( $maxid ) = $this->db->fetchRow( $mrs ) ;
			return intval( $maxid ) ;
		}

		function get_top_weight( $topcat=0 )
		{
			$sql = "SELECT MIN( cat_weight ) FROM ".$this->cat_table."" ;
			if( ! empty( $topcat ) ) $sql .= " WHERE pid='0'" ;
			$trs = $this->db->query( $sql ) ;
			list( $topweight ) = $this->db->fetchRow( $trs ) ;
			return intval( $topweight ) ;
		}

		function get_top_weightid( $topcat=0 )
		{
			$topweight = intval( $this->get_top_weight( $topcat ) ) ;
			$sql = "SELECT cid FROM ".$this->cat_table." WHERE cat_weight='".$topweight."'" ;
			if( ! empty( $topcat ) ) $sql .= " AND pid='0'" ;
			$sql .= " ORDER BY cid ASC";
			$trs = $this->db->query( $sql ) ;
			list( $max_weight ) = $this->db->fetchRow( $trs ) ;
			return intval( $max_weight ) ;
		}

		function get_my_maincid( $selectid=0 )
		{
			$myid = ( empty( $selectid ) ) ? $this->selectid : $selectid ;
			$path_array = $this->unserialize_my_path( $myid ) ;
			foreach ( $path_array as $path ) {
				if( $path['pid'] == 0 ) $maincid = intval( $path['cid'] ) ;
				break ;
			}
			return $maincid ;
		}

		function get_my_maincid_by_recursive( $selectid=0 )
		{
			$myid = ( empty( $selectid ) ) ? $this->selectid : $selectid ; 
			$sql = "SELECT cid, pid FROM ".$this->cat_table." WHERE cid='".$myid."'" ;
			$result = $this->db->query( $sql ) ;
			list( $id ,$pid ) = $this->db->fetchRow( $result ) ;
			if ( $pid == 0 ){
				$maincid = intval( $id ) ;
				return $maincid ;
			} else {
				$maincid = $this->get_my_maincid_by_recursive( intval( $pid ) ) ;
			}
			return $maincid ;
		}

		function get_my_parent_cat( $pid=0 )
		{
			$mypid = ( empty( $pid ) ) ? $this->return_pid() : $pid ;
			if( $mypid == 0 ) return  '' ;
			$prs = $this->db->query( "SELECT cid, title FROM ".$this->cat_table." WHERE cid='".$mypid."'" ) ;
			list( $parentid, $title ) = $this->db->fetchRow( $prs ) ;
			return  array(
				'parentid' => intval( $parentid ) ,
				'title'    => $this->myts->makeTboxData4Show( $title )  ,
			) ;
		}

		function get_recent_updatecid( $topcat=0 )
		{
			$sql = "SELECT cid FROM ".$this->cat_table."" ;
			if( ! empty( $topcat ) ) $sql .= " WHERE pid='0'" ;
			$sql .= " ORDER BY date DESC";
			$rec = $this->db->query( $sql ) ;
			list( $recent ) = $this->db->fetchRow( $rec ) ;
			return intval( $recent ) ;
		}

		function unserialize_my_child( $selectid, $whr='', $child_array='' )
		{
			if( $child_array === '' ){
				$sql = "SELECT child FROM ".$this->cat_table." WHERE cid='".$selectid."'" ;
				if ( $whr != '' ) {
					$sql .= " AND ( $whr )";
				}
				$result = $this->db->query( $sql ) ;
				if ( $this->db->getRowsNum( $result ) == 0 ) {
					return array() ;
				}
				$result = $this->db->query( $sql ) ;
				list( $child_array ) = $this->db->fetchRow( $result ) ;
			}
			if( empty( $child_array ) ) return array() ;
			else  $data = $this->myts->unSerializeImport( $child_array ) ;
			if( is_array( $data ) ) return $data ;
			else return $this->get_my_child_array_by_recursive( $selectid, $whr )  ;
		}

		function unserialize_my_path( $selectid, $whr='', $path_array='' )
		{
			if( $path_array === '' ){
				$sql = "SELECT path FROM ".$this->cat_table." WHERE cid='".$selectid."'" ;
				if ( $whr != '' ) {
					$sql .= " AND ( $whr )";
				}
				$result = $this->db->query( $sql ) ;
				if ( $this->db->getRowsNum( $result ) == 0 ) {
					return array() ;
				}
				$result = $this->db->query( $sql ) ;
				list( $path_array ) = $this->db->fetchRow( $result ) ;
			}
			if( empty( $path_array ) ) return array() ;
			else  $data = $this->myts->unSerializeImport( $path_array ) ;
			if( is_array( $data ) ) return $data ;
			else return $this->get_my_path_array_by_recursive( $selectid, $whr )  ;
		}


		function getFirstChild( $selectid , $whr='', $child_array='' )
		{
			$arr = array() ;
			if( $child_array === '' ){
				$child_array = $this->unserialize_my_child( $selectid, $whr ) ;
			}
			if( empty( $child_array ) ) return array() ;
			else  foreach( $child_array as $child ) {
				if( $child['pid'] == $selectid ) array_push( $arr, $child ) ;
			}
			return $arr ;
		}

		function getFirstChildId( $selectid, $whr='', $child_array='' )
		{
			$idarray = array() ;
			if( $child_array === '' ){
				$child_array = $this->unserialize_my_child( $selectid, $whr ) ;
			}
			if( empty( $child_array ) ) return array() ;
			else  foreach( $child_array as $child ) {
				if( $child['pid'] == $selectid ) $idarray[] = intval( $child['cid'] ) ;
			}
			return $idarray ;
		}

		function getAllParentId( $selectid, $whr='', $path_array='' )
		{
			$idarray = array() ;
			if( $path_array === '' ){
				$path_array = $this->unserialize_my_path( $selectid, $whr ) ;
			}
			if( empty( $path_array ) ) return array() ;
			else  foreach( $path_array as $mypath ) {
				$r_id = intval( $mypath['cid'] ) ;
				if( $r_id != $selectid ) array_push( $idarray, $r_id ) ;
			}
			return $idarray ;
		}

		function getMycidsIntreeArray( $selectid, $whr='', $cids_child='' )
		{
			$cids  = $idarray = array() ;
			$cids[]  = $selectid ;
			$idarray = $this->getAllChildId( $selectid, $whr, $cids_child ) ;
			return  array_merge( $cids, $idarray ) ;
		}

		function getAllChildId( $selectid, $whr='', $cids_child='' )
		{
			$idarray = array() ;
			if( $cids_child === '' ){
				$sql = "SELECT cids_child FROM ".$this->cat_table." WHERE cid='".$selectid."'" ;
				if ( $whr != '' ) {
					$sql .= " AND ( $whr )";
				}
				$result = $this->db->query( $sql ) ;
				if ( $this->db->getRowsNum( $result ) == 0 ) {
					return array() ;
				}
				list( $cids_child ) = $this->db->fetchRow( $result ) ;
			}
			return $this->myts->idarray_by_explode( $cids_child ) ;
		}

		function getPathFromId( $selectid, $whr='' , $path_array='' )
		{
			$path = '' ;
			$i = 0 ;
			if( $path_array ==='' ){
				$path_array = $this->unserialize_my_path( $selectid, $whr ) ;
			}
			$count = count( $path_array ) ;
			if( $count == 0 ) return $path ;
			else  foreach( $path_array as $mypath ) {
				$i++ ;
				if( $i < $count ) $path .= $this->myts->makeTboxData4Show( $mypath['title'] )."&nbsp;&gt;&nbsp;" ;
				else $path .= $this->myts->makeTboxData4Show( $mypath['title'] ) ;
			}
			return $path;
		}

		function getPathArrayFromId( $selectid, $whr='' , $path_array='' )
		{
			$path = array() ;
			if( $path_array ==='' ){
				$path_array = $this->unserialize_my_path( $selectid, $whr ) ;
			}
			if( empty( $path_array ) ) return array() ;
			else  foreach( $path_array as $mypath ) {
				$path[] = $this->myts->makeTboxData4Show( $mypath['title'] ) ;
			}
			return $path;
		}

		function getNicePathFromId( $selectid, $whr='' , $funcURL, $path_array='' )
		{
			$path = '' ;
			$i = 0 ;
			if( $path_array === '' ){
				$path_array = $this->unserialize_my_path( $selectid, $whr ) ;
			}
			$count = count( $path_array ) ;
			if( $count == 0 ) return $path ;
			else  foreach( $path_array as $mypath ) {
				$i++ ;
				$cid    = intval( $mypath['cid'] ) ;
				$name   = $this->myts->makeTboxData4Show( $mypath['title'] ) ;
				$liason = ( $funcURL == "index.php?" ) ? '' : '&amp;' ;
				if( $i < $count ) $path .= '<a href="'.$funcURL.$liason.'cid='.$cid.'">'.$name.'</a>&nbsp;&gt;&nbsp;' ;
				else $path .= $name ;
			}
			return $path ;
		}

		function getNicePathArrayFromId( $selectid, $whr='' , $funcURL, $path_array='' )
		{
			$path = array() ;
			if( $path_array === '' ){
				$path_array = $this->unserialize_my_path( $selectid, $whr ) ;
			}
			if( empty( $path_array ) ) return array() ;
			else  foreach( $path_array as $mypath ) {
				$cid    = intval( $mypath['cid'] ) ;
				$liason = ( $funcURL == "index.php?" ) ? '' : '&amp;' ;
				$path[] = array(
					'url'  => $funcURL.$liason.'cid='.$cid ,
					'title'=> htmlspecialchars( $mypath['title'] , ENT_QUOTES )
				) ;
			}
			return $path ;
		}

		// $selectid -> ( $maincid ) only
		function get_my_cids_array( $selectid=0 , $whr='', $topcat=0, $child=0 )
		{
			$cids = array() ;
			$sql = "SELECT cid, cids_child FROM ".$this->cat_table."" ;
			if( ! empty( $child ) ) $sql .= "  WHERE pid > '0'" ;
			else  $sql .= "  WHERE pid = '0'" ;
			if( ! empty( $selectid ) ){
				$maincid = $this->get_my_maincid( $selectid ) ;
				$sql .= " AND cid='".$maincid."'" ;
			}
			if ( $whr != '' ) {
				$sql .= " AND ( $whr )" ;
			}
			$result = $this->db->query( $sql ) ;
			if ( $this->db->getRowsNum( $result ) == 0 ) {
				return array() ;
			}
			while( list( $id, $cids_child ) = $this->db->fetchRow( $result ) ) {
				$cid    = intval( $id ) ;
				$cids[] = $cid ;
				if( empty( $topcat ) && empty( $child ) ){
					$cids = array_merge( $cids, $this->getAllChildId( $cid, $whr, $cids_child ) ) ;
				}
			}
			return $cids ;
		}

		function default_whr_append()
		{
			include_once dirname( dirname(__FILE__) ).'/class/mydownload.php' ;
			$mydownload = new MyDownload( $this->mydirname ) ;
			return $mydownload->whr_append( 'Single' ) ;
		}

		function getsub_categories( $whr, $selectid=0, $whr_append = "", $default_whr_append=1 )
		{
			global $xoopsUser ;

			$cid = ( empty( $selectid ) ) ? $this->selectid : $selectid ; 
			if( ! empty( $default_whr_append ) && $whr_append == "" ) $whr_append = $this->default_whr_append() ;

			$cache_time = 86400 ;
			$site_salt = substr( md5( XOOPS_URL ) , -4 ) ;
			$cache = XOOPS_TRUST_PATH.'/cache/'.$this->mydirname.'_'.$cid.'_'.$site_salt.'.php' ;
			$cache_topview = XOOPS_TRUST_PATH.'/cache/'.$this->mydirname.'_topview_'.$site_salt.'.php' ;

			if( is_object( $xoopsUser ) || ! file_exists( XOOPS_TRUST_PATH.'/cache/' ) ) {
				return $this->get_categories_data( $cid, $whr, $whr_append ) ;
			} elseif ( file_exists( $cache ) && file_exists( $cache_topview ) && filemtime( $cache ) + $cache_time > time() ){
				$data = @unserialize( join( '', file( $cache ) ) ) ;
				if( is_array( $data ) ) return $data ;
				else return $this->get_categories_data( $cid, $whr, $whr_append ) ;
			} else {
				$data = $this->get_categories_data( $cid, $whr, $whr_append ) ;
				if ( $fp = @fopen( $cache, 'wb' ) ){
					fputs( $fp, serialize( $data ) ) ;
					fclose( $fp );
				}
				return $data ;
			}
		}

		function get_categories_data( $selectid, $whr, $whr_append = "", $default_whr_append=1 )
		{
			$ret = array() ;
			if( ! empty( $default_whr_append ) && $whr_append == "" ) $whr_append = $this->default_whr_append() ;
			$sql = "SELECT cid, title, imgurl, child, cids_child FROM ".$this->cat_table." WHERE pid = '".$selectid."'" ;
			if ( $whr != '' ) {
				$sql .= " AND ( $whr )";
			}
			$sql .= " ORDER BY cat_weight";
			$result = $this->db->query( $sql ) ;
			while( list( $id , $title , $imgurl, $child, $cids_child ) = $this->db->fetchRow( $result ) ) {
				$subcat      = array() ;
				$cid         = intval( $id );
				$child_array = $this->unserialize_my_child( $selectid, $whr, $child ) ;
				$arr         = $this->getFirstChild( $cid, $whr, $child_array ) ;
				if( ! empty( $arr ) ) foreach( $arr as $mychild ) {
					$child_id = intval( $mychild['cid'] );
					$subcat[] = array(
						'cid'              => $child_id ,
						'title'            => $this->myts->makeTboxData4Show( $mychild['title'] ) ,
						'subcat_total'     => $this->small_sum_from_cat( $child_id , $whr_append ) ,
						'number_of_subcat' => count( $this->getFirstChildId( $child_id , $whr, $child_array ) )
					) ;
				}
				// Category's banner default
				if( $imgurl == "http://" ) $imgurl = '' ;
				// Total sum of file
				$cids = $this->getMycidsIntreeArray( $cid, $whr, $cids_child ) ;
				$ret[] = array(
					'cid'           => $cid ,
					'imgurl'        => $this->myts->makeTboxData4Show( $imgurl ) ,
					'subcat_total'  => $this->small_sum_from_cat( $cid , $whr_append ),
					'bcat_total'    => empty( $cids ) ? 0 : $this->total_sum_from_cat( $cids , $whr_append ) ,
					'title'         => $this->myts->makeTboxData4Show( $title ) ,
					'subcategories' => $subcat
				) ;
			}
			return $ret ;
		}

		function total_sum_from_cat( $cids, $whr_append = "" )
		{
			if( $whr_append ) $whr_append = "AND ( $whr_append )" ;
			$whr = "cid IN (".implode(",", $cids ).")" ;
			$sql = "SELECT COUNT( lid ) FROM ".$this->downloads_table." WHERE $whr $whr_append" ;
			$trs = $this->db->query( $sql ) ;
			list( $numrows ) = $this->db->fetchRow( $trs ) ;
			return $numrows ;
		}

		function small_sum_from_cat( $cid, $whr_append = "" )
		{
			if( $whr_append ) $whr_append = "AND ( $whr_append )" ;
			$sql = "SELECT COUNT( lid ) FROM ".$this->downloads_table." WHERE cid='".$cid."' $whr_append" ;
			$trs = $this->db->query( $sql ) ;
			list( $numrows ) = $this->db->fetchRow( $trs ) ;
			return $numrows ;
		}

		function sitemap( $path, $whr='', $plugin=0, $whr_append = "", $intree=1 )
		{
			$i = 0 ;
			$ret = array() ;
			$liason = ( $path == "index.php?" ) ? '' : '&amp;' ;
			$sql = "SELECT cid, title, imgurl, child, cids_child FROM ".$this->cat_table." WHERE pid='0'" ;
			if ( $whr != '' ) $sql .= " AND ( $whr )";
			$sql .= " ORDER BY cat_weight ASC";
			$crs = $this->db->query( $sql ) ;
			while( list( $id, $name, $imgurl, $child, $cids_child ) = $this->db->fetchRow( $crs ) ) {
				if( $imgurl == "http://" ) $imgurl = '' ;
				$cid         = intval( $id );
				$child_array = $this->unserialize_my_child( $cid, $whr, $child ) ;
				$ret['parent'][$i] = array(
					'title'       => $this->myts->makeTboxData4Show( $name ) ,
					'url'         => ( empty( $plugin ) ) ? $path.$liason.'cid='.$cid : 'index.php?cid='.$cid ,
					'image'       => ( empty( $plugin ) ) ? $this->myts->makeTboxData4Show( $imgurl ) : 1 ,
					'files'       => $this->small_sum_from_cat( $cid, $whr_append ) ,
					'total_files' => $this->total_sum_from_cat( $this->getMycidsIntreeArray( $cid, $whr, $cids_child ), $whr_append ),
				) ;
				if( ! empty( $intree ) && ! empty( $child_array ) ) $ret['parent'][$i]['child'] = $this->sitemap_child( $cid, $path, $whr, $plugin, $child_array, $whr_append, $liason ) ;
				$i++ ;
			}
			return $ret ;
		}

		function sitemap_child( $cid, $path, $whr, $plugin, $child_array, $whr_append = "", $liason )
		{
			$ret = array() ;
			if( empty( $plugin ) ) foreach ( $child_array as $child ) {
				$child_id        = intval( $child['cid'] );
				$child['prefix'] = str_replace( ".","--", $child['prefix'] );
				$ret[] = array(
					'title' => $child['prefix']."&nbsp;".$this->myts->makeTboxData4Show( $child['title'] ) ,
					'url'   => $path.$liason.'cid='.$child_id  ,
					'image' => ( $child['imgurl'] == "http://" ) ? '' : $this->myts->makeTboxData4Show( $child['imgurl'] ) ,
					'files' => $this->small_sum_from_cat( $child_id, $whr_append ) ,
				) ;
			} else foreach ( $child_array as $child ) {
				$child_id = intval( $child['cid'] );
				$count = strlen( $child['prefix'] ) + 1;
				$ret[] = array(
					'title' => $this->myts->makeTboxData4Show( $child['title'] ) ,
					'url'   => 'index.php?cid='.$child_id  ,
					'image' => ( ( $count > 3 ) ? 4 : $count ) ,
				) ;
			}
			return $ret ;
		}

		function makecache_for_selbox( $whr, $selectid=0, $sum=0, $all=0, $none='', $top=0, $notnin=0 )
		{
			global $xoopsUser ;

			$cache_time = 86400 ;
			$site_salt = substr( md5( XOOPS_URL ) , -4 ) ;
			$cache = XOOPS_TRUST_PATH.'/cache/'.$this->mydirname.'_selbox_'.$site_salt.'.php' ;
			$cache_topview = XOOPS_TRUST_PATH.'/cache/'.$this->mydirname.'_topview_'.$site_salt.'.php' ;

			if( is_object( $xoopsUser ) || ! file_exists( XOOPS_TRUST_PATH.'/cache/' ) ) {
				return $this->categories_selbox( $whr, $selectid, $sum, $all, $none, $top, $notnin ) ;
			} elseif ( file_exists( $cache ) && file_exists( $cache_topview ) && filemtime( $cache ) + $cache_time > time() ){
				$data = @unserialize( join( '', file( $cache ) ) ) ;
				if( is_array( $data ) ) return $data ;
				else return $this->categories_selbox( $whr, $selectid, $sum, $all, $none, $top, $notnin ) ;
			} else {
				$data = $this->categories_selbox( $whr, $selectid, $sum, $all, $none, $top, $notnin ) ;
				if ( $fp = @fopen( $cache, 'wb' ) ){
					fputs( $fp, serialize( $data ) ) ;
					fclose( $fp );
				}
				return $data ;
			}
		}

		function categories_selbox( $whr, $selectid=0, $sum=0, $all=0, $none='', $top=0, $notnin=0 )
		{
			$category = array();
			if( ! empty( $selectid ) ){
				$maincid = $this->get_my_maincid( $selectid ) ;
				$cid = ( empty( $maincid ) ) ? $selectid : $maincid ;
			}
			if( ! empty( $none ) ) $category = array( 0 => $none ) ;
			$whr_append = ( empty( $all ) ) ? $this->default_whr_append() : '' ;
			$sql = "SELECT cid, title, child FROM ".$this->cat_table."";
			$sql .= ( ! empty( $cid ) ) ? " WHERE cid='".$cid."'" : " WHERE pid='0'";
			if( ! empty( $whr ) ) $sql .= " AND ( $whr )";
			$sql .= " ORDER BY cat_weight ASC";
			$crs = $this->db->query( $sql );
			while( list( $id, $name, $child_array ) = $this->db->fetchRow( $crs ) ) {
				$catid = intval( $id );
				if(  $catid != $notnin ) $category[$catid] = $this->myts->makeTboxData4Show( $name ) ;
				if( ! empty( $sum ) ) $category[$catid] .= "&nbsp;(".$this->small_sum_from_cat( $catid, $whr_append ).")" ;
				if( empty( $top ) ){
					$arr = $this->unserialize_my_child( $catid, $whr, $child_array ) ;
					if( ! empty( $arr ) ) foreach ( $arr as $mychild ) {
						$child_id = intval( $mychild['cid'] );
						if(  $child_id != $notnin ){
							$mychild['prefix'] = str_replace( ".","--", $mychild['prefix'] );
							$category[$child_id] = $mychild['prefix']."&nbsp;".$this->myts->makeTboxData4Show( $mychild['title'] );
							if( ! empty( $sum ) ) $category[$child_id] .= "&nbsp;(".$this->small_sum_from_cat( $child_id , $whr_append ).")";
						}
					}
				}
			}
			return $category ;
		}

		function get_categorylist( $perpage, $current_start )
		{
			$category = array();
			$sql = "SELECT $this->columns FROM ".$this->cat_table." ORDER BY cat_weight ASC" ;
			$result = $this->db->query( $sql, $perpage, $current_start ) ;
			if ( $this->db->getRowsNum( $result ) == 0 ) {
				return array() ;
			}
			while( $array = $this->db->fetchArray( $result ) ) {
				foreach ( $array as $key=>$value ){
					$this->$key = $value;
				}
				$cid           = $this->return_cid() ;
				$pid           = $this->return_pid() ;
				$my_parent_cat = $this->get_my_parent_cat( $pid ) ;
				$category[] = array(
					'cid'         => $cid ,
					'pid'         => $pid ,
					'title'       => $this->return_title( 'Show' ) ,
					'cat_weight'  => $this->return_cat_weight() ,
					'files'       => $this->small_sum_from_cat( $cid ) ,
					'subcategory' =>  $this->subcategory_sum( $cid ) ,
					'parentid'    => ( empty( $my_parent_cat ) ) ? 0 : $my_parent_cat['parentid'] ,
					'parent_cat'  => ( empty( $my_parent_cat ) ) ? '' : $my_parent_cat['title'] ,
					'imgurl'      => ( $this->imgurl == "http://" ) ? '' : $this->return_imgurl( 'Show' ) ,
				) ;
			}
			return $category ;
		}

		function pid_select_check( $cid, $select_pid, $old_pid, $user_access_noupdate=0 )
		{
			if( ( $select_pid != $old_pid ) && in_array( $select_pid, $this->getAllChildId( $cid ) ) ){
				$this->pid_arrangement( $cid, $select_pid, $old_pid, $user_access_noupdate ) ;
			}
		}

		function pid_arrangement( $cid, $select_pid, $old_pid, $user_access_noupdate=0 )
		{
			$error = 0 ;
			$prs = $this->db->query( "SELECT cid FROM ".$this->cat_table."  WHERE pid='".$cid."'");
			while( list( $id ) = $this->db->fetchRow( $prs ) ) {
				$this->db->query( "UPDATE ".$this->cat_table." SET pid='".$old_pid."' WHERE cid='".intval( $id )."'" ) or die( "DB error: cat table." ) ;
				if( $select_pid != 0 && $old_pid == 0 ){
					$error = $this->my_user_access_copy( $cid, intval( $id ), $user_access_noupdate ) ;
					if( ! empty( $error ) ) die( "DB error: user_access table." ) ;
				}
			}
		}

		function my_user_access_copy( $fromid, $toid, $user_access_noupdate=0 )
		{
			include_once dirname( dirname(__FILE__) ).'/class/user_access.php' ;
			$user_access = new user_access( $this->mydirname ) ;

			$error = 0 ;
			$error = $user_access->current_user_access_copy( $fromid, $toid, 'group', $user_access_noupdate ) ;
			$error = $user_access->current_user_access_copy( $fromid, $toid, 'user', $user_access_noupdate ) ;
			return $error ;
		}

		function category_move( $cid, $select_pid )
		{
			$error = 0 ;
			$result = $this->db->query( "SELECT pid FROM ".$this->cat_table." WHERE cid='".$cid."'" );
			list( $mypid ) = $this->db->fetchRow( $result ) ;
			$this->pid_select_check( $cid, $select_pid, intval( $mypid ), 1 ) ;
			$mrs = $this->db->query( "UPDATE ".$this->cat_table." SET pid='".$select_pid."' WHERE cid='".$cid."'" ) ;
			if( ! $mrs ) $error = $cid ;
			return $error ;
		}

		function category_top_move( $cid )
		{
			$error = 0 ;
			$fars = $this->db->query( "SELECT * FROM ".$this->user_access_table." WHERE cid='".$cid."' AND groupid > 0" ) ;
			if ( $this->db->getRowsNum( $fars ) == 0 ){
				$my_maincid= $this->get_my_maincid( $cid ) ;
				$error = $this->my_user_access_copy( $my_maincid, $cid, 1 ) ;
			}
			$mrs = $this->db->query( "UPDATE ".$this->cat_table." SET pid='0' WHERE cid='".$cid."'" ) ;
			if( ! $mrs ) $error = $cid ;
			return $error ;
		}

		function MyCategory_for_Edit( $cid )
		{
			if( empty( $cid ) ){
				return array(
					'cid'        => 0 ,
					'pid'        => isset( $_GET['pid'] ) ? intval( $_GET['pid'] ) : 0 ,
					'cat_weight' => $this->get_max_weight() + 1 ,
					'old_pid'    => 0 ,
				) ;
			} else {
				$this->GetMyCategory( $cid ) ;
				return array(
					'cid'            => $this->return_cid() ,
					'pid'            => $this->return_pid() ,
					'title'          => $this->return_title( 'Edit' ) ,
					'imgurl'         => $this->return_imgurl( 'Edit' ) ,
					'description'    => $this->return_description( 'Edit' ) ,
					'shotsdir'       => $this->return_shotsdir( 'Edit' ) ,
					'cat_weight'     => $this->return_cat_weight() ,
					'submit_message' => $this->return_submit_message( 'Edit' ) ,
					'old_pid'        => $this->return_pid() ,
				) ;
			}
		}

		function requests_int_categories()
		{
			// requests_int Initialization
			$cid = $pid = $cat_weight = 0 ;

			// get requests_int
			foreach( $this->requests_int as $key ) {
				$$key = intval( @$_POST[ $key ] ) ;
			}

			// set4sql
			$set4sql = "cid='".$cid."'" ;
			$array4sql = array_diff( $this->requests_int, array( 'cid' ) ) ;
			foreach( $array4sql as $key ) {
				$set4sql .= ",$key='".$$key."'" ;
			}

			return array(
				'cid'        => $cid ,
				'pid'        => $pid ,
				'cat_weight' => $cat_weight ,
				'set4sql'    => $set4sql ,
			) ;
		}

		function requests_text_categories()
		{
			// requests_text Initialization
			$title = $imgurl = $description = $shotsdir = $submit_message = "" ;

			// stripSlashesGPC
			foreach( $this->requests_text as $key ) {
				$$key = $this->myts->MystripSlashesGPC( @$_POST[ $key ] ) ;
			}

			// Data4Edit
			$tboxdata4edit = array( 'title' , 'imgurl' , 'shotsdir' ) ;
			foreach( $tboxdata4edit as $key ) {
				$tbox4data[$key] = $this->myts->makeTboxData4Edit( $$key ) ;
			}
			$tareadata4edit = array( 'description' , 'submit_message' ) ;
			foreach( $tareadata4edit as $key ) {
				$tarea4data[$key] = $this->myts->makeTareaData4Edit( $$key ) ;
			}

			// set4sql
			$set4sql = "" ;
			foreach( $this->requests_text as $key ) {
				$set4sql .= ",$key='".addslashes($$key)."'" ;
			}
			
			return array(
				'title'               => $title ,
				'imgurl'              => $imgurl ,
				'description'         => $description ,
				'shotsdir'            => $shotsdir ,
				'title4edit'          => $tbox4data['title'] ,
				'imgurl4edit'         => $tbox4data['imgurl'] ,
				'description4edit'    => $tarea4data['description'] ,
				'shotsdir4edit'       => $tbox4data['shotsdir'] ,
				'submit_message4edit' => $tarea4data['submit_message'] ,
				'set4sql'             => $set4sql ,
			) ;
	    }

		function serialize_insertdb()
		{
			$error = array() ;
			$result = $this->db->query( "SELECT cid FROM ".$this->cat_table."" ) ;
			while( list( $id ) = $this->db->fetchRow( $result ) ) {
				$cid = intval( $id ) ;

				// child
				$child_array = $this->get_my_child_array_by_recursive( $cid ) ;
				$child = ( ! empty( $child_array ) ) ? addslashes( $this->myts->makeSerializeData( $child_array ) ) : '' ;

				// path
				$path_array = $this->get_my_path_array_by_recursive( $cid ) ;
				$path = ( ! empty( $path_array ) ) ? addslashes( $this->myts->makeSerializeData( $path_array ) ) : '' ;

				// cids_child
				$my_cids = $this->get_my_cids_child_by_recursive( $cid ) ;
				$cids_child = ( ! empty( $my_cids ) ) ? addslashes( $my_cids ) : '' ;

				// set4sql
				$set4sql = "child='".$child."'" ;
				$set4sql .= ",path = '".$path."'" ;
				$set4sql .= ",cids_child = '".$cids_child."'" ;

				// insertdb
				$mrs = $this->db->query( "UPDATE ".$this->cat_table." SET $set4sql WHERE cid='".$cid ."'" ) ;
				if( ! $mrs ) $error[] = $cid ;
			}
			return $error ;
		}

		function get_my_child_array_by_recursive( $selectid, $whr='', $all=0, $child_array = array(), $prefix='' )
		{
			$columns = ( empty( $all ) ) ? "cid, pid, title, imgurl" : "*" ;
			$sql = "SELECT $columns FROM ".$this->cat_table." WHERE pid='".$selectid."'" ;
			if ( $whr != '' ) {
				$sql .= " AND ( $whr )";
			}
			$sql .= " ORDER BY cat_weight";
			$result = $this->db->query( $sql );
			$count = $this->db->getRowsNum( $result );
			if ( $count == 0 ) {
				return $child_array ;
			}
			while ( $row = $this->db->fetchArray( $result ) ) {
				$row['prefix'] = $prefix.'.';
				array_push( $child_array, $row );
				$child_array = $this->get_my_child_array_by_recursive( $row['cid'], $whr , $all, $child_array, $row['prefix'] );
			}
			return $child_array;
		}

		function get_my_path_array_by_recursive( $selectid, $whr='', $path=array() )
		{
			$sql = "SELECT pid, title FROM ".$this->cat_table." WHERE cid='".$selectid."'" ;
			if ( $whr != '' ) {
				$sql .= " AND ( $whr )";
			}
			$result = $this->db->query( $sql );
			if ( $this->db->getRowsNum( $result ) == 0 ) {
				return array_reverse( $path );
			}
			list( $pid, $title ) = $this->db->fetchRow( $result );
			$path[] = array(
				'cid'  => intval( $selectid ),
				'pid'  => intval( $pid ),
				'title'=> $title
			);
			$path = $this->get_my_path_array_by_recursive( intval( $pid ), $whr, $path );
			return $path;
		}

		function get_my_cids_child_by_recursive( $selectid , $whr='', $cids_child ='' )
		{
			$sql = "SELECT cid FROM ".$this->cat_table." WHERE pid='".$selectid."'" ;
			if ( $whr != '' ) {
				$sql .= " AND ( $whr )" ;
			}
			$sql .= " ORDER BY cat_weight";
			$result = $this->db->query( $sql ) ;
			if ( $this->db->getRowsNum( $result ) == 0 ) {
				return $cids_child ;
			}
			$result = $this->db->query( $sql ) ;
			while( list( $id ) = $this->db->fetchRow( $result ) ) {
				$cid = intval( $id ) ;
				$cids_child = ( empty( $cids_child ) ) ? $cid : $cids_child .','. $cid ;
				$cids_child = $this->get_my_cids_child_by_recursive( $cid, $whr, $cids_child ) ;
			}
			return $cids_child ;
		}

		function date_save_cat_table( $cid )
		{
			$this->db->query( "UPDATE ".$this->cat_table." SET date='".time()."' WHERE cid='".$cid."'" ) ;
		}

		function category_tree_check()
		{
			$error = 0 ;
			$cids = $this->get_my_cids_array() ;
			$crs = $this->db->query( "SELECT cid FROM ".$this->cat_table."" ) ;
			while( list( $id ) = $this->db->fetchRow( $crs ) ) {
				if( ! in_array( intval( $id ), $cids ) ){
					$mrs = $this->db->query( "UPDATE ".$this->cat_table." SET pid='0' WHERE cid='".intval( $id )."'" ) ;
					if( ! $mrs ) $error = $cid ;
				}
			}
			return $error ;
		}

		function delete_cache_of_categories()
		{
			$site_salt = substr( md5( XOOPS_URL ) , -4 ) ;

			$cache = XOOPS_TRUST_PATH.'/cache/'.$this->mydirname.'_0_'.$site_salt.'.php' ;
			if( file_exists( $cache ) ) @unlink( $cache ) ;

			$topview_cache = XOOPS_TRUST_PATH.'/cache/'.$this->mydirname.'_topview_'.$site_salt.'.php' ;
			if( file_exists( $topview_cache ) ) @unlink( $topview_cache ) ;

			$selbox_cache = XOOPS_TRUST_PATH.'/cache/'.$this->mydirname.'_selbox_'.$site_salt.'.php' ;
			if( file_exists( $selbox_cache ) ) @unlink( $selbox_cache ) ;

			$sql = "SELECT cid, cids_child FROM ".$this->cat_table." WHERE pid='0'";
			$crs = $this->db->query( $sql );
			while( list( $cid, $cids_child ) = $this->db->fetchRow( $crs ) ) {
				$catid = intval( $cid );
				$parent_cache = XOOPS_TRUST_PATH.'/cache/'.$this->mydirname.'_'.$catid.'_'.$site_salt.'.php' ;
				if( file_exists( $parent_cache ) ) @unlink( $parent_cache ) ;

				$array = $this->getAllChildId( $catid, '', $cids_child ) ;
				if( ! empty( $array ) ) foreach ( $array as $child ) {
					$child_cache = XOOPS_TRUST_PATH.'/cache/'.$this->mydirname.'_'.intval( $child ).'_'.$site_salt.'.php' ;
					if( file_exists( $child_cache ) ) @unlink( $child_cache ) ;
				}
			}
		}

		function Validate()
		{
			$void_check = $imgurl_check = $shotsdir_check = $max_check = array() ;

			// get post data
			$current_requests_text = array_diff( $this->requests_text, array( 'description' , 'submit_message' ) );
			foreach( $current_requests_text as $key ) {
				$this->$key = $this->myts->MystripSlashesGPC( @$_POST[ $key ] ) ;
			}
			$this->cat_weight = @$_POST['cat_weight'] ;

			// Validate
			$void_check = array(
				array(
					'value'   => $this->title,
					'type'    => array('void'),
					'message' => _MD_D3DOWNLOADS_TITLE_NONE
				), 
			);

			if( $this->imgurl != 'http://' && ! empty( $this->imgurl ) ) {
				$imgurl_check = array(
					array(
						'value'   => $this->imgurl,
						'type'    => array('imgurl'),
						'message' => _MD_D3DOWNLOADS_IMGURL_CHECK
					), 
				);
			}

			if( ! empty( $this->shotsdir ) ){
				$cate_shotsdir = XOOPS_ROOT_PATH.'/'.$this->shotsdir ;
				$shotsdir_check = array(
					array(
						'value'   => $cate_shotsdir,
						'type'    => array('file_exists'),
						'message' => _MD_D3DOWNLOADS_SHOTSDIR_CHECK
					), 
				);
			}

			$max_check = array(
				array(
					'value'   => array( $this->title, $this->title_length ),
					'type'    => array('max'),
					'message' => sprintf( _MD_D3DOWNLOADS_TITLE_TOOLONG, $this->title_length )
				), 
				array(
					'value'   => array( $this->imgurl, $this->imgurl_length ),
					'type'    => array('max'),
					'message' => sprintf( _MD_D3DOWNLOADS_IMGURL_TOOLONG, $this->imgurl_length )
				), 
				array(
					'value'   => array( $this->shotsdir, $this->shotsdir_length ),
					'type'    => array('max'),
					'message' => sprintf( _MD_D3DOWNLOADS_SHOTSDIR_TOOLONG, $this->shotsdir_length )
				), 
				array(
					'value'   => array( $this->cat_weight, $this->cat_weight_length ),
					'type'    => array('max'),
					'message' => sprintf( _MD_D3DOWNLOADS_CAT_WEIGHT_TOOLONG, $this->cat_weight_length )
				), 
			) ;

			$params = array_merge( $void_check, $imgurl_check, $shotsdir_check, $max_check ) ;
			$result = $this->post_check->check( $params );
			return array(
				'error'   => $this->post_check->error_count ,
				'message' => $this->post_check->error_message ,
			) ;
		}
	}
}

?>