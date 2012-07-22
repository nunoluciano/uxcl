<?php

eval('function ' . $mydirname . '_comments_update($lid)
{
    return none_comments_update_base("' . $mydirname . '");
}
');

if (!function_exists('none_comments_update_base')) {
    function none_comments_update_base($mydirname) {
    }
}


eval('function ' . $mydirname . '_comments_approve(&$comment)
{
    return none_comments_approve_base("' . $mydirname . '", $comment);
}
');


if (!function_exists('none_comments_approve_base')) {
    function none_comments_approve_base($mydirname, &$comment) {
    }
}
