<?php

require_once 'root.class.php';

//******************************************************************************

class XsnsTopic extends XsnsRoot
{
	var $handler = NULL;
	
	//--------------------------------------------------------------------------
	
	function XsnsTopic()
	{
		// $key, $data_type, $default, $required, $size
		$this->initVar('c_commu_topic_id', XOBJ_DTYPE_INT);
		$this->initVar('c_commu_id', XOBJ_DTYPE_INT);
		$this->initVar('name', XOBJ_DTYPE_TXTBOX);
		$this->initVar('r_datetime', XOBJ_DTYPE_DATETIME);
		$this->initVar('r_date', XOBJ_DTYPE_DATE);
		$this->initVar('uid', XOBJ_DTYPE_INT);
		
		$this->handler = array(
			'comment' => XsnsTopicCommentHandler::getInstance(),
			'image' => XsnsImageHandler::getInstance(),
			'file' => XsnsFileHandler::getInstance(),
		);
	}
	
	//--------------------------------------------------------------------------
	
	function &getCommentList($limit=0, $start=0)
	{
		return $this->handler['comment']->getListByTopicId($this->getVar('c_commu_topic_id'), $limit, $start);
	}
	//--------------------------------------------------------------------------
	
	function &getCommentListForPreview($limit=0, $start=0)
	{
		$num_criteria = new CriteriaCompo(new Criteria('number', 1+$start, '>='));
		$num_criteria->add(new Criteria('number', 1+$start+$limit, '<'));
		
		$num_criteria2 = new CriteriaCompo(new Criteria('number', 0));
		$num_criteria2->add($num_criteria, 'OR');
		
		$criteria = new CriteriaCompo(new Criteria('c_commu_topic_id', $this->getVar('c_commu_topic_id')));
		$criteria->add($num_criteria2);
		
		$obj_list =& $this->handler['comment']->getObjects($criteria, true);
		$ret = array();
		foreach($obj_list as $key => $obj){
			if(!is_object($obj)){
				continue;
			}
			$n = $obj->getNumber();
			$ret[$n] = $obj->getVarsArray();
			if($n != $obj->getVar('number')){
				$ret[$n]['number'] = $n;
			}
		}
		return $ret;
	}
	//--------------------------------------------------------------------------
	
	function getCommentCount()
	{
		return $this->handler['comment']->getCountByTopicId($this->getVar('c_commu_topic_id'));
	}
	//--------------------------------------------------------------------------
	
	function deleteCommentsAll()
	{
		// トピック内のコメントに添付された画像/ファイルを全て削除
		$comment_list =& $this->getCommentList();
		$comment_ids = array();
		foreach($comment_list as $comment){
			$comment_ids[] = $comment['c_commu_topic_comment_id'];
		}
		if(count($comment_ids) > 0){
			$criteria = new CriteriaCompo(new Criteria('target', 2));
			$criteria->add(new Criteria('target_id', '('.implode(',', $comment_ids).')', 'IN'));
			$this->handler['image']->deleteObjects($criteria);
			$this->handler['file']->deleteObjects($criteria);
		}
		
		// トピック内のコメントを全て削除
		$criteria = new Criteria('c_commu_topic_id', $this->getVar('c_commu_topic_id'));
		return $this->handler['comment']->deleteObjects($criteria);
	}
	//--------------------------------------------------------------------------
}

//******************************************************************************

class XsnsTopicHandler extends XsnsRootHandler
{
	
	//--------------------------------------------------------------------------
	
	function XsnsTopicHandler()
	{
		parent::XsnsRootHandler();
		$this->obj_class = "XsnsTopic";
		$this->table_name = "c_commu_topic";
		$this->primary_key = "c_commu_topic_id";
	}
	
	//--------------------------------------------------------------------------
	
	function &getInstance()
	{
		static $instance = NULL;
		if(is_null($instance)){
			$instance = new XsnsTopicHandler();
		}
		return $instance;
	}
	
	//--------------------------------------------------------------------------
	
	function &get($id)
	{
		$ret = false;
		if (intval($id) > 0) {
			$sql = "SELECT * FROM ".$this->prefix($this->table_name).
					" WHERE ".$this->primary_key."='".intval($id)."'";
			if ($result = $this->db->query($sql)) {
				$numrows = $this->db->getRowsNum($result);
				if ($numrows == 1) {
					$obj = new $this->obj_class();
					$obj->assignVars($this->db->fetchArray($result));
					$ret = $obj;
				}
			}
		}
		return $ret;
	}
	
	//--------------------------------------------------------------------------
	
	function &getListForCommunity($cid, $limit=0, $start=0, $get_body=false)
	{
		$ts =& XsnsTextSanitizer::getInstance();
		$image_handler =& XsnsImageHandler::getInstance();
		$file_handler =& XsnsFileHandler::getInstance();
		
		$ret = array();
		$base_url = XSNS_URL_TOPIC.'&tid=';
		
		$sql = "SELECT ".
				"ct.c_commu_topic_id AS tid,".
				"ct.name AS tname,".
				"MAX(ctc.r_datetime) AS max_r_datetime,".
				"ctc.c_commu_topic_comment_id AS tcid,".
				"COUNT(*) AS comment_count".
				" FROM ". $this->prefix('c_commu_topic_comment'). " ctc".
				" INNER JOIN ". $this->prefix('c_commu_topic'). " ct".
				" USING(c_commu_topic_id)".
				" WHERE ct.c_commu_id='".intval($cid)."'".
				" GROUP BY ctc.c_commu_topic_id".
				" ORDER BY max_r_datetime DESC";
		$rs = $this->db->query($sql, $limit, $start);
		if(!$rs){
			return $ret;
		}
		if($get_body){
			$comment_handler =& XsnsTopicCommentHandler::getInstance();
			
			while($row = $this->db->fetchArray($rs)){
				$comment =& $comment_handler->getByNumber($row['tid'], 0);
				
				$ret[] = array(
					'name' => $ts->makeTboxData4Show($row['tname']),
					'time' => XsnsUtils::getUserTimestamp($row['max_r_datetime']),
					'page_url' => $base_url. intval($row['tid']),
					'comment_count' => intval($row['comment_count'])-1,	// except comment No.0
					'body' => $comment->getVar('body'),
					'images' => $image_handler->getList(2, intval($row['tcid'])),
					'files' => $file_handler->getList(2, intval($row['tcid'])),
				);
				unset($comment);
			}
		}
		else{
			while($row = $this->db->fetchArray($rs)){
				$ret[] = array(
					'name' => $ts->makeTboxData4Show($row['tname']),
					'time' => XsnsUtils::getUserTimestamp($row['max_r_datetime']),
					'page_url' => $base_url. intval($row['tid']),
					'comment_count' => intval($row['comment_count'])-1,	// except comment No.0
					'body' => '',
				);
				unset($comment);
			}
		}
		return $ret;
	}
	
	//--------------------------------------------------------------------------
	
	function getCountForCommunity($cid)
	{
		$criteria = new CriteriaCompo(new Criteria('c_commu_id', intval($cid)));
		return $this->getCount($criteria);
	}
	
	//--------------------------------------------------------------------------
	
}

//******************************************************************************

?>
