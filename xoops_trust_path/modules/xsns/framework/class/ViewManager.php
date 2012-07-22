<?php

/**
 * View 管理用クラス
 *
 * @package ViewManager
 */
class XsnsViewManager
{
	/**
	 * 適切なViewを実行する
	 * 
	 * @param &$context
	 * @param $target_dir	Viewファイルのディレクトリ名
	 * @param $target		対象のView名
	 * @return void
	 */
	function dispatch(&$context, $target_dir="", $target="")
	{
		$args = array();
		if(!empty($target_dir)){
			$args[] = $target_dir;
			$target_dir = $target_dir.'/';
		}
		
		// 対象Viewの決定
		if(empty($target)){
			if(isset($_REQUEST[XSNS_ACTION_ARG])){
				$target = preg_replace("/[^0-9a-zA-Z_]/", "", $_REQUEST[XSNS_ACTION_ARG]);
				$args[] = $target;
			}
			else{
				$target = XSNS_DEFAULT_VIEW;
			}
		}
		else{
			$args[] = $target;
		}
		
		// 対象Viewクラス名、ファイル名を決定
		$viewFile  = XSNS_VIEW_DIR. $target_dir. $target. "View.php";
		
		// 対象ファイル読み込み
		if (is_readable($viewFile) && is_file($viewFile)) {
			require_once($viewFile);
			$viewClass = "Xsns_".ucfirst($target)."_View";
			// 対象クラスインスタンス作成
			if (class_exists($viewClass)) {
				$o = new $viewClass($context, $args);
				// 対象クラスのdispatchメソッド実行
				if (method_exists($o, "dispatch")) {
					$o->dispatch();
					return;
				}
			}
		}
		header('Location: '. XSNS_BASE_URL.'/index.php');
		exit();
	}
}

?>