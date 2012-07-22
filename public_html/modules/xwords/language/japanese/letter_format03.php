<?php
//  ------------------------------------------------------------------------ //
//  This program is free software; you can redistribute it and/or modify     //
//  it under the terms of the GNU General Public License as published by     //
//  the Free Software Foundation; either version 2 of the License, or        //
//  (at your option) any later version.                                      //
//                                                                           //
//  You may not change or alter any portion of this comment or credits       //
//  of supporting developers from this source code or any supporting         //
//  source code which is considered copyrighted (c) material of the          //
//  original comment or credit authors.                                      //
//                                                                           //
//  This program is distributed in the hope that it will be useful,          //
//  but WITHOUT ANY WARRANTY; without even the implied warranty of           //
//  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the            //
//  GNU General Public License for more details.                             //
//                                                                           //
//  You should have received a copy of the GNU General Public License        //
//  along with this program; if not, write to the Free Software              //
//  Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307 USA //
//  ------------------------------------------------------------------------ //
// XOOPS2 - Xwords 0.42
// WEBMASTER @ KANPYO.NET, 2005.

$MYDIRNAME = strtoupper(basename(dirname(dirname(dirname(__FILE__)))));
if (!defined("_MD_{$MYDIRNAME}_ALL_INIT"))
	{
	define("_MD_{$MYDIRNAME}_ALL_LINKTEXT", "���٤�");
	define("_MD_{$MYDIRNAME}_ALL_ID", "");
	define("_MD_{$MYDIRNAME}_ALL_INIT", "^.*");
	}

// **************************************************************************
// ����ե��٥åȡ��޽����ʤɡ�Ƭʸ���ˤ�륤��ǥå�����������뤿��Υǡ���
// $mb_init = �����ѡ�$mb_id = POST�ѡ�$mb_linktext = ɽ����
// $mb_separator = ����ǥå����֤ζ��ڤ�ʸ����
// �ѹ�����Ȥ��ϡ����Ĥ�����ο����碌�뤳�ȡ��ʡ�,�פ�Ʊ���ˤ����
// **************************************************************************


$mb_init = array(
	"^(��|��|��|��|��|��|��|��|��|��|��|��|��|��|��|��|��|��|��|��|a|A|i|I|u|U|e|E|o|O).*",
	"^(��|��|��|��|��|��|��|��|��|��|��|��|��|��|��|��|��|��|��|��|��|��|k|K|g|G).*",
	"^(��|��|��|��|��|��|��|��|��|��|��|��|��|��|��|��|��|��|��|��|s|S|z|Z|j|J).*",
	"^(��|��|��|��|��|��|��|��|��|��|��|��|��|��|��|��|��|��|��|��|��|��|t|T|d|D|c|C).*",
	"^(��|��|��|��|��|��|��|��|��|��|n|N).*",
	"^(��|��|��|��|��|��|��|��|��|��|��|��|��|��|��|��|��|��|��|��|��|��|��|��|��|��|��|��|��|��|h|H|b|B|v|V|p|P).*",
	"^(��|��|��|��|��|��|��|��|��|��|m|M).*",
	"^(��|��|��|��|��|��|��|��|��|��|��|��|y|Y).*",
	"^(��|��|��|��|��|��|��|��|��|��|r|R).*",
	"^(��|��|��|��|��|��|��|w|W).*",
	"([^\x21-\x7e]{2}|[\x21-\x7e]{1})(\xA4[\xA1-\xF3])",
	"([^\x21-\x7e]{2}|[\x21-\x7e]{1})(\xA5[\xA1-\xF6]|��|��|��|��|��|��|��|��|��|��|��|��|��|��|��|��|��|��|��|��|��|��|��|��|��|��|��|��|��|��|��|��|��|��|��|��|��|��|��|��|��|��|��|��|��|��|��|��|��|��|��|��|��|��|��|��)",
	"([^\x21-\x7e]{2}|[\x21-\x7e]{1})([A-Za-z]|\xA3[\xC1-\xFA])",
	"([^\x21-\x7e]{2}|[\x21-\x7e]{1})([0-9]|\xA3[\xB0-\xB9])",
	"([^\x21-\x7e]{2}|[\x21-\x7e]{1})([\xA1-\xA2][\xA1-\xFE]|[\x21-\x2F]|[\x3A-\x40]|[\x5B-\x60]|[\x7B-\x7E]|��|��|��|��|��|��|��|[\xA6-\xA8][\xA1-\xFE]|\xAD[\xA1-\xFE])",
	"([^\x21-\x7e]{2}|[\x21-\x7e]{1})([\xB0-\xF4][\xA1-\xFF])",
	constant("_MD_{$MYDIRNAME}_ALL_INIT"),
);

$mb_id = array(
	"01","02","03","04","05","06","07","08","09","10",
	"11","12","13","14","15","16",constant("_MD_{$MYDIRNAME}_ALL_ID"),
);

$mb_linktext = array(
	"����","����","����","����","�ʹ�","�Ϲ�","�޹�","���","���","���",
	"�Ҥ餬��","��������","����ե��٥å�","����","����","����",
	constant("_MD_{$MYDIRNAME}_ALL_LINKTEXT"),
);

$mb_separator = array(
	"","��","��","��","��","��","��","��","��","��","<br />","��","��","��","��","��","��",
);

?>