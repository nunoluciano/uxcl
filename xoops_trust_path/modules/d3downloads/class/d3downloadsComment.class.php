<?php

// a class for d3forum comment integration
if( ! class_exists( 'd3downloadsComment' ) )
{
	require_once XOOPS_TRUST_PATH.'/modules/d3forum/class/D3commentAbstract.class.php' ;

	class d3downloadsComment extends D3commentAbstract
	{
		function fetchSummary( $external_link_id )
		{
			require_once dirname( dirname(__FILE__) ).'/class/d3downloads.textsanitizer.php' ;

			$db =& Database::getInstance() ;
			$myts =& d3downloadsTextSanitizer::getInstance() ;

			$module_handler =& xoops_gethandler( 'module' ) ;
			$module =& $module_handler->getByDirname( $this->mydirname ) ;

			$lid = intval( $external_link_id ) ;
			$mydirname = $this->mydirname ;
			if( preg_match( '/[^0-9a-zA-Z_-]/' , $mydirname ) ) die( 'Invalid mydirname' ) ;

			$sql = "SELECT lid, cid, title, description, filters FROM ".$db->prefix( $mydirname."_downloads" )." WHERE lid='".$lid."'" ;
			$myrow = $db->fetchArray( $db->query( $sql ) ) ;
			if( empty( $myrow ) ) return '' ;

			$cid = intval( $myrow['cid'] ) ;
			$uri = XOOPS_URL.'/modules/'.$mydirname.'/index.php?page=singlefile&cid='.$cid.'&lid='.$lid ;
			$filters = $myts->makeTboxData4Show( $myrow['filters'] ) ;
			$str = strip_tags( $myts->displayTarea( strip_tags( $myrow['description'] ), 0, 1, 1, 1, 1, $filters ) ) ;
			$summary = xoops_substr( $str , 0 , 255 ) ;

			return array(
				'dirname' => $mydirname ,
				'module_name' => $module->getVar( 'name' ) ,
				'subject' => $myts->makeTboxData4Show( $myrow['title'] ) ,
				'uri' => $uri ,
				'summary' => $summary ,
			) ;
		}

		function validate_id( $link_id )
		{
			include_once dirname( dirname(__FILE__) ).'/class/user_access.php' ;
			include_once dirname( dirname(__FILE__) ).'/class/mydownload.php' ;

			$db =& Database::getInstance() ;
			$mydirname = $this->mydirname ;

			$user_access = new user_access( $mydirname ) ;
			$mydownload = new MyDownload( $mydirname ) ;

			$lid = intval( $link_id ) ;
			$whr_cat = "cid IN (".implode(",", $user_access->can_read() ).")" ;

			$sql = "SELECT COUNT(*) FROM ".$db->prefix( $mydirname."_downloads" )." WHERE lid='".$lid."'  AND ( $whr_cat )" ;
			$sql .= " AND ".$mydownload->whr_append( 'Single' )." AND cancomment = '1'" ;
			list( $count ) = $db->fetchRow( $db->query( $sql ) ) ;
			if( $count <= 0 ) return false ;
			else return $lid ;
		}

		function onUpdate( $mode , $link_id , $forum_id , $topic_id , $post_id = 0 )
		{
			include_once dirname( dirname(__FILE__) ).'/class/mycategory.php' ;

			$db =& Database::getInstance() ;
			$mydirname = $this->mydirname ;
			$mycategory = new MyCategory( $mydirname, 'Show' ) ;

			$lid = intval( $link_id ) ;

			$sql = "SELECT COUNT(*) FROM ".$db->prefix($this->d3forum_dirname."_posts")." p" ;
			$sql .= " LEFT JOIN ".$db->prefix($this->d3forum_dirname."_topics")." t" ;
			$sql .= " ON t.topic_id = p.topic_id WHERE t.forum_id = '".$forum_id."'" ;
			$sql .= " AND t.topic_external_link_id='".$lid."'" ;
			list( $count ) = $db->fetchRow( $db->query( $sql ) ) ;
			$db->queryF( "UPDATE ".$db->prefix( $mydirname."_downloads" )." SET comments=$count WHERE lid = '".$lid."'" ) ;
			$mycategory->delete_cache_of_categories() ;
			return true ;
		}

		// get id from <{$file_id}>
		function external_link_id( $params )
		{
			$file = $this->smarty->get_template_vars( 'file' ) ;
			return intval( $file['id'] ) ;
		}

		// get escaped subject from <{$file.title}>
		function getSubjectRaw( $params )
		{
			$file = $this->smarty->get_template_vars( 'file' ) ;
			return $this->unhtmlspecialchars( $file['title'] , ENT_QUOTES ) ;
		}

		// set d3forum_dirname from config
		function setD3forumDirname( $d3forum_dirname = '' )
		{
			$this->d3forum_dirname = $this->mod_config['comment_dirname'] ;
		}

		// get forum_id from config
		function getForumId( $params )
		{
			return $this->mod_config['comment_forum_id'] ;
		}

		// get view from config
		function getView( $params )
		{
			return $this->mod_config['comment_view'] ;
		}
	}
}

?>