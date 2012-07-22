<?php

require_once 'root.class.php';

//******************************************************************************

class XsnsFile extends XsnsRoot
{
	//--------------------------------------------------------------------------
	
	function XsnsFile()
	{
		// $key, $data_type, $default, $required, $size
		$this->initVar('c_file_id', XOBJ_DTYPE_INT);
		$this->initVar('filename', XOBJ_DTYPE_TXTBOX);
		$this->initVar('org_filename', XOBJ_DTYPE_TXTBOX);
		$this->initVar('target', XOBJ_DTYPE_INT);
		$this->initVar('target_id', XOBJ_DTYPE_INT);
		$this->initVar('uid', XOBJ_DTYPE_INT);
	}
	
	//--------------------------------------------------------------------------
	
	function &getInfo()
	{
		$id = $this->getVar('c_file_id');
		
		$ret = array(
			'c_file_id' => $id,
			'icon' => $this->getIcon(),
			'filename' => $this->getVar('filename'),
			'caption' => rawurldecode($this->getVar('org_filename')),
			'url' => XSNS_FILE_URL.'?id='.$id,
			'url_del' => XSNS_URL_FILE.'&file_id='.$id,
		);
		return $ret;
	}
	
	//--------------------------------------------------------------------------
	
	function getIcon()
	{
		global $xoopsModuleConfig;
		$filename = $xoopsModuleConfig['file_upload_path'].'/'.$this->getVar('filename');
		if(!($fileinfo = @pathinfo($filename))){
			return NULL;
		}
		$extensionToMime = include( XOOPS_ROOT_PATH . '/class/mimetypes.inc.php' );
		$mime = $extensionToMime[$fileinfo['extension']];
		
		switch($mime){
			case 'text/plain':
				$file = 'page_white_text.png';
				$alt = 'text';
				break;
			case 'application/msword':
				$file = 'page_white_word.png';
				$alt = 'word';
				break;
			case 'application/vnd.ms-excel':
				$file = 'page_excel.png';
				$alt = 'excel';
				break;
			case 'application/vnd.ms-powerpoint':
				$file = 'page_white_powerpoint.png';
				$alt = 'powerpoint';
				break;
			case 'application/pdf':
				$file = 'page_white_acrobat.png';
				$alt = 'pdf';
				break;
			case 'video/x-msvideo':
			case 'video/mpeg':
			case 'video/x-ms-wmv':
				$file = 'film.png';
				$alt = 'video';
				break;
			case 'audio/x-wav':
			case 'audio/mpeg':
				$file = 'sound.png';
				$alt = 'audio';
				break;
			case 'video/x-flv':
				$file = 'page_white_flash.png';
				$alt = 'flash';
				break;
			default:
				return NULL;
		}
		$ret = '<img src="'.XSNS_BASE_URL.'/images/icon/'.$file.'" alt="'.$alt.'" style="vertical-align:middle;"> ';
		return $ret;
	}
	
	//--------------------------------------------------------------------------
	
}

//******************************************************************************

class XsnsFileHandler extends XsnsRootHandler
{
	var $form_limit = 1;
	var $upload_dir = NULL;
	var $dir_exists = true;
	var $handler = array();
	
	//--------------------------------------------------------------------------
	
	function XsnsFileHandler()
	{
		parent::XsnsRootHandler();
		$this->obj_class = "XsnsFile";
		$this->table_name = "c_file";
		$this->primary_key = "c_file_id";
		
		if(isset($this->module_config['file_upload_path'])){
			$this->upload_dir = $this->module_config['file_upload_path'];
			$this->dir_exists = is_dir($this->upload_dir) ? true : false;
		}
		else{
			$this->dir_exists = false;
		}
		
		if(isset($this->module_config['file_form_limit'])){
			$this->setFormLimit($this->module_config['file_form_limit']);
		}
		
		$this->handler['session'] =& XsnsSessionHandler::getInstance();
	}
	
	//--------------------------------------------------------------------------
	
	function &getInstance()
	{
		static $instance = NULL;
		if(is_null($instance)){
			$instance = new XsnsFileHandler();
		}
		return $instance;
	}
	
	//--------------------------------------------------------------------------
	
	function setFormLimit($limit)
	{
		$this->form_limit = intval($limit);
	}
	
	//--------------------------------------------------------------------------
	
	function &getList($target, $target_id)
	{
		$ret = array();
		if(!$this->dir_exists || $this->form_limit < 1){
			return $ret;
		}
		
		$criteria = new CriteriaCompo(new Criteria('target', $target));
		$criteria->add(new Criteria('target_id', $target_id));
		$criteria->setLimit($this->form_limit);
		if(!($obj_list =& $this->getObjects($criteria))){
			return $ret;
		}
		
		$ret = array();
		foreach($obj_list as $obj){
			if(@file_exists($this->upload_dir.'/'.$obj->getVar('filename'))){
				$ret[] =& $obj->getInfo();
			}
		}
		return $ret;
	}
	
	//--------------------------------------------------------------------------
	
	function &getListByIds($target, $target_ids)
	{
		$ret = array();
		if(!$this->dir_exists || !is_array($target_ids) || count($target_ids)==0){
			return $ret;
		}
		
		$criteria = new CriteriaCompo(new Criteria('target', $target));
		$criteria->add(new Criteria('target_id', '('.implode(',', $target_ids).')', 'IN'));
		if(!($obj_list =& $this->getObjects($criteria))){
			return $ret;
		}
		
		$ret = array();
		foreach($obj_list as $obj){
			if(@file_exists($this->upload_dir.'/'.$obj->getVar('filename'))){
				$ret[$obj->getVar('target_id')][] =& $obj->getInfo();
			}
		}
		return $ret;
	}
	
	//--------------------------------------------------------------------------
	
	function uploadFileTemp($name)
	{
		if(!isset($_FILES[$name]) || !$this->dir_exists || $this->form_limit < 1){
			return false;
		}
		require_once XSNS_USERLIB_DIR.'/file_uploader.php';
		
		$file_count = count($_FILES[$name]['name']);
		$mime_array = explode('|', $this->module_config['file_upload_mime']);
		$max_size = $this->module_config['file_upload_size'];
		
		$uploader = new XsnsFileUploader($this->upload_dir, $mime_array, $max_size);
		
		$count = 0;
		$ret = array();
		
		$file_temp = array();
		$sessid = session_id();
		
		for($i=0; $i<$file_count; $i++){
			if($count >= $this->form_limit){
				continue;
			}
			if($_FILES[$name]['error'][$i]==0 && $uploader->fetchMedia($name, $i)){
				$tmp_filename = md5(date('Y-m-d H:i:s'). $sessid. $i);
				if(!$uploader->checkFileNameLength($this->upload_dir.'/'.$tmp_filename)){
					continue;
				}
				$target_filename = $tmp_filename.'.'.$uploader->getExt();
				$target_filepath = $this->upload_dir.'/'.$target_filename;
				if(!$uploader->checkFileNameLength($target_filepath)){
					continue;
				}
				
				$uploader->setTargetFileName($target_filename);
				if($uploader->upload()){
					$filename = $this->upload_dir.'/'.$uploader->getSavedFileName();
					$ret[] = array(
						'caption' => $uploader->mediaName,
						'size' => filesize($filename),
					);
					$file_temp[$i]['filename'] = basename($filename);
					$file_temp[$i]['org_filename'] = $uploader->mediaName;
					$count++;
				}
			}
		}
		$this->handler['session']->setVar('file', $file_temp);
		return $ret;
	}
	
	//--------------------------------------------------------------------------
	
	function deleteFileTemp()
	{
		$file_list = $this->handler['session']->getVar('file');
		
		if(isset($file_list) && is_array($file_list) && $this->dir_exists){
			foreach($file_list as $file){
				if(!preg_match('/^[0-9a-f]{32}/i', $file['filename'])){
					continue;
				}
				@unlink($this->upload_dir. '/'. $file['filename']);
			}
			$this->handler['session']->clearVar('file');
		}
	}
	
	//--------------------------------------------------------------------------
	
	function uploadFile($prefix, $target, $target_id)
	{
		global $xoopsUser;
		$file_list = $this->handler['session']->getVar('file');
		
		if($this->form_limit < 1 || !is_object($xoopsUser) || !$this->dir_exists || !isset($file_list) || !is_array($file_list)){
			return false;
		}
		$own_uid = $xoopsUser->getVar('uid');
		
		$file_ids = array();
		$index = 0;
		
		foreach($file_list as $file){
			if($index >= $this->form_limit || !preg_match('/^[0-9a-f]{32}/i', $file['filename']) || !isset($file['org_filename'])){
				continue;
			}
			
			$temp_filepath = $this->upload_dir. '/'. $file['filename'];
			if(!@file_exists($temp_filepath)){
				continue;
			}
			
			if(!($fileinfo = @pathinfo($temp_filepath))){
				continue;
			}
			
			// 一時ファイルの名前をタイムスタンプに基づいて変換
			$timestamp_name = uniqid($prefix).$index.'.'.$fileinfo['extension'];
			$new_filename = $this->upload_dir.'/'.$timestamp_name;
			if(!@rename($temp_filepath, $new_filename)){
				continue;
			}
			
			// ファイル名をテーブルに格納
			$new_file =& $this->create();
			$new_file->setVars(array(
				'filename' => $timestamp_name,
				'org_filename' => rawurlencode($file['org_filename']),
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
		$this->handler['session']->clearVar('file');
		
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
		return true;
	}
	
	//--------------------------------------------------------------------------
	
}

//******************************************************************************

?>
