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
    define($constpref . '_DESC', '�ƥ�ץ졼�ȵ�ǽ�򶯲�����NONE�⥸�塼��');

    define($constpref . '_BLOCK', 'block');
    define($constpref . '_BLOCK_DESC', '');
    define($constpref . '_PREF_USER_1', '�桼�������� 1');
    define($constpref . '_PREF_USER_2', '�桼�������� 2');
    define($constpref . '_PREF_USER_3', '�桼�������� 3');
    define($constpref . '_PREF_USER_4', '�桼�������� 4');
    define($constpref . '_PREF_USER_5', '�桼�������� 5');
    define($constpref . '_PREF_USER_6', '�桼�������� 6');
    define($constpref . '_PREF_USER_7', '�桼�������� 7');
    define($constpref . '_PREF_USER_8', '�桼�������� 8');
    define($constpref . '_PREF_USER_9', '�桼�������� 9');
    define($constpref . '_PREF_USER_DESC', '��ͳ�˻Ȥ���������ܤǤ����ƥ�ץ졼�Ȥ���ƤӽФ��ޤ���');
    define($constpref . '_DEBUG', 'debug');
    define($constpref . '_DEBUG_DESC', '');
    define($constpref . '_SEARCH_COMMENT', '�����Ȥ򸡺��оݤˤ���(��侩)');
    define($constpref . '_COM_DIRNAME', '���������礹��d3forum��dirname');
    define($constpref . '_COM_DIRNAME_DESC', '');
    define($constpref . '_COM_FORUM_ID', '���������礹��ե��������ֹ�');
    define($constpref . '_COM_FORUM_ID_DESC', '');
    define($constpref . '_COM_VIEW', '�����������ɽ����ˡ');
    define($constpref . '_COM_VIEW_DESC', '');
}
