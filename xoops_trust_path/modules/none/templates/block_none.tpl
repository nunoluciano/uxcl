<{if $block}>
<{assign var="config" value=$block.config}>
<{/if}>
<{capture assign="subtemplate"}>db:<{$config.dirname}>_subX.tpl<{/capture}>

<{* Request *}>
<{include file=$subtemplate|replace:"X":"8"}>
