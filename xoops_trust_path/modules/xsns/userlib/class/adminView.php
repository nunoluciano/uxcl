<?php
class Xsns_Admin_View extends XsnsCommonView
{

function getPageSelector($pager, $colspan=0)
{
	$colspan_html = ($colspan > 0)? " colspan='".$colspan."'" : "";
	
	$ret =	"<tr class='odd'>".
			"<td".$colspan_html." style='text-align:center;'>".$pager['selector']."</td>".
			"</tr>".
			"<tr class='odd'>".
			"<td".$colspan_html." style='text-align:right;'>".$pager['description']."</td>".
			"</tr>";
	return $ret;
}
//------------------------------------------------------------------------------


}
?>
