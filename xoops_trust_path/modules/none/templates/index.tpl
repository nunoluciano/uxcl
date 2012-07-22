<{* start sampale *}>

<h1>Sample Contents</h1>
<ul>
<li><a href="<{$xoops_url}>/modules/<{$xoops_dirname}>/"><{$xoops_modulename}></a></li>
<li><a href="?sample=template">Sample: XCL 2.1 Template</a></li>
<li><a href="?sample=preference">Sample: <{$smarty.const._PREFERENCES}></a></li>
<li><a href="?sample=request">Sample: Request</a></li>
<li><a href="?sample=iframe">Sample: iframe</a></li>
<li><a href="<{$xoops_url}>/modules/<{$xoops_dirname}>/admin/index.php?mode=admin&page=help">Help</a></li>
</ul>

<{capture assign="subtemplate"}>db: <{$config.dirname}>_subX.tpl<{/capture}>
<{if $smarty.request.sample=="iframe"}>
    <{include file=$subtemplate|replace:"X":"6"}>
    <{if !$config.user_1}>
      <p class="tips"><{$smarty.const._MODULENOEXIST}><br />
       please set url to preference &quot;user_1&quot;.<br />
      <a href="<{$xoops_url}>/modules/<{$xoops_dirname}>/admin/index.php?mode=admin&lib=altsys&page=mypreferences"><{$smarty.const._PREFERENCES}></a>
      </p>
    <{/if}>
<{elseif $smarty.request.sample=="template"}>
    <{include file=$subtemplate|replace:"X":"7"}>
<{elseif $smarty.request.sample=="request"}>
    <{include file=$subtemplate|replace:"X":"8"}>
<{elseif $smarty.request.sample=="preference"}>
    <{include file=$subtemplate|replace:"X":"9"}>
<{else}>
     <p class="tips">This is dummy.<br />
      Please edit template &quot;<{$config.dirname}>_index.tpl&quot;.<br />
      <a href="<{$xoops_url}>/modules/<{$xoops_dirname}>/admin/index.php?mode=admin&lib=altsys&page=mytplsadmin">template admin</a>
      </p>
<{/if}>

<{* end sample *}>

<{* start d3forum comment *}>
<{if $config.comment_forum_id > 0}>
<{d3comment mydirname=$config.dirname class="NoneCommentContent"
 subject=$xoops_pagetitle subject_escaped=0 id=1}>
<{/if}>
<{* end d3forum comment *}>
