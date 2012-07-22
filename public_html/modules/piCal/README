[mlimg]
[xlang:en]
        RFC2445 Class for PHP and Calendar Module for XOOPS2
                           "piCal"

                                GIJ=CHECKMATE <gij@peak.ne.jp>
                                PEAK Corp.   http://www.peak.ne.jp/
                                (in XOOPS site, my uname is GIJOE)


(0) Important Notification

piCal >= 0.93 can work under the environment with Protector's BigUmbrella anti-XSS.

If you don't want such a limitation, don't install/update it.

If you dare to use piCal, install Protector module and confirm the 
preference "BigUmbrella ant-XSS" is enabled.


(1) What about piCal?

piCal is an independent calendar class of php.

piCal is also a powerful calendar module for Xoops2.
This module can generate iCalendar data dynamically,
and can import via http or from a local file. 

And piCal also has a little functions of group-ware.
Of course, this module has enough calendar feature,
eg) 4 type of view -Daily,Weekly,Monthly,Yearly- .

This archive contains English, Japanese,
Germany, Spanish, French, Dutch, Russian, Tchinese, Swedish, Portuguese and
BrasilPortuguese language files.

The initial version of piCal was developped as a module only for 
Japanese in 2003-4-23.

I made internationalization in version 0.50 half a year later 0.10 
released.


(2) How to Install

Same as another modules for XOOPS2.
No changes to permissions of files or directories are necessary.

Since piCal >= 0.70 is implemented with DUPLICATABLE V2, you can duplicate this module easily.
And you are free to change the dirname of this module.

  modules/cal   - treated as the base module of piCal
  modules/cal0  - treated as No.0 moudle of piCal
  modules/c1    - treated as No.1 module of piCal
  modules/test0002 - treated as No.2 module of piCal

  The numbers of piCal have to be unique.


(3) How to Upgrade

- Overwrite all files in the archive.
- Update module by modules admin in your system's admin.

(- Check piCal's status by module maintenance in piCal's admin.(only after 0.60))



(4) FAQ

  Q) The Displayed time is different from the time input time

  A) This is caused the wrong setting of Time Zones in your XOOPS.
  Check Time Zones of your account, default account, or server.


  Q) How can I change externals of mini-calendar ?

  A) Since piCal is developped as an independent class, piCal doesn't
     use the template system of XOOPS.
     If you'd like to externals of mini calendar, use skin feature.

     1. copy all of images/default/ to images/(new skin name)/
     2. set the name of new skin directory into preferences of piCal
     3. edit minical*.tmpl.html

     That's all.
     In patTemplate, {VARIABLE} is replaced into the value.



(5) Copyrights

The license of piCal conforms to GPL.
see COPYING for detail.






[/xlang:en]
[xlang:ja]


        XOOPS2用 スケジューラ付カレンダーモジュール 「piCal」


                                GIJ=CHECKMATE <gij@peak.ne.jp>
                                PEAK Corp.   http://www.peak.ne.jp/
                             （XOOPS関連サイトでは、GIJOEというハンドルです）

●重要な通知

piCalは設計の古いモジュールであり、どこかにXSSがあっても不思議はあり
ません。そんなXSSが後から見つかってJPCERT/CCなどに報告されても、とて
も対処しきれないので、0.93以降では、Protectorの「大きな傘 Anti-XSS」
が有効でないと、一切動作しないように仕様変更しました。

この仕様変更が痛いようなら、piCalのアップデートやインストールをしない
でください。

「大きな傘 Anti-XSS」は、最新のProtectorをインストールすれば、自動的
に有効になっているはずですが、古いバージョンからのアップデートだと、
OFFのままかもしれません。piCal 0.93以上をインストール/アップデートす
る際には、必ずその機能がONになっていることを確認してください。


●piCalとは

PHP+MySQL用のクラスです。かなり以前に仕事で作ったカレンダー機能をベー
スとしています。あくまで汎用の「クラス」として作りましたが、かなり
XOOPSに特化した機能も充実してきたと自負しています。

名前の由来は、うちの社名 PEAK の頭文字と、iCalendar を合わせただけで
す。読み方は「ピーカル」ではなく「パイカル」です。
でも、後で調べてみたら、Python用のiCalendarライブラリも、picalという
名前のようです。こちらこそ「パイカル」でしょうから、読み方だけでも変
えようか、などと考えたりしてます。（ヨタ話にして失礼）



●開発の背景

XOOPSそのものはかなり前から興味を持っていたのですが、2003年の4月頃、
たまたまいくつかの案件があって、ようやく直接いじる機会にめぐまれまし
た。

ところが、それらの案件で必要になる、カレンダーもしくはスケジューラ機
能が公式モジュールにはありません。当然、3rd Partyモジュールを探すこと
になるのですが、当時唯一みつかったeCalは、私の利用方法にはそぐいませ
んでした。

最初はeCalをベースに改変しようかと思ったのですが、元がフランス語であ
ることもあって、あまりにもソースが読みづらく、これくらいなら0から作っ
てしまえ、と一念発起して、「車輪の再発明」することになりました。 (^^;;;

実際、カレンダー関係のPHPクラスなど、おそらくゴロゴロしていると思うの
ですが、暦というのは、意外とローカルな仕様が多くて、ある国の暦をベー
スとしたカレンダークラスを別の国向けにローカライズするのは大変です。

そんなわけで、piCalクラスも、XOOPS2用インターフェースの部分も、当初は
日本環境のためだけに作り、バージョン0.1〜0.4まで、日本人だけを対象と
してきたのですが、Horacio Salazarさん達の熱心なXOOPS伝道者にすすめら
れたこともあり、0.50でついに国際化しました。

元々が日本専用仕様で作っていただけに、国際化は非常に困難を極めました
が、今はそれなりのものが出来たと思っています。

今後も、「XOOPSにはpiCalがある」と言わせるだけのモジュールに育ててい
こうと思っています。



●利用方法（piCal新規導入の方）

XOOPS2で使うのは簡単なはずです。

他のモジュールと同様に、modules/ 以下に展開して下さい。特にパーミッショ
ンを変更するようなフォルダはありません。

その後、モジュール管理でインストールすればOKです。ブロックやモジュー
ルのアクセス権限は、従来通り、システムのグループ管理でもできますが、
piCalにはmyblocksadminがありますので、piCal内で行う方が便利なはずです。

「一般設定」のオプションもかなり多めですが、それほど難しいものはない
と思います。以下に、比較的、理解しづらい「権限」について書いておきます。

「一般ユーザの権限」

   一般ユーザが登録したスケジュールを全体にすぐ公開する場合は、「登録
   可・承認不要」を選びます。

   登録はできるけれども、管理者権限を持ったメンバーによって「承認」さ
   れるまでは自分にしか見えなくする場合は、「登録可・要承認」を
   そもそも登録できなくするためには、「登録不可」を選びます。

   グループごとに細かく設定したいのでしたら「グループ毎に設定する」を選び、
   「各グループの権限設定」ページで個別に指定して下さい。

   なお、登録されたスケジュールは、承認済・未承認にかかわらず、登録者
   本人および管理者が編集できます。管理者が編集しても、登録者はそのま
   まですが、未承認スケジュールは自動的に承認済となります。


「ゲストの権限」

   基本的には、「一般ユーザの権限」と同じです。ただし、ゲストが登録し
   た未承認状態のスケジュールは、管理者にしか見えません。


●複製方法

  piCal 0.70 以上は、DUPLICATABLE V2 仕様で作ってあります。
  そのため、modules/ 以下のディレクトリ名は自由に決められます。
  ただし、ちょっとしたルールがあるので、それだけは守らなくてはいけません。
  (数字以外が１字以上)+(他のpiCalとかぶらないpiCal番号)
  という名前にしてください。

  数字が一切含まれないディレクトリ名も、１つだけ存在可能です。
  デフォルトの 'piCal' は、その一例です。
  （piCal番号無しのモジュール）

  このモジュールをコピーして、'cal0' として置けば、piCal番号0のモジュールのできあがり。
  'cal00002' とかしても良いですが、これはpiCal番号2のモジュールとして扱われます。

  とりあえず、0,1,2 の3つだけ用意してあります。
  テンプレートとsqlファイルを用意しさえすれば、いくつでも可能です。
  piCal番号が同一のモジュールは２つ同時には存在できませんので、その点だけ注意して下さい。



●アップグレード方法

piCal 0.40以降で運用なさっている方は、他のモジュールと同様です

(1) 本パッケージをダウンロードし、解凍後、全てのファイルをmodules/以下
    に上書きアップロードします。
(2) システム管理->モジュール管理 からpiCalのアップデートを実行します


なお、0.4x または 0.5x から 0.6 以降にアップグレードする際には、さらに、


(3) piCalのモジュールメンテナンス画面にアクセスし、指示に従う


という手順が必要です。


なお、0.36以前のpiCalをお使いの方で、0.4以降にアップグレードするため
には、piCal 0.50 などを落として、テーブルを0.40形式にしてから、再度、
最新のpiCalへのアップグレード手順を踏んで下さい。



●FAQ

Q) なんだか表示される時間がずれているのですが…
A) piCalはその性格上、タイムゾーンの設定を正確にしないといけません。
   ありがちなのは、９時間ずれているというパターンで、この場合、あなた
   のアカウントのタイムゾーンがグリニッジ標準時のまま、という可能性を
   まず疑ってください。（管理者のタイムゾーンは、インストール後に特に
   設定しない限り、GMTのままです）
   また、デフォルトのタイムゾーンや、サーバのタイムゾーンが狂っている
   ことも考えられます。
   特に海外サーバをお使いの場合、そのサーバのタイムゾーンをきちんと設
   定する必要があります。

Q) ミニカレンダーの外観を変更したい

   piCal本体部分は、XOOPSのテンプレートシステムを利用していませんが、
   ミニカレンダー等ではpatTemplateというテンプレートクラスを利用して
   います。
   ミニカレンダーの外観を変更する場合は以下の手順となります。

   1. images/default/ を images/(新スキンフォルダ名)/ に丸ごとコピー
   2. piCal管理画面の一般設定で、新スキンフォルダ名をセットします
   3. 新スキンフォルダ内の minical*.tmpl.html を編集します。

   なお、patTemplateでは、{VARIABLE} という形式の変数がその中身に置換
   されます。

   「拡張ミニカレンダー」の方では、XOOPSのテンプレートを利用しています。


●著作権などの表記

piCalクラスおよびこのパッケージ内の各ファイルは、GPLに準拠します。
"see COPYING" という奴です。
当然、利用も配布も自由です。商用利用も構いませんし、改変も自由ですが、GPLである以上、改変バージョンの配布を行う際には、ソースの公開は必須条件となりますので、ご注意下さい。


[/xlang:ja]
