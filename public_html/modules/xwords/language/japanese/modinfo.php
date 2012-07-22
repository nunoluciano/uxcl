<?php
/**
 * $Id: modinfo.php v 1.0 8 May 2004 hsalazar Exp $
 * Module: Wordbook - a multicategory glossary
 * Version: v 1.00
 * Release Date: 8 May 2004
 * Author: hsalazar
 * Licence: GNU
 */

// XOOPS2 - Xwords 0.46
// WEBMASTER @ KANPYO.NET, 2006.
$mydirname = basename(dirname(dirname(dirname(__FILE__))));
$MYDIRNAME = strtoupper($mydirname);

// Module Info
define("_MI_{$MYDIRNAME}_MD_NAME", "Xwords");

// A brief description of this module
define("_MI_{$MYDIRNAME}_MD_DESC", "�ޥ�����ƥ��꡼��ŵ");

// Sub menus in main menu block
define("_MI_{$MYDIRNAME}_SUB_SMNAME0", "������˥塼");
define("_MI_{$MYDIRNAME}_SUB_SMNAME1", "�ǡ����ɲ�");
define("_MI_{$MYDIRNAME}_SUB_SMNAME2", "�ꥯ������");
define("_MI_{$MYDIRNAME}_SUB_SMNAME3", "�ǡ�������");

// A brief description of this module
define("_MI_{$MYDIRNAME}_PERPAGE", "01.�������̣��ڡ���������θ��");
define("_MI_{$MYDIRNAME}_PERPAGEDSC", "���ꤷ��������Ȥ˲��ڡ������ޤ���");

define("_MI_{$MYDIRNAME}_PERPAGEINDEX", "02.�������̣��ڡ���������θ��");
define("_MI_{$MYDIRNAME}_PERPAGEINDEXDSC", "���ꤷ��������Ȥ˲��ڡ������ޤ���");

define("_MI_{$MYDIRNAME}_ALLOWREQ", "03.�����Ȥ���Υꥯ�����Ȥ�����ޤ�����");
define("_MI_{$MYDIRNAME}_ALLOWREQDSC", "����������θ���Ƥ���������");

define("_MI_{$MYDIRNAME}_REQREPLY", "04.�ꥯ�����Ȥ��Ф��Ƽ�ư�ֿ����ޤ�����");
define("_MI_{$MYDIRNAME}_REQREPLYDSC", "�֥ꥯ�����Ȥ��꤬�Ȥ��פȤ������ƤǤ������Ͷ��Υ᡼�륢�ɥ쥹�����Ϥ����ʤɤΤ���������θ���Ƥ���������");

define("_MI_{$MYDIRNAME}_ALLOWSUBMIT", "05.�桼�������ǡ������ɲäǤ���褦�ˤ��ޤ�����");
define("_MI_{$MYDIRNAME}_ALLOWSUBMITDSC", "�ɤ��������Ǥ⥲���Ȥϥꥯ�����Ȥ����Ǥ��ޤ���");

define("_MI_{$MYDIRNAME}_AUTOAPPROVE", "06.�桼��������Υǡ����ɲä�ư��ǧ���ޤ�����");
define("_MI_{$MYDIRNAME}_AUTOAPPROVEDSC", "�֤������פ����֤ȡ����ʤ�����ǧ���ʤ���и�������ޤ���");

define("_MI_{$MYDIRNAME}_DHTMLUSE", "07.�桼�����Υǡ����ɲû��˴����Ԥ�Ʊ���ե��������Ѥ����ޤ�����");
define("_MI_{$MYDIRNAME}_DHTMLUSEDSC", "�֤Ϥ��פ����ӡ����᡼���ޥ͡��������Ͽ�桼�����˳����������Ͽ�桼����������򥢥åפ��뤳�Ȥ���ǽ�Ȥʤ�ޤ���");

define("_MI_{$MYDIRNAME}_MULTICATS", "08.���Ӥ��Ȥ�ʬ��ʥ��ƥ��꡼�ˤ���Ѥ��ޤ�����");
define("_MI_{$MYDIRNAME}_MULTICATSDSC", "�֤������פ����֤�ʬ��Ǥ��ޤ���");

define("_MI_{$MYDIRNAME}_CATSINMENU","09.��˥塼��ʬ��ʥ��ƥ��꡼�ˤ�ɽ�����ޤ�����");
define("_MI_{$MYDIRNAME}_CATSINMENUDSC","�֤Ϥ��פ����֤ȥᥤ���˥塼�����ɽ�����ޤ���");

define("_MI_{$MYDIRNAME}_ALLOWADMINHITS", "10.�����Ԥ����Ƥ���������夲�ޤ�����");
define("_MI_{$MYDIRNAME}_ALLOWADMINHITSDSC", "�֤Ϥ��פ����֤ȡ������Ԥ����Ƥ⥫���󥿡��ͤ������ޤ���");

define("_MI_{$MYDIRNAME}_MAILTOADMIN", "11.��Ƥ����ä����Ȥ�᡼����Τ餻�ޤ�����");
define("_MI_{$MYDIRNAME}_MAILTOADMINDSC", "�����ȤΥꥯ�����ȡ��桼�����Υǡ����ɲä��������ٴ����Ԥ˥᡼��򤷤ޤ���");

define("_MI_{$MYDIRNAME}_RANDOMLENGTH", "12.����ʸ�ΰ�����ɽ������Ȥ���Ĺ��");
define("_MI_{$MYDIRNAME}_RANDOMLENGTHDSC", "���Ф���ξܺ٤�ɽ������ڡ����ʳ��Ǥ�����ʸ����ά����ޤ������ΤȤ���ʸ���ʥХ��ȡ˿�����ꤷ�Ƥ����������ʽ���͡�100��");

define("_MI_{$MYDIRNAME}_LINKTERMS", "13.��ư���ȥ�󥯡ʲ��˵�ǽ��Ȥ��ޤ�����");
define("_MI_{$MYDIRNAME}_LINKTERMSDSC", "����ʸ����ˡ�¾�θ��Ф���פ����ä��Ȥ������θ��Ф���Υڡ����ؼ�ưŪ�˥�󥯤�ĥ��ޤ����ѿ��ϥ��󥰥륯�����ȡ����֥륯�����ȤǤ����äƤ������������ܸ�� 14. ������Ǥ��ޤ���<a href='".XOOPS_URL."/modules/$mydirname/admin/pluginlist.php' target='_blank'>�ץ饰�����б�����</a>");
define("_MI_{$MYDIRNAME}_LINKTERMSOP0DSC", "���Ѥ��ʤ�");
define("_MI_{$MYDIRNAME}_LINKTERMSOP1DSC", "Xwords �������оݤ˻��Ѥ����ʣ����ޤ��");
define("_MI_{$MYDIRNAME}_LINKTERMSOP2DSC", "Xwords �ȥץ饰����Τ���⥸�塼����оݤ˻��Ѥ���");
define("_MI_{$MYDIRNAME}_LINKTERMSOP3DSC", "�����Ǥ���⥸�塼�뤹�٤Ƥ��оݤ˻��Ѥ���");

define("_MI_{$MYDIRNAME}_SPATTERN", "14.��ư���ȥ�󥯡ʲ��˵�ǽ��ʸ����");
define("_MI_{$MYDIRNAME}_SPATTERNDSC", "13.�ǻ��Ѥ��뼫ưŪ�˸�����������ꤹ�뤿���ʸ���򥳡��ɤǵ������Ƥ��������������Ƭ����ꤹ��ʸ�����ȸ�������ꤹ��ʸ�����򥫥�ޡ� , �ˤ�ʬ����ɬ�פ�����ޤ������ƥ�����Ǥ������Τޤ��ѹ����ʤ����Ȥ򤪤����ᤷ�ޤ�������͡�\\xA1[\\xAE\\xC6\\xC8\\xCC\\xCE\\xD0\\xD2\\xD4\\xD6\\xD8\\xDA] , \\xA1[\\xAD\\xC7\\xC9\\xCD\\xCF\\xD1\\xD3\\xD5\\xD7\\xD9\\xDB]");
define("_MI_{$MYDIRNAME}_SPATTERNDEFAULT", "\xA1[\xAE\xC6\xC8\xCC\xCE\xD0\xD2\xD4\xD6\xD8\xDA],\xA1[\xAD\xC7\xC9\xCD\xCF\xD1\xD3\xD5\xD7\xD9\xDB]");

define("_MI_{$MYDIRNAME}_LINKTERMSPOSI", "15.�������줿��󥯤���ʸ�����ɽ�����ޤ�����");
define("_MI_{$MYDIRNAME}_LINKTERMSPOSIDSC", "�֤������פ����֤���ʸ�β������󤷡��֤Ϥ��פ����֤���ʸ���桢����������˥��������ɽ�����ޤ���");

define("_MI_{$MYDIRNAME}_LINKTERMSTITLE", "16.��ư���ȥ�󥯥����ȥ�");
define("_MI_{$MYDIRNAME}_LINKTERMSTITLEDSC", "��ưŪ�˺������줿��󥯤˥����ȥ��Ĥ��ޤ���");
define("_MI_{$MYDIRNAME}_LINKTERMSDEFAULTTITLE", "��Ϣ������");

define("_MI_{$MYDIRNAME}_FILETYPES", "17.���åײ�ǽ�ʥե�����γ�ĥ��");
define("_MI_{$MYDIRNAME}_FILETYPESDSC", "Ⱦ�ѤΥ��ڡ����Ƕ��ڤäƤ�����������������ȴ����ԤΥǡ������ϥե�����ǥե�����ޥ͡����㡼�Ȥ��̤Υ��åץ��ɥץ���ब�Ȥ���褦�ˤʤ�ޤ������㡧gif jpg png��");

define("_MI_{$MYDIRNAME}_UPLOADMAX", "18.���åײ�ǽ�ʺ���ե����륵����");
define("_MI_{$MYDIRNAME}_UPLOADMAXDSC", "17.�����ꤷ������ͭ����ñ�̡�KB�ʽ���͡�300KB��");

define("_MI_{$MYDIRNAME}_AMAZON", "19.���ޥ����ID�ʽ�ͭ���Ƥ������");
define("_MI_{$MYDIRNAME}_AMAZONDSC", "��������ȥ��åץ��ɥץ����ǡ֥��ޥ���ؤΥ�󥯤��������ץ��ץ�����ɲä���ޤ����ޤ����饤�֥�󥯤���̾��ʥ�󥯤ˤ���Ѥ��ޤ���");

define("_MI_{$MYDIRNAME}_README", "20.�ȥåץڡ�������Ū�ʤɤ�ɽ�����ޤ�����");
define("_MI_{$MYDIRNAME}_READMEDSC", "�ɤ�ʸ��դ��Ͽ���Ƥ���Ȥ�������Ǥ�빽�Ǥ���");
define("_MI_{$MYDIRNAME}_READMEDEF", "�������Ȥǻ��Ѥ��Ƥ�����ա���Ϣ�Τ�����դ���⤷�ޤ���");

define("_MI_{$MYDIRNAME}_TITLEBLOCKUSE", "21.�����ȥ��ɽ�����ޤ�����");
define("_MI_{$MYDIRNAME}_TITLEBLOCKUSEDSC", "�֤������פ����ӡ������ե��������Ѥ��ʤ��Ȳ���ɽ�����ޤ���");

define("_MI_{$MYDIRNAME}_H1ID", "22.�����ȥ�˲����ե������Ȥ��ޤ�����");
define("_MI_{$MYDIRNAME}_H1IDDSC", "����ˤ���21.��֤Ϥ��פˤ���ȡ��ᥤ���˥塼��Ʊ�������ȥ��ʸ����ɽ�����ޤ��������ե������images�ե�������֤��Ƥ����������ʽ���͡�xwords_titlelogo.gif��");

define("_MI_{$MYDIRNAME}_STRFFORMAT", "23.���֤Υե����ޥå�");
define("_MI_{$MYDIRNAME}_STRFFORMATDSC", "��ξܺ٥ڡ�����ɽ�������������η������ѹ��Ǥ��ޤ���PHP��strftime()�ؿ�����ѡ������ϡ�<a href='http://jp.php.net/manual/ja/function.strftime.php' target='_blank'>PHP�ޥ˥奢��</a>�򤴤�󤯤�����������͡ʶ���ˡ�**ǯ**��**����������");
//define("_MI_{$MYDIRNAME}_STRFFORMAT1", "0");
//define("_MI_{$MYDIRNAME}_STRFFORMATDSC1", "strftime()�ؿ���Ȥ�ʤ�");
//define("_MI_{$MYDIRNAME}_STRFFORMAT2", "%Yǯ%m��%d����%a��");
//define("_MI_{$MYDIRNAME}_STRFFORMATDSC2", "%Yǯ%m��%d����%a�� - ������˴�Ť�**ǯ**��**����������");
//define("_MI_{$MYDIRNAME}_STRFFORMAT3", "%x");
//define("_MI_{$MYDIRNAME}_STRFFORMATDSC3", "%x - ������˴�Ť����֤����������");
//define("_MI_{$MYDIRNAME}_STRFFORMAT4", "%c");
//define("_MI_{$MYDIRNAME}_STRFFORMATDSC4", "%c - ������˴�Ť�Ŭ�������դȻ���");

define("_MI_{$MYDIRNAME}_Y","ǯ");
define("_MI_{$MYDIRNAME}_M","��");
define("_MI_{$MYDIRNAME}_D","��");
define("_MI_{$MYDIRNAME}_L", "��");
define("_MI_{$MYDIRNAME}_R", "��");

define("_MI_{$MYDIRNAME}_LETTERFORMAT", "23.Ƭʸ���̥�󥯤Υե����ޥå�");
define("_MI_{$MYDIRNAME}_LETTERFORMATDSC", "������ˡ���ѹ��Ǥ��ޤ�����Ƭ�ο����ϡ�language/japanese/letter_format**.php��**���б��������ˤʤ�������ˡ�ˤ��������ϡ�����letter_format**.php��񤭤����Ƥ���������");
define("_MI_{$MYDIRNAME}_LETTERFORMAT01", "01.����ե��٥åȡܸ޽����ܤ���¾�ʥ��޻����ɤߤ�޽����ǥ�����ȡ�");
define("_MI_{$MYDIRNAME}_LETTERFORMAT02", "02.����ե��٥åȡ�ʸ����ܸ޽����ʥ��޻����ɤߤ�޽����ǥ�����ȡ�");
define("_MI_{$MYDIRNAME}_LETTERFORMAT03", "03.�޽�����ʸ����ʥ��޻����ɤߤ�޽����ǥ�����ȡ�");
define("_MI_{$MYDIRNAME}_LETTERFORMAT04", "04.�޽����Τߡʥ��޻����ɤߤ�޽����ǥ�����ȡ�");
define("_MI_{$MYDIRNAME}_LETTERFORMAT05", "05.����ե��٥åȡܸ޽����ܤ���¾�ʥ��޻����ɤߤϸ޽���������ʤ���");
define("_MI_{$MYDIRNAME}_LETTERFORMAT06", "06.����ե��٥åȡ�ʸ����ܸ޽����ʥ��޻����ɤߤϸ޽���������ʤ���");
define("_MI_{$MYDIRNAME}_LETTERFORMAT07", "07.�޽�����ʸ����ʥ��޻����ɤߤϸ޽���������ʤ���");
define("_MI_{$MYDIRNAME}_LETTERFORMAT08", "08.�޽����Τߡʥ��޻����ɤߤϸ޽���������ʤ���");
define("_MI_{$MYDIRNAME}_LETTERFORMAT09", "09.�޽����ΤߡʹԤ��ȤǤϤʤ�����������������");
define("_MI_{$MYDIRNAME}_LETTERFORMAT10", "10.�����ܥ���ե��٥åȡܸ޽����ܤ���¾");
define("_MI_{$MYDIRNAME}_LETTERFORMAT11", "11.���Ф���Υ��˥�����Ͽ���ʤ��ʥƥ������");

define("_MI_{$MYDIRNAME}_SUBMITTERLINK", "25.��Ƽ�̾��USERINFO.PHP�ؤΥ�󥯤�ĥ��ޤ�����");
define("_MI_{$MYDIRNAME}_SUBMITTERLINKDSC", "USERINFO.PHP�Ȥ���ƼԤδ��ܾ���ʤɤ�ɽ������ڡ����Τ��ȤǤ���");

define("_MI_{$MYDIRNAME}_CATSARRAYUSE", "26.���ƥ��꡼�ΰ�����ȥåץڡ���������ɽ�����ޤ�����");
define("_MI_{$MYDIRNAME}_CATSARRAYUSEDSC", "�֤Ϥ��פˤ���ȡ��ȥåץڡ����˥��ƥ��꡼�ξܺ٤�ɽ�������˥�����̰�����ɽ�����ޤ��󡣡֤������פˤ���ȡ����ƥ��꡼̾�����ˤʤꡢ���˥�����̰�����ɽ�����ޤ���");

define("_MI_{$MYDIRNAME}_BLOCKSPERPAGE", "27.�ȥåפȥ��ƥ��꡼�ڡ�����ɽ�����뿷�塢�͵��ο�");
define("_MI_{$MYDIRNAME}_BLOCKSPERPAGEDSC", "����ˤ����ɽ�����ޤ��󡣽���͡�5");

// Names of admin menu items
define("_MI_{$MYDIRNAME}_ADMENU1", "�ᥤ��");
define("_MI_{$MYDIRNAME}_ADMENU2", "���ƥ��꡼");
define("_MI_{$MYDIRNAME}_ADMENU3", "����ȥ꡼");
define("_MI_{$MYDIRNAME}_ADMENU4", "�֥�å������롼��");
define("_MI_{$MYDIRNAME}_ADMENU5", "��ǧ");
define("_MI_{$MYDIRNAME}_ADMENU6", "�⥸�塼��˹Ԥ�");

//Names of Blocks and Block information
define("_MI_{$MYDIRNAME}_ENTRIESNEW", "����֥�å�");
define("_MI_{$MYDIRNAME}_ENTRIESTOP", "�͵��֥�å�");
define("_MI_{$MYDIRNAME}_RANDOMTERM", "������֥�å�");
define("_MI_{$MYDIRNAME}_TERMINITIAL", "Ƭʸ���֥�å�");
define("_MI_{$MYDIRNAME}_COMBLOCK", "D3�����ȥ֥�å�");

//define("_MI_{$MYDIRNAME}_NOTUJIS", "MYSQL�δĶ��� default-character-set = %s �Ǥ���<br />XOOPS����Ѥ����ǻپ㤬���뤫�⤷��ޤ���");

//d3comment integration
define("_MI_{$MYDIRNAME}_COM_DIRNAME","���������礹��d3forum��dirname");
define("_MI_{$MYDIRNAME}_COM_DIRNAMEDSC","d3forum�Υ��������絡ǽ����Ѥ������<br/>�ե�������html¦�ǥ��쥯�ȥ�̾����ꤷ�ޤ���<br/>xoops�����Ȥ���Ѥ�����䥳���ȵ�ǽ��̵���ˤ�����϶���Ǥ���");
define("_MI_{$MYDIRNAME}_COM_FORUM_ID","���������礹��ե��������ֹ�");
define("_MI_{$MYDIRNAME}_COM_FORUM_IDDSC","��������������򤷤���硢forum_id��ɬ�����ꤷ�Ƥ���������");
define("_MI_{$MYDIRNAME}_COM_ORDER","�����������ɽ�����");
define("_MI_{$MYDIRNAME}_COM_ORDERDSC","��������������򤷤����Ρ������Ȥο������硿�Ť�������Ǥ��ޤ���");
define("_MI_{$MYDIRNAME}_COM_VIEW","�����������ɽ����ˡ");
define("_MI_{$MYDIRNAME}_COM_VIEWDSC","�ե�å�ɽ��������å�ɽ���������򤷤ޤ���");
define("_MI_{$MYDIRNAME}_COM_POSTSNUM","����������Υե�å�ɽ���ˤ��������ɽ�����");

?>