<?php
/**
 * $Id: admin.php v 1.0 8 May 2004 hsalazar Exp $
 * Module: Wordbook - a multicategory glossary
 * Version: v 1.00
 * Release Date: 8 May 2004
 * Author: hsalazar
 * Licence: GNU
 */
// XOOPS2 - Xwords 0.42
// WEBMASTER @ KANPYO.NET, 2005.

$MYDIRNAME = strtoupper(basename(dirname(dirname(dirname(__FILE__)))));

// index.php
define("_AM_{$MYDIRNAME}_INDEX", "�ǡ��������ᥤ���˥塼");
define("_AM_{$MYDIRNAME}_INVENTORY", "��Ͽ����");
define("_AM_{$MYDIRNAME}_TOTALENTRIES", "���Ф������ ");
define("_AM_{$MYDIRNAME}_TOTALCATS", "������ʬ����� ");
define("_AM_{$MYDIRNAME}_TOTALSUBM", "̤��ǧ�桼������ƿ��� ");
define("_AM_{$MYDIRNAME}_TOTALREQ", "̤��ǧ�ꥯ�����ȿ��� ");
define("_AM_{$MYDIRNAME}_GOAUTHORIZE", "�׾�ǧ����");
define("_AM_{$MYDIRNAME}_SHOWENTRIES", "���Ф���");
define("_AM_{$MYDIRNAME}_CREATEENTRY", "�ɲ�");
define("_AM_{$MYDIRNAME}_ENTRYID", "ID");
define("_AM_{$MYDIRNAME}_ENTRYCATNAME", "ʬ��̾");
define("_AM_{$MYDIRNAME}_ENTRYTERM", "���Ф���");
define("_AM_{$MYDIRNAME}_SUBMITTER", "��Ƽ�");
define("_AM_{$MYDIRNAME}_ENTRYCREATED", "�����");
define("_AM_{$MYDIRNAME}_STATUS", "����");
define("_AM_{$MYDIRNAME}_ACTION", "�Խ������");
define("_AM_{$MYDIRNAME}_EDITENTRY", "�Խ�");
define("_AM_{$MYDIRNAME}_DELETEENTRY", "���");
define("_AM_{$MYDIRNAME}_ENTRYISOFF", "�񤭤���");
define("_AM_{$MYDIRNAME}_ENTRYISON", "������");
define("_AM_{$MYDIRNAME}_ENTRYISFUTURE", "����ͽ��");
define("_AM_{$MYDIRNAME}_NOTERMS", "������Ͽ����Ƥ��ޤ���");
define("_AM_{$MYDIRNAME}_SHOWCATS", "������ʬ��ʥ��ƥ��꡼��");
define("_AM_{$MYDIRNAME}_CREATECAT", "�ɲ�");
define("_AM_{$MYDIRNAME}_WEIGHT", "ɽ���ν���");
define("_AM_{$MYDIRNAME}_CATNAME", "ʬ��̾");
define("_AM_{$MYDIRNAME}_DESCRIP", "����");
define("_AM_{$MYDIRNAME}_EDITCAT", "�Խ�");
define("_AM_{$MYDIRNAME}_DELETECAT", "���");
define("_AM_{$MYDIRNAME}_NOCATS", "ʬ�व��Ƥ��ޤ���");
define("_AM_{$MYDIRNAME}_EDITSUBM", "�Խ�");
define("_AM_{$MYDIRNAME}_DELETESUBM", "���");
define("_AM_{$MYDIRNAME}_NOSUBMISSYET", "��ǧ���Ԥ���ƤϤ���ޤ���");
define("_AM_{$MYDIRNAME}_SHOWREQUESTS", "�����Ԥ���Υꥯ������");
define("_AM_{$MYDIRNAME}_NOREQSYET", "�ꥯ�����ȤϤ���ޤ���");
define("_AM_{$MYDIRNAME}_NOTUJIS", "MYSQL�δĶ��� default-character-set = %s �Ǥ���<br />XOOPS����Ѥ����ǻپ㤬���뤫�⤷��ޤ���");


// category.php
define("_AM_{$MYDIRNAME}_NOCATTOEDIT", "���ƥ��꡼�κ����ϤǤ��ޤ���");
define("_AM_{$MYDIRNAME}_CATS", "������ʬ��ʥ��ƥ��꡼��");
define("_AM_{$MYDIRNAME}_CATSHEADER", "������ʬ��ʥ��ƥ��꡼���Խ�");
define("_AM_{$MYDIRNAME}_NEWCAT", "������ʬ��ʥ��ƥ��꡼�ˤ��ɲ�");
define("_AM_{$MYDIRNAME}_CATDESCRIPT", "���Ӳ���");
define("_AM_{$MYDIRNAME}_CATPOSIT", "ɽ����");
//define("_AM_{$MYDIRNAME}_AMAZONTAG", "���ޥ��󥿥�");
define("_AM_{$MYDIRNAME}_CREATE", "����");
define("_AM_{$MYDIRNAME}_CLEAR", "���ꥢ");
define("_AM_{$MYDIRNAME}_CANCEL", "����󥻥�");
define("_AM_{$MYDIRNAME}_MODCAT", "�������륫�ƥ��꡼");
define("_AM_{$MYDIRNAME}_MODIFY", "����");
define("_AM_{$MYDIRNAME}_DELETE", "���");
define("_AM_{$MYDIRNAME}_DELETETHISCAT", "���Υ��ƥ��꡼�������Ƥ������Ǥ�����<br />���Υ��ƥ��꡼����Ͽ����Ƥ��븫�Ф���Ȥ��Υ����Ȥ�<br />���٤ƺ������ޤ��ΤǸ���դ���������");
define("_AM_{$MYDIRNAME}_CATISDELETED", "%s �Ϻ������ޤ���");
define("_AM_{$MYDIRNAME}_CATCREATED", "���������ƥ��꡼�ϡ�̵���˺�������ޤ�����");
define("_AM_{$MYDIRNAME}_NOTUPDATED", "���顼�Τ���ǡ����١����򹹿��Ǥ��ޤ���Ǥ���");
define("_AM_{$MYDIRNAME}_CATMODIFIED", "̵����������ޤ�����");
define("_AM_{$MYDIRNAME}_BACK2IDX", "����󥻥뤷�ޤ���");
define("_AM_{$MYDIRNAME}_SINGLECAT", "ʣ����������ʬ��ʥ��ƥ��꡼�ˤ�Ȥ��褦�����ꤵ��Ƥ��ޤ��󡣡ְ�������פ���ǧ����������");
define("_AM_{$MYDIRNAME}_NOCAT", "������������ʬ��ʥ��ƥ��꡼�ˤϤ���ޤ���");
define("_AM_{$MYDIRNAME}_OPENDATA", "���");


// entry.php
define("_AM_{$MYDIRNAME}_NEWENTRY", "�ɲä�������");
define("_AM_{$MYDIRNAME}_WRITEHERE", "����������ʸ��񤤤Ƥ���������");
define("_AM_{$MYDIRNAME}_NOENTRYTOEDIT", "��Ͽ����Ƥ��ޤ���");
define("_AM_{$MYDIRNAME}_ENTRIES", "���Ф��졦����ʸ");
define("_AM_{$MYDIRNAME}_ADMINENTRYMNGMT", "�ɲ�");
define("_AM_{$MYDIRNAME}_NEEDONECOLUMN", "�ޤ���������ʬ��ʥ��ƥ��꡼�ˤ�������Ƥ���������");
define("_AM_{$MYDIRNAME}_AUTHOR", "����");
define("_AM_{$MYDIRNAME}_ENTRYPROC", "�ɤ����ʤҤ餬�ʡ�");
define("_AM_{$MYDIRNAME}_ENTRYDEF", "����ʸ");
define("_AM_{$MYDIRNAME}_ENTRYREFERENCE", "����ʸ���ʤ�<span style='font-size: xx-small; font-weight: normal;'>(Reference)</span>");
define("_AM_{$MYDIRNAME}_ENTRYURL", "���ͥ�����<span style='font-size: xx-small; font-weight: normal;'>(http://�����)</span>");
define("_AM_{$MYDIRNAME}_SWITCHOFFLINE", "�񤭤����ˤ��ޤ�����");
define("_AM_{$MYDIRNAME}_YES", "�Ϥ�");
define("_AM_{$MYDIRNAME}_NO", "������");
define("_AM_{$MYDIRNAME}_OPTIONS", "���ץ����");
define("_AM_{$MYDIRNAME}_SETNEWDATE", " ������������ꤹ��Ȥ��ϥ����å������졢�����򥻥åȤ��Ƥ���������");
define("_AM_{$MYDIRNAME}_RENEWDATE", " ����������ѹ�����Ȥ��ϥ����å������졢�����򥻥åȤ��Ƥ���������");
define("_AM_{$MYDIRNAME}_RENEWDATE_DEFAULT", "����͡�");
define("_AM_{$MYDIRNAME}_CURRENTTIME_Y","ǯ");
define("_AM_{$MYDIRNAME}_CURRENTTIME_M","��");
define("_AM_{$MYDIRNAME}_CURRENTTIME_D","��");
define("_AM_{$MYDIRNAME}_CURRENTTIME_J","��");
define("_AM_{$MYDIRNAME}_CURRENTTIME_H","ʬ");
define("_AM_{$MYDIRNAME}_DOHTML", " HTML������Ȥ��������å��򳰤��ȥ��������Τޤ�ɽ������롣");
define("_AM_{$MYDIRNAME}_DOSMILEY", " ��ʸ����饢��������Ѵ����롣�����å��򳰤���ʸ���Τޤޡ�");
define("_AM_{$MYDIRNAME}_DOXCODE", " XOOPS�����ɤ�Ȥ��������å��򳰤��ȥ����ɤ����Τޤ�ɽ������롣");
define("_AM_{$MYDIRNAME}_BREAKS", " ���Ԥ�&lt;BR&gt;�������Ѵ����롣�����å��򳰤��Ȳ��Ԥ���ʤ���");
define("_AM_{$MYDIRNAME}_ENTRYCREATEDOK", "�ɲä���ޤ�����");
define("_AM_{$MYDIRNAME}_ENTRYNOTCREATED", "�ɲä��뤳�ȤϤǤ��ޤ���Ǥ�����");
define("_AM_{$MYDIRNAME}_MODENTRY", "����");
define("_AM_{$MYDIRNAME}_ENTRYMODIFIED", "�ѹ����ޤ�����");
define("_AM_{$MYDIRNAME}_ENTRYNOTUPDATED", "�ѹ��Ǥ��ޤ���Ǥ�����");
define("_AM_{$MYDIRNAME}_ENTRYISDELETED", "�������ޤ���");
define("_AM_{$MYDIRNAME}_DELETETHISENTRY", "������Ƥ������Ǥ�����");
define("_AM_{$MYDIRNAME}_UPFILES", "�ե����륢�åץ���");
define("_AM_{$MYDIRNAME}_UPLOADOPEN", "�ե����륢�åץ��ɥץ����򳫤�");
define("_AM_{$MYDIRNAME}_SPAW", "Wysiwyg���Ϥ��ѹ��ʢ�����ޤǤ����Ϥ�̵���ˤʤ�ޤ���");
define("_AM_{$MYDIRNAME}_BB", "BBcode���Ϥ��ѹ��ʢ�����ޤǤ����Ϥ�̵���ˤʤ�ޤ���");
define("_AM_{$MYDIRNAME}_SPAWTOBB", "SPAW��BB");
define("_AM_{$MYDIRNAME}_BBTOSPAW", "BB��SPAW");
define("_AM_{$MYDIRNAME}_PREVIEWOPEN", "����ǥץ�ӥ塼");
define("_AM_{$MYDIRNAME}_NOENTRY", "�����θ��Ф���Ϥ���ޤ���");


// submissions.php
define("_AM_{$MYDIRNAME}_AUTHENTRY", "������Ƴ�ǧ");
define("_AM_{$MYDIRNAME}_AUTHORIZE", "��ǧ");
define("_AM_{$MYDIRNAME}_ENTRYAUTHORIZED", "��ƤϾ�ǧ����ޤ���");
define("_AM_{$MYDIRNAME}_SUBMITS", "���");
define("_AM_{$MYDIRNAME}_SUBMITSDEL", "�Ѳ��ʺ����");
define("_AM_{$MYDIRNAME}_SHOWSUBMISSIONS", "�桼�����ˤ���ɲ�");
define("_AM_{$MYDIRNAME}_MAINPAGEKARA", "���ߤޤ��󡣥ᥤ��ڡ������餪�ꤤ���ޤ���");
define("_AM_{$MYDIRNAME}_FUTUREENTRY", "����ͽ��θ��Ф���");
define("_AM_{$MYDIRNAME}_HIDDENENTRY", "�񤭤����θ��Ф���");
define("_AM_{$MYDIRNAME}_NOFUTUREENTRY", "����ͽ��θ��Ф���Ϥ���ޤ���");
define("_AM_{$MYDIRNAME}_NOHIDDENENTRY", "�񤭤����θ��Ф���Ϥ���ޤ���");
define("_AM_{$MYDIRNAME}_OPENSCHEDULE", "����ͽ����");


// myblocksadmin.php
define("_AM_{$MYDIRNAME}_BLOCKS", "�֥�å������롼�״���");

// pluginlist.php
define("_AM_{$MYDIRNAME}_PLUGINLISTTITLE", "�ץ饰�����б�����");
define("_AM_{$MYDIRNAME}_PLUGINLISTDSC_HEAD", "<p>������ɽ������Ƥ���⥸�塼�뤬�ָ����Ǥ���⥸�塼�뤹�٤ơפ˳������ޤ����ץ饰����Τ���⥸�塼��ϡ������Υե�����̾��ɽ�����Ƥ��ޤ���</p>");
define("_AM_{$MYDIRNAME}_PLUGINLISTDSC_FOOT", "<p>����ư���ȥ�󥯵�ǽ�������ָ����Ǥ���⥸�塼�뤹�٤Ƥ��оݤ˻��Ѥ���פˤ�����硢�ץ饰���󤬤ʤ��⥸�塼��� XOOPS �θ�����ǽ�����Ѥ��ޤ������������ץ饰��������٤�������ޤ���</p><p>���֥ץ饰����Τ���⥸�塼��Τߤ��оݤ˻��Ѥ���פ����ꤹ��ݡ����������⥸�塼�뤬������ϳ����Υץ饰����ե�����������Ƥ���������</p><p>����ư���ȥ�󥯵�ǽ�ϡ������ε�����ɽ�����뤿�Ӥ� XOOPS �����򤷤Ƥ���Τ�Ʊ���٤Υ����С���٤������ޤ���</p>");
define("_AM_{$MYDIRNAME}_NOPLUGIN", "�ץ饰����ʤ�");


// functions.php
define("_AM_{$MYDIRNAME}_OPTS", "��������عԤ�");
define("_AM_{$MYDIRNAME}_GOMOD", "�⥸�塼��عԤ�");
define("_AM_{$MYDIRNAME}_ID", "ID");
define("_AM_{$MYDIRNAME}_MODADMIN", " �⥸�塼�������: ");
define("_AM_{$MYDIRNAME}_HELP", "�إ��");


?>