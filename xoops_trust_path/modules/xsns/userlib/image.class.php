<?php

require_once 'root.class.php';

//******************************************************************************

class XsnsImage extends XsnsRoot
{
	
	//--------------------------------------------------------------------------
	
	function XsnsImage()
	{
		// $key, $data_type, $default, $required, $size
		$this->initVar('c_image_id', XOBJ_DTYPE_INT);
		$this->initVar('filename', XOBJ_DTYPE_TXTBOX);
		$this->initVar('target', XOBJ_DTYPE_INT);
		$this->initVar('target_id', XOBJ_DTYPE_INT);
		$this->initVar('uid', XOBJ_DTYPE_INT);
	}
	
	//--------------------------------------------------------------------------
	
	function &getInfo($thumb_id = XSNS_IMAGE_SIZE_M)
	{
		$id = $this->getVar('c_image_id');
		$filename = $this->getVar('filename');
		
		$ret = array(
			'c_image_id' => $id,
			'filename' => $filename,
			'url' => XSNS_IMAGE_URL.'?f='.$filename,
			'url_src' => XSNS_IMAGE_URL.'?f='.$filename.'&t='.$thumb_id,
			'url_del' => XSNS_URL_FILE.'&image_id='.$id,
		);
		return $ret;
	}
	
	//--------------------------------------------------------------------------
	
}

//******************************************************************************

class XsnsImageHandler extends XsnsRootHandler
{
	var $form_limit = 1;
	var $upload_dir = NULL;
	var $dir_exists = true;
	var $handler = array();
	//--------------------------------------------------------------------------
	
	function XsnsImageHandler()
	{
		parent::XsnsRootHandler();
		$this->obj_class = "XsnsImage";
		$this->table_name = "c_image";
		$this->primary_key = "c_image_id";
		
		if(isset($this->module_config['file_upload_path'])){
			$this->upload_dir = $this->module_config['file_upload_path'];
			$this->dir_exists = is_dir($this->upload_dir) ? true : false;
		}
		else{
			$this->dir_exists = false;
		}
		
		if(isset($this->module_config['image_form_limit'])){
			$this->setFormLimit($this->module_config['image_form_limit']);
		}
		
		$this->handler['session'] =& XsnsSessionHandler::getInstance();
	}
	
	//--------------------------------------------------------------------------
	
	function &getInstance()
	{
		static $instance = NULL;
		if(is_null($instance)){
			$instance = new XsnsImageHandler();
		}
		return $instance;
	}
	
	//--------------------------------------------------------------------------
	
	function setFormLimit($limit)
	{
		$this->form_limit = intval($limit);
	}
	
	//--------------------------------------------------------------------------
	
	function &getList($target, $target_id, $thumb_id = XSNS_IMAGE_SIZE_M)
	{
		$ret = array();
		if(!$this->dir_exists || $this->form_limit < 1){
			return $ret;
		}
		
		$criteria = new CriteriaCompo(new Criteria('target', $target));
		$criteria->add(new Criteria('target_id', $target_id));
		if(!($obj_list =& $this->getObjects($criteria))){
			return $ret;
		}
		
		foreach($obj_list as $obj){
			if(@file_exists($this->upload_dir.'/'.$obj->getVar('filename'))){
				$ret[] =& $obj->getInfo($thumb_id);
			}
		}
		return $ret;
	}
	
	//--------------------------------------------------------------------------
	
	function &getListByIds($target, $target_ids, $thumb_id = XSNS_IMAGE_SIZE_M)
	{
		$ret = array();
		if(!$this->dir_exists || !is_array($target_ids) || count($target_ids)==0 || $this->form_limit < 1){
			return $ret;
		}
		
		$criteria = new CriteriaCompo(new Criteria('target', $target));
		$criteria->add(new Criteria('target_id', '('.implode(',', $target_ids).')', 'IN'));
		if(!($obj_list =& $this->getObjects($criteria))){
			return $ret;
		}
		
		foreach($obj_list as $obj){
			if(@file_exists($this->upload_dir.'/'.$obj->getVar('filename'))){
				$ret[$obj->getVar('target_id')][] =& $obj->getInfo($thumb_id);
			}
		}
		return $ret;
	}
	
	//--------------------------------------------------------------------------
	
	function uploadImageTemp($name)
	{
		if(!isset($_FILES[$name]) || !$this->dir_exists || $this->form_limit < 1){
			return false;
		}
		$thumb_id = XSNS_IMAGE_SIZE_M;
		
		require_once XSNS_USERLIB_DIR.'/image_uploader.php';
		
		$file_count = count($_FILES[$name]['name']);
		$mime = "image/jpeg|image/pjpeg|image/gif|image/png|image/x-png";
		$mime_array = explode('|', $mime);
		$max_size = $this->module_config['file_upload_size'];
		$max_width = $this->module_config['image_width'];
		$max_height = $this->module_config['image_height'];
		
		$uploader = new XsnsImageUploader($this->upload_dir, $mime_array, $max_size, $max_width, $max_height);
		$ret = array();
		$image_temp = array();
		$sessid = session_id();
		$count = 0;
		
		for($i=0; $i<$file_count; $i++){
			if($count >= $this->form_limit){
				continue;
			}
			if($_FILES[$name]['error'][$i]==0 && $uploader->fetchMedia($name, $i)){
				$tmp_filename = md5(date('Y-m-d H:i:s'). $sessid. $i);
				if(!$uploader->checkFileNameLength($this->upload_dir.'/'.$tmp_filename)){
					continue;
				}
				$uploader->setTargetFileName($tmp_filename.'.'.$uploader->getExt());
				if($uploader->upload()){
					$filename = $this->upload_dir.'/'.$uploader->getSavedFileName();
					$thumb_filename = $this->upload_dir.'/thumbnail'.$thumb_id.'/'.basename($filename);
					if(!$this->createThumbnail($filename, $thumb_id, $thumb_filename)){
						continue;
					}
					$image_temp[$i]['filename'] = basename($filename);
					
					$ret[] = array(
						'url' => XSNS_IMAGE_URL.'?f='.basename($filename),
						'url_src' => XSNS_IMAGE_URL.'?f='.basename($filename).'&t='.$thumb_id,
					);
					$count++;
				}
			}
		}
		$this->handler['session']->setVar('image', $image_temp);
		return $ret;
	}
	
	//--------------------------------------------------------------------------
	
	// 一時画像の削除
	function deleteImageTemp()
	{
		$image_list = $this->handler['session']->getVar('image');
		
		if(isset($image_list) && is_array($image_list) && $this->dir_exists){
			foreach($image_list as $image){
				if(!preg_match('/^[0-9a-f]{32}/i', $image['filename'])){
					continue;
				}
				@unlink($this->upload_dir. '/'. $image['filename']);
				@unlink($this->upload_dir. '/thumbnail2/'. $image['filename']);
			}
			$this->handler['session']->clearVar('image');
		}
	}
	
	//--------------------------------------------------------------------------
	
	// 画像のアップロード
	function uploadImage($prefix, $target, $target_id, $thumb_id = XSNS_IMAGE_SIZE_M)
	{
		global $xoopsUser;
		$image_list = $this->handler['session']->getVar('image');
		
		if($this->form_limit < 1 || !is_object($xoopsUser) || !$this->dir_exists || !isset($image_list) || !is_array($image_list)){
			return false;
		}
		$own_uid = $xoopsUser->getVar('uid');
		
		$file_ids = array();
		$index = 0;
		
		foreach($image_list as $image){
			if($index >= $this->form_limit || !preg_match('/^[0-9a-f]{32}/i', $image['filename'])){
				continue;
			}
			
			$temp_filepath = $this->upload_dir. '/'. $image['filename'];
			if(!@file_exists($temp_filepath)){
				continue;
			}
			if(!($fileinfo = @pathinfo($temp_filepath))){
				continue;
			}
			
			// 一時ファイルの名前をタイムスタンプに基づいて変換
			$timestamp_name = uniqid($prefix).$index.'.'.$fileinfo['extension'];
			$new_filename = $this->upload_dir.'/'.$timestamp_name;
			if(!@rename($this->upload_dir.'/'.$image['filename'], $new_filename)){
				continue;
			}
			
			// 一時サムネイル画像(中)をリネーム
			$thumb_dir = $this->upload_dir.'/thumbnail'.$thumb_id.'/';
			if(!@rename($thumb_dir.$image['filename'], $thumb_dir.$timestamp_name)){
				continue;
			}
			
			// サムネイル画像(小)を生成
			if(!$this->createThumbnail($new_filename, XSNS_IMAGE_SIZE_S, $this->upload_dir.'/thumbnail1/'.$timestamp_name)){
				continue;
			}
			// サムネイル画像(大)を生成
			if(!$this->createThumbnail($new_filename, XSNS_IMAGE_SIZE_L, $this->upload_dir.'/thumbnail3/'.$timestamp_name)){
				continue;
			}
			
			// 保存ファイル名をテーブルに格納
			$new_file =& $this->create();
			$new_file->setVars(array(
				'filename' => $timestamp_name,
				'target' => $target,
				'target_id' => $target_id,
				'uid' => $own_uid,
			));
			if($ret = $this->insert($new_file)){
				$file_ids[] = $ret;
			}
			unset($new_file);
			$index++;
		}
		$this->handler['session']->clearVar('image');
		
		return $file_ids;
	}
	
	//--------------------------------------------------------------------------
	
	function delete(&$obj)
	{
		if(strtolower(get_class($obj)) != strtolower($this->obj_class) || !$this->dir_exists){
			return false;
		}
		$filename = $obj->getVar('filename');
		
		$sql = "DELETE FROM ".$this->prefix($this->table_name).
				" WHERE ".$this->primary_key."='".intval($obj->getVar($this->primary_key))."'";
		$result = $this->db->query($sql);
		if (!$result) {
			return false;
		}
		
		@unlink($this->upload_dir.'/'.$filename);
		for($i=1; $i<=3; $i++){
			@unlink($this->upload_dir.'/thumbnail'.$i.'/'.$filename);
		}
		return true;
	}
	
	//--------------------------------------------------------------------------
	
	function createThumbnail($filename, $thumb_id, $dst_filename=NULL)
	{
		if(!@file_exists($filename) || !$this->dir_exists || $this->form_limit < 1){
			return false;
		}
		if(!function_exists('getimagesize') || !($sizeinfo = getimagesize($filename))){
			return false;
		}
		if(!($path_parts = @pathinfo($filename))){
			return false;
		}
		
		$w_max_array = array(XSNS_IMAGE_SIZE_S => 80, XSNS_IMAGE_SIZE_M => 120, XSNS_IMAGE_SIZE_L => 180);
		$h_max_array = array(XSNS_IMAGE_SIZE_S => 80, XSNS_IMAGE_SIZE_M => 120, XSNS_IMAGE_SIZE_L => 180);
		
		$w_max = $w_max_array[$thumb_id];
		$h_max = $h_max_array[$thumb_id];
		
		$width = $sizeinfo[0];
		$height = $sizeinfo[1];
		
		$w_ratio = ($width > $w_max)? $w_max/$width : 1.0;
		$h_ratio = ($height > $h_max)? $h_max/$height : 1.0;
		$ratio = ($w_ratio > $h_ratio)? $h_ratio : $w_ratio;
		
		if(is_null($dst_filename)){
			$thumb_filename = $this->upload_dir.'/thumbnail'.$thumb_id.'/'.basename($filename);
		}
		else{
			$thumb_filename = $dst_filename;
		}
		
		if($ratio < 1){
			if(!function_exists('imagecreatetruecolor') || !function_exists('imagecopyresampled')){
				return false;
			}
			$ext = $path_parts['extension'];
			
			switch(strtolower($ext)){
				case 'gif':
					if(!function_exists('imagecreatefromgif') || !function_exists('imagegif')){
						return false;
					}
					$source = imagecreatefromgif($filename);
					$output_func = 'imagegif';
					break;
				case 'jpg':
				case 'jpeg':
					if(!function_exists('imagecreatefromjpeg') || !function_exists('imagejpeg')){
						return false;
					}
					$source = imagecreatefromjpeg($filename);
					$output_func = 'imagejpeg';
					break;
				case 'png':
					if(!function_exists('imagecreatefrompng') || !function_exists('imagepng')){
						return false;
					}
					$source = imagecreatefrompng($filename);
					$output_func = 'imagepng';
					break;
				default:
					return false;
			}
			
			$new_width = intval($width * $ratio);
			$new_height = intval($height * $ratio);
			
			$thumb = imagecreatetruecolor($new_width, $new_height);
			imagecopyresampled($thumb, $source, 0, 0, 0, 0, $new_width, $new_height, $width, $height);
			return @call_user_func($output_func, $thumb, $thumb_filename);
		}
		else{
			return @copy($filename, $thumb_filename);
		}
	}
	
}

//******************************************************************************

?>
