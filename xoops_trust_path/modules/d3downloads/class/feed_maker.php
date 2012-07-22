<?php

if( ! class_exists( 'feed_maker' ) )
{
	class feed_maker
	{
		var $feed_limit = 15;
		var $encoding = 'UTF-8';
		var $encode = 'UTF-8';
		var $data = array() ;
		var $xsl_file = 'rss2html.xsl';

		function feed_maker( $mydirname )
		{
			global $xoopsModule;

			$this->mydirname = $mydirname ;
			$this->module_name = $xoopsModule->getVar('name');
			$module_handler =& xoops_gethandler('module');
			$config_handler =& xoops_gethandler('config');
			$module =& $module_handler->getByDirname( $mydirname );
			$mod_config =& $config_handler->getConfigsByCat( 0, $module->getVar('mid') );
			$this->mod_config = $mod_config ;
			$this->generator = 'd3downloads v'.intval( $module->getVar('version') )/100;
		}

		function get_feed_language()
		{
			return _LANGCODE;
		}

		function get_feed_author()
		{
			global $xoopsConfig ;
			return $xoopsConfig['sitename'];
		}

		function get_feed_limit()
		{
			if ( empty( $this->mod_config['per_rss'] ) ){
				 return $this->feed_limit;
			} else {
				 return intval( $this->mod_config['per_rss'] );
			}
		}

		function get_feed_title( $cid, $data )
		{
			global $xoopsConfig ;
			if( ! empty( $cid ) ){
				return $data[0]['cat_name']. ' - ' . $xoopsConfig['sitename'];
			} else {
				return $this->module_name. ' - ' . $xoopsConfig['sitename'] ;
			}
		}

		function get_feed_toplink( $cid )
		{
			$top_link = ( $cid )? "index.php?cid=".$cid : "";
			return XOOPS_URL.'/modules/'.$this->mydirname.'/'.$top_link;
		}

		function get_feed_link_self( $cid )
		{
			$top_link = ( $cid )? "&amp;cid=".$cid : "";
			return XOOPS_URL.'/modules/'.$this->mydirname.'/index.php?page=atom'.$top_link;
		}

		function set_xsl_file( $xsl_file )
		{
			return XOOPS_URL.'/modules/'.$this->mydirname.'/'.$xsl_file;
		}

		function get_feed_slogan()
		{
			global $xoopsConfig ;
			return $xoopsConfig['slogan'];
		}

		function get_feed_copyright()
		{
			global $xoopsConfig ;
			$copyright = 'Copyright (c) '.$this->get_date_year().','. $xoopsConfig['sitename'];
			return $copyright;
		}

		function get_feed_logo()
		{
			$logo = 'images/logo.gif';

			list( $file_width , $file_height ) = getimagesize( XOOPS_ROOT_PATH.'/'.$logo ) ;

			$maxwidth = 144 ;

			$width  = ( ! empty( $file_width ) ) ? intval( $file_width ) : 88 ;
			$height = ( ! empty( $file_height ) ) ? intval( $file_height ) : 31 ;
			if ( $width > $maxwidth ){
				$showsize = $maxwidth / $width ;
				$width    = floor( $width * $showsize );
				$height   = floor( $height * $showsize );
			}

			return array(
				'image_url'  => XOOPS_URL.'/'.$logo ,
				'width'  => $width ,
				'height' => $height ,
			) ;
		}

		function iso8601( $time )
		{
			$tzd = date( 'O', $time );
			$tzd = substr( chunk_split( $tzd, 3, ':' ), 0, 6 );
			$date = date('Y-m-d\TH:i:s', $time) . $tzd;
			return $date;
		}

		function get_feed_id( $url, $cid=0, $id, $time )
		{
			$parse = parse_url( $url );
			if ( isset( $parse['host'] ) ){
				if( ! empty( $cid ) ){
					$tag = 'tag:'.$parse['host'].','.$this->get_date_year( $time ).'://'.$cid.','.$id;
				} else {
					$tag = 'tag:'.$parse['host'].','.$this->get_date_year( $time ).'://'.$id;
				}
				return $tag ;
			} else {
				return false;
			}
		}

		function get_date_year( $time=null )
		{
			if ( empty( $time ) ){
				$time = time();
			}
			$usertimestamp = $this->get_user_timestamp( $time );
			$date = date( 'Y', $usertimestamp );
			return $date;
		}

		function get_user_timestamp( $time )
		{
			global $xoopsUser, $xoopsConfig ;
			if( is_object( $xoopsUser ) ) {
				$timeoffset = $xoopsUser->getVar('timezone_offset');
			} else {
				$timeoffset = $xoopsConfig['default_TZ'];
			}
			$usertimestamp = intval( $time ) + ( intval( $timeoffset ) - $xoopsConfig['server_TZ'] ) * 3600 ;
			return $usertimestamp;
		}

		// rdf 2.0
		function rdf_build( $cid, $data, $b_time, $encode, $encoding, $xsl_file='' )
		{
			$link = $this->get_feed_toplink( $cid );
			$out = '<?xml version="1.0" encoding="'.$encoding.'"?>
					<rdf:RDF xmlns="http://purl.org/rss/1.0/"
					xmlns:rdf="http://www.w3.org/1999/02/22-rdf-syntax-ns#"
					xmlns:dc="http://purl.org/dc/elements/1.1/"
					xmlns:content="http://purl.org/rss/1.0/modules/content/" xml:lang="'.$this->get_feed_language().'">
					<channel rdf:about="'.$link.'">
					<title>'.htmlspecialchars( $this->make_context( strip_tags( $this->get_feed_title( $cid, $data ) ) ), ENT_QUOTES ).'</title>
					<link>'.$link.'</link>
			';

		    if ( $this->get_feed_slogan() !='' ){
				$out .='<description>'.htmlspecialchars( $this->make_context( strip_tags( $this->get_feed_slogan() ) ), ENT_QUOTES ).'</description>';
			}

			$out .='<dc:date>'.$this->iso8601( $b_time ).'</dc:date>';
			$out .='<dc:language>'.$this->get_feed_language().'</dc:language>';
			$out .='<items><rdf:Seq>';
			foreach( $data as $item ) {
				$out .='<rdf:li rdf:resource="'.$item['link'].'" />';
			}
			$out .='</rdf:Seq></items>
					</channel>
			';

			foreach( $data as $item ) {
				$out .='<item rdf:about="'.$item['link'].'">
					<title>'.htmlspecialchars( $this->make_context( strip_tags( $item['title'] ) ), ENT_QUOTES).'</title>
					<link>'.$item['link'].'</link>
					<description>'.htmlspecialchars( $this->make_context( strip_tags( $item['description'] ) ), ENT_QUOTES ).'</description>
					<content:encoded><![CDATA['.$item['description'].']]></content:encoded>
					<dc:date>'.$this->iso8601( $item['time'] ).'</dc:date>
					<dc:subject>'.htmlspecialchars( $this->make_context( strip_tags( $item['title'] ) ), ENT_QUOTES).'</dc:subject>
				</item>
				';
			}
			$out .='</rdf:RDF>';
			$this->feed_out( $out, $encode );
		}

		// rss 2.0
		function rss_build( $cid, $data, $b_time, $encode, $encoding, $xsl_file='' )
		{
			$link = $this->get_feed_toplink( $cid );
			$feed_logo = $this->get_feed_logo();
			$image_url = $feed_logo['image_url'];
			$width = $feed_logo['width'];
			$height = $feed_logo['height'];

			$out = '<?xml version="1.0" encoding="'.$encoding.'"?>';
			if( ! empty( $xsl_file ) ){
				$out .='<?xml-stylesheet type="text/xsl" media="screen" href="'.$xsl_file.'" ?>';
			}

			$out .='<rss version="2.0" xmlns:content="http://purl.org/rss/1.0/modules/content/">
					<channel>
					<title>'.htmlspecialchars( $this->make_context( strip_tags( $this->get_feed_title( $cid, $data ) ) ), ENT_QUOTES ).'</title>
					<link>'.$link.'</link>
			';

		    if ( $this->get_feed_slogan() !='' ){
				$out .='<description>'.htmlspecialchars( $this->make_context( strip_tags( $this->get_feed_slogan() ) ), ENT_QUOTES ).'</description>';
			}

			$out .='<lastBuildDate>'.date('r', $b_time).'</lastBuildDate>
					<docs>http://backend.userland.com/rss/</docs>
					<image>
						<title>'.htmlspecialchars( $this->make_context( strip_tags( $this->get_feed_title( $cid, $data ) ) ), ENT_QUOTES ).'</title>
						<link>'.$link.'</link>
						<url>'.$image_url.'</url>
						<width>'.$width.'</width>
						<height>'.$height.'</height>
					</image>
			';

			if ( $this->generator !='' ){
				$out .='<generator>'.$this->generator.'</generator>';
 			}
		    if ( $this->get_feed_copyright() !='' ){
				$out .='<copyright>'.htmlspecialchars( $this->make_context( strip_tags( $this->get_feed_copyright() ) ), ENT_QUOTES).'</copyright>';
			}
			foreach( $data as $item ) {
				$out .='  <item>
					<title>'.htmlspecialchars( $this->make_context( strip_tags( $item['title'] ) ), ENT_QUOTES).'</title>
					<link>'.$item['link'].'</link>
					<guid>'.$item['link'].'</guid>
					<description>'.htmlspecialchars( $this->make_context( strip_tags( $item['description'] ) ), ENT_QUOTES ).'</description>
					<pubDate>'.date("r", $item['time']).'</pubDate>
					<category>'.$item['cat_name'].'</category>
					<content:encoded><![CDATA['.$item['description'].']]></content:encoded>
				</item>
				';
			}
			$out .='</channel>
			</rss>';
			$this->feed_out( $out, $encode );
		}

		// Atom 1.0
		function Atom_build( $cid, $data, $b_time, $encode, $encoding, $xsl_file='' )
		{
			$link = $this->get_feed_toplink( $cid );
			$out = '<?xml version="1.0" encoding="'.$encoding.'"?>';
			if( ! empty( $xsl_file ) ){
				$out .='<?xml-stylesheet type="text/xsl" media="screen" href="'.$xsl_file.'" ?>';
			}
			$out .='<feed xmlns="http://www.w3.org/2005/Atom"';
			if ( $this->get_feed_language() !='' ) {
				$out .= ' xml:lang="'.$this->get_feed_language().'"';
			}
			$out .='>';
			$out .='<title>'.htmlspecialchars( $this->make_context( strip_tags( $this->get_feed_title( $cid, $data ) ) ), ENT_QUOTES ).'</title>';
		    if ( $this->get_feed_slogan() !='' ){
				$out .='<subtitle>'.htmlspecialchars( $this->make_context( strip_tags( $this->get_feed_slogan() ) ), ENT_QUOTES ).'</subtitle>';
			}

			$out .='<link rel="alternate" type="text/html" href="'.$link.'"/>';
			$out .='<id>'.$this->get_feed_id( $link, $cid, $data[0]['id'], $data[0]['time'] ).'</id>';
			$out .='<updated>'.$this->iso8601( $b_time ).'</updated>';
			$out .='<author><name>'.$this->get_feed_author().'</name></author>';
			if ( $this->generator !=''){
				$out .='<generator uri="http://www.photositelinks.com/">'.$this->generator.'</generator>';
 			}
			if ( $this->get_feed_copyright() !=''){
				$out .='<rights>'.$this->get_feed_copyright().'</rights>';
 			}
			$out .='<link rel="self" type="application/atom+xml" href="'.$this->get_feed_link_self( $cid ).'" />';

			foreach( $data as $item ) {
				$out .='  <entry>
						<title>'.htmlspecialchars( $this->make_context( strip_tags( $item['title'] ) ), ENT_QUOTES).'</title>
						<link rel="alternate" type="text/html" href="'.$item['link'].'"/>
						<published>'.$this->iso8601( $item['time'] ).'</published>
						<updated>'.$this->iso8601( $item['time'] ).'</updated>
						<id>'.$this->get_feed_id( $item['link'], $item['cid'], $item['id'], $item['time'] ).'</id>
						<category term=">'.$item['cat_name'].'"/>
						<summary type="html">'.htmlspecialchars( $this->make_context( strip_tags( $item['description'] ) ), ENT_QUOTES ).'</summary>
						<content type="html"><![CDATA['.$item['description'].']]></content>
					</entry>
				';
			}
			$out .='</feed>';
			$this->feed_out( $out, $encode );
		}

		function feed_out( $out, $encode )
		{
			if( XOOPS_USE_MULTIBYTES == 1 ) {
				if ( ! extension_loaded( 'mbstring' ) && ! class_exists( 'HypMBString' ) ) {
					require_once dirname( dirname( __FILE__ ) ).'/class/mbemulator/mb-emulator.php' ;
				}
				$out = str_replace("\0", '', mb_convert_encoding( $out, $encode, _CHARSET ) );
			} else {
				$out = str_replace("\0", '', utf8_encode( $out ) );
			}

			header( 'Content-type: application/xml' );
			echo $out;
		}

		function make_context( $text, $words=array(), $l=255 ) 
		{
			if ( ! extension_loaded( 'mbstring' ) && ! class_exists( 'HypMBString' ) ) {
				require_once dirname( dirname( __FILE__ ) ).'/class/mbemulator/mb-emulator.php' ;
			}
			static $strcut = "";
			if ( ! $strcut )
				$strcut = create_function( '$a,$b,$c', ( function_exists('mb_strcut') )?
					'return mb_strcut( $a, $b, $c );':
					'return strcut( $a, $b, $c );');
			$text = str_replace( array('&lt;','&gt;','&amp;','&quot;','&#039;'),array('<','>','&','"',"'"), $text );
			if ( !is_array( $words ) ) $words = array();

			$ret = "";
			$q_word = str_replace( " ","|",preg_quote( join(' ', $words ),"/") );

			$match = array();
			if ( preg_match( "/$q_word/i", $text, $match ) ){
				$ret = ltrim( preg_replace( '/\s+/', ' ', $text ) );
				list( $pre, $aft ) = array_pad( preg_split( "/$q_word/i", $ret, 2 ), 2, "" );
				$m = intval( $l/2 );
				$ret = ( strlen( $pre ) > $m )? "... " : "";
				$ret .= $strcut( $pre, max( strlen( $pre )-$m+1,0), $m ). $match[0];
				$m = $l-strlen( $ret );
				$ret .= $strcut( $aft, 0, min( strlen( $aft ),$m ) );
				if ( strlen( $aft ) > $m ) $ret .= " ...";
			}

			if ( ! $ret ) {
				$ret = $strcut( $text, 0, $l );
				$ret = preg_replace( '/&([^;]+)?$/', '', $ret );
			}

			return htmlspecialchars( $ret, ENT_NOQUOTES );
		}
	}
}

?>