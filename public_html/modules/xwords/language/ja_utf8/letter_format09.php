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
	define("_MD_{$MYDIRNAME}_ALL_LINKTEXT", "すべて");
	define("_MD_{$MYDIRNAME}_ALL_ID", "");
	define("_MD_{$MYDIRNAME}_ALL_INIT", "^.*");
	}

// **************************************************************************
// アルファベット、五十音など、頭文字によるインデックスを作成するためのデータ
// $mb_init = 検索用、$mb_id = POST用、$mb_linktext = 表示用
// $mb_separator = インデックス間の区切り文字。
// 変更するときは、４つの配列の数を合わせること。（「,」を同数にする）
// **************************************************************************

$mb_init = array(
	"^(あ|ア|ぁ|ァ).*",
	"^(い|イ|ぃ|ィ).*",
	"^(う|ウ|ぅ|ゥ).*",
	"^(え|エ|ぇ|ェ).*",
	"^(お|オ|ぉ|ォ).*",
	"^(か|カ|ヵ|が|ガ).*",
	"^(き|キ|ぎ|ギ).*",
	"^(く|ク|ぐ|グ).*",
	"^(け|ケ|ヶ|げ|ゲ).*",
	"^(こ|コ|ご|ゴ).*",
	"^(さ|サ|ざ|ザ).*",
	"^(し|シ|じ|ジ).*",
	"^(す|ス|ず|ズ).*",
	"^(せ|セ|ぜ|ゼ).*",
	"^(そ|ソ|ぞ|ゾ).*",
	"^(た|タ|だ|ダ).*",
	"^(ち|チ|ぢ|ヂ).*",
	"^(つ|ツ|っ|ッ|づ|ヅ).*",
	"^(て|テ|で|デ).*",
	"^(と|ト|ど|ド).*",
	"^(な|ナ).*",
	"^(に|ニ).*",
	"^(ぬ|ヌ).*",
	"^(ね|ネ).*",
	"^(の|ノ).*",
	"^(は|ハ|ば|バ|ぱ|パ).*",
	"^(ひ|ヒ|び|ビ|ぴ|ピ).*",
	"^(ふ|フ|ぶ|ブ|ぷ|ヴ).*",
	"^(へ|ヘ|べ|ベ|ぺ|ペ).*",
	"^(ほ|ホ|ぼ|ボ|ぽ|ポ).*",
	"^(ま|マ).*",
	"^(み|ミ).*",
	"^(む|ム).*",
	"^(め|メ).*",
	"^(も|モ).*",
	"^(や|ヤ|ゃ|ャ).*",
	"^(ゆ|ユ|ゅ|ュ).*",
	"^(よ|ヨ|ょ|ョ).*",
	"^(ら|ラ).*",
	"^(り|リ).*",
	"^(る|ル).*",
	"^(れ|レ).*",
	"^(ろ|ロ).*",
	"^(わ|ワ|ヮ|を|ヲ|ん|ン).*",
	constant("_MD_{$MYDIRNAME}_ALL_INIT"),
);

$mb_id = array(
	"01","02","03","04","05","06","07","08","09","10","11","12","13","14","15",
	"16","17","18","19","20","21","22","23","24","25","26","27","28","29","30",
	"31","32","33","34","35","36","37","38","39","40","41","42","43","44",
	constant("_MD_{$MYDIRNAME}_ALL_ID"),
);

$mb_linktext = array(
	"あ","い","う","え","お","か","き","く","け","こ","さ","し","す","せ","そ",
	"た","ち","つ","て","と","な","に","ぬ","ね","の","は","ひ","ふ","へ","ほ",
	"ま","み","む","め","も","や","ゆ","よ","ら","り","る","れ","ろ","わ・ん",
	constant("_MD_{$MYDIRNAME}_ALL_LINKTEXT"),
);

$mb_separator = array(
	"","　","　","　","　","　","　","　","　","　","　","　","　","　","　",
	"　","　","　","　","　","　","　","　","　","　","　","　","　","　","　",
	"　","　","　","　","　","　","　","　","　","　","　","　","　","　","　",
);

?>