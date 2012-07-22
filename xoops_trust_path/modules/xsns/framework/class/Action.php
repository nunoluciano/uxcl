<?php

class XsnsAction
{
	var $db;
	var $context;
	
	function XsnsAction(&$context)
	{
		$this->db =& Database::getInstance();
		$this->context =& $context;
	}
	
	function dispatch()
	{
	}
}

?>
