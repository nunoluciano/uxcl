<?php
// XOOPS2 - Xwords 0.42
// WEBMASTER @ KANPYO.NET, 2005.

include( "./admin_header.php" );

global $xoopsUser, $xoopsConfig, $xoopsModuleConfig;

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title><?php echo $xoopsModule->name()." : ".constant("_AM_{$MYDIRNAME}_PLUGINLISTTITLE"); ?></title>
<link rel="stylesheet" href="<?php echo XOOPS_URL. "/themes/" . $xoopsConfig['theme_set'] . "/style.css"; ?>" type="text/css" />
<meta http-equiv="Content-Type" content="text/html; charset=<?php echo _CHARSET; ?>" /></head>
<body>

<?php
$titleblockuse = intval( $xoopsModuleConfig["titleblockuse"] );
$h1id = $myts -> makeTboxData4Show( $xoopsModuleConfig["h1id"] );
if ($titleblockuse && $h1id) {
	$style = "background: #fff url(".XOOPS_URL."/modules/".$xoopsModule->dirname()."/images/$h1id) no-repeat center;font-size: 100%; overflow: hidden; margin: 0px; padding: 50px 0 0 0; height: 0px !important; height /**/:50px;";
	} elseif ($titleblockuse) {
	$style = "margin: 0 0 10px 0; padding: 0.2em 0em; text-align: center; font-size: 1.4em;";
	}
?>

<h1 style="<?php echo $style; ?>"><?php echo $xoopsModule->name(); ?></h1>
<div style="margin:1em;padding:1em;line-height:1.3em;background-color:#ffffff;font-size:small;">
<fieldset class="item" style="margin: 4px 0px; padding: 0.5em;background-color: transparent;">
<legend class="itemHead"><?php echo constant("_AM_{$MYDIRNAME}_PLUGINLISTTITLE"); ?></legend>

<?php
echo constant("_AM_{$MYDIRNAME}_PLUGINLISTDSC_HEAD");

$groups = array();
$mids = array();
$mod_plugin_file = "";

// get module list installed
$gperm_handler = & xoops_gethandler( 'groupperm' );
$groups = ( $xoopsUser ) ? $xoopsUser -> getGroups() : array(XOOPS_GROUP_ANONYMOUS);

$module_handler =& xoops_gethandler('module');
$criteria = new CriteriaCompo(new Criteria('hassearch', 1));
$criteria->add(new Criteria('isactive', 1));
$mids =& array_keys($module_handler->getList($criteria));

$i = 0;
echo "<table class='head'>\n";
foreach ($mids as $mid)
	{
	if ( $gperm_handler->checkRight('module_read', $mid, $groups))
		{
		$module =& $module_handler->get($mid);
		$mod = $module->getVar('dirname') ;

		$mod_plugin_file = "modules/$mod/include/myxwords.plugin.php";
		if (file_exists(XOOPS_ROOT_PATH."/".$mod_plugin_file))
			{
			echo "<tr><td class='even' style='color:red;'>".$myts->htmlSpecialChars($module->getVar('name'))."($mod)"."</td>"."<td class='even' style='color:red;'>"."$mod_plugin_file"."</td></tr>\n";
			continue;
			}

		$mod_plugin_file = "modules/$mod/include/xwords.plugin.php";
		if (file_exists(XOOPS_ROOT_PATH."/".$mod_plugin_file))
			{
			echo "<tr><td class='even'>".$myts->htmlSpecialChars($module->getVar('name'))."($mod)"."</td>"."<td class='even'>"."$mod_plugin_file"."</td></tr>\n";
			continue;
			}

		$mod_plugin_file = "modules/$mydirname/plugins/{$mod}.plugin.php";
		if (file_exists(XOOPS_ROOT_PATH."/".$mod_plugin_file))
			{
			echo "<tr><td class='even'>".$myts->htmlSpecialChars($module->getVar('name'))."($mod)"."</td>"."<td class='even'>"."$mod_plugin_file"."</td></tr>\n";
			continue;
			}

		echo "<tr><td class='odd'>".$myts->htmlSpecialChars($module->getVar('name'))."($mod)"."</td>"."<td class='odd'>".constant("_AM_{$MYDIRNAME}_NOPLUGIN")."</td></tr>\n";
		}
	}
echo "</table>\n";
echo constant("_AM_{$MYDIRNAME}_PLUGINLISTDSC_FOOT");

?>

<form style="text-align:center;margin: 4em 0em;">
<input type="button" value="<?php echo constant("_MD_{$MYDIRNAME}_UPLOAD_CLOSE"); ?>" onClick="window.close();" class="formButton" />
</form>
</fieldset>
<div class="foot" style="text-align:center;margin: 1em 0em;">Powered by <a href="http://www.kanpyo.net/" title="kanpyo.net"><strong>Xwords</strong></a> based on <a href="http://dev.xoops.org/modules/xfmod/project/showfiles.php?group_id=1019" title="Official XOOPS Development Site"><strong>Wordbook</strong></a></div>
</div>
</body></html>
