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
    define($constpref . '_DESC', 'テンプレート機能を強化したNONEモジュール');

    define($constpref . '_BLOCK', 'block');
    define($constpref . '_BLOCK_DESC', '');
    define($constpref . '_PREF_USER_1', 'ユーザー設定 1');
    define($constpref . '_PREF_USER_2', 'ユーザー設定 2');
    define($constpref . '_PREF_USER_3', 'ユーザー設定 3');
    define($constpref . '_PREF_USER_4', 'ユーザー設定 4');
    define($constpref . '_PREF_USER_5', 'ユーザー設定 5');
    define($constpref . '_PREF_USER_6', 'ユーザー設定 6');
    define($constpref . '_PREF_USER_7', 'ユーザー設定 7');
    define($constpref . '_PREF_USER_8', 'ユーザー設定 8');
    define($constpref . '_PREF_USER_9', 'ユーザー設定 9');
    define($constpref . '_PREF_USER_DESC', '自由に使える設定項目です。テンプレートから呼び出せます。');
    define($constpref . '_DEBUG', 'debug');
    define($constpref . '_DEBUG_DESC', '');
    define($constpref . '_SEARCH_COMMENT', 'コメントを検索対象にする(非推奨)');
    define($constpref . '_COM_DIRNAME', 'コメント統合するd3forumのdirname');
    define($constpref . '_COM_DIRNAME_DESC', '');
    define($constpref . '_COM_FORUM_ID', 'コメント統合するフォーラムの番号');
    define($constpref . '_COM_FORUM_ID_DESC', '');
    define($constpref . '_COM_VIEW', 'コメント統合の表示方法');
    define($constpref . '_COM_VIEW_DESC', '');
}
