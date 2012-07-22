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
define("_AM_{$MYDIRNAME}_INDEX", "データ管理メインメニュー");
define("_AM_{$MYDIRNAME}_INVENTORY", "登録状況");
define("_AM_{$MYDIRNAME}_TOTALENTRIES", "見出し語数： ");
define("_AM_{$MYDIRNAME}_TOTALCATS", "用途別分類数： ");
define("_AM_{$MYDIRNAME}_TOTALSUBM", "未承認ユーザー投稿数： ");
define("_AM_{$MYDIRNAME}_TOTALREQ", "未承認リクエスト数： ");
define("_AM_{$MYDIRNAME}_GOAUTHORIZE", "要承認処理");
define("_AM_{$MYDIRNAME}_SHOWENTRIES", "見出し語");
define("_AM_{$MYDIRNAME}_CREATEENTRY", "追加");
define("_AM_{$MYDIRNAME}_ENTRYID", "ID");
define("_AM_{$MYDIRNAME}_ENTRYCATNAME", "分類名");
define("_AM_{$MYDIRNAME}_ENTRYTERM", "見出し語");
define("_AM_{$MYDIRNAME}_SUBMITTER", "投稿者");
define("_AM_{$MYDIRNAME}_ENTRYCREATED", "投稿日");
define("_AM_{$MYDIRNAME}_STATUS", "状況");
define("_AM_{$MYDIRNAME}_ACTION", "編集・削除");
define("_AM_{$MYDIRNAME}_EDITENTRY", "編集");
define("_AM_{$MYDIRNAME}_DELETEENTRY", "削除");
define("_AM_{$MYDIRNAME}_ENTRYISOFF", "書きかけ");
define("_AM_{$MYDIRNAME}_ENTRYISON", "公開中");
define("_AM_{$MYDIRNAME}_ENTRYISFUTURE", "公開予定");
define("_AM_{$MYDIRNAME}_NOTERMS", "何も登録されていません");
define("_AM_{$MYDIRNAME}_SHOWCATS", "用途別分類（カテゴリー）");
define("_AM_{$MYDIRNAME}_CREATECAT", "追加");
define("_AM_{$MYDIRNAME}_WEIGHT", "表示の順番");
define("_AM_{$MYDIRNAME}_CATNAME", "分類名");
define("_AM_{$MYDIRNAME}_DESCRIP", "用途");
define("_AM_{$MYDIRNAME}_EDITCAT", "編集");
define("_AM_{$MYDIRNAME}_DELETECAT", "削除");
define("_AM_{$MYDIRNAME}_NOCATS", "分類されていません");
define("_AM_{$MYDIRNAME}_EDITSUBM", "編集");
define("_AM_{$MYDIRNAME}_DELETESUBM", "削除");
define("_AM_{$MYDIRNAME}_NOSUBMISSYET", "承認を待つ投稿はありません");
define("_AM_{$MYDIRNAME}_SHOWREQUESTS", "閲覧者からのリクエスト");
define("_AM_{$MYDIRNAME}_NOREQSYET", "リクエストはありません");
define("_AM_{$MYDIRNAME}_NOTUJIS", "MYSQLの環境が default-character-set = %s です。<br />XOOPSを使用する上で支障があるかもしれません。");


// category.php
define("_AM_{$MYDIRNAME}_NOCATTOEDIT", "カテゴリーの作成はできません");
define("_AM_{$MYDIRNAME}_CATS", "用途別分類（カテゴリー）");
define("_AM_{$MYDIRNAME}_CATSHEADER", "用途別分類（カテゴリー）編集");
define("_AM_{$MYDIRNAME}_NEWCAT", "用途別分類（カテゴリー）を追加");
define("_AM_{$MYDIRNAME}_CATDESCRIPT", "用途解説");
define("_AM_{$MYDIRNAME}_CATPOSIT", "表示順");
//define("_AM_{$MYDIRNAME}_AMAZONTAG", "アマゾンタグ");
define("_AM_{$MYDIRNAME}_CREATE", "作成");
define("_AM_{$MYDIRNAME}_CLEAR", "クリア");
define("_AM_{$MYDIRNAME}_CANCEL", "キャンセル");
define("_AM_{$MYDIRNAME}_MODCAT", "修正するカテゴリー");
define("_AM_{$MYDIRNAME}_MODIFY", "修正");
define("_AM_{$MYDIRNAME}_DELETE", "削除");
define("_AM_{$MYDIRNAME}_DELETETHISCAT", "このカテゴリーを削除してもよろしいですか？<br />このカテゴリーで登録されている見出し語とそのコメントも<br />すべて削除されますので御注意ください。");
define("_AM_{$MYDIRNAME}_CATISDELETED", "%s は削除されました");
define("_AM_{$MYDIRNAME}_CATCREATED", "新しいカテゴリーは、無事に作成されました！");
define("_AM_{$MYDIRNAME}_NOTUPDATED", "エラーのためデータベースを更新できませんでした");
define("_AM_{$MYDIRNAME}_CATMODIFIED", "無事修正されました！");
define("_AM_{$MYDIRNAME}_BACK2IDX", "キャンセルしました");
define("_AM_{$MYDIRNAME}_SINGLECAT", "複数の用途別分類（カテゴリー）を使うように設定されていません。「一般設定」を御確認ください。");
define("_AM_{$MYDIRNAME}_NOCAT", "該当の用途別分類（カテゴリー）はありません");
define("_AM_{$MYDIRNAME}_OPENDATA", "語数");


// entry.php
define("_AM_{$MYDIRNAME}_NEWENTRY", "追加する内容");
define("_AM_{$MYDIRNAME}_WRITEHERE", "ここに説明文を書いてください。");
define("_AM_{$MYDIRNAME}_NOENTRYTOEDIT", "登録されていません。");
define("_AM_{$MYDIRNAME}_ENTRIES", "見出し語・説明文");
define("_AM_{$MYDIRNAME}_ADMINENTRYMNGMT", "追加");
define("_AM_{$MYDIRNAME}_NEEDONECOLUMN", "まず、用途別分類（カテゴリー）を作成してください。");
define("_AM_{$MYDIRNAME}_AUTHOR", "著者");
define("_AM_{$MYDIRNAME}_ENTRYPROC", "読み方（ひらがな）");
define("_AM_{$MYDIRNAME}_ENTRYDEF", "説明文");
define("_AM_{$MYDIRNAME}_ENTRYREFERENCE", "参考文献など<span style='font-size: xx-small; font-weight: normal;'>(Reference)</span>");
define("_AM_{$MYDIRNAME}_ENTRYURL", "参考サイト<span style='font-size: xx-small; font-weight: normal;'>(http://を除く)</span>");
define("_AM_{$MYDIRNAME}_SWITCHOFFLINE", "書きかけにしますか？");
define("_AM_{$MYDIRNAME}_YES", "はい");
define("_AM_{$MYDIRNAME}_NO", "いいえ");
define("_AM_{$MYDIRNAME}_OPTIONS", "オプション");
define("_AM_{$MYDIRNAME}_SETNEWDATE", " ←投稿日を設定するときはチェックを入れ、日時をセットしてください。");
define("_AM_{$MYDIRNAME}_RENEWDATE", " ←投稿日を変更するときはチェックを入れ、日時をセットしてください。");
define("_AM_{$MYDIRNAME}_RENEWDATE_DEFAULT", "初期値：");
define("_AM_{$MYDIRNAME}_CURRENTTIME_Y","年");
define("_AM_{$MYDIRNAME}_CURRENTTIME_M","月");
define("_AM_{$MYDIRNAME}_CURRENTTIME_D","日");
define("_AM_{$MYDIRNAME}_CURRENTTIME_J","時");
define("_AM_{$MYDIRNAME}_CURRENTTIME_H","分");
define("_AM_{$MYDIRNAME}_DOHTML", " HTMLタグを使う。チェックを外すとタグがそのまま表示される。");
define("_AM_{$MYDIRNAME}_DOSMILEY", " 絵文字を顔アイコンに変換する。チェックを外すと文字のまま。");
define("_AM_{$MYDIRNAME}_DOXCODE", " XOOPSコードを使う。チェックを外すとコードがそのまま表示される。");
define("_AM_{$MYDIRNAME}_BREAKS", " 改行を&lt;BR&gt;タグに変換する。チェックを外すと改行されない。");
define("_AM_{$MYDIRNAME}_ENTRYCREATEDOK", "追加されました！");
define("_AM_{$MYDIRNAME}_ENTRYNOTCREATED", "追加することはできませんでした！");
define("_AM_{$MYDIRNAME}_MODENTRY", "修正");
define("_AM_{$MYDIRNAME}_ENTRYMODIFIED", "変更しました！");
define("_AM_{$MYDIRNAME}_ENTRYNOTUPDATED", "変更できませんでした！");
define("_AM_{$MYDIRNAME}_ENTRYISDELETED", "削除されました");
define("_AM_{$MYDIRNAME}_DELETETHISENTRY", "削除してもよろしいですか？");
define("_AM_{$MYDIRNAME}_UPFILES", "ファイルアップロード");
define("_AM_{$MYDIRNAME}_UPLOADOPEN", "ファイルアップロードプログラムを開く");
define("_AM_{$MYDIRNAME}_SPAW", "Wysiwyg入力に変更（※これまでの入力が無効になります）");
define("_AM_{$MYDIRNAME}_BB", "BBcode入力に変更（※これまでの入力が無効になります）");
define("_AM_{$MYDIRNAME}_SPAWTOBB", "SPAW→BB");
define("_AM_{$MYDIRNAME}_BBTOSPAW", "BB→SPAW");
define("_AM_{$MYDIRNAME}_PREVIEWOPEN", "別窓でプレビュー");
define("_AM_{$MYDIRNAME}_NOENTRY", "該当の見出し語はありません");


// submissions.php
define("_AM_{$MYDIRNAME}_AUTHENTRY", "投稿内容確認");
define("_AM_{$MYDIRNAME}_AUTHORIZE", "承認");
define("_AM_{$MYDIRNAME}_ENTRYAUTHORIZED", "投稿は承認されました");
define("_AM_{$MYDIRNAME}_SUBMITS", "投稿");
define("_AM_{$MYDIRNAME}_SUBMITSDEL", "却下（削除）");
define("_AM_{$MYDIRNAME}_SHOWSUBMISSIONS", "ユーザーによる追加");
define("_AM_{$MYDIRNAME}_MAINPAGEKARA", "すみません。メインページからお願いします。");
define("_AM_{$MYDIRNAME}_FUTUREENTRY", "公開予定の見出し語");
define("_AM_{$MYDIRNAME}_HIDDENENTRY", "書きかけの見出し語");
define("_AM_{$MYDIRNAME}_NOFUTUREENTRY", "公開予定の見出し語はありません");
define("_AM_{$MYDIRNAME}_NOHIDDENENTRY", "書きかけの見出し語はありません");
define("_AM_{$MYDIRNAME}_OPENSCHEDULE", "公開予定日");


// myblocksadmin.php
define("_AM_{$MYDIRNAME}_BLOCKS", "ブロック・グループ管理");

// pluginlist.php
define("_AM_{$MYDIRNAME}_PLUGINLISTTITLE", "プラグイン対応状況");
define("_AM_{$MYDIRNAME}_PLUGINLISTDSC_HEAD", "<p>ここに表示されているモジュールが「検索できるモジュールすべて」に該当します。プラグインのあるモジュールは、該当のファイル名を表示しています。</p>");
define("_AM_{$MYDIRNAME}_PLUGINLISTDSC_FOOT", "<p>※自動参照リンク機能の設定を「検索できるモジュールすべてを対象に使用する」にした場合、プラグインがないモジュールは XOOPS の検索機能を代用します。ただし、プラグインより負荷がかかります。</p><p>※「プラグインのあるモジュールのみを対象に使用する」に設定する際、外したいモジュールがある場合は該当のプラグインファイルを削除してください。</p><p>※自動参照リンク機能は、該当の記事を表示するたびに XOOPS 検索をしているのと同程度のサーバー負荷が生じます。</p>");
define("_AM_{$MYDIRNAME}_NOPLUGIN", "プラグインなし");


// functions.php
define("_AM_{$MYDIRNAME}_OPTS", "一般設定へ行く");
define("_AM_{$MYDIRNAME}_GOMOD", "モジュールへ行く");
define("_AM_{$MYDIRNAME}_ID", "ID");
define("_AM_{$MYDIRNAME}_MODADMIN", " モジュール管理者: ");
define("_AM_{$MYDIRNAME}_HELP", "ヘルプ");


?>