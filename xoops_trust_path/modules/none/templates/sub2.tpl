<{* start sampale *}>
<p>
<{$smarty.now|date_format:"%Y-%m-%d %T"}>
</p>
<{* end sample *}>

<{* start d3forum comment *}>
<{if $config.comment_forum_id > 0}>
<{d3comment mydirname=$config.dirname class="NoneCommentContent"
 subject=$xoops_pagetitle subject_escaped=0 id=2}>
<{/if}>
<{* end d3forum comment *}>
