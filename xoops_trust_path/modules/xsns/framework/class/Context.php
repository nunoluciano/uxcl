<?php

class XsnsContext
{
	var $_hash = array();
	
	function XsnsContext(){
	}
	
	function setAttribute($name, $value){
		$this->_hash[$name] = $value;
	}
	
	function getAttribute($name){
		if(isset($this->_hash[$name])){
			return $this->_hash[$name];
		}
		return NULL;
	}
	
	function assignAttributes(){
		global $xoopsTpl;
		if(is_object($xoopsTpl)){
			$xoopsTpl->assign($this->_hash);
		}
	}
}

?>