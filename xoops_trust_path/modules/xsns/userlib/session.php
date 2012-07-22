<?php

class XsnsSessionHandler
{
	
	var $_mydirname;
	
	//--------------------------------------------------------------------------
	
	function XsnsSessionHandler($mydirname)
	{
		$this->_mydirname = $mydirname;
	}
	
	//--------------------------------------------------------------------------
	
	function &getInstance()
	{
		global $mydirname;
		static $instance = NULL;
		if(is_null($instance) && !empty($mydirname)){
			$instance = new XsnsSessionHandler($mydirname);
		}
		return $instance;
	}
	
	//--------------------------------------------------------------------------
	
	function setVar($key, $value)
	{
		$_SESSION[$this->_mydirname][$key] = $value;
	}
	
	//--------------------------------------------------------------------------
	
	function setVars($vars)
	{
		if(is_array($vars)){
			foreach($vars as $key => $value){
				$_SESSION[$this->_mydirname][$key] = $value;
			}
		}
	}
	
	//--------------------------------------------------------------------------
	
	function getVar($key, $clear=false)
	{
		$ret = isset($_SESSION[$this->_mydirname][$key]) ? $_SESSION[$this->_mydirname][$key] : NULL;
		if($clear){
			$this->clearVar($key);
		}
		return $ret;
	}
	
	//--------------------------------------------------------------------------
	
	function clearVar($key)
	{
		unset($_SESSION[$this->_mydirname][$key]);
	}
	
	//--------------------------------------------------------------------------
	
	function clearVars()
	{
		unset($_SESSION[$this->_mydirname]);
	}
	
	//--------------------------------------------------------------------------
	
}

?>
