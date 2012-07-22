<?php

/**
 * Action 管理用クラス
 *
 * @package ActionManager
 */
class XsnsActionManager
{
	/**
	 * 適切なActionを実行する
	 * 
	 * @param &$context
	 * @param $target_dir	Actionファイルのディレクトリ名
	 * @return string		Viewの名前
	 */
	function dispatch(&$context, $target_dir="")
	{
		// 対象Actionの決定
		if(isset($_REQUEST[XSNS_ACTION_ARG])){
			$target = preg_replace("/[^0-9a-zA-Z_]/", "", $_REQUEST[XSNS_ACTION_ARG]);
		}
		else{
			$target = XSNS_DEFAULT_ACTION;
		}
		
		if(!empty($target_dir)){
			$target_dir = $target_dir.'/';
		}
		
		// 対象Actionクラス名、ファイル名を決定
		$actionFile  = XSNS_ACTION_DIR. $target_dir. $target. "Action.php";
		
		// 対象ファイル読み込み
		if (is_readable($actionFile) && is_file($actionFile)) {
			require_once($actionFile);
			$actionClass = "Xsns_".ucfirst($target)."_Action";
			// 対象クラスインスタンス作成
			if (class_exists($actionClass)) {
				$o = new $actionClass($context);
				// 対象クラスのdispatchメソッド実行
				if (method_exists($o, "dispatch")) {
					return $o->dispatch();
				}
			}
		}
		header('Location: '. XSNS_BASE_URL.'/index.php');
		exit();
	}
}

?>