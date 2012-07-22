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
	"^(あ|ア|ぁ|ァ|い|イ|ぃ|ィ|う|ウ|ぅ|ゥ|え|エ|ぇ|ェ|お|オ|ぉ|ォ).*",
	"^(か|カ|ヵ|が|ガ|き|キ|ぎ|ギ|く|ク|ぐ|グ|け|ケ|ヶ|げ|ゲ|こ|コ|ご|ゴ).*",
	"^(さ|サ|ざ|ザ|し|シ|じ|ジ|す|ス|ず|ズ|せ|セ|ぜ|ゼ|そ|ソ|ぞ|ゾ).*",
	"^(た|タ|だ|ダ|ち|チ|ぢ|ヂ|つ|ツ|っ|ッ|づ|ヅ|て|テ|で|デ|と|ト|ど|ド).*",
	"^(な|ナ|に|ニ|ぬ|ヌ|ね|ネ|の|ノ).*",
	"^(は|ハ|ば|バ|ぱ|パ|ひ|ヒ|び|ビ|ぴ|ピ|ふ|フ|ぶ|ブ|ぷ|へ|ヘ|べ|ベ|ぺ|ペ|ほ|ホ|ぼ|ボ|ぽ|ポ|ヴ).*",
	"^(ま|マ|み|ミ|む|ム|め|メ|も|モ).*",
	"^(や|ヤ|ゃ|ャ|ゆ|ユ|ゅ|ュ|よ|ヨ|ょ|ョ).*",
	"^(ら|ラ|り|リ|る|ル|れ|レ|ろ|ロ).*",
	"^(わ|ワ|ヮ|を|ヲ|ん|ン).*",
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
	"あ行","か行","さ行","た行","な行","は行","ま行","や行","ら行","わ・ん",
	"その他",constant("_MD_{$MYDIRNAME}_ALL_LINKTEXT"),
);

$mb_separator = array(
	"","　","　","　","　","　","　","　","　","　","　","　","　",
	"　","　","　","　","　","　","　","　","　","　","　","　","　","<br />",
	"　","　","　","　","　","　","　","　","　","　","　","　",
);

?>