<?php

if( ! defined( 'XOOPS_TRUST_PATH' ) ) die( 'set XOOPS_TRUST_PATH into mainfile.php' );

require_once dirname(dirname(__FILE__)).'/D3pipesBlockAbstract.class.php' ;

class D3pipesBlockXsnstopiclist extends D3pipesBlockAbstract {

    var $target_dirname;
    var $trustdirname = 'xsns';

    function init()
    {
        // parse and check option for this class
        $params = array_map( 'trim' , explode( '|' , $this->option ));
        if( empty( $params[0] ) ) {
            $this->errors[] = _MD_D3PIPES_ERR_INVALIDDIRNAMEINBLOCK."\n($this->pipe_id)" ;
            return false ;
        }
        $this->target_dirname = preg_replace( '/[^0-9a-zA-Z_-]/' , '' , $params[0] );

        // configurations (file, name, block_options)
        $this->func_file = XOOPS_ROOT_PATH.'/modules/'.$this->target_dirname.'/blocks/blocks.php' ;
        $this->func_name = 'b_xsns_recent_topic_show';
        $this->block_options = array(
            'disable_renderer' => true,
            0 => $this->target_dirname, // mydirname of xsns
            1 => empty( $params[1] ) ? 5 : intval( $params[1] ), // number of item to show
        );
        return true;
    }

    function reassign( $data )
    {
        $ret = array();
        if(is_array($data)) {
        	foreach( $data['topic_list'] as $item ) {
            	$ret[] = array(
                	'pubtime' => $item['time'], // unix timestamp
                	'link' => $item['link'],
            		'fingerprint' => $item['link'],
                	'headline' => $this->unhtmlspecialchars( $item['title'] ),
                	'description' => $this->unhtmlspecialchars( $item['body'] ),
                	'allow_html' => false,
            	);
        	}
        }
        return $ret;
    }

}

?>