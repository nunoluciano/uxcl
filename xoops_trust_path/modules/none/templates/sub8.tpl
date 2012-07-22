<{if $xoops_isadmin}>

<h2>Request</h2>

<table class="outer">
<tr class ="head"><th>key</th><th>value</th></tr>
<{foreach from=$smarty.request key="key" item="item"}>
<tr class="<{cycle values="odd,even"}>"><td><{$key|escape}></td><td><{$item|escape}></td></tr>
<{/foreach}>
</table>
<{/if}>
