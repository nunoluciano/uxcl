<?php

/**
 * View �Ǘ��p�N���X
 *
 * @package ViewManager
 */
class XsnsViewManager
{
	/**
	 * �K�؂�View�����s����
	 * 
	 * @param &$context
	 * @param $target_dir	View�t�@�C���̃f�B���N�g����
	 * @param $target		�Ώۂ�View��
	 * @return void
	 */
	function dispatch(&$context, $target_dir="", $target="")
	{
		$args = array();
		if(!empty($target_dir)){
			$args[] = $target_dir;
			$target_dir = $target_dir.'/';
		}
		
		// �Ώ�View�̌���
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
		
		// �Ώ�View�N���X���A�t�@�C����������
		$viewFile  = XSNS_VIEW_DIR. $target_dir. $target. "View.php";
		
		// �Ώۃt�@�C���ǂݍ���
		if (is_readable($viewFile) && is_file($viewFile)) {
			require_once($viewFile);
			$viewClass = "Xsns_".ucfirst($target)."_View";
			// �ΏۃN���X�C���X�^���X�쐬
			if (class_exists($viewClass)) {
				$o = new $viewClass($context, $args);
				// �ΏۃN���X��dispatch���\�b�h���s
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