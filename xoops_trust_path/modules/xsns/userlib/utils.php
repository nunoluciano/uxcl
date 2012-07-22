<?php

class XsnsUtils
{

//------------------------------------------------------------------------------

function getUserTimestamp($datetime, $timeoffset="")
{
	return xoops_getUserTimestamp(strtotime($datetime), $timeoffset);
}

//------------------------------------------------------------------------------

function getUserDatetime($datetime, $timeoffset="")
{
	return date('Y-m-d H:i:s', XsnsUtils::getUserTimestamp($datetime, $timeoffset));
}

//------------------------------------------------------------------------------

function getSelectBoxHtml($name, $options, $default=NULL)
{
	if(empty($name) || !is_array($options)){
		return "";
	}
	
	$ret = '<select name="'.$name.'">';
	foreach($options as $value => $description){
		if($value==$default){
			$ret .= '<option value="'.$value.'" selected>'.$description.'</option>';
		}
		else{
			$ret .= '<option value="'.$value.'">'.$description.'</option>';
		}
	}
	$ret.= '</select>';
	
	return $ret;
}

//------------------------------------------------------------------------------

function getRadioHtml($name, $options, $default=NULL)
{
	if(empty($name) || !is_array($options)){
		return "";
	}
	
	$ret = '';
	foreach($options as $value => $description){
		if($value==$default){
			$ret .= '<label><input type="radio" name="'.$name.'" value="'.$value.'" checked>'.$description.'</label>';
		}
		else{
			$ret .= '<label><input type="radio" name="'.$name.'" value="'.$value.'">'.$description.'</label>';
		}
	}
	
	return $ret;
}

//------------------------------------------------------------------------------

}

?>
