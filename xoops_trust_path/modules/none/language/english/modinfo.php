<?php
// Module Info
if (defined('FOR_XOOPS_LANG_CHECKER')) $mydirname = basename(dirname(dirname(dirname(__FILE__))));
$constpref = '_MI_' . strtoupper($mydirname);

// NONE; Nothing but templates.
if (defined('FOR_XOOPS_LANG_CHECKER') || !defined($constpref . '_LOADED')) {
    define($constpref . '_LOADED', 1);

    // The name of this module
    define($constpref . '_NAME', '');
    // A brief description of this module
    define($constpref . '_DESC', 'none module w/ template');

    define($constpref . '_BLOCK', 'block');
    define($constpref . '_BLOCK_DESC', '');
    define($constpref . '_DEBUG', 'debug');
    define($constpref . '_DEBUG_DESC', '');
    define($constpref . '_SEARCH_COMMENT', 'search within comments.');
    define($constpref . '_COM_DIRNAME', 'comment dirname');
    define($constpref . '_COM_DIRNAME_DESC', '');
    define($constpref . '_COM_FORUM_ID', 'comment forumid');
    define($constpref . '_COM_FORUM_ID_DESC', '');
    define($constpref . '_COM_VIEW', 'comment view');
    define($constpref . '_COM_VIEW_DESC', '');

    define($constpref . '_PREF_USER_1', 'user 1');
    define($constpref . '_PREF_USER_2', 'user 2');
    define($constpref . '_PREF_USER_3', 'user 3');
    define($constpref . '_PREF_USER_4', 'user 4');
    define($constpref . '_PREF_USER_5', 'user 5');
    define($constpref . '_PREF_USER_6', 'user 6');
    define($constpref . '_PREF_USER_7', 'user 7');
    define($constpref . '_PREF_USER_8', 'user 8');
    define($constpref . '_PREF_USER_9', 'user 9');
    define($constpref . '_PREF_USER_DESC', 'user custom setting values.');
}
