<?php

// for spam_check

if( ! class_exists( 'spam_check' ) )
{
	require_once dirname( dirname(__FILE__) ).'/class/d3downloads.textsanitizer.php' ;

	class spam_check
	{
		var $str_length    =  10 ;
		var $add_method    =  array( 'count_url' , 'rbl' ) ;
		var $hidden_name   = 'auth' ;
		var $post_name     =  array() ;
		var $max_url       =   0 ;
		var $rbls          =  array( 'dnsbl.spam-champuru.livedoor.com' , 'zen.spamhaus.org' ) ;
		var $result        =  false ;
		var $error_message =  _MD_D3DOWNLOADS_CHECK_SPAM ;

		function spam_check( $mydirname )
		{
			global $xoopsUser ;

			$this->myts =& d3downloadsTextSanitizer::getInstance() ;
			$this->xoops_isuser = ( is_object( $xoopsUser ) ) ? true : false ;
			$this->my_session   = $mydirname.'_spam_check' ;
			$this->str_list     = array_merge( range( 'a', 'z' ), range( 'A', 'Z' ), range( 0, 9 ) ) ;
			$url_info           = parse_url( XOOPS_URL ) ;
			$this->my_host      = ( ! empty( $url_info['host'] ) ) ? $url_info['host'] : '' ;
		}

		function check()
		{
			$this->result = ( ! $this->xoops_isuser ) ? $this->check_execute() : true ;

			unset( $_SESSION[ $this->my_session ] ) ;

			return $this->result ;
		}

		function check_execute()
		{
			return ( $this->check_by_javascript() ) ? true : $this->check_by_add_method() ;
		}

		function check_by_javascript()
		{
			$request = $this->myts->MystripSlashesGPC( @$_POST[ $this->hidden_name ] ) ;
			return ( strcmp( $request, $this->select_value() ) == 0 ) ? true : false ;
		}

		function select_value()
		{
			return ( ! empty( $_SESSION[ $this->my_session ] ) ) ? md5( $_SESSION[ $this->my_session ] ) : '' ;
		}

		function check_by_add_method()
		{
			$count = 0 ;

			if( ! is_array( $this->add_method ) || empty( $this->add_method ) ) return 0 ;

			foreach ( $this->add_method as $key ) {
				$method = 'check_by_'. strtolower( $key ) ;
				if ( method_exists( $this, $method ) ) {
					$count += $this->$method() ;
				}
			}

			return ( $count == 0 ) ? true : false ;
		}

		function check_by_count_url()
		{
			$count = 0 ;

			if( ! is_array( $this->post_name ) || empty( $this->post_name ) ) return 0 ;

			$_POST = $this->myts->Delete_Nullbyte( $_POST ) ;

			foreach( $this->post_name as $key ) {
				$count += $this->count_url( $this->myts->MystripSlashesGPC( @$_POST[ $key ] ) ) ;
			}

			return ( $count > intval( $this->max_url ) ) ? 1 : 0 ;
		}

		function count_url( $text )
		{
			if ( empty( $text ) ) return 0 ;

			$array = preg_split( '`(https?|ftp)://`i' , trim( $text ) , -1 , PREG_SPLIT_NO_EMPTY ) ;
			$count = ( preg_match( '`^(https?|ftp)://`i' , $text ) ) ? count( $array ) : count( $array ) -1 ;

			if ( $count > 0 && ! empty( $this->my_host ) ) foreach( $array as $value ) {
				if ( strncmp( $value , $this->my_host , strlen( $this->my_host ) ) == 0 ) $count-- ;
			}

			return $count ;
		}

		function check_by_rbl( $ip='' )
		{
			$count = 0 ;

			if( ! is_array( $this->rbls ) || empty( $this->rbls ) ) return 0 ;

			$target_ip = ( empty( $ip ) ) ? $_SERVER['REMOTE_ADDR'] : $ip ;
			$rev_ip    = implode( '.', array_reverse( explode( '.', $target_ip ) ) ) ;

			foreach( $this->rbls as $rbl ) {
				$host = $rev_ip . '.' . $rbl ;
				if ( strcmp( gethostbyname( $host ), $host ) != 0 ) $count++ ;
			}

			return $count ;
		}

		function random_str()
		{
			$str = '' ;

			$length = intval( $this->str_length ) ;

			if ( ! empty( $length ) ) {
				for ( $i = 0 ; $i < $length ; $i++ ) {
					$str .= $this->str_list[ mt_rand( 0, count( $this->str_list ) - 1 ) ] ;
				}

				$_SESSION[ $this->my_session ] = $str ;
			}
		}
	}
}

?>