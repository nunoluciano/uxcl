<?php

if( defined( 'FOR_XOOPS_LANG_CHECKER' ) || ! defined( 'GNAVI_CNST_LOADED' ) ) {

define( 'GNAVI_CNST_LOADED' , 1 ) ;

// System Constants (Don't Edit)
define( "GNAV_GPERM_INSERTABLE" , 1 ) ;
define( "GNAV_GPERM_SUPERINSERT" , 2 ) ;
define( "GNAV_GPERM_EDITABLE" , 4 ) ;
define( "GNAV_GPERM_SUPEREDIT" , 8 ) ;
define( "GNAV_GPERM_DELETABLE" , 16 ) ;
define( "GNAV_GPERM_SUPERDELETE" , 32 ) ;
define( "GNAV_GPERM_TOUCHOTHERS" , 64 ) ;
define( "GNAV_GPERM_SUPERTOUCHOTHERS" , 128 ) ;
define( "GNAV_GPERM_RATEVIEW" , 256 ) ;
define( "GNAV_GPERM_RATEVOTE" , 512 ) ;
define( "GNAV_GPERM_WYSIWYG" , 1024 ) ;

// Global Group Permission
define( "_GNAV_GPERM_G_INSERTABLE" , "��Ʋġ��׾�ǧ��" ) ;
define( "_GNAV_GPERM_G_SUPERINSERT" , "��Ʋġʾ�ǧ���ס�" ) ;
define( "_GNAV_GPERM_G_EDITABLE" , "�Խ��ġ��׾�ǧ��" ) ;
define( "_GNAV_GPERM_G_SUPEREDIT" , "�Խ��ġʾ�ǧ���ס�" ) ;
define( "_GNAV_GPERM_G_DELETABLE" , "����ġ��׾�ǧ��" ) ;
define( "_GNAV_GPERM_G_SUPERDELETE" , "����ġʾ�ǧ���ס�" ) ;
define( "_GNAV_GPERM_G_TOUCHOTHERS" , "¾�桼���Υ��᡼�����Խ�������ġ��׾�ǧ��" ) ;
define( "_GNAV_GPERM_G_SUPERTOUCHOTHERS" , "¾�桼���Υ��᡼�����Խ�������ġʾ�ǧ���ס�" ) ;
define( "_GNAV_GPERM_G_RATEVIEW" , "��ɼ������" ) ;
define( "_GNAV_GPERM_G_RATEVOTE" , "��ɼ��" ) ;
define( "_GNAV_GPERM_G_WYSIWYG" , "WYSIWYG���Խ���" ) ;

// Caption
define( "_GNAV_CAPTION_TOTAL" , "Total:" ) ;
define( "_GNAV_CAPTION_GUESTNAME" , "������" ) ;
define( "_GNAV_CAPTION_REFRESH" , "����" ) ;
define( "_GNAV_CAPTION_IMAGEXYT" , "������" ) ;
define( "_GNAV_CAPTION_CATEGORY" , "���ƥ��꡼" ) ;

	// encoding conversion if possible and needed
	function gnavi_callback_after_stripslashes_local( $text )
	{
		if( function_exists( 'mb_convert_encoding' ) && mb_internal_encoding() !=  mb_http_output() ) {
			return mb_convert_encoding( $text , mb_internal_encoding() , mb_detect_order() ) ;
		} else {
			return $text ;
		}
	}

}

?>
