<?php

require_once dirname(dirname(__FILE__)).'/D3pipesBlockAbstract.class.php' ;

class D3pipesBlockXwordslist extends D3pipesBlockAbstract {

	var $target_dirname = '' ;
	var $trustdirname = 'xwords' ;

	function init()
	{
		// parse and check option for this class
		$params = array_map( 'trim' , explode( '|' , $this->option ) ) ;
		if( empty( $params[0] ) ) {
			$this->errors[] = _MD_D3PIPES_ERR_INVALIDDIRNAMEINBLOCK."\n($this->pipe_id)" ;
			return false ;
		}
		$this->target_dirname = preg_replace( '/[^0-9a-zA-Z_-]/' , '' , $params[0] ) ;

		// configurations (file, name, block_options)
		$this->func_file = XOOPS_ROOT_PATH.'/modules/'.$this->target_dirname.'/blocks/entries_new.php' ;
		$this->func_name = 'xwords_b_entries_new_show' ;
		$this->block_options = array(
			0 => 'datesub' , // order by
			1 => empty( $params[1] ) ? 10 : intval( $params[1] ) , // max_entries
		) ;

		return true ;
	}

	function reassign( $data )
	{
		$entries = array() ;
		foreach( $data['newstuff'] as $item ) {
			$entry = array(
				'pubtime'=> $this->refetchPubtime( 'xwords_ent' , 'datesub' , 'entryID' , $item['id'] ) ,
				'link' =>  XOOPS_URL.'/modules/'.$this->target_dirname.'/entry.php?entryID='.$item['id'] ,
				'headline' => $this->unhtmlspecialchars( $item['linktext'] ) ,
				'description' => $item['summary']  ,
				'allow_html' => true ,
			) ;
			$entry['fingerprint'] = $entry['link'] ;
			$entries[] = $entry ;
		}

		return $entries ;
	}

}

?>