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
define("_MI_{$MYDIRNAME}_MD_DESC", "マルチカテゴリー辞典");

// Sub menus in main menu block
define("_MI_{$MYDIRNAME}_SUB_SMNAME0", "管理メニュー");
define("_MI_{$MYDIRNAME}_SUB_SMNAME1", "データ追加");
define("_MI_{$MYDIRNAME}_SUB_SMNAME2", "リクエスト");
define("_MI_{$MYDIRNAME}_SUB_SMNAME3", "データ検索");

// A brief description of this module
define("_MI_{$MYDIRNAME}_PERPAGE", "01.管理画面１ページあたりの語数");
define("_MI_{$MYDIRNAME}_PERPAGEDSC", "指定した語数ごとに改ページします。");

define("_MI_{$MYDIRNAME}_PERPAGEINDEX", "02.閲覧画面１ページあたりの語数");
define("_MI_{$MYDIRNAME}_PERPAGEINDEXDSC", "指定した語数ごとに改ページします。");

define("_MI_{$MYDIRNAME}_ALLOWREQ", "03.ゲストからのリクエストを受けますか？");
define("_MI_{$MYDIRNAME}_ALLOWREQDSC", "いたずらを考慮してください。");

define("_MI_{$MYDIRNAME}_REQREPLY", "04.リクエストに対して自動返信しますか？");
define("_MI_{$MYDIRNAME}_REQREPLYDSC", "「リクエストありがとう」という内容ですが、架空のメールアドレスを入力されるなどのいたずらを考慮してください。");

define("_MI_{$MYDIRNAME}_ALLOWSUBMIT", "05.ユーザーがデータを追加できるようにしますか？");
define("_MI_{$MYDIRNAME}_ALLOWSUBMITDSC", "どちらを選んでもゲストはリクエストしかできません。");

define("_MI_{$MYDIRNAME}_AUTOAPPROVE", "06.ユーザーからのデータ追加を自動承認しますか？");
define("_MI_{$MYDIRNAME}_AUTOAPPROVEDSC", "「いいえ」を選ぶと、あなたが承認しなければ公開されません。");

define("_MI_{$MYDIRNAME}_DHTMLUSE", "07.ユーザーのデータ追加時に管理者と同じフォームを使用させますか？");
define("_MI_{$MYDIRNAME}_DHTMLUSEDSC", "「はい」を選び、イメージマネージャを登録ユーザーに開放すると登録ユーザーも画像をアップすることが可能となります。");

define("_MI_{$MYDIRNAME}_MULTICATS", "08.用途ごとの分類（カテゴリー）を使用しますか？");
define("_MI_{$MYDIRNAME}_MULTICATSDSC", "「いいえ」を選ぶと分類できません。");

define("_MI_{$MYDIRNAME}_CATSINMENU","09.メニューに分類（カテゴリー）を表示しますか？");
define("_MI_{$MYDIRNAME}_CATSINMENUDSC","「はい」を選ぶとメインメニューの中に表示します。");

define("_MI_{$MYDIRNAME}_ALLOWADMINHITS", "10.管理者が見ても閲覧回数を上げますか？");
define("_MI_{$MYDIRNAME}_ALLOWADMINHITSDSC", "「はい」を選ぶと、管理者が見てもカウンター値が増えます。");

define("_MI_{$MYDIRNAME}_MAILTOADMIN", "11.投稿があったことをメールで知らせますか？");
define("_MI_{$MYDIRNAME}_MAILTOADMINDSC", "ゲストのリクエスト、ユーザーのデータ追加がある都度管理者にメールをします。");

define("_MI_{$MYDIRNAME}_RANDOMLENGTH", "12.説明文の一部を表示するときの長さ");
define("_MI_{$MYDIRNAME}_RANDOMLENGTHDSC", "見出し語の詳細を表示するページ以外では説明文が省略されます。そのときの文字（バイト）数を指定してください。（初期値：100）");

define("_MI_{$MYDIRNAME}_LINKTERMS", "13.自動参照リンク（仮）機能を使いますか？");
define("_MI_{$MYDIRNAME}_LINKTERMSDSC", "説明文の中に「他の見出し語」があったとき、その見出し語のページへ自動的にリンクを張ります。英数はシングルクオート、ダブルクオートでくくってください。日本語は 14. で設定できます。<a href='".XOOPS_URL."/modules/$mydirname/admin/pluginlist.php' target='_blank'>プラグイン対応状況</a>");
define("_MI_{$MYDIRNAME}_LINKTERMSOP0DSC", "使用しない");
define("_MI_{$MYDIRNAME}_LINKTERMSOP1DSC", "Xwords だけを対象に使用する（複製も含む）");
define("_MI_{$MYDIRNAME}_LINKTERMSOP2DSC", "Xwords とプラグインのあるモジュールを対象に使用する");
define("_MI_{$MYDIRNAME}_LINKTERMSOP3DSC", "検索できるモジュールすべてを対象に使用する");

define("_MI_{$MYDIRNAME}_SPATTERN", "14.自動参照リンク（仮）機能用文字群");
define("_MI_{$MYDIRNAME}_SPATTERNDSC", "13.で使用する自動的に検索する語を指定するための文字をコードで記入してください。語の先頭を指定する文字群と語尾を指定する文字群をカンマ（ , ）で分ける必要があります。※テスト中です。このまま変更しないことをおすすめします。初期値：\\xA1[\\xAE\\xC6\\xC8\\xCC\\xCE\\xD0\\xD2\\xD4\\xD6\\xD8\\xDA] , \\xA1[\\xAD\\xC7\\xC9\\xCD\\xCF\\xD1\\xD3\\xD5\\xD7\\xD9\\xDB]");
define("_MI_{$MYDIRNAME}_SPATTERNDEFAULT", "\xA1[\xAE\xC6\xC8\xCC\xCE\xD0\xD2\xD4\xD6\xD8\xDA],\xA1[\xAD\xC7\xC9\xCD\xCF\xD1\xD3\xD5\xD7\xD9\xDB]");

define("_MI_{$MYDIRNAME}_LINKTERMSPOSI", "15.作成されたリンクを本文の中に表示しますか？");
define("_MI_{$MYDIRNAME}_LINKTERMSPOSIDSC", "「いいえ」を選ぶと本文の下に羅列し、「はい」を選ぶと本文の中、該当語の前にアイコンを表示します。");

define("_MI_{$MYDIRNAME}_LINKTERMSTITLE", "16.自動参照リンクタイトル");
define("_MI_{$MYDIRNAME}_LINKTERMSTITLEDSC", "自動的に作成されたリンクにタイトルをつけます。");
define("_MI_{$MYDIRNAME}_LINKTERMSDEFAULTTITLE", "関連記事：");

define("_MI_{$MYDIRNAME}_FILETYPES", "17.アップ可能なファイルの拡張子");
define("_MI_{$MYDIRNAME}_FILETYPESDSC", "半角のスペースで区切ってください。記入すると管理者のデータ入力フォームでファイルマネージャーとは別のアップロードプログラムが使えるようになります。（例：gif jpg png）");

define("_MI_{$MYDIRNAME}_UPLOADMAX", "18.アップ可能な最大ファイルサイズ");
define("_MI_{$MYDIRNAME}_UPLOADMAXDSC", "17.を設定した場合に有効。単位：KB（初期値：300KB）");

define("_MI_{$MYDIRNAME}_AMAZON", "19.アマゾンのID（所有している場合）");
define("_MI_{$MYDIRNAME}_AMAZONDSC", "記入するとアップロードプログラムで「アマゾンへのリンクを作成する」オプションが追加されます。また、ライブリンクや個別商品リンクにも使用します。");

define("_MI_{$MYDIRNAME}_README", "20.トップページに目的などを表示しますか？");
define("_MI_{$MYDIRNAME}_READMEDSC", "どんな言葉を収録しているとか。空欄でも結構です。");
define("_MI_{$MYDIRNAME}_READMEDEF", "当サイトで使用している言葉、関連のある言葉を解説します。");

define("_MI_{$MYDIRNAME}_TITLEBLOCKUSE", "21.タイトルを表示しますか？");
define("_MI_{$MYDIRNAME}_TITLEBLOCKUSEDSC", "「いいえ」を選び、画像ファイルも使用しないと何も表示しません。");

define("_MI_{$MYDIRNAME}_H1ID", "22.タイトルに画像ファイルを使いますか？");
define("_MI_{$MYDIRNAME}_H1IDDSC", "空欄にし、21.を「はい」にすると、メインメニューと同じタイトルを文字で表示します。画像ファイルはimagesフォルダに置いてください。（初期値：xwords_titlelogo.gif）");

define("_MI_{$MYDIRNAME}_STRFFORMAT", "23.時間のフォーマット");
define("_MI_{$MYDIRNAME}_STRFFORMATDSC", "語の詳細ページで表示される投稿日の形式を変更できます。PHPのstrftime()関数を使用。書き方は、<a href='http://jp.php.net/manual/ja/function.strftime.php' target='_blank'>PHPマニュアル</a>をごらんください。初期値（空欄）：**年**月**日（曜日）");
//define("_MI_{$MYDIRNAME}_STRFFORMAT1", "0");
//define("_MI_{$MYDIRNAME}_STRFFORMATDSC1", "strftime()関数を使わない");
//define("_MI_{$MYDIRNAME}_STRFFORMAT2", "%Y年%m月%d日（%a）");
//define("_MI_{$MYDIRNAME}_STRFFORMATDSC2", "%Y年%m月%d日（%a） - ロケールに基づく**年**月**日（曜日）");
//define("_MI_{$MYDIRNAME}_STRFFORMAT3", "%x");
//define("_MI_{$MYDIRNAME}_STRFFORMATDSC3", "%x - ロケールに基づく時間を除いた日付");
//define("_MI_{$MYDIRNAME}_STRFFORMAT4", "%c");
//define("_MI_{$MYDIRNAME}_STRFFORMATDSC4", "%c - ロケールに基づく適当な日付と時間");

define("_MI_{$MYDIRNAME}_Y","年");
define("_MI_{$MYDIRNAME}_M","月");
define("_MI_{$MYDIRNAME}_D","日");
define("_MI_{$MYDIRNAME}_L", "（");
define("_MI_{$MYDIRNAME}_R", "）");

define("_MI_{$MYDIRNAME}_LETTERFORMAT", "23.頭文字別リンクのフォーマット");
define("_MI_{$MYDIRNAME}_LETTERFORMATDSC", "集計方法を変更できます。先頭の数字は、language/japanese/letter_format**.phpの**に対応。ここにない集計方法にしたい場合は、このletter_format**.phpを書きかえてください。");
define("_MI_{$MYDIRNAME}_LETTERFORMAT01", "01.アルファベット＋五十音＋その他（ローマ字の読みも五十音でカウント）");
define("_MI_{$MYDIRNAME}_LETTERFORMAT02", "02.アルファベット＋文字種＋五十音（ローマ字の読みも五十音でカウント）");
define("_MI_{$MYDIRNAME}_LETTERFORMAT03", "03.五十音＋文字種（ローマ字の読みも五十音でカウント）");
define("_MI_{$MYDIRNAME}_LETTERFORMAT04", "04.五十音のみ（ローマ字の読みも五十音でカウント）");
define("_MI_{$MYDIRNAME}_LETTERFORMAT05", "05.アルファベット＋五十音＋その他（ローマ字の読みは五十音に入れない）");
define("_MI_{$MYDIRNAME}_LETTERFORMAT06", "06.アルファベット＋文字種＋五十音（ローマ字の読みは五十音に入れない）");
define("_MI_{$MYDIRNAME}_LETTERFORMAT07", "07.五十音＋文字種（ローマ字の読みは五十音に入れない）");
define("_MI_{$MYDIRNAME}_LETTERFORMAT08", "08.五十音のみ（ローマ字の読みは五十音に入れない）");
define("_MI_{$MYDIRNAME}_LETTERFORMAT09", "09.五十音のみ（行ごとではなく、あ、い、う〜）");
define("_MI_{$MYDIRNAME}_LETTERFORMAT10", "10.数字＋アルファベット＋五十音＋その他");
define("_MI_{$MYDIRNAME}_LETTERFORMAT11", "11.見出し語のイニシャルを記録しない（テスト中）");

define("_MI_{$MYDIRNAME}_SUBMITTERLINK", "25.投稿者名にUSERINFO.PHPへのリンクを張りますか？");
define("_MI_{$MYDIRNAME}_SUBMITTERLINKDSC", "USERINFO.PHPとは投稿者の基本情報などを表示するページのことです。");

define("_MI_{$MYDIRNAME}_CATSARRAYUSE", "26.カテゴリーの一覧をトップページだけに表示しますか？");
define("_MI_{$MYDIRNAME}_CATSARRAYUSEDSC", "「はい」にすると、トップページにカテゴリーの詳細を表示、イニシャル別一覧を表示しません。「いいえ」にすると、カテゴリー名だけになり、イニシャル別一覧を表示します。");

define("_MI_{$MYDIRNAME}_BLOCKSPERPAGE", "27.トップとカテゴリーページに表示する新着、人気の数");
define("_MI_{$MYDIRNAME}_BLOCKSPERPAGEDSC", "ゼロにすると表示しません。初期値：5");

// Names of admin menu items
define("_MI_{$MYDIRNAME}_ADMENU1", "メイン");
define("_MI_{$MYDIRNAME}_ADMENU2", "カテゴリー");
define("_MI_{$MYDIRNAME}_ADMENU3", "エントリー");
define("_MI_{$MYDIRNAME}_ADMENU4", "ブロック・グループ");
define("_MI_{$MYDIRNAME}_ADMENU5", "承認");
define("_MI_{$MYDIRNAME}_ADMENU6", "モジュールに行く");

//Names of Blocks and Block information
define("_MI_{$MYDIRNAME}_ENTRIESNEW", "新着ブロック");
define("_MI_{$MYDIRNAME}_ENTRIESTOP", "人気ブロック");
define("_MI_{$MYDIRNAME}_RANDOMTERM", "ランダムブロック");
define("_MI_{$MYDIRNAME}_TERMINITIAL", "頭文字ブロック");
define("_MI_{$MYDIRNAME}_COMBLOCK", "D3コメントブロック");

//define("_MI_{$MYDIRNAME}_NOTUJIS", "MYSQLの環境が default-character-set = %s です。<br />XOOPSを使用する上で支障があるかもしれません。");

//d3comment integration
define("_MI_{$MYDIRNAME}_COM_DIRNAME","コメント統合するd3forumのdirname");
define("_MI_{$MYDIRNAME}_COM_DIRNAMEDSC","d3forumのコメント統合機能を使用する場合は<br/>フォーラムのhtml側ディレクトリ名を指定します。<br/>xoopsコメントを使用する場合やコメント機能を無効にする場合は空欄です。");
define("_MI_{$MYDIRNAME}_COM_FORUM_ID","コメント統合するフォーラムの番号");
define("_MI_{$MYDIRNAME}_COM_FORUM_IDDSC","コメント統合を選択した場合、forum_idを必ず指定してください。");
define("_MI_{$MYDIRNAME}_COM_ORDER","コメント統合の表示順序");
define("_MI_{$MYDIRNAME}_COM_ORDERDSC","コメント統合を選択した場合の、コメントの新しい順／古い順を指定できます。");
define("_MI_{$MYDIRNAME}_COM_VIEW","コメント統合の表示方法");
define("_MI_{$MYDIRNAME}_COM_VIEWDSC","フラット表示かスレッド表示かを選択します。");
define("_MI_{$MYDIRNAME}_COM_POSTSNUM","コメント統合のフラット表示における最大表示件数");

?>