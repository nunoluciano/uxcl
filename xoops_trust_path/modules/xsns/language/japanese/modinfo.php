<?php

$constpref = '_MI_'.strtoupper($mydirname);

if(!defined($constpref.'_LOADED')){

define($constpref.'_LOADED', 1);

define($constpref.'_MODULE_DESC', 'SNS��XOOPS���Ω���夲�뤳�Ȥ��Ǥ���⥸�塼��Ǥ�');

define($constpref.'_MENU_MYPAGE', '�ޥ��ڡ���');

define($constpref.'_BLOCK_RECENT_TOPIC', '�ǿ��ȥԥå�');
define($constpref.'_BLOCK_INFORMATION', 'INFORMATION');

define($constpref.'_AD_MENU_CATEGORY', '���ߥ�˥ƥ����ƥ�������');
define($constpref.'_AD_MENU_IMAGE', '��������');
define($constpref.'_AD_MENU_FILE', '�ե��������');
define($constpref.'_AD_MENU_ACCESS', '����������');
define($constpref.'_AD_MENU_MYTPLSADMIN', '�ƥ�ץ졼�ȴ���');
define($constpref.'_AD_MENU_MYBLOCKSADMIN', '�֥�å�����/������������');
define($constpref.'_AD_MENU_MYLANGADMIN', '�����������');
define($constpref.'_AD_MENU_MYPREFERENCES', '��������');


define($constpref.'_COMMU_NOTIFY', 'ɽ����Υ��ߥ�˥ƥ�');
define($constpref.'_COMMU_NOTIFY_DSC', 'ɽ����Υ��ߥ�˥ƥ����Ф������Υ��ץ����');

define($constpref.'_TOPIC_CREATE_NOTIFY', '�����ȥԥå�����');
define($constpref.'_TOPIC_CREATE_NOTIFY_CAP', '�����˥ȥԥå����������줿�������Τ���');
define($constpref.'_TOPIC_CREATE_NOTIFY_DSC', '�����˥ȥԥå����������줿�������Τ���');
define($constpref.'_TOPIC_CREATE_NOTIFY_SBJ', '[{X_SITENAME}] {X_MODULE}: �����˥ȥԥå�����������ޤ���');

define($constpref.'_TOPIC_POST_NOTIFY', '�������������');
define($constpref.'_TOPIC_POST_NOTIFY_CAP', '�ȥԥå����Ф��ƥ����Ȥ���Ƥ��줿�������Τ���');
define($constpref.'_TOPIC_POST_NOTIFY_DSC', '�ȥԥå����Ф��ƥ����Ȥ���Ƥ��줿�������Τ���');
define($constpref.'_TOPIC_POST_NOTIFY_SBJ', '[{X_SITENAME}] {X_MODULE}: �����˥����Ȥ���Ƥ���ޤ���');

define($constpref.'_FPATH', '����/�ե�����Υ��åץ�����ǥ��쥯�ȥ�');
define($constpref.'_FPATHDSC', '���åץ��ɤ������/�ե���������Ƥ�������¸����ޤ���<br><span style="color:#ff0000;">�� �������ƥ��Τ��ᡢ�����Фθ����ǥ��쥯�ȥ곰�ξ�����ꤷ�Ƥ���������</span>');

define($constpref.'_FSIZE', '����/�ե�����κ��祵���� [bytes]');
define($constpref.'_FSIZEDSC', '���åץ��ɤ������/�ե�����κ��祵������Х���ñ�̤ǻ��ꤷ�Ƥ���������');

define($constpref.'_FMIME', '���åץ��ɤ���Ĥ���ե������MIME������');
define($constpref.'_FMIMEDSC', '���åץ��ɤ���Ĥ���ե������MIME�����פ�äǶ��ڤä����Ϥ��Ƥ���������');

define($constpref.'_IMGW', '�����κ����� [pixel]');
define($constpref.'_IMGWDSC', '');

define($constpref.'_IMGH', '�����κ���⤵ [pixel]');
define($constpref.'_IMGHDSC', '');

define($constpref.'_ILIMIT', '������Ʊ�����åץ��ɿ�������');
define($constpref.'_ILIMITDSC', '1�Ĥ����ʸ���Ф���ź�ղ����κ��������ꤷ�ޤ��������Υ��åץ��ɤ���Ĥ��ʤ�����0�ˤ��Ƥ���������');

define($constpref.'_FLIMIT', '�ե������Ʊ�����åץ��ɿ�������');
define($constpref.'_FLIMITDSC', '1�Ĥ����ʸ���Ф���ź�եե�����κ��������ꤷ�ޤ����ե�����Υ��åץ��ɤ���Ĥ��ʤ�����0�ˤ��Ƥ���������');

define($constpref.'_BLOG', '�֥��⥸�塼�������');
define($constpref.'_BLOGDSC', '���Ѥ���֥��⥸�塼�������������򤷤Ƥ���������<br>�⥸�塼�뤬���󥹥ȡ��뤵��Ƥ��ʤ��������ѤǤ��ޤ���');
define($constpref.'_BLOG0', '���Ѥ��ʤ�');
define($constpref.'_BLOG1', '�����֥�');
define($constpref.'_BLOG2', '�����֥�D3');
define($constpref.'_BLOG3', 'WordPress ME (for XOOPS2)');
define($constpref.'_BLOG4', 'd3blog');
define($constpref.'_BLOG5', 'minidiary');

define($constpref.'_BLOGDIR', '�֥��⥸�塼��Υǥ��쥯�ȥ�̾');
define($constpref.'_BLOGDIRDSC', '�֥��⥸�塼��Υǥ��쥯�ȥ�̾���ѹ����Ƥ�����ϡ�����̾�Τ����Ϥ��Ƥ���������<br>����ˤ������ϥǥե���ȤΥǥ��쥯�ȥ�̾�ˤʤ�ޤ���');

define($constpref.'_MYPAGE', '��������Ⱦ���ڡ�����ޥ��ڡ������֤�������');
define($constpref.'_MYPAGEDSC', 'XOOPSɸ��Υ�������Ⱦ���ڡ����򡢥��ߥ�˥ƥ��⥸�塼������Ѥ��ò������ޥ��ڡ������֤������뤳�Ȥ��Ǥ��ޤ���<br><br>XOOPS 2.0�Ϥξ�硢[�Ϥ�]�����򤹤�Ȱʲ��Υե���������Ƥ��ѹ�����ޤ��������ᤷ�������Ϻ���[������]�����򤷤Ƥ���������<br>&nbsp;'.XOOPS_ROOT_PATH.'/userinfo.php<br>&nbsp;'.XOOPS_ROOT_PATH.'/edituser.php');

define($constpref.'_MYPAGEG', '�ޥ��ڡ����򥲥��Ȥ˸�������');
define($constpref.'_MYPAGEGDSC', 'xsns�򥲥��Ȥ˸������Ƥ��ʤ����ϡ���������˴ؤ�餺�ޥ��ڡ����ϸ�������ޤ���');

define($constpref.'_POPMAX', '�͵��٤Υ������');
define($constpref.'_POPMAXDSC', '�͵��٤������ͤ�Ķ����ȣ�����(�ǹ���)�ˤʤ�ޤ���<br>�桼�������ε��Ϥ˱������ѹ����Ƥ���������<br><br><span style="color:#0000ff;">���͵��١��оݥ��ߥ�˥ƥ��ؤΥ������������ʿ���͡ʲ��30�������</span>');

define($constpref.'_FREQMAX', '�������٤Υ������');
define($constpref.'_FREQMAXDSC', '�������٤������ͤ�Ķ����ȣ�����(�ǹ���)�ˤʤ�ޤ���<br>�桼�������ε��Ϥ˱������ѹ����Ƥ���������<br><br><span style="color:#0000ff;">���������١��оݥ��ߥ�˥ƥ�����Ƥ��줿�ȥԥå�����ӥ����Ȥο���ʿ���͡ʲ��30�������</span>');

define($constpref.'_FOOT', '�������ȵ�ǽ����Ѥ���');
define($constpref.'_FOOTDSC', '�ޥ��ڡ������Ф��륢����������ǽ����Ѥ��뤫�ɤ�������ꤷ�ޤ���');

define($constpref.'_XBC', '�ѥ󤯤��ꥹ�Ȥ�ɽ������');
define($constpref.'_XBCDSC', '�ơ��ޤǥѥ󤯤��ꥹ�Ȥ�ɽ������褦�ˤ��Ƥ������[������]�����ꤷ�Ƥ���������');

define($constpref.'_INSTERR', '<span style="color:#ff0000;"><b>�⥸�塼��Υǥ��쥯�ȥ�̾��ʸ�����ξ�¤�15ʸ���Ǥ���<br />��ö�⥸�塼��򥢥󥤥󥹥ȡ��뤷��15ʸ������Υǥ��쥯�ȥ�̾���ѹ������塢���٥��󥹥ȡ��뤷�Ƥ���������<br /></b></span>');

define($constpref.'_CATEGORY', '���ƥ���');
define($constpref.'_CATEGORY_1', '��̣');
define($constpref.'_CATEGORY_2', '����');
define($constpref.'_CATEGORY_3', '���٥��');
define($constpref.'_CATEGORY_4', '����¾');

}

?>
