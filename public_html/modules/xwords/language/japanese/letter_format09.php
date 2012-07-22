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
	"^(��|��|��|��).*",
	"^(��|��|��|��).*",
	"^(��|��|��|��).*",
	"^(��|��|��|��).*",
	"^(��|��|��|��).*",
	"^(��|��|��|��|��).*",
	"^(��|��|��|��).*",
	"^(��|��|��|��).*",
	"^(��|��|��|��|��).*",
	"^(��|��|��|��).*",
	"^(��|��|��|��).*",
	"^(��|��|��|��).*",
	"^(��|��|��|��).*",
	"^(��|��|��|��).*",
	"^(��|��|��|��).*",
	"^(��|��|��|��).*",
	"^(��|��|��|��).*",
	"^(��|��|��|��|��|��).*",
	"^(��|��|��|��).*",
	"^(��|��|��|��).*",
	"^(��|��).*",
	"^(��|��).*",
	"^(��|��).*",
	"^(��|��).*",
	"^(��|��).*",
	"^(��|��|��|��|��|��).*",
	"^(��|��|��|��|��|��).*",
	"^(��|��|��|��|��|��).*",
	"^(��|��|��|��|��|��).*",
	"^(��|��|��|��|��|��).*",
	"^(��|��).*",
	"^(��|��).*",
	"^(��|��).*",
	"^(��|��).*",
	"^(��|��).*",
	"^(��|��|��|��).*",
	"^(��|��|��|��).*",
	"^(��|��|��|��).*",
	"^(��|��).*",
	"^(��|��).*",
	"^(��|��).*",
	"^(��|��).*",
	"^(��|��).*",
	"^(��|��|��|��|��|��|��).*",
	constant("_MD_{$MYDIRNAME}_ALL_INIT"),
);

$mb_id = array(
	"01","02","03","04","05","06","07","08","09","10","11","12","13","14","15",
	"16","17","18","19","20","21","22","23","24","25","26","27","28","29","30",
	"31","32","33","34","35","36","37","38","39","40","41","42","43","44",
	constant("_MD_{$MYDIRNAME}_ALL_ID"),
);

$mb_linktext = array(
	"��","��","��","��","��","��","��","��","��","��","��","��","��","��","��",
	"��","��","��","��","��","��","��","��","��","��","��","��","��","��","��",
	"��","��","��","��","��","��","��","��","��","��","��","��","��","���",
	constant("_MD_{$MYDIRNAME}_ALL_LINKTEXT"),
);

$mb_separator = array(
	"","��","��","��","��","��","��","��","��","��","��","��","��","��","��",
	"��","��","��","��","��","��","��","��","��","��","��","��","��","��","��",
	"��","��","��","��","��","��","��","��","��","��","��","��","��","��","��",
);

?>