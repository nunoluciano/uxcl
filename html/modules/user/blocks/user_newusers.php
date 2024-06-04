<?php
function b_user_newusers_show($options)
{
    $block = [];
    $criteria = new CriteriaCompo(new Criteria('level', 0, '>'));
    $limit = (!empty($options[0])) ? $options[0] : 10;
    $criteria->setOrder('DESC');
    $criteria->setSort('user_regdate');
    $criteria->setLimit($limit);
    $member_handler =& xoops_gethandler('member');
    $newmembers =& $member_handler->getUsers($criteria);
    $count = is_countable($newmembers) ? count($newmembers) : 0;
    for ($i = 0; $i < $count; $i++) {
        if (1 == $options[1]) {
            $block['users'][$i]['avatar'] = 'blank.gif' != $newmembers[$i]->getVar('user_avatar') ? XOOPS_UPLOAD_URL . '/' . $newmembers[$i]->getVar('user_avatar') : '';
        } else {
            $block['users'][$i]['avatar'] = '';
        }
        $block['users'][$i]['id'] = $newmembers[$i]->getVar('uid');
        $block['users'][$i]['name'] = $newmembers[$i]->getVar('uname');
        $block['users'][$i]['joindate'] = $newmembers[$i]->getVar('user_regdate');
    }
    return $block;
}

function b_user_newusers_edit($options)
{
    $inputtag = '<input type="text" name="options[]" value="'.$options[0].'" />';
    $form = sprintf(_MB_USER_DISPLAY, $inputtag);
    $form .= '<br>'._MB_USER_DISPLAYA.'&nbsp;<input type="radio" id="options[]" name="options[]" value="1"';
    if (1 == $options[1]) {
        $form .= ' checked="checked"';
    }
    $form .= ' />&nbsp;'._YES.'<input type="radio" id="options[]" name="options[]" value="0"';
    if (0 == $options[1]) {
        $form .= ' checked="checked"';
    }
    $form .= ' />&nbsp;'._NO;
    return $form;
}
