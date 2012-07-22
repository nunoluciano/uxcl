<{if $xoops_isadmin && $config}>

<h2>Preference</h2>

<table class="outer">
<tr class ="head"><th>sample code</th><th>value</th></tr>
<{foreach from=$config key="key" item="item"}>
<tr class="<{cycle values="odd,even"}>"><td>&lt;{$config.<{$key|escape}>}&gt;</td><td><{$item|escape}></td></tr>
<{/foreach}>
</table>
<{/if}>
