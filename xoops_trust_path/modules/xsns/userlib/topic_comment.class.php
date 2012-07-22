<?php

require_once 'root.class.php';


//******************************************************************************

class XsnsTopicComment extends XsnsRoot
{
	var $handler = NULL;
	
	//--------------------------------------------------------------------------
	
	function XsnsTopicComment()
	{
		// $key, $data_type, $default, $required, $size
		$this->initVar('c_commu_topic_comment_id', XOBJ_DTYPE_INT);
		$this->initVar('c_commu_topic_id', XOBJ_DTYPE_INT);
		$this->initVar('c_commu_id', XOBJ_DTYPE_INT);
		$this->initVar('uid', XOBJ_DTYPE_INT);
		$this->initVar('body', XOBJ_DTYPE_TXTAREA);
		$this->initVar('r_datetime', XOBJ_DTYPE_DATETIME);
		$this->initVar('r_date', XOBJ_DTYPE_DATE);
		$this->initVar('number', XOBJ_DTYPE_INT);

		$this->handler = array(
			'image' => XsnsImageHandler::getInstance(),
			'file' => XsnsFileHandler::getInstance(),
			'comment' => XsnsTopicCommentHandler::getInstance(),
		);
	}
	
	//--------------------------------------------------------------------------
	
	function &getImageList($target, $thumb_id=XSNS_IMAGE_SIZE_M)
	{
		return $this->handler['image']->getList($target, $this->getVar('c_commu_topic_comment_id'), $thumb_id);
	}
	
	//--------------------------------------------------------------------------
	
	function &getFileList($target)
	{
		return $this->handler['file']->getList($target, $this->getVar('c_commu_topic_comment_id'));
	}
	
	//--------------------------------------------------------------------------
	
	function getNumber()
	{
		$criteria = new CriteriaCompo(new Criteria('c_commu_topic_id', $this->getVar('c_commu_topic_id')));
		$criteria->add(new Criteria('c_commu_topic_comment_id', $this->getVar('c_commu_topic_comment_id'), '<='));
		return $this->handler['comment']->getCount($criteria) - 1;
	}
	
	//--------------------------------------------------------------------------
	
}

//******************************************************************************

class XsnsTopicCommentHandler extends XsnsRootHandler
{
	//--------------------------------------------------------------------------
	
	function XsnsTopicCommentHandler()
	{
		parent::XsnsRootHandler();
		$this->obj_class = "XsnsTopicComment";
		$this->table_name = "c_commu_topic_comment";
		$this->primary_key = "c_commu_topic_comment_id";
	}
	
	//--------------------------------------------------------------------------
	
	function &getInstance()
	{
		static $instance = NULL;
		if(is_null($instance)){
			$instance = new XsnsTopicCommentHandler();
		}
		return $instance;
	}
	
	//--------------------------------------------------------------------------
	
	function &getListByTopicId($topic_id, $limit=0, $start=0)
	{
		$criteria = new CriteriaCompo(new Criteria('c_commu_topic_id', $topic_id));
		$criteria->setSort('number');
		$criteria->setLimit($limit);
		$criteria->setStart($start);
		$obj_list =& $this->getObjects($criteria);
		$ret = array();
		$n = $start;
		foreach($obj_list as $key => $obj){
			if(!is_object($obj)){
				continue;
			}
			$ret[$n] = $obj->getVarsArray();
			if($n != $obj->getVar('number')){
				$n = $obj->getNumber();
				$ret[$n]['number'] = $n;
			}
			$n++;
		}
		return $ret;
	}
	
	//--------------------------------------------------------------------------
	
	function getCountByTopicId($topic_id)
	{
		$criteria = new Criteria('c_commu_topic_id', $topic_id);
		return $this->getCount($criteria);
	}
	
	//--------------------------------------------------------------------------
	
	function &getByNumber($topic_id, $number)
	{
		$ret = NULL;
		$criteria = new CriteriaCompo(new Criteria('c_commu_topic_id', $topic_id));
		$criteria->add(new Criteria('number', $number));
		$obj_list =& $this->getObjects($criteria);
		if(count($obj_list)==1){
			$ret =& $obj_list[0];
		}
		return $ret;
	}
	
	//--------------------------------------------------------------------------
	
	function &getListByNumbers($topic_id, $numbers, $number_as_key=true)
	{
		$ret = array();
		if(!is_array($numbers) || count($numbers)==0){
			return $ret;
		}
		$criteria = new CriteriaCompo(new Criteria('c_commu_topic_id', $topic_id));
		$criteria->add(new Criteria('number', '('.implode(',', $numbers).')', 'IN'));
		$obj_list =& $this->getObjects($criteria, true);
		foreach($obj_list as $obj){
			if($number_as_key){
				$ret[$obj->getVar('number')] = $obj->getVarsArray();
			}
			else{
				$ret[] = $obj->getVarsArray();
			}
		}
		return $ret;
	}
	
	//--------------------------------------------------------------------------
}

//******************************************************************************

?>
