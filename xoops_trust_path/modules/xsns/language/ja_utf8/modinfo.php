<?php

$constpref = '_MI_'.strtoupper($mydirname);

if(!defined($constpref.'_LOADED')){

define($constpref.'_LOADED', 1);

define($constpref.'_MODULE_DESC', 'SNSをXOOPS内で立ち上げることができるモジュールです');

define($constpref.'_MENU_MYPAGE', 'マイページ');

define($constpref.'_BLOCK_RECENT_TOPIC', '最新トピック');
define($constpref.'_BLOCK_INFORMATION', 'INFORMATION');

define($constpref.'_AD_MENU_CATEGORY', 'コミュニティカテゴリ設定');
define($constpref.'_AD_MENU_IMAGE', '画像管理');
define($constpref.'_AD_MENU_FILE', 'ファイル管理');
define($constpref.'_AD_MENU_ACCESS', 'アクセスログ');
define($constpref.'_AD_MENU_MYTPLSADMIN', 'テンプレート管理');
define($constpref.'_AD_MENU_MYBLOCKSADMIN', 'ブロック管理/アクセス権限');
define($constpref.'_AD_MENU_MYLANGADMIN', '言語定数管理');
define($constpref.'_AD_MENU_MYPREFERENCES', '一般設定');


define($constpref.'_COMMU_NOTIFY', '表示中のコミュニティ');
define($constpref.'_COMMU_NOTIFY_DSC', '表示中のコミュニティに対する通知オプション');

define($constpref.'_TOPIC_CREATE_NOTIFY', '新規トピック作成');
define($constpref.'_TOPIC_CREATE_NOTIFY_CAP', '新たにトピックが作成された時に通知する');
define($constpref.'_TOPIC_CREATE_NOTIFY_DSC', '新たにトピックが作成された時に通知する');
define($constpref.'_TOPIC_CREATE_NOTIFY_SBJ', '[{X_SITENAME}] {X_MODULE}: 新たにトピックが作成されました');

define($constpref.'_TOPIC_POST_NOTIFY', '新規コメント投稿');
define($constpref.'_TOPIC_POST_NOTIFY_CAP', 'トピックに対してコメントが投稿された時に通知する');
define($constpref.'_TOPIC_POST_NOTIFY_DSC', 'トピックに対してコメントが投稿された時に通知する');
define($constpref.'_TOPIC_POST_NOTIFY_SBJ', '[{X_SITENAME}] {X_MODULE}: 新たにコメントが投稿されました');

define($constpref.'_FPATH', '画像/ファイルのアップロード先ディレクトリ');
define($constpref.'_FPATHDSC', 'アップロードする画像/ファイルは全てここに保存されます。<br><span style="color:#ff0000;">※ セキュリティのため、サーバの公開ディレクトリ外の場所を指定してください。</span>');

define($constpref.'_FSIZE', '画像/ファイルの最大サイズ [bytes]');
define($constpref.'_FSIZEDSC', 'アップロードする画像/ファイルの最大サイズをバイト単位で指定してください。');

define($constpref.'_FMIME', 'アップロードを許可するファイルのMIMEタイプ');
define($constpref.'_FMIMEDSC', 'アップロードを許可するファイルのMIMEタイプを｜で区切って入力してください。');

define($constpref.'_IMGW', '画像の最大幅 [pixel]');
define($constpref.'_IMGWDSC', '');

define($constpref.'_IMGH', '画像の最大高さ [pixel]');
define($constpref.'_IMGHDSC', '');

define($constpref.'_ILIMIT', '画像の同時アップロード数の制限');
define($constpref.'_ILIMITDSC', '1つの投稿文に対する添付画像の最大数を指定します。画像のアップロードを許可しない場合は0にしてください。');

define($constpref.'_FLIMIT', 'ファイルの同時アップロード数の制限');
define($constpref.'_FLIMITDSC', '1つの投稿文に対する添付ファイルの最大数を指定します。ファイルのアップロードを許可しない場合は0にしてください。');

define($constpref.'_BLOG', 'ブログモジュールの選択');
define($constpref.'_BLOGDSC', '利用するブログモジュールを一覧から選択してください。<br>モジュールがインストールされていない場合は利用できません。');
define($constpref.'_BLOG0', '利用しない');
define($constpref.'_BLOG1', 'うぇブログ');
define($constpref.'_BLOG2', 'うぇブログD3');
define($constpref.'_BLOG3', 'WordPress ME (for XOOPS2)');
define($constpref.'_BLOG4', 'd3blog');
define($constpref.'_BLOG5', 'minidiary');

define($constpref.'_BLOGDIR', 'ブログモジュールのディレクトリ名');
define($constpref.'_BLOGDIRDSC', 'ブログモジュールのディレクトリ名を変更している場合は、その名称を入力してください。<br>空白にした場合はデフォルトのディレクトリ名になります。');

define($constpref.'_MYPAGE', 'アカウント情報ページをマイページに置き換える');
define($constpref.'_MYPAGEDSC', 'XOOPS標準のアカウント情報ページを、コミュニティモジュールの利用に特化したマイページに置き換えることができます。<br><br>XOOPS 2.0系の場合、[はい]を選択すると以下のファイルの内容が変更されます。元に戻したい場合は再度[いいえ]を選択してください。<br>&nbsp;'.XOOPS_ROOT_PATH.'/userinfo.php<br>&nbsp;'.XOOPS_ROOT_PATH.'/edituser.php');

define($constpref.'_MYPAGEG', 'マイページをゲストに公開する');
define($constpref.'_MYPAGEGDSC', 'xsnsをゲストに公開していない場合は、この設定に関わらずマイページは公開されません。');

define($constpref.'_POPMAX', '人気度のランク設定');
define($constpref.'_POPMAXDSC', '人気度がこの値を超えると５つ星(最高ランク)になります。<br>ユーザー数の規模に応じて変更してください。<br><br><span style="color:#0000ff;">※人気度：対象コミュニティへのアクセス回数の平均値（過去30日以内）</span>');

define($constpref.'_FREQMAX', '更新頻度のランク設定');
define($constpref.'_FREQMAXDSC', '更新頻度がこの値を超えると５つ星(最高ランク)になります。<br>ユーザー数の規模に応じて変更してください。<br><br><span style="color:#0000ff;">※更新頻度：対象コミュニティに投稿されたトピックおよびコメントの数の平均値（過去30日以内）</span>');

define($constpref.'_FOOT', 'あしあと機能を使用する');
define($constpref.'_FOOTDSC', 'マイページに対するアクセスログ機能を使用するかどうかを指定します。');

define($constpref.'_XBC', 'パンくずリストを表示する');
define($constpref.'_XBCDSC', 'テーマでパンくずリストを表示するようにしている場合は[いいえ]に設定してください。');

define($constpref.'_INSTERR', '<span style="color:#ff0000;"><b>モジュールのディレクトリ名の文字数の上限は15文字です。<br />一旦モジュールをアンインストールし、15文字以内のディレクトリ名に変更した後、再度インストールしてください。<br /></b></span>');

define($constpref.'_CATEGORY', 'カテゴリ');
define($constpref.'_CATEGORY_1', '趣味');
define($constpref.'_CATEGORY_2', '生活');
define($constpref.'_CATEGORY_3', 'イベント');
define($constpref.'_CATEGORY_4', 'その他');

}

?>
