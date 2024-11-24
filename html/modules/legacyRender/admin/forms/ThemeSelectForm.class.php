<?php
/**
 * @package legacyRender
 * @version $Id: ThemeSelectForm.class.php,v 1.2 2007/06/07 02:23:37 minahito Exp $
 */

if (!defined('XOOPS_ROOT_PATH')) {
    exit();
}

require_once XOOPS_ROOT_PATH . '/core/XCube_ActionForm.class.php';

/***
 * @internal
 * This class is generated by makeActionForm tool.
 */
class LegacyRender_ThemeSelectForm extends XCube_ActionForm
{
    public function getTokenName()
    {
        return 'module.legacyRender.ThemeSelectForm.TOKEN';
    }

    public function prepare()
    {
        //
        // Set form properties
        //
        $this->mFormProperties['select'] =new XCube_BoolArrayProperty('select');
        $this->mFormProperties['choose'] =new XCube_StringArrayProperty('choose');
    }

    /**
     * @access public
     */
    public function getChooseTheme()
    {
        $ret = [];

        $themes = $this->get('choose');
        foreach ($themes as $theme => $dmy) {
            return $theme;
        }
        
        return null;
    }
    
    public function load(&$objs)
    {
        foreach ($objs as $obj) {
            $this->set('select', $obj->get('id'), $obj->get('enable_select'));
        }
    }

    public function update(&$objs)
    {
        foreach (array_keys($objs) as $key) {
            $objs[$key]->set('enable_select', $this->get('select', $objs[$key]->get('id')));
        }
    }
}