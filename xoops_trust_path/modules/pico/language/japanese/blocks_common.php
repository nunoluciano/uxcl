<?php

// definitions for editing blocks
define("_MB_PICO_CATLIMIT","���ƥ��꡼����ꤹ��");
define("_MB_PICO_CATLIMITDSC","��ʣ�����ꤹ����ϥ��ƥ��꡼�ֹ�򥫥��(,)�Ƕ��ڤ롣���֥��ƥ��꡼�ϴޤޤʤ����Ȥ���ա�ɬ�פʤ顢�ƥ��֥��ƥ��꡼������Ū�˻��ꤹ�뤳�ȡˡ�0�ϥȥåץ��ƥ��꡼���̣���롣���ƥ��꡼����ꤷ�ʤ����϶���ˤ��롣");
define("_MB_PICO_PARENTCAT","�ƥ��ƥ��꡼");
define("_MB_PICO_PARENTCATDSC","�����ǻ��ꤵ�줿�ƥ��ƥ��꡼ľ���Υ��ƥ��꡼�Τߤ�ɽ������롣�ƥ��ƥ��꡼��ʣ�����ꤹ����ϥ��ƥ��꡼�ֹ�򥫥��(,)�Ƕ��ڤ롣");
define("_MB_PICO_SELECTORDER","ɽ����");
define("_MB_PICO_CONTENTSNUM","ɽ�����");
define("_MB_PICO_THISTEMPLATE","���Υ֥�å��Υƥ�ץ졼��");
define("_MB_PICO_DISPLAYBODY","��ʸɽ������");
define("_MB_PICO_CONTENT_ID","����ƥ���ֹ�");
define("_MB_PICO_PROCESSBODY","��ʸ��ưŪ��������");
define("_MB_PICO_TAGSNUM","����ɽ����");
define("_MB_PICO_TAGSLISTORDER","����ɽ����");
define("_MB_PICO_TAGSSQLORDER","������н�");

// LTR or RTL
if( defined( '_ADM_USE_RTL' ) ) {
	@define( '_ALIGN_START' , _ADM_USE_RTL ? 'right' : 'left' ) ;
	@define( '_ALIGN_END' , _ADM_USE_RTL ? 'left' : 'right' ) ;
} else {
	@define( '_ALIGN_START' , 'left' ) ; // change it right for RTL
	@define( '_ALIGN_END' , 'right' ) ;  // change it left for RTL
}


?>