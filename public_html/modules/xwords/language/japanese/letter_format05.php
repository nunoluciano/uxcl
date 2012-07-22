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
	"^([^\x21-\x7e]{2}|[\x21-\x7e]{1})(A|a)",
	"^([^\x21-\x7e]{2}|[\x21-\x7e]{1})(B|b)",
	"^([^\x21-\x7e]{2}|[\x21-\x7e]{1})(C|c)",
	"^([^\x21-\x7e]{2}|[\x21-\x7e]{1})(D|d)",
	"^([^\x21-\x7e]{2}|[\x21-\x7e]{1})(E|e)",
	"^([^\x21-\x7e]{2}|[\x21-\x7e]{1})(F|f)",
	"^([^\x21-\x7e]{2}|[\x21-\x7e]{1})(G|g)",
	"^([^\x21-\x7e]{2}|[\x21-\x7e]{1})(H|h)",
	"^([^\x21-\x7e]{2}|[\x21-\x7e]{1})(I|i)",
	"^([^\x21-\x7e]{2}|[\x21-\x7e]{1})(J|j)",
	"^([^\x21-\x7e]{2}|[\x21-\x7e]{1})(K|k)",
	"^([^\x21-\x7e]{2}|[\x21-\x7e]{1})(L|l)",
	"^([^\x21-\x7e]{2}|[\x21-\x7e]{1})(M|m)",
	"^([^\x21-\x7e]{2}|[\x21-\x7e]{1})(N|n)",
	"^([^\x21-\x7e]{2}|[\x21-\x7e]{1})(O|o)",
	"^([^\x21-\x7e]{2}|[\x21-\x7e]{1})(P|p)",
	"^([^\x21-\x7e]{2}|[\x21-\x7e]{1})(Q|q)",
	"^([^\x21-\x7e]{2}|[\x21-\x7e]{1})(R|r)",
	"^([^\x21-\x7e]{2}|[\x21-\x7e]{1})(S|s)",
	"^([^\x21-\x7e]{2}|[\x21-\x7e]{1})(T|t)",
	"^([^\x21-\x7e]{2}|[\x21-\x7e]{1})(U|u)",
	"^([^\x21-\x7e]{2}|[\x21-\x7e]{1})(V|v)",
	"^([^\x21-\x7e]{2}|[\x21-\x7e]{1})(W|w)",
	"^([^\x21-\x7e]{2}|[\x21-\x7e]{1})(X|x)",
	"^([^\x21-\x7e]{2}|[\x21-\x7e]{1})(Y|y)",
	"^([^\x21-\x7e]{2}|[\x21-\x7e]{1})(Z|z)",
	"^(��|��|��|��|��|��|��|��|��|��|��|��|��|��|��|��|��|��|��|��).*",
	"^(��|��|��|��|��|��|��|��|��|��|��|��|��|��|��|��|��|��|��|��|��|��).*",
	"^(��|��|��|��|��|��|��|��|��|��|��|��|��|��|��|��|��|��|��|��).*",
	"^(��|��|��|��|��|��|��|��|��|��|��|��|��|��|��|��|��|��|��|��|��|��).*",
	"^(��|��|��|��|��|��|��|��|��|��).*",
	"^(��|��|��|��|��|��|��|��|��|��|��|��|��|��|��|��|��|��|��|��|��|��|��|��|��|��|��|��|��|��).*",
	"^(��|��|��|��|��|��|��|��|��|��).*",
	"^(��|��|��|��|��|��|��|��|��|��|��|��).*",
	"^(��|��|��|��|��|��|��|��|��|��).*",
	"^(��|��|��|��|��|��|��).*",
	"^([^\x21-\x7e]{2}|[\x21-\x7e]{1})([!-@\[-`{-~])",
	constant("_MD_{$MYDIRNAME}_ALL_INIT"),
);

$mb_id = array(
	"A","B","C","D","E","F","G","H","I","J","K","L","M",
	"N","O","P","Q","R","S","T","U","V","W","X","Y","Z",
	"01","02","03","04","05","06","07","08","09","10",
	"11",constant("_MD_{$MYDIRNAME}_ALL_ID"),
);

$mb_linktext = array(
	"A","B","C","D","E","F","G","H","I","J","K","L","M",
	"N","O","P","Q","R","S","T","U","V","W","X","Y","Z",
	"����","����","����","����","�ʹ�","�Ϲ�","�޹�","���","���","���",
	"����¾",constant("_MD_{$MYDIRNAME}_ALL_LINKTEXT"),
);

$mb_separator = array(
	"","��","��","��","��","��","��","��","��","��","��","��","��",
	"��","��","��","��","��","��","��","��","��","��","��","��","��","<br />",
	"��","��","��","��","��","��","��","��","��","��","��","��",
);

?>