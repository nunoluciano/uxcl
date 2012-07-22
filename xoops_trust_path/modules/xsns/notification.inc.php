<?php

eval('function '.$mydirname.'_notify_iteminfo($category, $item_id){return notify_iteminfo($category, $item_id);}');

function notify_iteminfo($category, $item_id)
{
	$item['name'] = '';
	$item['url'] = '';
	return $item;
}
?>
