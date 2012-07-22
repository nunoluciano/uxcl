(English)

TODO LIST (order has non-sense):

- get_flags_date_has_events() will be fixed
- Registered Users can import iCalendar
- Deletion or modify with admission needed
- More impressive design like phpicalendar (Daily or Weekly View)
- Cron scripts for notifying events

- VTODO of RFC2445
- EXDATE,EXRULE,BYSETPOS of RRULE
- Cooperation with another modules like eguide or weblog.

- a quick and easy submit event
http://www.peak.ne.jp/xoops/modules/xhnewbb/viewtopic.php?viewmode=flat&topic_id=119&forum=1
- Search page for events
- PRINT.php without navigation
- hide "status admitted"
- only displaying coming events in admin view
- automated .ics generation


----------------------------------------------------------------
(Japanese)

●今後の予定（順不同）

・ユーザ用iCalendarインポート
・import時のcategory自動登録・class,group_id
・変更・削除承認の仕組み
・全体的な見栄えの改善 （まずはphpicalendarのデザインをパクろうかと…）
・スケジュール通知機能 （cron用スクリプトの用意）

一応、このあたりで、1.0 のリリースバージョンとする予定です。
以下については時間があったらやるかもしれません。

・iCalendarのVTODO対応 （実装系を知らないのでさすがに無理か？）


●作者も判っていて手抜きをしている部分

・WKSTの実装が、日曜と月曜以外は考慮していない
・1970年以前および2038年以降の日付は、ISO形式(というかMySQLのDATE形
  式)で出力され、languageによるフォーマット関連の設定が効かない
・1970-1-1〜1971-1-1 および 2037-1-1〜2038-1-19 の処理が甘い
・カテゴリーで権限制限されたユーザ・ゲストから登録を行うと、権限外の
  カテゴリーが消えてしまう



http://www.xugj.org/modules/QandA/index.php?topic_id=1034


他人の予定を入力・編集する機能

予定入力時の並び替え

86400 -> mktime() のチェック （ブロック表示関数など）

アクセス権限の再チェック
- event_id 直接指定時の、詳細表示・コメント処理等


機能省略
- タイムゾーン
- 終了日・時間
- rrule
- その他、各種フィールド

maintenance の処理

権限の種類追加 個人privateのみ 個人・グループprivateのみ

ICSをRSSのように出力する機能（出来れば、カテゴリー絞り込みなどもアリ）

ICSをOUTLOOKにインポートすると、表示がサーバタイムゾーンとなってしまうバグ修正

hcalendarサポート
http://www.microformats.org/wiki/hcalendar

リストビューで、イベント毎のカテゴリー名アサイン

カテゴリー絞り込みで、排除条件。-1 で、cid=-1 以外


