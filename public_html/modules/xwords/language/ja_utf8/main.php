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

// templates共通
define("_MD_{$MYDIRNAME}_HOME", "HOME");
define("_MD_{$MYDIRNAME}_WEHAVE", "登録数");
define("_MD_{$MYDIRNAME}_NOW", "＜現在の掲載数は次のとおり＞");
define("_MD_{$MYDIRNAME}_BROWSELETTER", "頭文字（イニシャル）別");
//define("_MD_{$MYDIRNAME}_OTHER", "その他");
define("_MD_{$MYDIRNAME}_BROWSECAT", "用途別分類（カテゴリー）別");
define("_MD_{$MYDIRNAME}_SEARCHENTRY", "検索");
define("_MD_{$MYDIRNAME}_LOOKON", "検索対象");
define("_MD_{$MYDIRNAME}_TERMS", "見出し語");
define("_MD_{$MYDIRNAME}_PROCS", "読み方");
define("_MD_{$MYDIRNAME}_DEFINS", "説明文");
define("_MD_{$MYDIRNAME}_CATEGORY", "用途別分類");
//define("_MD_{$MYDIRNAME}_ALLOFTHEM", "0 : すべて");
define("_MD_{$MYDIRNAME}_ALLOFTHEM", "全分類（カテゴリー）");
define("_MD_{$MYDIRNAME}_TERM", "検索語");
define("_MD_{$MYDIRNAME}_SEARCH", "検索！");
define("_MD_{$MYDIRNAME}_DELTERM", "これを削除");
define("_MD_{$MYDIRNAME}_EDITTERM", "これを編集");
define("_MD_{$MYDIRNAME}_ALLCATEGORY", "全分類");
define("_MD_{$MYDIRNAME}_STILLNOTHINGHERE", "Xwordsにようこそ！　残念ながらまだ何も登録されていません。");
define("_MD_{$MYDIRNAME}_RUBYL", "（");
define("_MD_{$MYDIRNAME}_RUBYR", "）");

// xwords_index.html
define("_MD_{$MYDIRNAME}_READMEFIRST", "はじめに");
define("_MD_{$MYDIRNAME}_READMEWEHAVE", "＜情報求む＞");
define("_MD_{$MYDIRNAME}_DEFS", "見出し語数：");
define("_MD_{$MYDIRNAME}_CATS", "用途別分類数：");
define("_MD_{$MYDIRNAME}_ADDDATA", "追加");
define("_MD_{$MYDIRNAME}_SUBMITENTRY", "データの追加");
define("_MD_{$MYDIRNAME}_REQUESTDEF", "リクエスト");
define("_MD_{$MYDIRNAME}_ALLCATS", "分類説明一覧");
define("_MD_{$MYDIRNAME}_RECENTENT", "新着");
define("_MD_{$MYDIRNAME}_POPULARENT", "ランキング");
define("_MD_{$MYDIRNAME}_RANDOMTERM", "ランダム");
define("_MD_{$MYDIRNAME}_SUBANDREQ", "データの追加・リクエスト");
define("_MD_{$MYDIRNAME}_SUB", "ユーザーによるデータ追加：");
define("_MD_{$MYDIRNAME}_REQ", "閲覧者からのリクエスト：");
define("_MD_{$MYDIRNAME}_NOSUB", "ありません");
define("_MD_{$MYDIRNAME}_NOREQ", "ありません");
define("_MD_{$MYDIRNAME}_NOTERM", "ありません");

// xwords_letter.html
define("_MD_{$MYDIRNAME}_INALLGLOSSARIES", "語");
define("_MD_{$MYDIRNAME}_BEGINWITHLETTER", "語");
define("_MD_{$MYDIRNAME}_LETTERDEFINS", "解説：");
define("_MD_{$MYDIRNAME}_RETURN", "戻る");
define("_MD_{$MYDIRNAME}_RETURN2INDEX", "トップに戻る");
define("_MD_{$MYDIRNAME}_NOTERMSINLETTER", "この頭文字で始まるものはありません。");

// xwords_entry.html
define("_MD_{$MYDIRNAME}_ENTRYYOMI", "読み：");
define("_MD_{$MYDIRNAME}_ENTRYCATEGORY", "用途：");
define("_MD_{$MYDIRNAME}_ENTRYDEFINITION", "とは...");
define("_MD_{$MYDIRNAME}_ENTRYREFERENCE", "参考文献：");
define("_MD_{$MYDIRNAME}_ENTRYRELATEDURL", "関連サイト：");
define("_MD_{$MYDIRNAME}_SUBMITTEDBY", "投稿者：");
define("_MD_{$MYDIRNAME}_SUBMITTED", "投稿日：");
define("_MD_{$MYDIRNAME}_COUNT", "閲覧回数：");
define("_MD_{$MYDIRNAME}_COMMENT", "閲覧者のコメント");
define("_MD_{$MYDIRNAME}_AMAZON", "アマゾン：");
define("_MD_{$MYDIRNAME}_AMAZONLINK", "で検索");

// xwords_category.html
define("_MD_{$MYDIRNAME}_ENTRIESINCAT", "語");
define("_MD_{$MYDIRNAME}_NOENTRIESINCAT", "まだ何も登録されていません。");
define("_MD_{$MYDIRNAME}_NOCATSINSYSTEM", "まずカテゴリーを設定してください。");
define("_MD_{$MYDIRNAME}_CATRECENTENT", "この分類での新着");
define("_MD_{$MYDIRNAME}_CATPOPULARENT", "この分類での人気");

// xwords_search.html
define("_MD_{$MYDIRNAME}_SEARCHHEAD", "検索");
define("_MD_{$MYDIRNAME}_SEARCED", "検索結果");
define("_MD_{$MYDIRNAME}_SEARCHTYPE", "検索の種類");
define("_MD_{$MYDIRNAME}_TERMSDEFS", "見出し語+読み方+説明文");
define("_MD_{$MYDIRNAME}_SEARCHALL", "すべての語に一致するもの");
define("_MD_{$MYDIRNAME}_SEARCHANY", "いずれかの語に一致するもの");
define("_MD_{$MYDIRNAME}_SEARCHEXACT", "スペースも含め１語として");
define("_MD_{$MYDIRNAME}_NOSEARCHTERM", "検索語を入力してください。");
define("_MD_{$MYDIRNAME}_NORESULTS", "該当なし。再度お試しください。");
define("_MD_{$MYDIRNAME}_THEREWERE", "上記の条件で&nbsp;%s&nbsp;件見つかりました。");
define("_MD_{$MYDIRNAME}_DUMMY", "美乳");
define("_MD_{$MYDIRNAME}_NBSP", "　");


// xwords_request.html
define("_MD_{$MYDIRNAME}_ASKFORDEF", "リクエスト");
define("_MD_{$MYDIRNAME}_INTROREQUEST", "当サイトの趣旨、目的をお考えの上、掲載した方がいいと思われるものをお知らせください。<br />※このフォームを表示してから30分以内に送信してください。");
define("_MD_{$MYDIRNAME}_REQUESTFORM", "リクエスト内容");
define("_MD_{$MYDIRNAME}_USERNAME", "お名前");
define("_MD_{$MYDIRNAME}_USERMAIL", "メールアドレス");
define("_MD_{$MYDIRNAME}_REQTERM", "見出し語");
define("_MD_{$MYDIRNAME}_NOTIFY", "結果を知りたいときにチェック");
define("_MD_{$MYDIRNAME}_SUBMIT", "この内容を送信");
define("_MD_{$MYDIRNAME}_ANONYMOUS", "匿名");
define("_MD_{$MYDIRNAME}_WHOASKED", "%sさんのリクエスト内容：");
define("_MD_{$MYDIRNAME}_EMAILLEFT", "送信者のメールアドレス: ");
define("_MD_{$MYDIRNAME}_NOTIFYONPUB", "送信者に結果を知らせてください");
define("_MD_{$MYDIRNAME}_DEFINITIONREQ", "さんからのリクエスト");
define("_MD_{$MYDIRNAME}_MESSAGESENT", "%s へリクエストを送信！");
define("_MD_{$MYDIRNAME}_THANKS1", "ありがとうございました。");
define("_MD_{$MYDIRNAME}_THANKS2", "リクエスト、ありがとうございました。");
define("_MD_{$MYDIRNAME}_GOODDAY2", "%s さん、こんにちは。");
define("_MD_{$MYDIRNAME}_THANKYOU", "早速、「%s」について調査いたします。");
define("_MD_{$MYDIRNAME}_REQUESTSENT", "このメールは、%sの辞典にリクエストされると
確認のために自動送信しているものです。
掲載することをお約束するものではありませんので、
あらかじめ御了承ください。");
define("_MD_{$MYDIRNAME}_WEBMASTER", "Webmaster");
define("_MD_{$MYDIRNAME}_SENTCONFIRMMAIL", "リクエストの確認として、あなた（<b>%s</b>）あてにメールを送りました。");
define("_MD_{$MYDIRNAME}_NOUSERNAME", "お名前を記入してください。");
define("_MD_{$MYDIRNAME}_NOUSERMAIL", "メールアドレスを記入してください。");
define("_MD_{$MYDIRNAME}_NOREQTERM", "見出し語を記入してください。");

// submit.php include/storyform.inc.php
define("_MD_{$MYDIRNAME}_SUB_SNEWNAME", "データの追加");
define("_MD_{$MYDIRNAME}_SUBMITART", "データの追加");
define("_MD_{$MYDIRNAME}_SUB_SEDITNAME", "データの修正");
define("_MD_{$MYDIRNAME}_SUBMITEDIT", "データの修正");
define("_MD_{$MYDIRNAME}_GOODDAY", "こんにちは、");
define("_MD_{$MYDIRNAME}_SUB_SNEWNAMEDESC1", "修正されたデータは、自動承認中のため投稿後すぐに公開されます。<br />※このフォームを表示してから30分以内に送信してください。");
define("_MD_{$MYDIRNAME}_SUB_SNEWNAMEDESC2", "修正されたデータを確認させていただきます。内容によっては公開しないことも、こちらで修正することもあります。<br />※このフォームを表示してから30分以内に送信してください。");
define("_MD_{$MYDIRNAME}_SUB_SNEWNAMEDESC3", "当サイトの趣旨、目的をお考えの上、データを追加してください。自動承認中のため投稿後すぐに公開されます。<br />※このフォームを表示してから30分以内に送信してください。");
define("_MD_{$MYDIRNAME}_SUB_SNEWNAMEDESC4", "当サイトの趣旨、目的をお考えの上、データを追加してください。内容の確認後、承認されるまで公開されません。<br />※このフォームを表示してから30分以内に送信してください。");
define("_MD_{$MYDIRNAME}_SUB_SMNAME", "投稿内容");
define("_MD_{$MYDIRNAME}_ENTRY", "見出し語");
define("_MD_{$MYDIRNAME}_PROC", "読み方");
define("_MD_{$MYDIRNAME}_DEFINITION", "説明文");
define("_MD_{$MYDIRNAME}_WRITEHERE", "ここに説明文を記述");
define("_MD_{$MYDIRNAME}_REFERENCE", "参考文献など<span style='font-size: xx-small; font-weight: normal;'>(Reference)</span>");
define("_MD_{$MYDIRNAME}_URL", "参考サイト<span style='font-size: xx-small; font-weight: normal;'>(http://を除く)</span>");
define("_MD_{$MYDIRNAME}_CREATE", "この内容を投稿");
define("_MD_{$MYDIRNAME}_MODIFY", "この内容で修正");
define("_MD_{$MYDIRNAME}_CLEAR", "クリア");
define("_MD_{$MYDIRNAME}_CANCEL", "キャンセル");
define("_MD_{$MYDIRNAME}_WHOSUBMITTED", "%sさんの投稿：");
define("_MD_{$MYDIRNAME}_DEFINITIONSUB", "投稿通知");
define("_MD_{$MYDIRNAME}_RECEIVEDANDAPPROVED", "あなたの投稿は承認され、既に公開されています。");
define("_MD_{$MYDIRNAME}_RECEIVED", "投稿ありがとうございました。できるだけ早く拝見させていただきます。");
define("_MD_{$MYDIRNAME}_ERRORSAVINGDB", "データベースはエラーにより更新されませんでした！");
define("_AM_{$MYDIRNAME}_NOCOLEXISTS", "カテゴリーはありません。サイト管理者にお問い合わせください。");
define("_MD_{$MYDIRNAME}_UPFILES", "ファイルアップロード");
define("_MD_{$MYDIRNAME}_UPLOADOPEN", "ファイルアップロードプログラムを開く");
define("_MD_{$MYDIRNAME}_PREVIEWOPEN", "別窓でプレビュー");
define("_MD_{$MYDIRNAME}_NOPROC", "読み方をひらがなで記入してください。");
define("_MD_{$MYDIRNAME}_DONTUSETAG", "<span style='font-size: xx-small; font-weight: normal;color:red;'>（タグは使用不可）</span>");
define("_MD_{$MYDIRNAME}_HIRAGANA", "<span style='font-size: xx-small; font-weight: normal;color:red;'>（ひらがな）</span>");


//preview.html
define("_MD_{$MYDIRNAME}_PREVIEW_DSC",'プレビュー（多分こんな感じで表示されます）');
define("_MD_{$MYDIRNAME}_PREVIEW_CLOSE",'終了（閉じる）');
define("_MD_{$MYDIRNAME}_PREVIEW_NOTERM",'未記入');
define("_MD_{$MYDIRNAME}_PREVIEW_NOPROC",'みきにゅう');

// admin/upload.php
define("_MD_{$MYDIRNAME}_UPLOAD_START",'アップロードを続ける');
define("_MD_{$MYDIRNAME}_UPLOAD_CLOSE",'終了（閉じる）');
define("_MD_{$MYDIRNAME}_UPLOAD_BACK",'戻る');
define("_MD_{$MYDIRNAME}_UPLOAD_CODEIN",'このコードを投稿フォームに挿入');
define("_MD_{$MYDIRNAME}_UPLOAD_CODE",'こちらの表示用コードをお使い下さい。');
define("_MD_{$MYDIRNAME}_UPLOAD_SUCCESS",'指定されたファイルのアップロードが完了しました。');
define("_MD_{$MYDIRNAME}_UPLOAD_REBTN",'アップロードリトライ');
define("_MD_{$MYDIRNAME}_UPLOAD_ALT",'説明 (ALT)：');
define("_MD_{$MYDIRNAME}_UPLOAD_ALTER",'代替ファイル名:');
define("_MD_{$MYDIRNAME}_UPLOAD_RENAME",'下記の代替ファイル名、またはお好きなファイル名に変更できます。');
define("_MD_{$MYDIRNAME}_UPLOAD_EXISTS",'この名前のファイルは既に存在します : ');
define("_MD_{$MYDIRNAME}_UPLOAD_DUPLICATE",'ファイル名が重複していませんか ?');
define("_MD_{$MYDIRNAME}_UPLOAD_BTN",'ファイルアップロード');
define("_MD_{$MYDIRNAME}_UPLOAD_AMAZON",'アマゾンアソシエイト');
define("_MD_{$MYDIRNAME}_UPLOAD_PX",'px（長辺側）');
define("_MD_{$MYDIRNAME}_UPLOAD_CUSTOM",'カスタムサイズ');
define("_MD_{$MYDIRNAME}_UPLOAD_LARGE",'ラージサイズ（長辺側 400px）');
define("_MD_{$MYDIRNAME}_UPLOAD_SMALL",'スモールサイズ（長辺側 200px）');
define("_MD_{$MYDIRNAME}_ATTACH_ICON",'添付ファイルのアイコンのみ');
define("_MD_{$MYDIRNAME}_UPLOAD_NO",'作成しない');
define("_MD_{$MYDIRNAME}_UPLOAD_THUMBNAIL",'サムネイル：');
define("_MD_{$MYDIRNAME}_UPLOAD_FILE",'ファイル選択：');
define("_MD_{$MYDIRNAME}_UPLOAD_OPTIONS",'これらの値を変更するときは、管理メニューの一般設定を編集してください。');
define("_MD_{$MYDIRNAME}_UPLOAD_BYTES",'アップロード可能なファイルのサイズ : ');
define("_MD_{$MYDIRNAME}_UPLOAD_EXTENSION",'アップロード可能なファイルの種類 : ');
define("_MD_{$MYDIRNAME}_UPLOAD_DIRECTORY",'指定されたディレクトリーが書き込み可能になっていませんので、現在アップロード機能を利用することができません。<br />ディレクトリーのパーミッション及びフルパスを再度チェックしてください');


// ******************************
// 辞書順にソートするためのデータ
// ******************************

$patterns1 = array (
	'/^((?:.{2})*)ア|ぁ|ァ/',
	'/^((?:.{2})*)イ|ぃ|ィ|ゐ/',
	'/^((?:.{2})*)ウ|ぅ|ゥ/',
	'/^((?:.{2})*)エ|ぇ|ェ|ゑ/',
	'/^((?:.{2})*)オ|ぉ|ォ/',
	'/^((?:.{2})*)カ|ヵ|が|ガ/',
	'/^((?:.{2})*)キ|ぎ|ギ/',
	'/^((?:.{2})*)ク|ぐ|グ/',
	'/^((?:.{2})*)ケ|ヶ|げ|ゲ/',
	'/^((?:.{2})*)コ|ご|ゴ/',
	'/^((?:.{2})*)サ|ざ|ザ/',
	'/^((?:.{2})*)シ|じ|ジ/',
	'/^((?:.{2})*)ス|ず|ズ/',
	'/^((?:.{2})*)セ|ぜ|ゼ/',
	'/^((?:.{2})*)ソ|ぞ|ゾ/',
	'/^((?:.{2})*)タ|だ|ダ/',
	'/^((?:.{2})*)チ|ぢ|ヂ/',
	'/^((?:.{2})*)ツ|っ|ッ|づ|ヅ/',
	'/^((?:.{2})*)テ|で|デ/',
	'/^((?:.{2})*)ト|ど|ド/',
	'/^((?:.{2})*)ナ/',
	'/^((?:.{2})*)ニ/',
	'/^((?:.{2})*)ヌ/',
	'/^((?:.{2})*)ネ/',
	'/^((?:.{2})*)ノ/',
	'/^((?:.{2})*)ハ|ば|バ|ぱ|パ/',
	'/^((?:.{2})*)ヒ|び|ビ|ぴ|ピ/',
	'/^((?:.{2})*)フ|ぶ|ブ|ぷ|プ/',
	'/^((?:.{2})*)ヘ|べ|ベ|ぺ|ペ/',
	'/^((?:.{2})*)ホ|ぼ|ボ|ぽ|ポ/',
	'/^((?:.{2})*)マ/',
	'/^((?:.{2})*)ミ/',
	'/^((?:.{2})*)ム/',
	'/^((?:.{2})*)メ/',
	'/^((?:.{2})*)モ/',
	'/^((?:.{2})*)ヤ|ゃ|ャ/',
	'/^((?:.{2})*)ユ|ゅ|ュ/',
	'/^((?:.{2})*)ヨ|ょ|ョ/',
	'/^((?:.{2})*)ラ/',
	'/^((?:.{2})*)リ/',
	'/^((?:.{2})*)ル/',
	'/^((?:.{2})*)レ/',
	'/^((?:.{2})*)ロ/',
	'/^((?:.{2})*)ワヮ/',
	'/^((?:.{2})*)ヲ/',
	'/^((?:.{2})*)ン/'
);

$replace1 = array (
	'$1あ','$1い','$1う','$1え','$1お',
	'$1か','$1き','$1く','$1け','$1こ',
	'$1さ','$1し','$1す','$1せ','$1そ',
	'$1た','$1ち','$1つ','$1て','$1と',
	'$1な','$1に','$1ぬ','$1ね','$1の',
	'$1は','$1ひ','$1ふ','$1へ','$1ほ',
	'$1ま','$1み','$1む','$1め','$1も',
	'$1や','$1ゆ','$1よ',
	'$1ら','$1り','$1る','$1れ','$1ろ',
	'$1わ','$1を','$1ん',
);

$patterns2 = array (
	'/あー/','/かー/','/さー/','/たー/','/なー/',
	'/はー/','/まー/','/やー/','/らー/','/わー/',
	'/いー/','/きー/','/しー/','/ちー/','/にー/',
	'/ひー/','/みー/','/りー/',
	'/うー/','/くー/','/すー/','/つー/','/ぬー/',
	'/ふー/','/むー/','/ゆー/','/るー/',
	'/えー/','/けー/','/せー/','/てー/','/ねー/',
	'/へー/','/めー/','/れー/',
	'/おー/','/こー/','/そー/','/とー/','/のー/',
	'/ほー/','/もー/','/よー/','/ろー/','/をー/','/んー/',
);

$replace2 = array (
	'ああ','かあ','さあ','たあ','なあ','はあ','まあ','やあ','らあ','わあ',
	'いい','きい','しい','ちい','にい','ひい','みい','りい',
	'うう','くう','すう','つう','ぬう','ふう','むう','ゆう','るう',
	'ええ','けえ','せえ','てえ','ねえ','へえ','めえ','れえ',
	'おお','こお','そお','とお','のお','ほお','もお','よお','ろお','をを','んん',
);


// ********************************************************
// 日付表示用配列
// XOOPSのファンクションはサーバーのロケールに依存するため、
// ロケールをEUC-JPに設定できない場合に使用する。
// ********************************************************

define("_MD_{$MYDIRNAME}_Y",'年');
define("_MD_{$MYDIRNAME}_M",'月');
define("_MD_{$MYDIRNAME}_D",'日');

$week = array("日","月","火","水","木","金","土");
setlocale(LC_ALL, 'ja_JP.eucJP' ) ;

?>