<h1>Xoops Cube Legacy 2.1 Template</h1>
<h2>request</h2>
<table class="xcl-template">
<tr class ="head">
<th>syntax</th>
<th>example</th>
</tr>
<tr class="odd">
<td class="smarty">&lt;{$SCRIPT_NAME}&gt;</td>
<td class="example"><{$SCRIPT_NAME|escape|default:"(?)"}></td>
</tr>
<tr class="even">
<td class="smarty">&lt;{$xoops_requesturi}&gt;</td>
<td class="example"><{$xoops_requesturi|escape|default:"(?)"}></td>
</tr>
</table>

<h2>url</h2>
<table class="xcl-template">
<tr class ="head">
<th>syntax</th>
<th>example</th>
</tr>
<tr class="odd">
<td class="smarty">&lt;{$xoops_imageurl}&gt;</td>
<td class="example"><{$xoops_imageurl|escape|default:"(?)"}></td>
</tr>
<tr class="even">
<td class="smarty">&lt;{$xoops_upload_url}&gt;</td>
<td class="example"><{$xoops_upload_url|escape|default:"(?)"}></td>
</tr>
<tr class="odd">
<td class="smarty">&lt;{$xoops_url}&gt;</td>
<td class="example"><{$xoops_url|escape|default:"(?)"}></td>
</tr>
<tr class="even">
<td class="smarty">&lt;{$xoops_themecss}&gt;</td>
<td class="example"><{$xoops_themecss|escape|default:"(?)"}></td>
</tr>
</table>

<h2>path</h2>
<table class="xcl-template">
<tr class ="head">
<th>syntax</th>
<th>example</th>
</tr>
<tr class="odd">
<td class="smarty">&lt;{$xoops_rootpath}&gt;</td>
<td class="example"><{if $xoops_isadmin}><{$xoops_rootpath}><{else}>/var/www/html (for example)<{/if}></td>
</tr>
</table>

<h2>misc</h2>
<table class="xcl-template">
<tr class ="head">
<th>syntax</th>
<th>example</th>
</tr>
<tr class="odd">
<td class="smarty">&lt;{$legacy_buffertype}&gt;  [ main | theme | block ]</td>
<td class="example"><{$legacy_buffertype|escape|default:"(?)"}></td>
</tr>
<tr class="even">
<td class="smarty">&lt;{$stdout_buffer}&gt;</td>
<td class="example"><{$stdout_buffer|escape|default:"(?)"}></td>
</tr>
</table>

<h2>config</h2>
<table class="xcl-template">
<tr class ="head">
<th>syntax</th>
<th>example</th>
</tr>
<tr class="odd">
<td class="smarty">&lt;{$xoops_charset}&gt;</td>
<td class="example"><{$xoops_charset|escape|default:"(?)"}></td>
</tr>
<tr class="even">
<td class="smarty">&lt;{$xoops_langcode}&gt;</td>
<td class="example"><{$xoops_langcode|escape|default:"(?)"}></td>
</tr>
<tr class="odd">
<td class="smarty">&lt;{$xoops_sitename}&gt;</td>
<td class="example"><{$xoops_sitename|escape|default:"(?)"}></td>
</tr>
<tr class="even">
<td class="smarty">&lt;{$xoops_slogan}&gt;</td>
<td class="example"><{$xoops_slogan|escape|default:"(?)"}></td>
</tr>
<tr class="odd">
<td class="smarty">&lt;{$xoops_version}&gt;</td>
<td class="example"><{$xoops_version|escape|default:"(?)"}></td>
</tr>
<tr class="even">
<td class="smarty">&lt;{$xoops_theme}&gt;</td>
<td class="example"><{$xoops_theme|escape|default:"(?)"}></td>
</tr>
<tr class="odd">
<td class="smarty">&lt;{$xoops_pagetitle}&gt;</td>
<td class="example"><{$xoops_pagetitle|escape|default:"(?)"}></td>
</tr>
</table>

<h2>role/user</h2>
<table class="xcl-template">
<tr class ="head">
<th>syntax</th>
<th>example</th>
</tr>
<tr class="odd">
<td class="smarty">&lt;{$xoops_isadmin}&gt;</td>
<td class="example"><{$xoops_isadmin|escape|default:"(?)"}></td>
</tr>
<tr class="even">
<td class="smarty">&lt;{$xoops_isuser}&gt;</td>
<td class="example"><{$xoops_isuser|escape|default:"(?)"}></td>
</tr>
<tr class="odd">
<td class="smarty">&lt;{$xoops_userid}&gt;</td>
<td class="example"><{$xoops_userid|escape|default:"(?)"}></td>
</tr>
<tr class="even">
<td class="smarty">&lt;{$xoops_uname}&gt;</td>
<td class="example"><{$xoops_uname|escape|default:"(?)"}></td>
</tr>
</table>

<h2>dirname/modulename</h2>
<table class="xcl-template">
<tr class ="head">
<th>syntax</th>
<th>example</th>
</tr>
<tr class="odd">
<td class="smarty">&lt;{$legacy_module}&gt;</td>
<td class="example"><{$legacy_module|escape|default:"(?)"}></td>
</tr>
<tr class="even">
<td class="smarty">&lt;{$mytrustdirname}&gt;</td>
<td class="example"><{$mytrustdirname|escape|default:"(?)"}></td>
</tr>
<tr class="odd">
<td class="smarty">&lt;{$xoops_dirname}&gt;</td>
<td class="example"><{$xoops_dirname|escape|default:"(?)"}></td>
</tr>
<tr class="even">
<td class="smarty">&lt;{$xoops_modulename}&gt;</td>
<td class="example"><{$xoops_modulename|escape|default:"(?)"}></td>
</tr>
</table>

<h2>head</h2>
<table class="xcl-template">
<tr class ="head">
<th>syntax</th>
<th>example</th>
</tr>
<tr class="odd">
<td class="smarty">&lt;{$xoops_module_header}&gt;</td>
<td class="example"><{$xoops_module_header|escape|default:"(?)"}></td>
</tr>
<tr class="even">
<td class="smarty">&lt;{$xoops_block_header}&gt;</td>
<td class="example"><{$xoops_block_header|escape|default:"(?)"}></td>
</tr>
<tr class="odd">
<td class="smarty">&lt;{$xoops_js}&gt;</td>
<td class="example"><{$xoops_js|escape|default:"(?)"}></td>
</tr>
</table>

<h2>meta</h2>
<table class="xcl-template">
<tr class ="head">
<th>syntax</th>
<th>example</th>
</tr>
<tr class="odd">
<td class="smarty">&lt;{$xoops_meta_author}&gt;</td>
<td class="example"><{$xoops_meta_author|escape|default:"(?)"}></td>
</tr>
<tr class="even">
<td class="smarty">&lt;{$xoops_meta_copyright}&gt;</td>
<td class="example"><{$xoops_meta_copyright|escape|default:"(?)"}></td>
</tr>
<tr class="odd">
<td class="smarty">&lt;{$xoops_meta_description}&gt;</td>
<td class="example"><{$xoops_meta_description|escape|default:"(?)"}></td>
</tr>
<tr class="even">
<td class="smarty">&lt;{$xoops_meta_keywords}&gt;</td>
<td class="example"><{$xoops_meta_keywords|escape|default:"(?)"}></td>
</tr>
<tr class="odd">
<td class="smarty">&lt;{$xoops_meta_rating}&gt;</td>
<td class="example"><{$xoops_meta_rating|escape|default:"(?)"}></td>
</tr>
<tr class="even">
<td class="smarty">&lt;{$xoops_meta_robots}&gt;</td>
<td class="example"><{$xoops_meta_robots|escape|default:"(?)"}></td>
</tr>
</table>

<h2>mail template</h2>
<table class="xcl-template">
<tr class ="head">
<th>syntax</th>
<th>example</th>
</tr>
<tr class="odd">
<td class="smarty">{X_ADMINMAIL}</td>
<td class="example">(-)</td>
</tr>
<tr class="even">
<td class="smarty">{X_SITENAME}</td>
<td class="example"><{$xoops_sitename|escape|default:"(?)"}></td>
</tr>
<tr class="odd">
<td class="smarty">{X_SITEURL}</td>
<td class="example"><{$xoops_url|escape|default:"(?)"}></td>
</tr>
<tr class="even">
<td class="smarty">{X_UNAME}</td>
<td class="example"><{$xoops_uname|escape|default:"(?)"}></td>
</tr>
<tr class="odd">
<td class="smarty">{X_UID}</td>
<td class="example"><{$xoops_userid|escape|default:"(?)"}></td>
</tr>
<tr class="even">
<td class="smarty">{X_UEMAIL}</td>
<td class="example"><{$xoops_userid|xoops_user:"email"|escape|default:"(?)"}></td>
</tr>
<tr class="even">
<td class="smarty">{X_UACTLINK}</td>
<td class="example">(-)</td>
</tr>
</table>
