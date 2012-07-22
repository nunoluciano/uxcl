<?php
// XOOPS2 - Xwords 0.42
// upload.php ... Powered by Wordpress
// Edit : WEBMASTER @ KANPYO.NET, 2005.

include( "./admin_header.php" );

global $xoopsUser, $xoopsConfig, $xoopsModuleConfig;

$fileupload_realpath = XOOPS_ROOT_PATH . "/modules/" . $xoopsModule->dirname() . "/images/uploads";
$fileupload_url = "images/uploads";
$iconurl = "images";

$imgalt = "";

// add thumbnail function
function wp_create_thumbnail($file, $max_side, $effect = '') {

	// 1 = GIF, 2 = JPEG, 3 = PNG

	if(file_exists($file)) {
		$type = getimagesize($file);
		
		// if the associated function doesn't exist - then it's not
		// handle. duh. i hope.
		
		if(!function_exists('imagegif') && $type[2] == 1) {
			$error = 'Filetype not supported. Thumbnail not created.';
		}elseif(!function_exists('imagejpeg') && $type[2] == 2) {
			$error = 'Filetype not supported. Thumbnail not created.';
		}elseif(!function_exists('imagepng') && $type[2] == 3) {
			$error = 'Filetype not supported. Thumbnail not created.';
		} else {
		
			// create the initial copy from the original file
			if($type[2] == 1) {
				$image = imagecreatefromgif($file);
			} elseif($type[2] == 2) {
				$image = imagecreatefromjpeg($file);
			} elseif($type[2] == 3) {
				$image = imagecreatefrompng($file);
			}
			
			if (function_exists('imageantialias'))
				imageantialias($image, TRUE);
			
			$image_attr = getimagesize($file);
			
			// figure out the longest side
			
			if($image_attr[0] > $image_attr[1]) {
				$image_width = $image_attr[0];
				$image_height = $image_attr[1];
				$image_new_width = $max_side;
				
				$image_ratio = $image_width/$image_new_width;
				$image_new_height = $image_height/$image_ratio;
				//width is > height
			} else {
				$image_width = $image_attr[0];
				$image_height = $image_attr[1];
				$image_new_height = $max_side;
				
				$image_ratio = $image_height/$image_new_height;
				$image_new_width = $image_width/$image_ratio;
				//height > width
			}
			
			$thumbnail = imagecreatetruecolor($image_new_width, $image_new_height);
			@imagecopyresized($thumbnail, $image, 0, 0, 0, 0, $image_new_width, $image_new_height, $image_attr[0], $image_attr[1]);
			
			// move the thumbnail to it's final destination
			
			$path = explode('/', $file);
			$thumbpath = substr($file, 0, strrpos($file, '/')) . '/thumb-' . $path[count($path)-1];
			touch($thumbpath);

			if($type[2] == 1) {
				if(!imagegif($thumbnail, $thumbpath)) {
					$error = "Thumbnail path invalid";
				}
			} elseif($type[2] == 2) {
				if(!imagejpeg($thumbnail, $thumbpath)) {
					$error = "Thumbnail path invalid";
				}
			} elseif($type[2] == 3) {
				if(!imagepng($thumbnail, $thumbpath)) {
					$error = "Thumbnail path invalid";
				}
			}
			
		}
	}
	
	if(!empty($error))
	{
		return $error;
	}
	else
	{
		return 1;
	}
}

// function to add leading zeros when necessary
function zeroise($number,$threshold) {
	$l=strlen($number);
	if ($l<$threshold)
		for ($i=0; $i<($threshold-$l); $i=$i+1) { $number='0'.$number;	}
	return $number;
}

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title><?php echo $xoopsModule->name(); ?> &raquo; Upload images/files</title>
<link rel="stylesheet" href="<?php echo XOOPS_URL. "/themes/" . $xoopsConfig['theme_set'] . "/style.css"; ?>" type="text/css" />
<meta http-equiv="Content-Type" content="text/html; charset=<?php echo _CHARSET; ?>" />
<script type="text/javascript">
<!-- // idocs.com's popup tutorial rules !
function targetopener(blah, closeme, closeonly) {
	if (! (window.focus && window.opener))return true;
//	window.opener.focus();
	if (! closeonly)window.opener.document.op.definition.value += blah;
	if (closeme)window.close();
	return false;
}
//-->
</script>
</head>
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
<legend class="itemHead">Upload images/files</legend>

<?php

$allowed_types = explode(' ', trim($xoopsModuleConfig["allowedtypes"]));

if (isset($_POST['submit'])) {
	$action = 'upload';
} else {
	$action = '';
}

if (!is_writable($fileupload_realpath))
	$action = 'not-writable';

switch ($action) {
case 'not-writable':
?>

<p>(<code><?php echo $fileupload_realpath; ?></code>)</p>
<p><?php echo constant("_MD_{$MYDIRNAME}_UPLOAD_DIRECTORY"); ?></p>

<?php
break;
case '':
	foreach ($allowed_types as $type) {
		$type_tags[] = "<code>$type</code>";
	}
	$i = implode(', ', $type_tags);
?>
<ul style="margin: 1em; padding: 0em;">
<li style="margin: 0px 4px 0px 0px; padding: 0px; line-height: 120%;"><?php echo constant("_MD_{$MYDIRNAME}_UPLOAD_EXTENSION"); ?><?php echo $i; ?></li>
<li style="margin: 0px 4px 0px 0px; padding: 0px; line-height: 120%;"><?php echo constant("_MD_{$MYDIRNAME}_UPLOAD_BYTES"); ?><?php echo $xoopsModuleConfig["uploadmax"]; ?> KB</li>
<li style="margin: 0px 4px 0px 0px; padding: 0px; line-height: 120%;"><?php echo constant("_MD_{$MYDIRNAME}_UPLOAD_OPTIONS"); ?></li>
</ul>
	<form action="upload.php" method="post" enctype="multipart/form-data">
	<table border="1" align="center" width="90%"><tr>
	<td class="even" align="right"><label for="img1"><?php echo constant("_MD_{$MYDIRNAME}_UPLOAD_FILE"); ?></label></td>
	<td class="even"><input type="hidden" name="MAX_FILE_SIZE" value="<?php echo $xoopsModuleConfig["uploadmax"] * 1024; ?>" /><input type="file" name="img1" id="img1" size="35" class="formButton" /></td>
	</tr><tr>
	<td class="odd" align="right"><label for="imgdesc"><?php echo constant("_MD_{$MYDIRNAME}_UPLOAD_ALT"); ?></label></td>
	<td class="odd"><input type="text" name="imgdesc" id="imgdesc" size="30" class="formButton" /></td>
	</tr><tr>
	<td class="even" align="right"><?php echo constant("_MD_{$MYDIRNAME}_UPLOAD_THUMBNAIL"); ?></td>
	<td class="even">
	<label for="thumbsize_no">
	<input type="radio" name="thumbsize" value="none" checked="checked" id="thumbsize_no" />
	<?php echo constant("_MD_{$MYDIRNAME}_UPLOAD_NO"); ?></label>
	<br />
		<label for="attach_icon">
<input type="radio" name="thumbsize" value="icon" id="attach_icon" />
<?php echo constant("_MD_{$MYDIRNAME}_ATTACH_ICON"); ?></label>
		<br />
		<label for="thumbsize_small">
<input type="radio" name="thumbsize" value="small" id="thumbsize_small" />
<?php echo constant("_MD_{$MYDIRNAME}_UPLOAD_SMALL"); ?></label>
		<br />
		<label for="thumbsize_large">
<input type="radio" name="thumbsize" value="large" id="thumbsize_large" />
<?php echo constant("_MD_{$MYDIRNAME}_UPLOAD_LARGE"); ?></label>
		<br />
		<label for="thumbsize_custom">
		<input type="radio" name="thumbsize" value="custom" id="thumbsize_custom" />
		<?php echo constant("_MD_{$MYDIRNAME}_UPLOAD_CUSTOM"); ?></label>
	:
	<input type="text" name="imgthumbsizecustom" size="4" class="formButton" />
	<?php echo constant("_MD_{$MYDIRNAME}_UPLOAD_PX"); ?>

	<?php
	if ($xoopsModuleConfig["amazon_id"]) {
		echo '<br /><label for="associate_amazon">';
		echo '<input type="radio" name="thumbsize" value="amazon" id="associate_amazon" /> ';
		echo constant("_MD_{$MYDIRNAME}_UPLOAD_AMAZON")."</label>";
	}
	?>

	</td>
	</tr><tr>
	<td class="odd" colspan="2" align="center">
	<input type="submit" name="submit" value="<?php echo constant("_MD_{$MYDIRNAME}_UPLOAD_BTN"); ?>" class="formButton" />
	<input type="button" value="<?php echo constant("_MD_{$MYDIRNAME}_UPLOAD_CLOSE"); ?>" onClick="window.close();" class="formButton" />
	</td>
	</tr></table></form>
	<br />

<?php 
break;
case 'upload':
?>

<?php //Makes sure they choose a file

//print_r($_FILES);
//die();

	$imgalt = (isset($_POST['imgalt'])) ? $_POST['imgalt'] : $imgalt;

	$img1_name = (strlen($imgalt)) ? $_POST['imgalt'] : $_FILES['img1']['name'];
	$img1_type = (strlen($imgalt)) ? $_POST['img1_type'] : $_FILES['img1']['type'];
	$imgdesc = str_replace('"', '&amp;quot;', $_POST['imgdesc']);

	$imgtype = explode(".",$img1_name);
	$imgtype = $imgtype[count($imgtype)-1];

	if (in_array($imgtype, $allowed_types) == false) {
		die("File $img1_name of type $imgtype is not allowed.");
	}

	if (strlen($imgalt)) {
		$pathtofile = $fileupload_realpath . "/".$imgalt;
		$img1 = $_POST['img1'];
	} else {
		$pathtofile = $fileupload_realpath . "/".$img1_name;
		$img1 = $_FILES['img1']['tmp_name'];
	}

	$fsize = sprintf("%5.1f",$_FILES['img1']['size'] / 1024);

	// makes sure not to upload duplicates, rename duplicates
	$i = 1;
	$pathtofile2 = $pathtofile;
	$tmppathtofile = $pathtofile2;
	$img2_name = $img1_name;

	while (file_exists($pathtofile2)) {
		$pos = strpos($tmppathtofile, '.'.trim($imgtype));
		$pos = strpos($tmppathtofile, '.'.trim($imgtype));
		$pathtofile_start = substr($tmppathtofile, 0, $pos);
		$pathtofile2 = $pathtofile_start.'_'.zeroise($i++, 2).'.'.trim($imgtype);
		$img2_name = explode('/', $pathtofile2);
		$img2_name = $img2_name[count($img2_name)-1];
	}

	if (file_exists($pathtofile) && !strlen($imgalt)) {
		$i = explode(' ', $xoopsModuleConfig["allowedtypes"]);
		$i = implode(', ',array_slice($i, 1, count($i)-2));
		$moved = move_uploaded_file($img1, $pathtofile2);
		// if move_uploaded_file() fails, try copy()
		if (!$moved) {
			$moved = copy($img1, $pathtofile2);
		}
		if (!$moved) {
			die("Couldn't Upload Your File to $pathtofile2.");
		} else {
			@unlink($img1);
		}
	
	// duplicate-renaming function contributed by Gary Lawrence Murphy
	?>
	<p><strong><?php echo constant("_MD_{$MYDIRNAME}_UPLOAD_DUPLICATE"); ?></strong></p>
	<p><?php echo constant("_MD_{$MYDIRNAME}_UPLOAD_EXISTS"); ?><em><?php echo $img1_name; ?></em></p>
	<!--<p> filename '<?php echo $img1; ?>' moved to '<?php echo "$pathtofile2 - $img2_name"; ?>'</p>-->
	<p><?php echo constant("_MD_{$MYDIRNAME}_UPLOAD_RENAME"); ?></p>
	<form action="upload.php" method="post" enctype="multipart/form-data">
	<input type="hidden" name="MAX_FILE_SIZE" value="<?php echo  $xoopsModuleConfig["uploadmax"] *1024; ?>" />
	<input type="hidden" name="img1_type" value="<?php echo $img1_type;?>" />
	<input type="hidden" name="img1_name" value="<?php echo $img2_name;?>" />
	<input type="hidden" name="img1_size" value="<?php echo $img1_size;?>" />
	<input type="hidden" name="img1" value="<?php echo $pathtofile2;?>" />
	<input type="hidden" name="thumbsize" value="<?php echo $_REQUEST['thumbsize'];?>" />
	<input type="hidden" name="imgthumbsizecustom" value="<?php echo $_REQUEST['imgthumbsizecustom'];?>" />
	<input type="hidden" name="thumbsize" value="<?php echo $_REQUEST['thumbsize'];?>" />
	<?php echo constant("_MD_{$MYDIRNAME}_UPLOAD_ALTER"); ?><br /><input type="text" name="imgalt" size="50" class="formButton" value="<?php echo $img2_name;?>" /><br />
	<br />
	<?php echo constant("_MD_{$MYDIRNAME}_UPLOAD_ALT"); ?><br /><input type="text" name="imgdesc" size="50" class="formButton" value="<?php echo $imgdesc;?>" />
	<br />
	<input type="submit" name="submit" value="<?php echo constant("_MD_{$MYDIRNAME}_UPLOAD_REBTN"); ?>" class="formButton" />
	<input type="button" value="<?php echo constant("_MD_{$MYDIRNAME}_UPLOAD_BACK"); ?>" onClick="history.go(-1);" class="formButton" />
	<input type="button" value="<?php echo constant("_MD_{$MYDIRNAME}_UPLOAD_CLOSE"); ?>" onClick="window.close();" class="formButton" />
	</form>
	<br />
	</fieldset>
	<div class="foot" style="text-align:center;"><cite>Upload.php is based on <a href="http://www.kowa.org/" title="NobuNobu XOOPS"><strong>WordPress Module</strong></a> & <a href="http://wordpress.xwd.jp/" title="Powered by WordPress Japan"><strong>WordPress ME</strong></a> & <a href="http://www.wordpress.org/" title="Powered by WordPress"><strong>WordPress</strong></a></cite><br />Powered by <a href="http://www.kanpyo.net/" title="kanpyo"><strong>Xwords</strong></a> based on <a href="http://dev.xoops.org/modules/xfmod/project/showfiles.php?group_id=1019" title="Official XOOPS Development Site"><strong>Wordbook</strong></a></div>
	</div></body></html>

<?php 
die();

	}

	if (!strlen($imgalt)) {
		@$moved = move_uploaded_file($img1, $pathtofile);
		//Path to your images directory, chmod the dir to 777
		// move_uploaded_file() can fail if open_basedir in PHP.INI doesn't
		// include your tmp directory. Try copy instead?
		if(!$moved) {
			$moved = copy($img1, $pathtofile);
		}
		// Still couldn't get it. Give up.
		if (!$moved) {
			die("Couldn't Upload Your File to $pathtofile.");
		} else {
			@unlink($img1);
		}
		
	} else {
		rename($img1, $pathtofile)
		or die("Couldn't Upload Your File to $pathtofile.");
	}
	
	if(($_POST['thumbsize'] != 'none')&&($_POST['thumbsize'] != 'icon')) {
		if($_POST['thumbsize'] == 'small') {
			$max_side = 200;
		}
		elseif($_POST['thumbsize'] == 'large') {
			$max_side = 400;
		}
		elseif($_POST['thumbsize'] == 'custom') {
			$max_side = $_POST['imgthumbsizecustom'];
		}
		
		$result = wp_create_thumbnail($pathtofile, $max_side, NULL);
		if($result != 1) {
			print $result;
		}
	}

	if ($_POST['thumbsize'] == 'amazon') {
	$asin = explode(".", $img1_name);
	$piece_of_code = "&lt;a href=&quot;http://www.amazon.co.jp/exec/obidos/ASIN/$asin[0]/".$xoopsModuleConfig["amazon_id"]."&quot; target=&quot;_blank&quot;&gt;&lt;img style=&quot;float: left; margin: 0 10px 0 0;&quot; src=&quot;". $fileupload_url ."/$img1_name&quot; border=&quot;0&quot; alt=&quot;$imgdesc&quot; /&gt;&lt;/a&gt;";
	}
	elseif ($_POST['thumbsize'] == 'icon') {
	$piece_of_code = "&lt;a style=&quot;float: left; margin: 0 10px 0 0;&quot; href=&quot;". $fileupload_url . "/$img1_name&quot;&gt;" . "&lt;img src=&quot;". $iconurl ."/file.gif&quot; alt=&quot;$imgdesc&quot; /&gt;" .$img1_name. "(".$fsize."KB)&lt;/a&gt;";
	}
	elseif ( ereg('image/',$img1_type) && $_POST['thumbsize'] != 'none') {
	$piece_of_code = "&lt;a style=&quot;float: left; margin: 0 10px 0 0;&quot; href=&quot;". $fileupload_url . "/$img1_name&quot;&gt;" . "&lt;img src=&quot;". $fileupload_url ."/thumb-$img1_name&quot; alt=&quot;$imgdesc&quot; /&gt;" . "&lt;/a&gt;";
	} else {
	$piece_of_code = "&lt;img src=&quot;". $fileupload_url . "/$img1_name&quot; alt=&quot;$imgdesc&quot; /&gt;";
	}

?>

<p><strong><?php echo constant("_MD_{$MYDIRNAME}_UPLOAD_SUCCESS"); ?></strong></p>
<p><?php echo constant("_MD_{$MYDIRNAME}_UPLOAD_CODE"); ?></p>
<form style="text-align:center;">
<input type="text" name="imgpath" value="<?php echo $piece_of_code; ?>" size="50" style="margin: 2px;" class="formButton" /><br />
<input type="button" name="close" value="<?php echo constant("_MD_{$MYDIRNAME}_UPLOAD_CODEIN"); ?>" onClick="targetopener('<?php echo $piece_of_code; ?>')" class="uploadform" />
</form>
<p><strong>Image Details</strong>: <br />
Name:
<?php echo $img1_name; ?>
<br />
Size:
<?php echo round($img1_size / 1024, 2); ?> <abbr title="Kilobyte">KB</abbr><br />
Type:
<?php echo $img1_type; ?>
</p>
<br />
<form action="upload.php" method="post" style="text-align:center;">
<input class="formButton" type="button" value="<?php echo constant("_MD_{$MYDIRNAME}_UPLOAD_CLOSE"); ?>" onClick="window.close();" class="uploadform" />
<input class="formButton" type="submit" value="<?php echo constant("_MD_{$MYDIRNAME}_UPLOAD_START"); ?>" class="uploadform" />
</form>
<?php
break;
}
?>
</fieldset>
<div class="foot" style="text-align:center;"><cite>Upload.php is based on <a href="http://www.kowa.org/" title="NobuNobu XOOPS"><strong>WordPress Module</strong></a> & <a href="http://wordpress.xwd.jp/" title="Powered by WordPress Japan"><strong>WordPress ME</strong></a> & <a href="http://www.wordpress.org/" title="Powered by WordPress"><strong>WordPress</strong></a></cite><br />Powered by <a href="http://www.kanpyo.net/" title="kanpyo"><strong>Xwords</strong></a> based on <a href="http://dev.xoops.org/modules/xfmod/project/showfiles.php?group_id=1019" title="Official XOOPS Development Site"><strong>Wordbook</strong></a></div>
</div>
</body></html>
