<?php

// for ratefile

if( ! class_exists( 'rate_download' ) )
{
	include_once dirname( dirname(__FILE__) ).'/class/mydownload.php' ;
	require_once dirname( dirname(__FILE__) ).'/class/d3downloads.textsanitizer.php' ;

	class rate_download extends MyDownload
	{
		var $db;
		var $table;
		var $ratingid;
		var $lid;
		var $ratinguser;
		var $rating;
		var $ratinghostname;
		var $ratingtimestamp;
		var $anonwaitdays = 1 ;//Make sure only 1 anonymous from an IP in a single day.
		var $Insertdata = array( 'lid' ,'ratinguser' , 'rating', 'ratinghostname', 'ratingtimestamp' ) ;

		function rate_download( $mydirname, $mode='' )
		{
			include_once dirname( dirname(__FILE__) ).'/include/mytable.php' ;

			$this->db =& Database::getInstance();
			$this->myts =& d3downloadsTextSanitizer::getInstance() ;
			$this->mod_url = XOOPS_URL.'/modules/'.$mydirname ;
			$this->table = $this->db->prefix( "{$mydirname}_votedata" ) ;
			$this->downloads_table = $this->db->prefix( "{$mydirname}_downloads" ) ;
			$this->mydirname = $mydirname ;
			$this->mod_url = XOOPS_URL.'/modules/'.$mydirname ;
			$columns = implode( ',' , $GLOBALS['d3download_tables']['votedata'] ) ;
			$this->columns = $columns ;
			if( $mode == 'Rate' ) {
				global $xoopsUser ;
				$this->newid = $this->db->genId( $this->table."_reportid_seq" );
				if( is_object( $xoopsUser ) ) {
					$this->ratinguser = $xoopsUser->getVar('uid') ;
				} else {
					$this->ratinguser = 0 ;
				}
				$this->rating = intval( $_POST['rating'] );
				$this->ratinghostname = getenv( "REMOTE_ADDR" );
				$this->ratingtimestamp = time();
				$this->yesterday = ( time() - ( 86400 * $this->anonwaitdays ) ) ;
			}
		}

		function Get_User_vote( $lid )
		{
			global $xoopsConfig ;

			$sql = "SELECT $this->columns FROM ".$this->table." WHERE lid = '".$lid."' AND ratinguser != 0 ORDER BY ratingtimestamp DESC" ;
			$result = $this->db->query( $sql );
			$count = $this->db->getRowsNum( $result ) ;
			if ( $count == 0 ) return array(
				'user_totalvote' => '' ,
				'user_vote'      => '' ,
			) ;
			$user_votes = intval( $count ) ;
			$user_totalvote = sprintf( _MD_D3DOWNLOADS_USER_TOTAL_VOTE , $user_votes );
			while( $array = $this->db->fetchArray( $result ) ) {
				foreach ( $array as $key=>$value ){
					$this->$key = $value;
				}
				$ratinguser = intval( $this->ratinguser );
				$usr = $this->db->query("SELECT rating FROM ".$this->table." WHERE ratinguser = '".$ratinguser."'" );
				$uservotes = $this->db->getRowsNum( $usr );
				$useravgrating = 0;
				while( list( $user_rating ) = $this->db->fetchRow( $usr ) ){
					$useravgrating = $useravgrating + $user_rating;
				}
				$useravgrating = $useravgrating / $uservotes;
				$useravgrating = number_format( $useravgrating, 1 );
				$user_vote[] = array(
					'id'              => intval( $this->ratingid ) ,
					'ratingusername'  => $this->getlink_for_postname( $ratinguser ) ,
					'ratinghostname'  => htmlspecialchars($this->ratinghostname , ENT_QUOTES ) ,
					'rating'          => intval( $this->rating ) ,
					'useravgrating'   => intval( $useravgrating ) ,
					'uservotes'       => intval( $uservotes ) ,
					'ratingtimestamp' => formatTimestamp( intval( $this->ratingtimestamp ), 'l', $xoopsConfig['default_TZ'] ) ,
				) ;
			}
			return array(
				'user_totalvote' => $user_totalvote ,
				'user_vote'      => $user_vote ,
			) ;
		}

		function Get_Guest_vote( $lid )
		{
			global $xoopsConfig ;

			$sql = "SELECT $this->columns FROM ".$this->table." WHERE lid = '".$lid."' AND ratinguser = '0' ORDER BY ratingtimestamp DESC" ;
			$result = $this->db->query( $sql );
			$count = $this->db->getRowsNum( $result ) ;
			if ( $count == 0 ) return array(
				'guest_totalvote' => '' ,
				'guest_vote'      => '' ,
			) ;
			$guest_votes = intval( $count ) ;
			$guest_totalvote = sprintf( _MD_D3DOWNLOADS_GUEST_TOTAL_VOTE , $guest_votes );
			while( $array = $this->db->fetchArray( $result ) ) {
				foreach ( $array as $key=>$value ){
					$this->$key = $value;
				}
				$guest_vote[] = array(
					'id'              => intval( $this->ratingid ) ,
					'ratinghostname'  => htmlspecialchars($this->ratinghostname , ENT_QUOTES ) ,
					'rating'          => intval( $this->rating ) ,
					'guestvote'       => $guest_votes ,
					'ratingtimestamp' => formatTimestamp( intval( $this->ratingtimestamp ), 'l', $xoopsConfig['default_TZ'] ) ,
				) ;
			}
			return array(
				'guest_totalvote' => $guest_totalvote ,
				'guest_vote'      => $guest_vote ,
			) ;
		}

		function Ratefile_Execution( $cid, $lid )
		{
			global $xoopsConfig ;

			// Check if rating is valid
			if( $this->rating <= 0 || $this->rating > 10 ) {
				redirect_header( XOOPS_URL."/modules/$this->mydirname/index.php?page=ratefile&amp;cid=$cid&amp;lid=$lid" , 4 , _MD_D3DOWNLOADS_NORATING ) ;
				exit ;
			}

			$check_result = $this->Ratefile_check( $lid ) ;
			if( ! empty( $check_result ) ) {
				$this->redirect_message( $check_result ) ;
				exit ;
			}

			// All is well.  Add to Line Item Rate to DB.
			$this->Insert_DB( $lid ) ;
			//All is well.  Calculate Score & Add to Summary (for quick retrieval & sorting) to DB.
			$this->UpdateRating( $lid );

			include_once dirname( dirname(__FILE__) ).'/class/mycategory.php' ;
			$mycategory = new MyCategory( $this->mydirname, 'Show' ) ;
			$mycategory->delete_cache_of_categories() ;
			$message = _MD_D3DOWNLOADS_VOTEAPPRE."<br />".sprintf( _MD_D3DOWNLOADS_THANKURATE , $xoopsConfig['sitename'] ) ;
			$this->redirect_message( $message ) ;
			exit ;
		}

		function Ratefile_check( $lid )
		{
			$message = '' ;
			if( $this->ratinguser != 0 ) {
				// Check if Download POSTER is voting
				$rs = $this->db->query( "SELECT COUNT(*) FROM ".$this->downloads_table." WHERE lid='".$lid."' AND submitter='".$this->ratinguser."'" ) ;
				list( $is_my_deta ) = $this->db->fetchRow( $rs ) ;
				if( $is_my_deta ) $message = _MD_D3DOWNLOADS_CANTVOTEOWN ;
	
				// Check if REG user is trying to vote twice.
				$rs = $this->db->query( "SELECT COUNT(*) FROM ".$this->table." WHERE lid='".$lid."' AND ratinguser='".$this->ratinguser."'" ) ;
				list( $has_already_rated ) = $this->db->fetchRow( $rs ) ;
				if( $has_already_rated ) $message = _MD_D3DOWNLOADS_VOTEONCE2 ;
			} else {
				// Check if ANONYMOUS user is trying to vote more than once per day.
				$rs = $this->db->query( "SELECT COUNT(*) FROM ".$this->table." WHERE lid='".$lid."' AND ratinguser=0 AND ratinghostname='".$this->ratinghostname."' AND ratingtimestamp > '".$this->yesterday."'");
				list( $anonvotecount ) = $this->db->fetchRow( $rs ) ;
				if( $anonvotecount ) $message = _MD_D3DOWNLOADS_VOTEONCE2 ;
			}

			return $message ;
		}

		function Insert_DB( $lid )
		{
			$this->lid = $lid;
			$set4sql = "ratingid='".$this->newid."'" ;
			foreach( $this->Insertdata as $key ) {
				$set4sql .= ",$key='".$this->$key."'" ;
			}
			$this->db->query( "INSERT INTO ".$this->table." SET $set4sql" ) or exit() ;
			$new_id = $this->db->getInsertId();
			return $new_id;
		}

		function UpdateRating( $lid )
		{
			$sql = "SELECT rating FROM ".$this->table." WHERE lid = '".$lid."'";
			$result = $this->db->query( $sql );
			$votesDB = $this->db->getRowsNum( $result );
			$totalrating = 0;
			while( list( $rating ) = $this->db->fetchRow( $result ) ){
				$totalrating += $rating;
			}
			if( ! empty( $votesDB ) ){
				$finalrating = $totalrating / $votesDB;
			} else {
				$finalrating = 0 ;
			}
			$finalrating = number_format( $finalrating, 4 );
			$set4sql = "rating='".$finalrating."'" ;
			$set4sql .= ",votes='".$votesDB."'" ;
			$sql = "UPDATE ".$this->downloads_table." SET $set4sql WHERE lid = '".$lid."'" ;
			$this->db->query( $sql );
		}
	}
}

?>