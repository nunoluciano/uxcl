<?php

class XsnsView
{
	var $tpl;
	var $context;
	var $args;
	
	function XsnsView(&$context, $args)
	{
		global $xoopsTpl;
		$this->tpl =& $xoopsTpl;
		$this->context =& $context;
		$this->args = $args;
	}
	
	function dispatch()
	{
	}

}

?>