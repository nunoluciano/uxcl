<?php

if (!defined('XOOPS_ROOT_PATH')) {
    exit();
}

class LegacyRenderTplsourceObject extends XoopsSimpleObject
{
    public function __construct()
    {
        static $initVars;
        if (isset($initVars)) {
            $this->mVars = $initVars;
            return;
        }
        $this->initVar('tpl_id', XOBJ_DTYPE_INT, '0', true);
        $this->initVar('tpl_source', XOBJ_DTYPE_TEXT, '', true);
        $initVars=$this->mVars;
    }
}

class LegacyRenderTplsourceHandler extends XoopsObjectGenericHandler
{
    public $mTable = 'tplsource';
    public $mPrimary = 'tpl_id';
    public $mClass = 'LegacyRenderTplsourceObject';
}
