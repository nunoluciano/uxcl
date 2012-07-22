<?php

// D3DOWNLOADS FILEMANAGER
define('_MD_D3DOWNLOADS_H2FILEMANAGER','ダウンロード情報管理');
define('_MD_D3DOWNLOADS_NEWADDFILE','ダウンロード情報登録');
define('_MD_D3DOWNLOADS_TH_VISIBLE','表示');
define('_MD_D3DOWNLOADS_TH_CANCOMMENT','コメント');
define('_MD_D3DOWNLOADS_TH_CATEGORY','カテゴリ');
define('_MD_D3DOWNLOADS_TH_BROKEN','ファイル破損');
define('_MD_D3DOWNLOADS_TH_HITS','ダウンロード');
define('_MD_D3DOWNLOADS_TH_RATING','評価');
define('_MD_D3DOWNLOADS_TH_COMMENTS','コメント');
define('_MD_D3DOWNLOADS_TH_MYLINK','マイリンク');
define('_MD_D3DOWNLOADS_VOTES','票');
define('_MD_D3DOWNLOADS_LABEL_FILECHECKED','右端にチェックしたダウンロード情報を');
define('_MD_D3DOWNLOADS_CONFIRM_DELETE','削除してよろしいですか?');
define('_MD_D3DOWNLOADS_LABEL_CATEGORYSELECT','カテゴリ選択');
define('_MD_D3DOWNLOADS_TOTAL_FIlE_NUM','全体で %s 件のファイルがあります');
define('_MD_D3DOWNLOADS_TOTAL_INVISIBLE_NUM','全体で %s 件の非公開ファイルがあります');
define('_MD_D3DOWNLOADS_CATEGORY_FIlE_NUM','このカテゴリには %s 件のファイルがあります');
define('_MD_D3DOWNLOADS_CATEGORY_INVISIBLE_NUM','このカテゴリには %s 件の非公開ファイルがあります');
define('_MD_D3DOWNLOADS_BTN_MOVE','移動');
define('_MD_D3DOWNLOADS_MOVEED','移動が完了しました');
define('_MD_D3DOWNLOADS_NO_MOVEED','移動先のカテゴリを選択してください');
define('_MD_D3DOWNLOADS_CONFIRM_MOVE','移動してよろしいですか? なお、カテゴリ毎のスクリーンショット画像を使用している場合は、その画像はご自身で移動してください。');
define('_MD_D3DOWNLOADS_INVISIBLEINFO','非表示');
define('_MD_D3DOWNLOADS_WAITINGRELEASEINFO','公開待ち');
define('_MD_D3DOWNLOADS_EXPIREDINFO','期限切れ');
define('_MD_D3DOWNLOADS_SEL_SUBMITTER','投稿者を選択');
define('_MD_D3DOWNLOADS_ERROR_SEL_FILSE','ダウンロード情報を選択してください');

// D3DOWNLOADS APPROVALMANAGER
define('_MD_D3DOWNLOADS_H2APROVALLIST','新規登録未承認ダウンロード情報管理');
define('_MD_D3DOWNLOADS_H2MODFILELIST','編集未承認ダウンロード情報管理');
define('_MD_D3DOWNLOADS_APPROVAL','承認');
define('_MD_D3DOWNLOADS_SUBMIT_APPROVAL','ダウンロード情報承認');
define('_MD_D3DOWNLOADS_SUBMIT_APPROVED','承認しました');
define('_MD_D3DOWNLOADS_UNAPROVALNUM','未承認のファイル : %s 件');
define('_MD_D3DOWNLOADS_NOWDATA','承認前登録内容');

// D3DOWNLOADS CATEGORY MANAGER
define('_MD_D3DOWNLOADS_H2CATEGORYMANAGER','カテゴリ管理');
define('_MD_D3DOWNLOADS_NEWCATEGORY','新規作成');
define('_MD_D3DOWNLOADS_TH_ID','ID');
define('_MD_D3DOWNLOADS_TH_TITLE','タイトル');
define('_MD_D3DOWNLOADS_TH_WEIGHT','表示順');
define('_MD_D3DOWNLOADS_TH_CONTENTSACTIONS','アクション');
define('_MD_D3DOWNLOADS_LABEL_CATEGORYCHECKED','チェックしたカテゴリーを');
define('_MD_D3DOWNLOADS_BTN_DELETE','削除');
define('_MD_D3DOWNLOADS_CATEGORYEDITTITLE','カテゴリ編集 ( %s )');
define('_MD_D3DOWNLOADS_NEWCATEGORYEDITTITLE','カテゴリ新規作成');
define('_MD_D3DOWNLOADS_CATEGORYTITLE','タイトル');
define('_MD_D3DOWNLOADS_CATEGORYIMGURL','カテゴリ画像URL');
define('_MD_D3DOWNLOADS_CATEGORYIMGURLDESC','画像ファイルの幅は 70ピクセルに調整されます');
define('_MD_D3DOWNLOADS_CATEGORYSHOTSDIR','スクリーンショット画像用ディレクトリ');
define('_MD_D3DOWNLOADS_CATEGORYSHOTSDIRDESC','XOOPS のインストール先からのパスで指定します<br />設定例 : images/shots/ (最初の / は不要、最後の / は必要)');
define('_MD_D3DOWNLOADS_CATEGORYSHOTSDIRHELP','入力は必須ではなく、省略した場合には %s<br />ディレクトリ下にある画像ファイルをスクリーンショットとして利用することができます');
define('_MD_D3DOWNLOADS_CATWEIGHT','表示順');
define('_MD_D3DOWNLOADS_MAINCATEGORY','親カテゴリ');
define('_MD_D3DOWNLOADS_CATEGORY_TREE','カテゴリツリー');
define('_MD_D3DOWNLOADS_HELP_CATEGORY_DEL','※ カテゴリを削除すると、配下のサブカテゴリも含めて、全てのデータが削除されます。');
define('_MD_D3DOWNLOADS_CONFIRM_CATEGORY_DEL','本当に削除してよろしいですか? カテゴリを削除すると、配下のサブカテゴリも含めて、全てのデータが削除されます。');
define('_MD_D3DOWNLOADS_CATDESCRIPTION','カテゴリの説明');
define('_MD_D3DOWNLOADS_SUBMIT_MESSAGE','投稿フォームの説明文');
define('_MD_D3DOWNLOADS_SUBMIT_MESSAGE_HELP','サイト管理者以外の投稿フォーム上部に表示される説明文を記入します。なお、記入は必須ではなく、無記入にした場合にはデフォルトの説明文が表示されます。');
define('_MD_D3DOWNLOADS_IMGURL_CHECK','カテゴリ画像URLの入力が正しくありません。');
define('_MD_D3DOWNLOADS_IMGURL_TOOLONG','カテゴリ画像URLは半角で  %s 字まででお願いします');
define('_MD_D3DOWNLOADS_SHOTSDIR_CHECK','スクリーンショット画像用ディレクトリの入力が正しくありません。');
define('_MD_D3DOWNLOADS_SHOTSDIR_TOOLONG','スクリーンショット画像用ディレクトリは半角で  %s 字まででお願いします');
define('_MD_D3DOWNLOADS_CAT_WEIGHT_TOOLONG','表示順は半角で  %s 字まででお願いします');
define('_MD_D3DOWNLOADS_SUBCATEGORY_SUM','サブカテゴリ数');
define('_MD_D3DOWNLOADS_FILES_SUM','登録数');
define('_MD_D3DOWNLOADS_MAKESUBCATEGORY','サブカテゴリ作成');
define('_MD_D3DOWNLOADS_MYTPLSFORM_BTN_MODIFYCONT','更新して編集継続');
define('_MD_D3DOWNLOADS_CATEGORY_MOVE','選択したカテゴリのサブカテゴリとして移動');
define('_MD_D3DOWNLOADS_CONFIRMCATEGORY_MOVE','本当にサブカテゴリとして移動してよろしいですか?');
define('_MD_D3DOWNLOADS_CATEGORY_TOP_MOVE','トップカテゴリにする');
define('_MD_D3DOWNLOADS_CONFIRMCATEGORY_TOP_MOVE','本当にトップカテゴリとして移動してよろしいですか?');
define('_MD_D3DOWNLOADS_CATEGORYIMG','カテゴリ画像');
define('_MD_D3DOWNLOADS_CATEGORY_CHECK','カテゴリツリーなどがおかしくなった時に一度だけ実行してください');
define('_MD_D3DOWNLOADS_CATEGORY_CHECK_DONE','処理が完了しました');
define('_MD_D3DOWNLOADS_SELECT_IMGURL','カテゴリ画像選択');
define('_MD_D3DOWNLOADS_SELECT_IMGURLDESC','スクリーンショットディレクトリまたは一般設定で設定した画像管理モジュールの画像を選択することができます。');

// D3DOWNLOADS USER ACCESS
define('_MD_D3DOWNLOADS_H2USERACCESS','アクセス権限管理 ( %s )');
define('_MD_D3DOWNLOADS_H2USERACCESS_INFO','アクセス権限確認 ( %s )');
define('_MD_D3DOWNLOADS_NEWCID_USERACCESS','アクセス権限管理');
define('_MD_D3DOWNLOADS_NEWCID_USERACCESS_INFO','アクセス権限確認');
define('_MD_D3DOWNLOADS_TH_GROUPID','グループID');
define('_MD_D3DOWNLOADS_TH_CAN_READ','閲覧可');
define('_MD_D3DOWNLOADS_TH_CAN_POST','投稿可');
define('_MD_D3DOWNLOADS_TH_CAN_EDIT','編集可');
define('_MD_D3DOWNLOADS_TH_CAN_DELETE','削除可');
define('_MD_D3DOWNLOADS_TH_POST_AUTO_APPROVED','自動承認(登録)');
define('_MD_D3DOWNLOADS_TH_EDIT_AUTO_APPROVED','自動承認(編集)');
define('_MD_D3DOWNLOADS_TH_CAN_HTML','HTML可');
define('_MD_D3DOWNLOADS_TH_CAN_UPLOAD','アップロード可');
define('_MD_D3DOWNLOADS_TH_GROUPNAME','グループ名');
define('_MD_D3DOWNLOADS_TH_UID','ユーザID');
define('_MD_D3DOWNLOADS_TH_UNAME','ユーザ名');
define('_MD_D3DOWNLOADS_HELP_USERACCESS','※ 登録ユーザーでない場合、「編集可」、「削除可」、「自動承認(編集可)、「HTML可」を選択しても実際には機能しません。<br />※ これらの設定が実際に機能するのは、登録ユーザーのみです。<br />※ また、サイト管理者はここでの設定に関係なく、編集・削除・アップロードが可能です。<br />※ ここで設定した内容が配下の全サブカテゴリに適用されます。');
define('_MD_D3DOWNLOADS_HELP_USERACCESS_USER','※ ユーザを新規に追加する場合、ユーザ ID かユーザ名のいずれかを入力してください。<br />※ 「閲覧可」を外すと、そのユーザはリストから消すことができます。');
define('_MD_D3DOWNLOADS_HELP_USERACCESS_PID','※ 閲覧・投稿権限などの設定については、親カテゴリの設定がそのまま適用されます。');
define('_MD_D3DOWNLOADS_USERACCESS_COPY','他のカテゴリにコピー');
define('_MD_D3DOWNLOADS_CONFIRM_USERACCESS_COPY','コピーしてよろしいですか?');
define('_MD_D3DOWNLOADS_COPYDONE','コピーが完了しました');
define('_MD_D3DOWNLOADS_ALL_USERACCESS_COPY','全カテゴリにコピー');
define('_MD_D3DOWNLOADS_CONFIRM_ALL_USERACCESS_COPY','本当にコピーしてよろしいですか? 選択された内容で、全カテゴリのアクセス権限設定が変更されます。');
define('_MD_D3DOWNLOADS_SEL_GROUP','グループ選択');
define('_MD_D3DOWNLOADS_SEL_USER','ユーザ選択');
define('_MD_D3DOWNLOADS_LABEL_GROUP_CHECKED','グループを選択して');
define('_MD_D3DOWNLOADS_LABEL_USER_CHECKED','ユーザを選択して');
define('_MD_D3DOWNLOADS_ERROR_SEL_CATEGORY','カテゴリが選択されていないため処理を中断しました');
define('_MD_D3DOWNLOADS_ERROR_SEL_GROUP','グループが選択されていないため処理を中断しました');
define('_MD_D3DOWNLOADS_ERROR_SEL_USER','ユーザが選択されていないため処理を中断しました');

// D3DOWNLOADS BROKENMANAGER
define('_MD_D3DOWNLOADS_H2BROKENMANAGER','ファイル破損報告');
define('_MD_D3DOWNLOADS_BROKENNUM','件数: %s ');
define('_MD_D3DOWNLOADS_TH_REPORT','ファイル破損報告');
define('_MD_D3DOWNLOADS_TH_SENDERNAME','報告者');
define('_MD_D3DOWNLOADS_TH_IP','IPアドレス');
define('_MD_D3DOWNLOADS_TH_REPORTDATE','報告日時');
define('_MD_D3DOWNLOADS_TH_BROKENDEL','報告を無視する');
define('_MD_D3DOWNLOADS_LABEL_BROKENCHECK','ファイル破損/リンク切れチェック');
define('_MD_D3DOWNLOADS_HELP_BROKENCHECK','※ 「ファイル破損/リンク切れチェック」を実行すると、破損したファイルのレポートの他、どのダウンロード情報にもリンクされていないファイルを削除することができます。<br />※ cron を利用できる環境では、コマンドラインでの定期的なファイル破損/リンク切れチェックも可能です。<br />[ crontab の設定例 ] :<br /><ul><li>0 0 1 * * /usr/local/bin/php php -q -f home/***/html/modules/(dirname)/bin/broken_check.sh pass=パスワード limit=100 offset=0</li><li>パスワードは必須で、「一般設定」により設定・変更が可能。limit と offset は必須ではなく、必要に応じて設定してください。</li></ul>');
define('_MD_D3DOWNLOADS_ERROR_SEL_REPORT','無視する破損報告を選択してください');
define('_MD_D3DOWNLOADS_BTN_INVISIBLE','非表示にする');
define('_MD_D3DOWNLOADS_CONFIRM_INVISIBLE','本当に非表示にしてよろしいですか?');
define('_MD_D3DOWNLOADS_INVISIBLE_DONE','非表示に設定されました');

// D3DOWNLOADS IMPORT
define('_MD_D3DOWNLOADS_H2_IMPORTFROM','インポート');
define('_MD_D3DOWNLOADS_BTN_DOIMPORT','インポート実行');
define('_MD_D3DOWNLOADS_LABEL_SELECTMODULE','モジュール選択');
define('_MD_D3DOWNLOADS_CONFIRM_DOIMPORT','インポートを実行してよろしいですか?');
//define('_MD_D3DOWNLOADS_HELP_IMPORTFROM','現在インポートに対応しているのは d3downloads と mydownloads です。<br />できる限り忠実にインポートしますが、完全な再現はできません。<br />なお、インポートを実行すると、現在モジュール内に保存されているデータは全て削除されます。<br />また、mydownloads からのインポートの場合、カテゴリ毎の閲覧・投稿権限は初期値に設定されます。<br />インポート後に「カテゴリ管理」で各種権限を確認してください。');
define('_MD_D3DOWNLOADS_HELP_IMPORTFROM','現在インポートに対応しているのは d3downloads 、mydownloads 、wfdownloads v3.10 以上です。<br />できる限り忠実にインポートしますが、完全な再現はできません。<br />なお、インポートを実行すると、現在モジュール内に保存されているデータは全て削除されます。<br />また、mydownloads と wfdownloads からのインポートの場合、カテゴリ毎の閲覧・投稿権限は初期値に設定されます。<br />インポート後に「アクセス権限管理」で各種権限を確認してください。');
define('_MD_D3DOWNLOADS_FILE_IMPORT_HELP','他の d3downloads からのインポートの場合 %s<br />にアップロードファイルをコピーしようと試みますが、使用環境によっては、完全なコピーができない場合があります。<br />インポート後に正しくコピーされているかどうか確認してください。');
define('_MD_D3DOWNLOADS_FILE_CONFIGERROR_HELP','他の d3downloads からのインポートの場合、あらかじめ、ディレクトリ %s<br />を作り書き込み権限を与えてください。このディレクトリにアップロードファイルをコピーしようと試みます。');
define('_MD_D3DOWNLOADS_FILE_CONFIGERROR','あらかじめアップロード先ディレクトリを作り書き込み権限を与えてから実行してください');
define('_MD_D3DOWNLOADS_IMPORTDONE','インポートが完了しました');
define('_MD_D3DOWNLOADS_ERR_INVALIDMID','指定されたモジュールからはインポートできません');
define('_MD_D3DOWNLOADS_SQLONIMPORT','インポートに失敗しました。インポート元とインポート先で、テーブル構造が違う可能性があります。両方とも最新版にアップデートしているか確認してください');
define('_MD_D3DOWNLOADS_FILE_NO_IMPORT','データのみインポートが完了し、アップロードしたファイルのインポートはできませんでした。');
define('_MD_D3DOWNLOADS_H2_UPDATEFROM','アップデータ(0.01 -> 0.02)');
define('_MD_D3DOWNLOADS_BTN_UPDATE','アップデート実行');
define('_MD_D3DOWNLOADS_HELP_UPDATEFROM','Ver.0.02 から個別のダウンロード情報毎に、HTML、顔アイコン、改行、XOOPSコードの使用の有無を選択できるようになりましたが、テーブルの構造を変更したため、Ver.0.01 からモジュールアップデートを行うと、これらの設定が全て無効になってしまいます。Ver.0.01 から Ver.0.02 にバージョンアップされる方は、一度だけこの「アップデート実行」をクリックしてください。そうすることで、顔アイコン、改行、XOOPSコードを有効にすることができます。なお、HTML に関しては、このアップデータでは有効にすることはできません。必要な方は、お手数ですが、個別の編集フォームにて HTML を有効にしてください。');
define('_MD_D3DOWNLOADS_UPDATEDONE','アップデートが完了しました');
define('_MD_D3DOWNLOADS_SQLONUPDATE','アップデートに失敗しました。');

// D3DOWNLOADS CONFIG_CHECK
define('_MD_D3DOWNLOADS_H2_CONFIG_CHECK','使用環境チェック');
define('_MD_D3DOWNLOADS_MAXFILESIZE','アップロード時の最大ファイルサイズ %s byte');
define('_MD_D3DOWNLOADS_SYSTEM_CHECK','使用環境');
define('_MD_D3DOWNLOADS_PHPINI_CHECK','php.iniディレクティブチェック');
define('_MD_D3DOWNLOADS_UPLOADDIR_CHECK','アップロード先ディレクトリチェック');
define('_MD_D3DOWNLOADS_UPLOADDIR_CONFIFG','アップロード先ディレクトリ');
define('_MD_D3DOWNLOADS_NOLINK_CHECK','リンクされていないアップロードファイル');
define('_MD_D3DOWNLOADS_CACHEDIR_CHECK','キャッシュディレクトリチェック');
define('_MD_D3DOWNLOADS_CACHEDIR_CONFIFG','キャッシュディレクトリ');
define('_MD_D3DOWNLOADS_CACHEDIR_NOT_IS_DIR','キャッシュディレクトリを作成して書き込み権限を与えてください');
define('_MD_D3DOWNLOADS_CACHEDIR_NOT_MKDIR','キャッシュディレクトリが作成できません。上位ディレクトリのパミッションなどをチェックしてください');
define('_MD_D3DOWNLOADS_CACHEDIR_NOT_IS_WRITEABLE','キャッシュディレクトリが書き込み不能です。パミッションをチェックしてください');
define('_MD_D3DOWNLOADS_UPLOAD_TMP_DIR_IS_NOTWRITEABLE','upload_tmp_dir が書き込み不能です');
define('_MD_D3DOWNLOADS_TABLE_CHECK','テーブルチェック');

// D3DOWNLOADS APPROVALMANAGER
define('_MD_D3DOWNLOADS_HISTORY_RESTORE','登録内容をこの内容で復元する');
define('_MD_D3DOWNLOADS_CONFIRM_HISTORY_RESTORE','この内容で復元してよろしいですか? 実行すると、現在の登録内容は履歴として保存したうえで、復元されます。ただし、すべてのデータを復元できるわけではありません。実行後に登録内容を確認し、必要に応じて、修正してください。');
define('_MD_D3DOWNLOADS_HISTORY_DELETE','この履歴を削除する');

?>