<?php
require_once XOOPS_TRUST_PATH.'/modules/d3forum/class/D3commentAbstract.class.php' ;

// a class for d3forum comment integration
if( !class_exists('piCalD3commentContent') )
{
	class piCalD3commentContent extends D3commentAbstract
	{
		function fetchSummary( $external_link_id )
		{
			global $xoopsDB, $xoopsConfig, $xoopsUser;
			$myts =& MyTextSanitizer::getInstance();

			$module_handler =& xoops_gethandler( 'module' ) ;
			$module =& $module_handler->getByDirname( $this->mydirname ) ;

			$eventcomment_id = intval( $external_link_id ) ;
			$mydirname = $this->mydirname ;
			if( ! preg_match( '/^(\D+)(\d*)$/' , $mydirname , $regs ) )  die( 'Invalid mydirname' ) ;
			$mydirnumber = $regs[2] === '' ? '' : intval( $regs[2] ) ;
			$table_event = $xoopsDB->prefix("pical{$mydirnumber}_event");

			$MOD_PATH = XOOPS_ROOT_PATH .'/modules/'. $mydirname;

			if( ! class_exists( 'piCal_xoops' ) )
			{
				require_once( $MOD_PATH .'/class/piCal.php' ) ;
				require_once( $MOD_PATH .'/class/piCal_xoops.php' ) ;
			}

			$cal = new piCal_xoops( '' , $xoopsConfig['language'] , true ) ;
			include( $MOD_PATH .'/include/read_configs.php' ) ;
			$whr_categories = $cal->get_where_about_categories() ;
			$whr_class      = $cal->get_where_about_class() ;

			$content_row = $xoopsDB->fetchArray( $xoopsDB->query( "SELECT id, summary, description FROM $table_event WHERE id=$eventcomment_id AND ($whr_categories) AND ($whr_class)" ) ) ;
			if( empty( $content_row ) ) {
				redirect_header(XOOPS_URL.'/user.php',3,_NOPERM);
				exit();
			}

			$subject = $myts->makeTboxData4Show( $content_row['summary'] );
//HACK by domifara
//			$uri = XOOPS_URL.'/modules/'.$mydirname.'/index.php?action=View&amp;event_id='.$eventcomment_id;
			$uri = XOOPS_URL.'/modules/'.$mydirname.'/index.php?action=View&event_id='.$eventcomment_id;
			$str = strip_tags($myts->displayTarea(strip_tags($content_row['description'])));
			$summary = xoops_substr( $str , 0 , 255 );

			return array(
				'dirname' => $mydirname ,
				'module_name' => $module->getVar( 'name' ) ,
				'subject' => $subject ,
				'uri' => $uri,
				'summary' => $summary,
			) ;
		}

		function validate_id( $link_id )
		{
		    global $xoopsDB, $xoopsConfig, $xoopsUser;
			$eventcomment_id = intval( $link_id ) ;
			$mydirname = $this->mydirname ;
			if( ! preg_match( '/^(\D+)(\d*)$/' , $mydirname , $regs ) )  die( 'Invalid mydirname' ) ;
			$mydirnumber = $regs[2] === '' ? '' : intval( $regs[2] ) ;
			$table_event = $xoopsDB->prefix("pical{$mydirnumber}_event");

			$MOD_PATH = XOOPS_ROOT_PATH .'/modules/'. $mydirname;

			if( ! class_exists( 'piCal_xoops' ) )
			{
				require_once( $MOD_PATH .'/class/piCal.php' ) ;
				require_once( $MOD_PATH .'/class/piCal_xoops.php' ) ;
			}

			$cal = new piCal_xoops( '' , $xoopsConfig['language'] , true ) ;
			include( $MOD_PATH .'/include/read_configs.php' ) ;
			$whr_categories = $cal->get_where_about_categories() ;
			$whr_class      = $cal->get_where_about_class() ;

			list( $count ) = $xoopsDB->fetchRow( $xoopsDB->query( "SELECT COUNT(*) FROM $table_event WHERE id=$eventcomment_id AND admission > 0 AND ($whr_categories) AND ($whr_class)" ) ) ;
			if( $count <= 0 ) return false ;
			else return $eventcomment_id ;
		}

		function onUpdate( $mode , $link_id , $forum_id , $topic_id , $post_id = 0 )
		{
		    global $xoopsDB ;
			$eventcomment_id = intval( $link_id ) ;
			$mydirname = $this->mydirname ;
			if( ! preg_match( '/^(\D+)(\d*)$/' , $mydirname , $regs ) )  die( 'Invalid mydirname' ) ;
			$mydirnumber = $regs[2] === '' ? '' : intval( $regs[2] ) ;
			$table_event = $xoopsDB->prefix("pical{$mydirnumber}_event");

			list( $count ) = $xoopsDB->fetchRow( $xoopsDB->query( "SELECT COUNT(*) FROM ".$xoopsDB->prefix($this->d3forum_dirname."_posts")." p LEFT JOIN ".$xoopsDB->prefix($this->d3forum_dirname."_topics")." t ON t.topic_id=p.topic_id WHERE t.forum_id=$forum_id AND t.topic_external_link_id='$eventcomment_id'" ) ) ;
			$xoopsDB->queryF( "UPDATE $table_event SET comments=$count WHERE id=$eventcomment_id" ) ;

			return true ;
		}

		// set forum_dirname from config.comment_dirname
		function setD3forumDirname( $d3forum_dirname = '' )
		{
			if( ! empty($this->mod_config['comment_dirname'] ) ) {
    				$this->d3forum_dirname = $this->mod_config['comment_dirname'] ;
			} elseif( ! empty( $params['comment_dirname'] ) ) {
				$this->d3forum_dirname = $params['comment_dirname'] ;
			} elseif( $d3forum_dirname ) {
				$this->d3forum_dirname = $d3forum_dirname ;
			} else {
				$this->d3forum_dirname = 'd3forum' ;
			}
		}
	}
}
?>