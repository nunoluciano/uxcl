<?php
/**
 * $Id: main.php v 1.0 8 May 2004 hsalazar Exp $
 * Module: Wordbook - a multicategory glossary
 * Version: v 1.00
 * Release Date: 8 May 2004
 * Author: hsalazar
 * Licence: GNU
 */
// XOOPS2 - Xwords 0.42
// WEBMASTER @ KANPYO.NET, 2005.

$MYDIRNAME = strtoupper(basename(dirname(dirname(dirname(__FILE__)))));

// templates����
define("_MD_{$MYDIRNAME}_HOME", "HOME");
define("_MD_{$MYDIRNAME}_WEHAVE", "��Ͽ��");
define("_MD_{$MYDIRNAME}_NOW", "�㸽�ߤηǺܿ��ϼ��ΤȤ����");
define("_MD_{$MYDIRNAME}_BROWSELETTER", "Ƭʸ���ʥ��˥�������");
//define("_MD_{$MYDIRNAME}_OTHER", "����¾");
define("_MD_{$MYDIRNAME}_BROWSECAT", "������ʬ��ʥ��ƥ��꡼����");
define("_MD_{$MYDIRNAME}_SEARCHENTRY", "����");
define("_MD_{$MYDIRNAME}_LOOKON", "�����о�");
define("_MD_{$MYDIRNAME}_TERMS", "���Ф���");
define("_MD_{$MYDIRNAME}_PROCS", "�ɤ���");
define("_MD_{$MYDIRNAME}_DEFINS", "����ʸ");
define("_MD_{$MYDIRNAME}_CATEGORY", "������ʬ��");
//define("_MD_{$MYDIRNAME}_ALLOFTHEM", "0 : ���٤�");
define("_MD_{$MYDIRNAME}_ALLOFTHEM", "��ʬ��ʥ��ƥ��꡼��");
define("_MD_{$MYDIRNAME}_TERM", "������");
define("_MD_{$MYDIRNAME}_SEARCH", "������");
define("_MD_{$MYDIRNAME}_DELTERM", "�������");
define("_MD_{$MYDIRNAME}_EDITTERM", "������Խ�");
define("_MD_{$MYDIRNAME}_ALLCATEGORY", "��ʬ��");
define("_MD_{$MYDIRNAME}_STILLNOTHINGHERE", "Xwords�ˤ褦����������ǰ�ʤ���ޤ�������Ͽ����Ƥ��ޤ���");
define("_MD_{$MYDIRNAME}_RUBYL", "��");
define("_MD_{$MYDIRNAME}_RUBYR", "��");

// xwords_index.html
define("_MD_{$MYDIRNAME}_READMEFIRST", "�Ϥ����");
define("_MD_{$MYDIRNAME}_READMEWEHAVE", "��������");
define("_MD_{$MYDIRNAME}_DEFS", "���Ф������");
define("_MD_{$MYDIRNAME}_CATS", "������ʬ�����");
define("_MD_{$MYDIRNAME}_ADDDATA", "�ɲ�");
define("_MD_{$MYDIRNAME}_SUBMITENTRY", "�ǡ������ɲ�");
define("_MD_{$MYDIRNAME}_REQUESTDEF", "�ꥯ������");
define("_MD_{$MYDIRNAME}_ALLCATS", "ʬ����������");
define("_MD_{$MYDIRNAME}_RECENTENT", "����");
define("_MD_{$MYDIRNAME}_POPULARENT", "��󥭥�");
define("_MD_{$MYDIRNAME}_RANDOMTERM", "������");
define("_MD_{$MYDIRNAME}_SUBANDREQ", "�ǡ������ɲá��ꥯ������");
define("_MD_{$MYDIRNAME}_SUB", "�桼�����ˤ��ǡ����ɲá�");
define("_MD_{$MYDIRNAME}_REQ", "�����Ԥ���Υꥯ�����ȡ�");
define("_MD_{$MYDIRNAME}_NOSUB", "����ޤ���");
define("_MD_{$MYDIRNAME}_NOREQ", "����ޤ���");
define("_MD_{$MYDIRNAME}_NOTERM", "����ޤ���");

// xwords_letter.html
define("_MD_{$MYDIRNAME}_INALLGLOSSARIES", "��");
define("_MD_{$MYDIRNAME}_BEGINWITHLETTER", "��");
define("_MD_{$MYDIRNAME}_LETTERDEFINS", "���⡧");
define("_MD_{$MYDIRNAME}_RETURN", "���");
define("_MD_{$MYDIRNAME}_RETURN2INDEX", "�ȥåפ����");
define("_MD_{$MYDIRNAME}_NOTERMSINLETTER", "����Ƭʸ���ǻϤޤ��ΤϤ���ޤ���");

// xwords_entry.html
define("_MD_{$MYDIRNAME}_ENTRYYOMI", "�ɤߡ�");
define("_MD_{$MYDIRNAME}_ENTRYCATEGORY", "���ӡ�");
define("_MD_{$MYDIRNAME}_ENTRYDEFINITION", "�Ȥ�...");
define("_MD_{$MYDIRNAME}_ENTRYREFERENCE", "����ʸ����");
define("_MD_{$MYDIRNAME}_ENTRYRELATEDURL", "��Ϣ�����ȡ�");
define("_MD_{$MYDIRNAME}_SUBMITTEDBY", "��Ƽԡ�");
define("_MD_{$MYDIRNAME}_SUBMITTED", "�������");
define("_MD_{$MYDIRNAME}_COUNT", "���������");
define("_MD_{$MYDIRNAME}_COMMENT", "�����ԤΥ�����");
define("_MD_{$MYDIRNAME}_AMAZON", "���ޥ���");
define("_MD_{$MYDIRNAME}_AMAZONLINK", "�Ǹ���");

// xwords_category.html
define("_MD_{$MYDIRNAME}_ENTRIESINCAT", "��");
define("_MD_{$MYDIRNAME}_NOENTRIESINCAT", "�ޤ�������Ͽ����Ƥ��ޤ���");
define("_MD_{$MYDIRNAME}_NOCATSINSYSTEM", "�ޤ����ƥ��꡼�����ꤷ�Ƥ���������");
define("_MD_{$MYDIRNAME}_CATRECENTENT", "����ʬ��Ǥο���");
define("_MD_{$MYDIRNAME}_CATPOPULARENT", "����ʬ��Ǥο͵�");

// xwords_search.html
define("_MD_{$MYDIRNAME}_SEARCHHEAD", "����");
define("_MD_{$MYDIRNAME}_SEARCED", "�������");
define("_MD_{$MYDIRNAME}_SEARCHTYPE", "�����μ���");
define("_MD_{$MYDIRNAME}_TERMSDEFS", "���Ф���+�ɤ���+����ʸ");
define("_MD_{$MYDIRNAME}_SEARCHALL", "���٤Ƥθ�˰��פ�����");
define("_MD_{$MYDIRNAME}_SEARCHANY", "�����줫�θ�˰��פ�����");
define("_MD_{$MYDIRNAME}_SEARCHEXACT", "���ڡ�����ޤᣱ��Ȥ���");
define("_MD_{$MYDIRNAME}_NOSEARCHTERM", "����������Ϥ��Ƥ���������");
define("_MD_{$MYDIRNAME}_NORESULTS", "�����ʤ������٤������������");
define("_MD_{$MYDIRNAME}_THEREWERE", "�嵭�ξ���&nbsp;%s&nbsp;�︫�Ĥ���ޤ�����");
define("_MD_{$MYDIRNAME}_DUMMY", "����");
define("_MD_{$MYDIRNAME}_NBSP", "��");


// xwords_request.html
define("_MD_{$MYDIRNAME}_ASKFORDEF", "�ꥯ������");
define("_MD_{$MYDIRNAME}_INTROREQUEST", "�������Ȥμ�ݡ���Ū�򤪹ͤ��ξ塢�Ǻܤ������������Ȼפ����Τ��Τ餻����������<br />�����Υե������ɽ�����Ƥ���30ʬ������������Ƥ���������");
define("_MD_{$MYDIRNAME}_REQUESTFORM", "�ꥯ����������");
define("_MD_{$MYDIRNAME}_USERNAME", "��̾��");
define("_MD_{$MYDIRNAME}_USERMAIL", "�᡼�륢�ɥ쥹");
define("_MD_{$MYDIRNAME}_REQTERM", "���Ф���");
define("_MD_{$MYDIRNAME}_NOTIFY", "��̤��Τꤿ���Ȥ��˥����å�");
define("_MD_{$MYDIRNAME}_SUBMIT", "�������Ƥ�����");
define("_MD_{$MYDIRNAME}_ANONYMOUS", "ƿ̾");
define("_MD_{$MYDIRNAME}_WHOASKED", "%s����Υꥯ���������ơ�");
define("_MD_{$MYDIRNAME}_EMAILLEFT", "�����ԤΥ᡼�륢�ɥ쥹: ");
define("_MD_{$MYDIRNAME}_NOTIFYONPUB", "�����Ԥ˷�̤��Τ餻�Ƥ�������");
define("_MD_{$MYDIRNAME}_DEFINITIONREQ", "���󤫤�Υꥯ������");
define("_MD_{$MYDIRNAME}_MESSAGESENT", "%s �إꥯ�����Ȥ�������");
define("_MD_{$MYDIRNAME}_THANKS1", "���꤬�Ȥ��������ޤ�����");
define("_MD_{$MYDIRNAME}_THANKS2", "�ꥯ�����ȡ����꤬�Ȥ��������ޤ�����");
define("_MD_{$MYDIRNAME}_GOODDAY2", "%s ���󡢤���ˤ��ϡ�");
define("_MD_{$MYDIRNAME}_THANKYOU", "��®����%s�פˤĤ���Ĵ���������ޤ���");
define("_MD_{$MYDIRNAME}_REQUESTSENT", "���Υ᡼��ϡ�%s�μ�ŵ�˥ꥯ�����Ȥ�����
��ǧ�Τ���˼�ư�������Ƥ����ΤǤ���
�Ǻܤ��뤳�Ȥ���«�����ΤǤϤ���ޤ���Τǡ�
���餫�����λ������������");
define("_MD_{$MYDIRNAME}_WEBMASTER", "Webmaster");
define("_MD_{$MYDIRNAME}_SENTCONFIRMMAIL", "�ꥯ�����Ȥγ�ǧ�Ȥ��ơ����ʤ���<b>%s</b>�ˤ��Ƥ˥᡼�������ޤ�����");
define("_MD_{$MYDIRNAME}_NOUSERNAME", "��̾���������Ƥ���������");
define("_MD_{$MYDIRNAME}_NOUSERMAIL", "�᡼�륢�ɥ쥹�������Ƥ���������");
define("_MD_{$MYDIRNAME}_NOREQTERM", "���Ф���������Ƥ���������");

// submit.php include/storyform.inc.php
define("_MD_{$MYDIRNAME}_SUB_SNEWNAME", "�ǡ������ɲ�");
define("_MD_{$MYDIRNAME}_SUBMITART", "�ǡ������ɲ�");
define("_MD_{$MYDIRNAME}_SUB_SEDITNAME", "�ǡ����ν���");
define("_MD_{$MYDIRNAME}_SUBMITEDIT", "�ǡ����ν���");
define("_MD_{$MYDIRNAME}_GOODDAY", "����ˤ��ϡ�");
define("_MD_{$MYDIRNAME}_SUB_SNEWNAMEDESC1", "�������줿�ǡ����ϡ���ư��ǧ��Τ�����Ƹ夹���˸�������ޤ���<br />�����Υե������ɽ�����Ƥ���30ʬ������������Ƥ���������");
define("_MD_{$MYDIRNAME}_SUB_SNEWNAMEDESC2", "�������줿�ǡ������ǧ�����Ƥ��������ޤ������Ƥˤ�äƤϸ������ʤ����Ȥ⡢������ǽ������뤳�Ȥ⤢��ޤ���<br />�����Υե������ɽ�����Ƥ���30ʬ������������Ƥ���������");
define("_MD_{$MYDIRNAME}_SUB_SNEWNAMEDESC3", "�������Ȥμ�ݡ���Ū�򤪹ͤ��ξ塢�ǡ������ɲä��Ƥ�����������ư��ǧ��Τ�����Ƹ夹���˸�������ޤ���<br />�����Υե������ɽ�����Ƥ���30ʬ������������Ƥ���������");
define("_MD_{$MYDIRNAME}_SUB_SNEWNAMEDESC4", "�������Ȥμ�ݡ���Ū�򤪹ͤ��ξ塢�ǡ������ɲä��Ƥ������������Ƥγ�ǧ�塢��ǧ�����ޤǸ�������ޤ���<br />�����Υե������ɽ�����Ƥ���30ʬ������������Ƥ���������");
define("_MD_{$MYDIRNAME}_SUB_SMNAME", "�������");
define("_MD_{$MYDIRNAME}_ENTRY", "���Ф���");
define("_MD_{$MYDIRNAME}_PROC", "�ɤ���");
define("_MD_{$MYDIRNAME}_DEFINITION", "����ʸ");
define("_MD_{$MYDIRNAME}_WRITEHERE", "����������ʸ�򵭽�");
define("_MD_{$MYDIRNAME}_REFERENCE", "����ʸ���ʤ�<span style='font-size: xx-small; font-weight: normal;'>(Reference)</span>");
define("_MD_{$MYDIRNAME}_URL", "���ͥ�����<span style='font-size: xx-small; font-weight: normal;'>(http://�����)</span>");
define("_MD_{$MYDIRNAME}_CREATE", "�������Ƥ����");
define("_MD_{$MYDIRNAME}_MODIFY", "�������Ƥǽ���");
define("_MD_{$MYDIRNAME}_CLEAR", "���ꥢ");
define("_MD_{$MYDIRNAME}_CANCEL", "����󥻥�");
define("_MD_{$MYDIRNAME}_WHOSUBMITTED", "%s�������ơ�");
define("_MD_{$MYDIRNAME}_DEFINITIONSUB", "�������");
define("_MD_{$MYDIRNAME}_RECEIVEDANDAPPROVED", "���ʤ�����ƤϾ�ǧ���졢���˸�������Ƥ��ޤ���");
define("_MD_{$MYDIRNAME}_RECEIVED", "��Ƥ��꤬�Ȥ��������ޤ������Ǥ�������᤯�Ҹ������Ƥ��������ޤ���");
define("_MD_{$MYDIRNAME}_ERRORSAVINGDB", "�ǡ����١����ϥ��顼�ˤ�깹������ޤ���Ǥ�����");
define("_AM_{$MYDIRNAME}_NOCOLEXISTS", "���ƥ��꡼�Ϥ���ޤ��󡣥����ȴ����Ԥˤ��䤤��碌����������");
define("_MD_{$MYDIRNAME}_UPFILES", "�ե����륢�åץ���");
define("_MD_{$MYDIRNAME}_UPLOADOPEN", "�ե����륢�åץ��ɥץ����򳫤�");
define("_MD_{$MYDIRNAME}_PREVIEWOPEN", "����ǥץ�ӥ塼");
define("_MD_{$MYDIRNAME}_NOPROC", "�ɤ�����Ҥ餬�ʤǵ������Ƥ���������");
define("_MD_{$MYDIRNAME}_DONTUSETAG", "<span style='font-size: xx-small; font-weight: normal;color:red;'>�ʥ����ϻ����Բġ�</span>");
define("_MD_{$MYDIRNAME}_HIRAGANA", "<span style='font-size: xx-small; font-weight: normal;color:red;'>�ʤҤ餬�ʡ�</span>");


//preview.html
define("_MD_{$MYDIRNAME}_PREVIEW_DSC",'�ץ�ӥ塼��¿ʬ����ʴ�����ɽ������ޤ���');
define("_MD_{$MYDIRNAME}_PREVIEW_CLOSE",'��λ���Ĥ����');
define("_MD_{$MYDIRNAME}_PREVIEW_NOTERM",'̤����');
define("_MD_{$MYDIRNAME}_PREVIEW_NOPROC",'�ߤ��ˤ夦');

// admin/upload.php
define("_MD_{$MYDIRNAME}_UPLOAD_START",'���åץ��ɤ�³����');
define("_MD_{$MYDIRNAME}_UPLOAD_CLOSE",'��λ���Ĥ����');
define("_MD_{$MYDIRNAME}_UPLOAD_BACK",'���');
define("_MD_{$MYDIRNAME}_UPLOAD_CODEIN",'���Υ����ɤ���ƥե����������');
define("_MD_{$MYDIRNAME}_UPLOAD_CODE",'�������ɽ���ѥ����ɤ򤪻Ȥ���������');
define("_MD_{$MYDIRNAME}_UPLOAD_SUCCESS",'���ꤵ�줿�ե�����Υ��åץ��ɤ���λ���ޤ�����');
define("_MD_{$MYDIRNAME}_UPLOAD_REBTN",'���åץ��ɥ�ȥ饤');
define("_MD_{$MYDIRNAME}_UPLOAD_ALT",'���� (ALT)��');
define("_MD_{$MYDIRNAME}_UPLOAD_ALTER",'���إե�����̾:');
define("_MD_{$MYDIRNAME}_UPLOAD_RENAME",'���������إե�����̾���ޤ��Ϥ������ʥե�����̾���ѹ��Ǥ��ޤ���');
define("_MD_{$MYDIRNAME}_UPLOAD_EXISTS",'����̾���Υե�����ϴ���¸�ߤ��ޤ� : ');
define("_MD_{$MYDIRNAME}_UPLOAD_DUPLICATE",'�ե�����̾����ʣ���Ƥ��ޤ��� ?');
define("_MD_{$MYDIRNAME}_UPLOAD_BTN",'�ե����륢�åץ���');
define("_MD_{$MYDIRNAME}_UPLOAD_AMAZON",'���ޥ��󥢥���������');
define("_MD_{$MYDIRNAME}_UPLOAD_PX",'px��Ĺ��¦��');
define("_MD_{$MYDIRNAME}_UPLOAD_CUSTOM",'�������ॵ����');
define("_MD_{$MYDIRNAME}_UPLOAD_LARGE",'�顼����������Ĺ��¦ 400px��');
define("_MD_{$MYDIRNAME}_UPLOAD_SMALL",'���⡼�륵������Ĺ��¦ 200px��');
define("_MD_{$MYDIRNAME}_ATTACH_ICON",'ź�եե�����Υ�������Τ�');
define("_MD_{$MYDIRNAME}_UPLOAD_NO",'�������ʤ�');
define("_MD_{$MYDIRNAME}_UPLOAD_THUMBNAIL",'����ͥ��롧');
define("_MD_{$MYDIRNAME}_UPLOAD_FILE",'�ե���������');
define("_MD_{$MYDIRNAME}_UPLOAD_OPTIONS",'�������ͤ��ѹ�����Ȥ��ϡ�������˥塼�ΰ���������Խ����Ƥ���������');
define("_MD_{$MYDIRNAME}_UPLOAD_BYTES",'���åץ��ɲ�ǽ�ʥե�����Υ����� : ');
define("_MD_{$MYDIRNAME}_UPLOAD_EXTENSION",'���åץ��ɲ�ǽ�ʥե�����μ��� : ');
define("_MD_{$MYDIRNAME}_UPLOAD_DIRECTORY",'���ꤵ�줿�ǥ��쥯�ȥ꡼���񤭹��߲�ǽ�ˤʤäƤ��ޤ���Τǡ����ߥ��åץ��ɵ�ǽ�����Ѥ��뤳�Ȥ��Ǥ��ޤ���<br />�ǥ��쥯�ȥ꡼�Υѡ��ߥå����ڤӥե�ѥ�����٥����å����Ƥ�������');


// ******************************
// �����˥����Ȥ��뤿��Υǡ���
// ******************************

$patterns1 = array (
	'/^((?:.{2})*)��|��|��/',
	'/^((?:.{2})*)��|��|��|��/',
	'/^((?:.{2})*)��|��|��/',
	'/^((?:.{2})*)��|��|��|��/',
	'/^((?:.{2})*)��|��|��/',
	'/^((?:.{2})*)��|��|��|��/',
	'/^((?:.{2})*)��|��|��/',
	'/^((?:.{2})*)��|��|��/',
	'/^((?:.{2})*)��|��|��|��/',
	'/^((?:.{2})*)��|��|��/',
	'/^((?:.{2})*)��|��|��/',
	'/^((?:.{2})*)��|��|��/',
	'/^((?:.{2})*)��|��|��/',
	'/^((?:.{2})*)��|��|��/',
	'/^((?:.{2})*)��|��|��/',
	'/^((?:.{2})*)��|��|��/',
	'/^((?:.{2})*)��|��|��/',
	'/^((?:.{2})*)��|��|��|��|��/',
	'/^((?:.{2})*)��|��|��/',
	'/^((?:.{2})*)��|��|��/',
	'/^((?:.{2})*)��/',
	'/^((?:.{2})*)��/',
	'/^((?:.{2})*)��/',
	'/^((?:.{2})*)��/',
	'/^((?:.{2})*)��/',
	'/^((?:.{2})*)��|��|��|��|��/',
	'/^((?:.{2})*)��|��|��|��|��/',
	'/^((?:.{2})*)��|��|��|��|��/',
	'/^((?:.{2})*)��|��|��|��|��/',
	'/^((?:.{2})*)��|��|��|��|��/',
	'/^((?:.{2})*)��/',
	'/^((?:.{2})*)��/',
	'/^((?:.{2})*)��/',
	'/^((?:.{2})*)��/',
	'/^((?:.{2})*)��/',
	'/^((?:.{2})*)��|��|��/',
	'/^((?:.{2})*)��|��|��/',
	'/^((?:.{2})*)��|��|��/',
	'/^((?:.{2})*)��/',
	'/^((?:.{2})*)��/',
	'/^((?:.{2})*)��/',
	'/^((?:.{2})*)��/',
	'/^((?:.{2})*)��/',
	'/^((?:.{2})*)���/',
	'/^((?:.{2})*)��/',
	'/^((?:.{2})*)��/'
);

$replace1 = array (
	'$1��','$1��','$1��','$1��','$1��',
	'$1��','$1��','$1��','$1��','$1��',
	'$1��','$1��','$1��','$1��','$1��',
	'$1��','$1��','$1��','$1��','$1��',
	'$1��','$1��','$1��','$1��','$1��',
	'$1��','$1��','$1��','$1��','$1��',
	'$1��','$1��','$1��','$1��','$1��',
	'$1��','$1��','$1��',
	'$1��','$1��','$1��','$1��','$1��',
	'$1��','$1��','$1��',
);

$patterns2 = array (
	'/����/','/����/','/����/','/����/','/�ʡ�/',
	'/�ϡ�/','/�ޡ�/','/�䡼/','/�顼/','/�/',
	'/����/','/����/','/����/','/����/','/�ˡ�/',
	'/�ҡ�/','/�ߡ�/','/�꡼/',
	'/����/','/����/','/����/','/�ġ�/','/�̡�/',
	'/�ա�/','/�ࡼ/','/�桼/','/�롼/',
	'/����/','/����/','/����/','/�ơ�/','/�͡�/',
	'/�ء�/','/�᡼/','/�졼/',
	'/����/','/����/','/����/','/�ȡ�/','/�Ρ�/',
	'/�ۡ�/','/�⡼/','/�衼/','/��/','/��/','/��/',
);

$replace2 = array (
	'����','����','����','����','�ʤ�','�Ϥ�','�ޤ�','�䤢','�餢','�濫',
	'����','����','����','����','�ˤ�','�Ҥ�','�ߤ�','�ꤤ',
	'����','����','����','�Ĥ�','�̤�','�դ�','�द','�椦','�뤦',
	'����','����','����','�Ƥ�','�ͤ�','�ؤ�','�ᤨ','�줨',
	'����','����','����','�Ȥ�','�Τ�','�ۤ�','�⤪','�褪','��','���','���',
);


// ********************************************************
// ����ɽ��������
// XOOPS�Υե��󥯥����ϥ����С��Υ�����˰�¸���뤿�ᡢ
// �������EUC-JP������Ǥ��ʤ����˻��Ѥ��롣
// ********************************************************

define("_MD_{$MYDIRNAME}_Y",'ǯ');
define("_MD_{$MYDIRNAME}_M",'��');
define("_MD_{$MYDIRNAME}_D",'��');

$week = array("��","��","��","��","��","��","��");
setlocale(LC_ALL, 'ja_JP.eucJP' ) ;

?>