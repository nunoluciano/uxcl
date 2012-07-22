<?php
class Xsns_Topic_Action extends XsnsCommonAction
{

function checkParam(&$param, &$errors)
{
	if(isset($param['number']) && $param['number']==0 && empty($param['name'])){
		$errors[] = _MD_XSNS_TOPIC_TITLE_NG;
	}
	if(empty($param['body'])){
		$errors[] = _MD_XSNS_TOPIC_BODY_NG;
	}
}

}
?>
