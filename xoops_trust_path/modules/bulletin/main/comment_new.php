<?php

$com_itemid = isset($_GET['com_itemid']) ? intval($_GET['com_itemid']) : 0 ;

// If there are no articles
if( !Bulletin::isPublishedExists( $mydirname , $com_itemid) ){
	redirect_header($mydirurl.'/index.php',2,_MD_NOSTORY);
	exit();
}

$article = new Bulletin( $mydirname , $com_itemid);

$gperm =& BulletinGP::getInstance($mydirname) ;
if( ! $gperm->proceed4topic('can_read',$article->getVar('topicid')) ){
	redirect_header($mydirurl.'/index.php',2,_NOPERM);
	exit();
}

$com_replytext = _POSTEDBY.'&nbsp;<b>'.$article->getUname().'</b>&nbsp;'._DATE.'&nbsp;<b>'.formatTimestamp($article->getvar('published')).'</b><br /><br />'.$article->getVar('hometext');
$bodytext = $article->getDividedBodytext();
if ($bodytext != '') {
	$com_replytext .= '<br /><br />'.$bodytext.'';
}
$com_replytitle = $article->getVar('title');

$_GET['page'] = 'article';
require XOOPS_ROOT_PATH.'/include/comment_new.php';

?>