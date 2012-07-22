<?php

class XsnsController
{
	function execute($target_dir="")
	{
		$context = new XsnsContext();
		
		$viewName = XsnsActionManager::dispatch($context, $target_dir);
		
		XsnsViewManager::dispatch($context, $target_dir, $viewName);
	}
}

?>