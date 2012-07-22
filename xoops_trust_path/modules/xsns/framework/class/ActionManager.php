<?php

/**
 * Action �Ǘ��p�N���X
 *
 * @package ActionManager
 */
class XsnsActionManager
{
	/**
	 * �K�؂�Action�����s����
	 * 
	 * @param &$context
	 * @param $target_dir	Action�t�@�C���̃f�B���N�g����
	 * @return string		View�̖��O
	 */
	function dispatch(&$context, $target_dir="")
	{
		// �Ώ�Action�̌���
		if(isset($_REQUEST[XSNS_ACTION_ARG])){
			$target = preg_replace("/[^0-9a-zA-Z_]/", "", $_REQUEST[XSNS_ACTION_ARG]);
		}
		else{
			$target = XSNS_DEFAULT_ACTION;
		}
		
		if(!empty($target_dir)){
			$target_dir = $target_dir.'/';
		}
		
		// �Ώ�Action�N���X���A�t�@�C����������
		$actionFile  = XSNS_ACTION_DIR. $target_dir. $target. "Action.php";
		
		// �Ώۃt�@�C���ǂݍ���
		if (is_readable($actionFile) && is_file($actionFile)) {
			require_once($actionFile);
			$actionClass = "Xsns_".ucfirst($target)."_Action";
			// �ΏۃN���X�C���X�^���X�쐬
			if (class_exists($actionClass)) {
				$o = new $actionClass($context);
				// �ΏۃN���X��dispatch���\�b�h���s
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