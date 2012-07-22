<?php

if( ! class_exists( 'user_access' ) )
{
	include_once dirname( dirname(__FILE__) ).'/class/mycategory.php' ;
	require_once dirname( dirname(__FILE__) ).'/class/d3downloads.textsanitizer.php' ;

	class user_access extends MyCategory
	{
		var $db;
		var $table;
		var $cat_table;
		var $cat_ids;
		var $whr4cat;

		function user_access( $mydirname )
		{
			global $xoopsUser ;
			include_once dirname( dirname(__FILE__) ).'/include/mytable.php' ;

			$this->db =& Database::getInstance() ;
			$this->myts =& d3downloadsTextSanitizer::getInstance() ;
			$this->mydirname = $mydirname ;
			$this->table = $this->db->prefix( "{$mydirname}_user_access" ) ;
			$this->cat_table = $this->db->prefix( "{$mydirname}_cat" ) ;
			$module_handler =& xoops_gethandler('module') ;
			$module =& $module_handler->getByDirname( $mydirname ) ;
			if( is_object( $xoopsUser ) ) {
				$this->xoops_isuser = true ;
				$this->xoops_userid = $xoopsUser->getVar('uid') ;
				$mid = $module->getVar('mid') ;
				$this->xoops_isadmin = $xoopsUser->isAdmin( $mid ) ;
			} else {
				$this->xoops_isuser = false ;
				$this->xoops_userid = 0 ;
				$this->xoops_isadmin = false ;
			}
			// set sql4permission check
			$this->sql4cat_ids = "SELECT distinct u.cid,c.cids_child FROM ".$this->table." u LEFT JOIN ".$this->cat_table." c ON u.cid=c.cid WHERE c.pid ='0'" ;

			// set array4user_access
			$this->array4user_access = array_diff( $GLOBALS['d3download_tables']['user_access'] , array( 'cid' , 'uid' , 'groupid' ) ) ;

			// table columns
			$this->columns4group = implode( ',' , $this->array4user_access ) ;
			$this->columns4user = 'u.uid, u.uname';
			$this->columns4user .=  ',a.'.implode( ',a.' , $this->array4user_access ) ;
		}

// permission check part
		function permissions_of_current_user( $cid=0 )
		{
			if( empty( $cid ) ){
				$whr = $this->get_whr4cat() ;
				$sql = "SELECT * FROM ".$this->table." u LEFT JOIN ".$this->cat_table." c ON u.cid=c.cid WHERE ( $whr ) GROUP BY u.cid" ;
				$result = $this->db->query( $sql ) ;
				if( $result ) while( $row = $this->db->fetchArray( $result ) ) {
					$ret[ $row['cid'] ] = $row ;
				}
				if( empty( $ret ) ) return array( 0 => array() ) ;
				else return $ret ;
			} else {
				return array(
					'can_read'      => $this->can_read4cid( $cid ) ,
					'can_post'      => $this->can_post4cid( $cid ) ,
					'can_edit'      => $this->can_edit4cid( $cid ) ,
					'auto_approved' => $this->auto_approved4cid( $cid ) ,
					'edit_approved' => $this->edit_approved4cid( $cid ) ,
					'can_delete'    => $this->can_delete4cid( $cid ) ,
					'can_html'      => $this->can_html4cid( $cid ) ,
					'can_upload'    => $this->can_upload4cid( $cid ) ,
				) ;
			}
		}

		function can_read4cid( $cid )
		{
			$whr_cat4read = "cid IN (".implode(",", $this->can_read() ).")" ;
			return $this->user_access_for_cat( $cid, $whr_cat4read ) ;
		}

		function can_post4cid( $cid )
		{
			$whr_cat4post = "cid IN (".implode(",", $this->can_post() ).")" ;
			return $this->user_access_for_cat( $cid, $whr_cat4post ) ;
		}

		function can_edit4cid( $cid, $whr='' )
		{
			if( $this->xoops_isadmin ) {
				return true ;
			} elseif( $this->xoops_isuser ){
				if( empty( $whr_cat4edit ) ) $whr = "cid IN (".implode(",", $this->can_edit() ).")" ;
				return $this->user_access_for_cat( $cid, $whr ) ;
			} else {
				return false ;
			}
		}

		function auto_approved4cid( $cid )
		{
			if( $this->xoops_isadmin ) {
				return true ;
			} else {
				$whr_cat4approved = "cid IN (".implode(",", $this->auto_approved() ).")" ;
				return $this->user_access_for_cat( $cid, $whr_cat4approved ) ;
			}
		}

		function edit_approved4cid( $cid )
		{
			if( $this->xoops_isadmin ) {
				return true ;
			} elseif( $this->xoops_isuser ){
				$whr_cat4approved = "cid IN (".implode(",", $this->edit_approved() ).")" ;
				return $this->user_access_for_cat( $cid, $whr_cat4approved ) ;
			} else {
				return false ;
			}
		}

		function can_delete4cid( $cid )
		{
			if( $this->xoops_isadmin ) {
				return true ;
			} elseif( $this->xoops_isuser ){
				$whr_cat4delete = "cid IN (".implode(",", $this->can_delete() ).")" ;
				return $this->user_access_for_cat( $cid, $whr_cat4delete ) ;
			} else {
				return false ;
			}
		}

		function can_html4cid( $cid )
		{
			if( $this->xoops_isuser ){
				$whr_cat4html = "cid IN (".implode(",", $this->can_html() ).")" ;
				return $this->user_access_for_cat( $cid, $whr_cat4html ) ;
			} else {
				return false ;
			}
		}

		function can_upload4cid( $cid )
		{
			if( $this->xoops_isadmin ) {
				return true ;
			} else {
				$whr_cat4upload = "cid IN (".implode(",", $this->can_upload() ).")" ;
				return $this->user_access_for_cat( $cid, $whr_cat4upload ) ;
			}
		}

		function can_read( $permit=0 )
		{
			$whr4cat = $this->get_whr4cat( $permit ) ;
			// get categories
			$sql = "".$this->sql4cat_ids." AND u.can_read ='1' AND ( $whr4cat )" ;
			$cat_ids = $this->get_cat_ids( $sql ) ;
			if( empty( $cat_ids ) ) return array( 0 ) ;
			else return $cat_ids ;
		}

		function can_post()
		{
			$whr4cat = $this->get_whr4cat() ;
			// get categories
			$sql = "".$this->sql4cat_ids." AND u.can_post ='1' AND ( $whr4cat )" ;
			$cat_ids = $this->get_cat_ids( $sql ) ;
			if( empty( $cat_ids ) ) return array( 0 ) ;
			else return array_intersect( $cat_ids, $this->can_read() ) ;
		}

		function can_edit()
		{
			$whr4cat = $this->get_whr4cat() ;
			// get categories
			$sql = "".$this->sql4cat_ids." AND u.can_edit ='1' AND ( $whr4cat )" ;
			$cat_ids = $this->get_cat_ids( $sql ) ;
			if( empty( $cat_ids ) ) return array( 0 ) ;
			else return array_intersect( $cat_ids, $this->can_read() ) ;
		}

		function can_delete()
		{
			$whr4cat = $this->get_whr4cat() ;
			// get categories
			$sql = "".$this->sql4cat_ids." AND u.can_delete ='1' AND ( $whr4cat )" ;
			$cat_ids = $this->get_cat_ids( $sql ) ;
			if( empty( $cat_ids ) ) return array( 0 ) ;
			else return array_intersect( $cat_ids, $this->can_read() ) ;
		}

		function auto_approved()
		{
			$whr4cat = $this->get_whr4cat() ;
			// get categories
			$sql = "".$this->sql4cat_ids." AND u.post_auto_approved ='1' AND ( $whr4cat )" ;
			$cat_ids = $this->get_cat_ids( $sql ) ;
			if( empty( $cat_ids ) ) return array( 0 ) ;
			else return array_intersect( $cat_ids, $this->can_read() ) ;
		}

		function edit_approved()
		{
			$whr4cat = $this->get_whr4cat() ;
			// get categories
			$sql = "".$this->sql4cat_ids." AND u.edit_auto_approved ='1' AND ( $whr4cat )" ;
			$cat_ids = $this->get_cat_ids( $sql ) ;
			if( empty( $cat_ids ) ) return array( 0 ) ;
			else return array_intersect( $cat_ids, $this->can_read() ) ;
		}

		function can_html()
		{
			$whr4cat = $this->get_whr4cat() ;
			// get categories
			$sql = "".$this->sql4cat_ids." AND u.html ='1' AND ( $whr4cat )" ;
			$cat_ids = $this->get_cat_ids( $sql ) ;
			if( empty( $cat_ids ) ) return array( 0 ) ;
			else return array_intersect( $cat_ids, $this->can_read() ) ;
		}

		function can_upload()
		{
			$whr4cat = $this->get_whr4cat() ;
			// get categories
			$sql = "".$this->sql4cat_ids." AND u.upload ='1' AND ( $whr4cat )" ;
			$cat_ids = $this->get_cat_ids( $sql ) ;
			if( empty( $cat_ids ) ) return array( 0 ) ;
			else return array_intersect( $cat_ids, $this->can_read() ) ;
		}

		function get_whr4cat( $permit=0 )
		{
			global $xoopsUser ;

			if( is_object( $xoopsUser ) ) {
				$groups = $xoopsUser->getGroups() ;
				if( ! empty( $groups ) ) $whr4cat = "u.uid = '".$this->xoops_userid."' || u.groupid IN ( ".implode( ",", $groups )." )" ;
				else $whr4cat = "u.uid = '".$this->xoops_userid."'" ;
			} else {
				if ( empty( $permit ) ) $whr4cat = "u.groupid = '".intval( XOOPS_GROUP_ANONYMOUS )."'" ;
				else $whr4cat = "u.groupid = '".intval( XOOPS_GROUP_USERS )."'" ;
			}
			return $whr4cat ;
		}

		function get_cat_ids( $sql )
		{
			$cat_ids = array() ;
			$result = $this->db->query( $sql ) ;
			if( $result ) while( list( $id, $cids_child ) = $this->db->fetchRow( $result ) ) {
				$cat_ids = array_merge( $cat_ids, $this->getMycidsIntreeArray( intval( $id ), '', $cids_child ) ) ;
			}
			if( empty( $cat_ids ) ) return array( 0 ) ;
			else return $cat_ids ;
		}

		function user_access_for_cat( $cid, $whr )
		{
			$res = $this->db->query( "SELECT * FROM ".$this->cat_table." WHERE cid='".$cid."' AND ( $whr )" ) ;
			return $this->db->getRowsNum( $res ) ;
		}

// permissions show part
		function show_group_user_access( $cid, $pid )
		{
			if( ! empty( $cid ) ) $selectid = ( $pid > 0 ) ? $this->get_my_maincid( $cid ) : $cid ;
			elseif( $pid > 0 ) $selectid = $pid ;
			else return '' ;

			$group_handler =& xoops_gethandler( 'group' ) ;
			$groups =& $group_handler->getObjects() ;
			$group_trs= '' ;

			foreach( $groups as $group ) {
				$checked= array() ;
				$groupid = $group->getVar('groupid') ;
				$checked = $this->return_checked_show_mode( $selectid, $groupid ) ;
				if ( empty ( $checked ) ) continue ;
				$group_trs .= "
					<tr>
						<td colspan='2' class='even' style='text-align:center;'>
							<span style='font-size: small;'>".$group->getVar('name')."</span>
						</td>
						<td class='even' style='text-align:center;'>".$checked['can_read']."</td>
						<td class='even' style='text-align:center;'>".$checked['can_post']."</td>
						<td class='even' style='text-align:center;'>".$checked['can_edit']."</td>
						<td class='even' style='text-align:center;'>".$checked['can_delete']."</td>
						<td class='even' style='text-align:center;'>".$checked['post_auto_approved']."</td>
						<td class='even' style='text-align:center;'>".$checked['edit_auto_approved']."</td>
						<td class='even' style='text-align:center;'>".$checked['html']."</td>
						<td class='even' style='text-align:center;'>".$checked['upload']."</td>
					</tr>\n" ;
			}
			return $group_trs ;
		}

		function show_myuser_user_access( $cid, $pid )
		{
			if( ! empty( $cid ) ) $selectid = ( $pid > 0 ) ? $this->get_my_maincid( $cid ) : $cid ;
			elseif( $pid > 0 ) $selectid = $pid ;
			else return '' ;

			$fars = $this->db->query( "SELECT a.uid, u.uname FROM ".$this->table." a LEFT JOIN ".$this->db->prefix("users")." u ON a.uid=u.uid WHERE a.cid='".$selectid."' AND a.groupid IS NULL ORDER BY u.uid ASC" ) ;
			$user_trs= '' ;

			if( $this->db->getRowsNum( $fars ) > 0 ) {
				while( list( $id, $uname ) = $this->db->fetchRow( $fars ) ) {
					$checked= array() ;
					$uid = empty( $id ) ?  0 : intval( $id ) ;			
					$uname4disp = empty( $uname ) ?  '' : htmlspecialchars( $uname , ENT_QUOTES ) ;
					$checked = $this->return_checked_show_mode( $selectid, 0, $uid ) ;
					$user_trs .= "
					<tr>
						<td class='even' style='text-align:center;'>
							<span style='font-size: small;'>$uid</span>
						</td>
						<td colspan='2' class='even' style='text-align:center;'>
							<span style='font-size: small;'>$uname4disp</span>
						</td>
						<td class='even' style='text-align:center;'>".$checked['can_read']."</td>
						<td class='even' style='text-align:center;'>".$checked['can_post']."</td>
						<td class='even' style='text-align:center;'>".$checked['can_edit']."</td>
						<td class='even' style='text-align:center;'>".$checked['can_delete']."</td>
						<td class='even' style='text-align:center;'>".$checked['post_auto_approved']."</td>
						<td class='even' style='text-align:center;'>".$checked['edit_auto_approved']."</td>
						<td class='even' style='text-align:center;'>".$checked['html']."</td>
						<td class='even' style='text-align:center;'>".$checked['upload']."</td>
					</tr>\n" ;
				}
			}
			return $user_trs ;
		}

		function return_checked_show_mode( $cid, $groupid=0, $uid=0 )
		{
			if( empty( $groupid ) ) $whr4cat = "`uid`=$uid" ;
			else $whr4cat = "`groupid`=$groupid" ;

			$result = $this->db->query( "SELECT $this->columns4group FROM ".$this->table." WHERE ( $whr4cat ) AND cid='".$cid."'" ) ;
			if ( $this->db->getRowsNum( $result ) == 0 ) return array() ;

			$array = $this->db->fetchArray( $result ) ;

			foreach ( $array as $key=>$value ){
				$$key = intval( $value ) ;
				$checked[$key] = ( $$key == 1 ) ? '<span style="font-size: small;">'._MD_D3DOWNLOADS_PERMISSION.'</span>' : '' ;
				if( empty( $checked['can_read'] ) ) continue ;
			}
			return $this->checked_revision( $groupid, $checked ) ;
		}

		function checked_revision( $groupid, $checked )
		{
			if( empty( $checked['can_read'] ) ) foreach( $this->array4empty_can_read() as $key ) {
				$checked[$key] = '' ;
			}
			elseif( empty( $checked['can_post'] ) && ! $this->is_module_admin( $groupid ) ) foreach( $this->array4empty_can_post() as $key ) {
				$checked[$key] = '' ;
			}
			elseif( $this->is_module_admin( $groupid ) ) foreach( $this->array4checked_admin() as $key ) {
				$checked[$key] = '<span style="font-size: small;">'._MD_D3DOWNLOADS_PERMISSION.'</span>' ;
			}
			elseif( $groupid == intval( XOOPS_GROUP_ANONYMOUS ) ) foreach( $this->array4empty_anonymous() as $key ) {
				$checked[$key] = '' ;
			}
			return $checked ;
		}

		function is_module_admin( $groupid )
		{
			$module_handler =& xoops_gethandler('module') ;
			$module =& $module_handler->getByDirname( $this->mydirname ) ;
			$mid = intval( $module->getVar('mid') ) ;
			$moduleperm_handler =& xoops_gethandler('groupperm') ;

			if( $moduleperm_handler->checkRight('module_admin', $mid, $groupid ) ) return true ;
			else return false ;
		}

		function array4empty_can_read()
		{
			return array_diff( $this->array4user_access, array( 'can_read' ) ) ;
		}

		function array4empty_can_post()
		{
			return array_diff( $this->array4user_access, array( 'can_read', 'can_post' ) ) ;
		}

		function array4checked_admin()
		{
			return array_diff( $this->array4user_access, array( 'can_read', 'can_post', 'html' ) ) ;
		}

		function array4empty_anonymous()
		{
			return array_diff( $this->array4user_access, array( 'can_read', 'can_post', 'post_auto_approved', 'upload' ) ) ;
		}

		function canread_info( $cid )
		{
			$maincid = $this->get_my_maincid( $cid ) ;
			$group_handler = & xoops_gethandler( 'group' ) ;
			$groups =& $group_handler->getObjects() ;
			$canread_info = '| ' ;

			foreach( $groups as $group ) {
				$gid = $group->getVar('groupid') ;
				$result = $this->db->query( "SELECT * FROM ".$this->table." WHERE can_read ='1' AND groupid = '".$gid."' AND cid='".$maincid."'" ) ;
				$canread = $this->db->getRowsNum( $result ) ;
				$can_read_checked = ( ! empty( $canread ) ) ? _MD_D3DOWNLOADS_CAN_READ.' | ' :  _MD_D3DOWNLOADS_CANNOT_READ.' | ' ;
				$canread_info .= $group->getVar('name').' : '.$can_read_checked ;
			}
			return $canread_info ;
		}

// make form part
		function get_group_form( $cid, $pid, $show=0, $group_sel=0 )
		{
			if( $cid == 0 ) return $this->make_group_form( $cid, $group_sel ) ;
			elseif( $pid == 0 && empty( $show ) ) return $this->make_group_form( $cid, $group_sel ) ;
			else  return $this->show_group_user_access( $cid, $pid ) ;
		}

		function make_group_form( $cid, $group_sel=0 )
		{
			$group_handler =& xoops_gethandler( 'group' ) ;
			$groups =& $group_handler->getObjects() ;
			$group_trs = '' ;

			foreach( $groups as $group ) {
				$groupid = $group->getVar('groupid') ;
				if( $this->is_current_group_user_access( $cid, $groupid ) ) {
					$mygroup = $this->current_group_user_access( $cid, $groupid ) ;
				} elseif( $this->is_recentid_group_user_access( $groupid ) ){
					$mygroup = $this->recentid_group_user_access( $groupid ) ;
				} else {
					$mygroup = $this->default_group_user_access( $groupid ) ;
				}
				$can_read_checked = $mygroup['can_read'] ? "checked='checked'" : "" ;
				$can_post_checked = $mygroup['can_post'] ? "checked='checked'" : "" ;
				$can_edit_checked = $mygroup['can_edit'] ? "checked='checked'" : "" ;
				$can_delete_checked = $mygroup['can_delete'] ? "checked='checked'" : "" ;
				$post_auto_approved_checked = $mygroup['post_auto_approved'] ? "checked='checked'" : "" ;
				$edit_auto_approved_checked = $mygroup['edit_auto_approved'] ? "checked='checked'" : "" ;
				$html_checked = $mygroup['html'] ? "checked='checked'" : "" ;
				$upload_checked = $mygroup['upload'] ? "checked='checked'" : "" ;
				$group_trs .= "
					<tr>
						<td class='even' style='text-align:center;'>".$group->getVar('name')."</td>
						<td class='even' style='text-align:center;'>
							<input type=\"checkbox\" onclick=\"col_check_on_off( this, '_gid$groupid' )\">
						</td>
						<td class='even' style='text-align:center;'><input type='checkbox' name='can_read[$groupid]' id='gcol_1_{$groupid}_gid{$groupid}' value='1' $can_read_checked /></td>
						<td class='even' style='text-align:center;'><input type='checkbox' name='can_posts[$groupid]' id='gcol_2_{$groupid}_gid{$groupid}' value='1' $can_post_checked /></td>
						<td class='even' style='text-align:center;'><input type='checkbox' name='can_edits[$groupid]' id='gcol_3_{$groupid}_gid{$groupid}' value='1' $can_edit_checked /></td>
						<td class='even' style='text-align:center;'><input type='checkbox' name='can_deletes[$groupid]' id='gcol_4_{$groupid}_gid{$groupid}' value='1' $can_delete_checked /></td>
						<td class='even' style='text-align:center;'><input type='checkbox' name='post_auto_approveds[$groupid]' id='gcol_5_{$groupid}_gid{$groupid}' value='1' $post_auto_approved_checked /></td>
						<td class='even' style='text-align:center;'><input type='checkbox' name='edit_auto_approved[$groupid]' id='gcol_6_{$groupid}_gid{$groupid}' value='1' $edit_auto_approved_checked /></td>
						<td class='even' style='text-align:center;'><input type='checkbox' name='html[$groupid]' id='gcol_7_{$groupid}_gid{$groupid}' value='1' $html_checked /></td>
						<td class='even' style='text-align:center;'><input type='checkbox' name='upload[$groupid]' id='gcol_8_{$groupid}_gid{$groupid}' value='1' $upload_checked /></td>" ;
				if( empty( $group_sel ) )$group_trs .= "</tr>\n" ;
				else $group_trs .= "<td class='even' style='text-align:center;'><input type='checkbox' name='action_selects[$groupid]' id='col_action_g_{$groupid}' value='1'/></td></tr>\n" ;
			}
			return $group_trs ;
		}

		function get_user_form( $cid, $pid, $show=0, $user_sel=0 )
		{
			if( $cid == 0 ) return $this->make_user_form( $cid, $user_sel ) ;
			elseif( $pid == 0 && empty( $show ) ) return $this->make_user_form( $cid, $user_sel ) ;
			else  return $this->show_myuser_user_access( $cid, $pid ) ;
		}

		function make_user_form( $cid, $user_sel=0 )
		{
			if( $cid > 0 && $this->is_myuser_user_access( $cid ) ) $selectid = $cid ;
			elseif( $cid == 0 && $this->is_recentid_myuser_user_access() )  $selectid = $this->is_recentid_myuser_user_access() ; 
			else return '' ;

			$sql = "SELECT $this->columns4user FROM ".$this->table." a LEFT JOIN ".$this->db->prefix("users")." u ON a.uid=u.uid WHERE a.cid='".$selectid."' AND a.groupid IS NULL ORDER BY u.uid ASC" ;
			$fars = $this->db->query( $sql ) ;
			$user_trs= '' ;
			$myuser = array() ;

			while( $user_array = $this->db->fetchArray( $fars ) ) {
				foreach ( $user_array as $key=>$value ){
					$myuser[$key] = $value;
				}
				$uid = intval( $myuser['uid'] ) ;
				$uname4disp = htmlspecialchars( $myuser['uname'] , ENT_QUOTES ) ;

				$can_read_checked_user = $myuser['can_read'] ? "checked='checked'" : "" ;
				$can_post_checked_user = $myuser['can_post'] ? "checked='checked'" : "" ;
				$can_edit_checked_user = $myuser['can_edit'] ? "checked='checked'" : "" ;
				$can_delete_checked_user = $myuser['can_delete'] ? "checked='checked'" : "" ;
				$post_auto_approved_checked_user = $myuser['post_auto_approved'] ? "checked='checked'" : "" ;
				$edit_auto_approved_checked_user = $myuser['edit_auto_approved'] ? "checked='checked'" : "" ;
				$html_checked_user = $myuser['html'] ? "checked='checked'" : "" ;
				$upload_checked_user = $myuser['upload'] ? "checked='checked'" : "" ;
				$user_trs .= "
					<tr>
						<td class='even' style='text-align:center;'>$uid</td>
						<td class='even' style='text-align:center;'>$uname4disp</td>
						<td class='even' style='text-align:center;'>
							<input type=\"checkbox\" onclick=\"col_check_on_off( this, '_uid$uid' )\">
						</td>
						<td class='even' style='text-align:center;'><input type='checkbox' name='can_read_user[$uid]' id='ucol_1_{$uid}_uid{$uid}' value='1' $can_read_checked_user /></td>
						<td class='even' style='text-align:center;'><input type='checkbox' name='can_posts_user[$uid]' id='ucol_2_{$uid}_uid{$uid}' value='1' $can_post_checked_user /></td>
						<td class='even' style='text-align:center;'><input type='checkbox' name='can_edits_user[$uid]' id='ucol_3_{$uid}_uid{$uid}' value='1' $can_edit_checked_user /></td>
						<td class='even' style='text-align:center;'><input type='checkbox' name='can_deletes_user[$uid]' id='ucol_4_{$uid}_uid{$uid}' value='1' $can_delete_checked_user /></td>
						<td class='even' style='text-align:center;'><input type='checkbox' name='post_auto_approveds_user[$uid]' id='ucol_5_{$uid}_uid{$uid}' value='1' $post_auto_approved_checked_user /></td>
						<td class='even' style='text-align:center;'><input type='checkbox' name='edit_auto_approved_user[$uid]' id='ucol_6_{$uid}_uid{$uid}' value='1' $edit_auto_approved_checked_user /></td>
						<td class='even' style='text-align:center;'><input type='checkbox' name='html_user[$uid]' id='ucol_7_{$uid}_uid{$uid}' value='1' $html_checked_user /></td>
						<td class='even' style='text-align:center;'><input type='checkbox' name='upload_user[$uid]' id='ucol_8_{$uid}_uid{$uid}' value='1' $upload_checked_user /></td>" ;
				if( empty( $user_sel ) )$user_trs .= "</tr>\n" ;
				else $user_trs .= "<td class='even' style='text-align:center;'><input type='checkbox' name='action_selects_u[$uid]' id='col_action_u_{$uid}' value='1'/></td></tr>\n" ;
			}
			return $user_trs ;
		}

		function get_newuser_form( $cid, $user_sel=0 )
		{
			$newuser_trs = '' ;
			for( $i = 0 ; $i < 5 ; $i ++ ) {
				$newuser_trs .= "
					<tr>
						<td class='head' style='text-align:center;'><input type='text' size='4' name='new_uids[$i]' value='' /></th>
						<td class='head' style='text-align:center;'><input type='text' size='12' name='new_unames[$i]' value='' /></th>
						<td class='head' style='text-align:center;'>
							<input type=\"checkbox\" onclick=\"col_check_on_off( this, '_new$i' )\">
						</td>
						<td class='head' style='text-align:center;'><input type='checkbox' name='new_can_read[$i]' id='ncol_1_{$i}_new{$i}' checked='checked' /></th>
						<td class='head' style='text-align:center;'><input type='checkbox' name='new_can_posts[$i]' id='ncol_2_{$i}_new{$i}' value='1' /></th>
						<td class='head' style='text-align:center;'><input type='checkbox' name='new_can_edits[$i]' id='ncol_3_{$i}_new{$i}' value='1' /></td>
						<td class='head' style='text-align:center;'><input type='checkbox' name='new_can_deletes[$i]' id='ncol_4_{$i}_new{$i}' value='1' /></td>
						<td class='head' style='text-align:center;'><input type='checkbox' name='new_post_auto_approveds[$i]' id='ncol_5_{$i}_new{$i}' value='1' /></td>
						<td class='head' style='text-align:center;'><input type='checkbox' name='new_edit_auto_approved[$i]' id='ncol_6_{$i}_new{$i}' value='1' /></td>
						<td class='head' style='text-align:center;'><input type='checkbox' name='new_html[$i]' id='ncol_7_{$i}_new{$i}' value='1' /></td>
						<td class='head' style='text-align:center;'><input type='checkbox' name='new_upload[$i]' id='ncol_8_{$i}_new{$i}' value='1' /></td>" ;
				if( empty( $user_sel ) )$newuser_trs .= "</tr>\n" ;
				else $newuser_trs .= "<td class='head' style='text-align:center;'><input type='checkbox' name='new_action_selects_u[$i]' id='new_col_action_u_{$i}' value='1'/></td></tr>\n" ;
			}
			return $newuser_trs ;
		}

		function is_current_group_user_access( $cid, $groupid )
		{
			$fars = $this->db->query( "SELECT $this->columns4group FROM ".$this->table." WHERE groupid=".$groupid." AND cid='".$cid."'" ) ;
			if ( $this->db->getRowsNum( $fars ) == 0 ) {
				return false ;
			} else {
				return true ;
			}
		}

		function current_group_user_access( $cid, $groupid )
		{
			$fars = $this->db->query( "SELECT $this->columns4group FROM ".$this->table." WHERE groupid=".$groupid." AND cid='".$cid."'" ) ;
			$array = $this->db->fetchArray( $fars ) ;

			foreach ( $array as $key=>$value ){
				$mygroup[$key] = intval( $value ) ;
			}
			return $mygroup ;
		}

		function is_recentid_group_user_access( $groupid )
		{
			$id = $this->get_recent_updatecid( 1 ) ;
			$mars = $this->db->query( "SELECT $this->columns4group FROM ".$this->table." WHERE groupid=".$groupid." AND cid='".$id."'" ) ;

			if ( $this->db->getRowsNum( $mars ) == 0 ) {
				return false ;
			} else {
				return true ;
			}
		}

		function recentid_group_user_access( $groupid )
		{
			$id = $this->get_recent_updatecid( 1 ) ;
			$mars = $this->db->query( "SELECT $this->columns4group FROM ".$this->table." WHERE groupid=".$groupid." AND cid='".$id."'" ) ;
			$array = $this->db->fetchArray( $mars ) ;

			foreach ( $array as $key=>$value ){
				$mygroup[$key] = intval( $value ) ;
			}
			return $mygroup ;
		}

		function default_group_user_access( $groupid )
		{
			if( $this->is_module_admin( $groupid ) ){
				$mygroup['can_read'] = $mygroup['can_post'] = $mygroup['can_edit'] = $mygroup['can_delete'] = $mygroup['post_auto_approved'] = $mygroup['edit_auto_approved'] = $mygroup['upload'] = true ;
				$mygroup['html'] = false ;
			} elseif( $groupid == intval( XOOPS_GROUP_USERS ) ){
				$mygroup['can_read'] = true ;
				$mygroup['can_post'] = $mygroup['can_edit'] = $mygroup['can_delete'] = $mygroup['post_auto_approved'] = $mygroup['edit_auto_approved'] = $mygroup['html'] = $mygroup['upload']= false ;
			} else {
				$mygroup['can_read'] = true ;
				$mygroup['can_post'] = $mygroup['can_edit'] = $mygroup['can_delete'] = $mygroup['post_auto_approved'] = $mygroup['edit_auto_approved'] = $mygroup['html'] = $mygroup['upload']= false ;
			}
			return $mygroup ;
		}

		function is_myuser_user_access( $cid )
		{
			$fars = $this->db->query( "SELECT $this->columns4group FROM ".$this->table." WHERE cid='".$cid."' AND uid > 0" ) ;

			if ( $this->db->getRowsNum( $fars ) == 0 ) {
				return false ;
			} else {
				return true ;
			}
		}

		function is_recentid_myuser_user_access()
		{
			$id = $this->get_recent_updatecid( 1 ) ;
			$mars = $this->db->query( "SELECT $this->columns4group FROM ".$this->table." WHERE cid='".$id."' AND uid > 0" ) ;

			if ( $this->db->getRowsNum( $mars ) == 0 ) {
				return false ;
			} else {
				return $id ;
			}
		}

// make permissions part
		function group_update( $cid, $pid=0, $nodatesave=0 )
		{
			$error = 0 ;
			$count = $this->db->getRowsNum( $this->db->query( "SELECT * FROM ".$this->table." WHERE cid='".$cid."' AND groupid > 0" ) ) ;
			if( $count > 0 ) $this->db->query( "DELETE FROM ".$this->table." WHERE cid='".$cid."' AND groupid > 0" ) ;

			if( $pid == 0 ){
				$result = $this->db->query( "SELECT groupid FROM ".$this->db->prefix("groups") ) ;
				while( list( $groupid ) = $this->db->fetchRow( $result ) ) {
					$can_read = empty( $_POST['can_read'][$groupid] ) ? 0 : 1 ;
					$can_post = empty( $_POST['can_posts'][$groupid] ) ? 0 : 1 ;
					$can_edit = empty( $_POST['can_edits'][$groupid] ) ? 0 : 1 ;
					$can_delete = empty( $_POST['can_deletes'][$groupid] ) ? 0 : 1 ;
					$post_auto_approved = empty( $_POST['post_auto_approveds'][$groupid] ) ? 0 : 1 ;
					$edit_auto_approved = empty( $_POST['edit_auto_approved'][$groupid] ) ? 0 : 1 ;
					$html = empty( $_POST['html'][$groupid] ) ? 0 : 1 ;
					$upload = empty( $_POST['upload'][$groupid] ) ? 0 : 1 ;
					$set4sql = "cid='".$cid."'" ;
					$set4sql .= ",groupid='".$groupid."'" ;
					foreach( $this->array4user_access as $key ) {
						$set4sql .= ",$key='".$$key."'" ;
					}
					$sql="INSERT INTO ".$this->table." SET $set4sql";
					$res = $this->db->query( $sql ) ;
					if( ! $res ) $error = $cid ;
					elseif( empty( $nodatesave ) ) $this->date_save_cat_table( $cid ) ;
				}
			}
			return $error ;
		}

		function user_update( $cid, $pid=0, $nodatesave=0 )
		{
			$error = 0 ;
			$array4user = array( 'can_post_user', 'can_edit_user', 'can_delete_user', 'post_auto_approved_user', 'edit_auto_approved_user', 'html_user', 'upload_user' ) ;
			$count = $this->db->getRowsNum( $this->db->query( "SELECT * FROM ".$this->table." WHERE cid='".$cid."' AND uid > 0" ) ) ;
			if( $count > 0 ) $this->db->query( "DELETE FROM ".$this->table." WHERE cid='".$cid."' AND uid > 0" ) ;

			if( $pid == 0 ){
				$can_read_user = is_array( @$_POST['can_read_user'] ) ? $_POST['can_read_user'] : array() ;
				foreach( $can_read_user as $uid => $can_read_user ) {
					$uid = intval( $uid ) ;
					if( $can_read_user ) {
						$can_post_user = empty( $_POST['can_posts_user'][$uid] ) ? 0 : 1 ;
						$can_edit_user = empty( $_POST['can_edits_user'][$uid] ) ? 0 : 1 ;
						$can_delete_user = empty( $_POST['can_deletes_user'][$uid] ) ? 0 : 1 ;
						$post_auto_approved_user = empty( $_POST['post_auto_approveds_user'][$uid] ) ? 0 : 1 ;
						$edit_auto_approved_user = empty( $_POST['edit_auto_approved_user'][$uid] ) ? 0 : 1 ;
						$html_user = empty( $_POST['html_user'][$uid] ) ? 0 : 1 ;
						$upload_user = empty( $_POST['upload_user'][$uid] ) ? 0 : 1 ;
						$set4sql = "cid='".$cid."'" ;
						$set4sql .= ",uid='".$uid."'" ;
						$set4sql .= ",can_read='".$can_read_user."'" ;
						foreach( $array4user as $key ) {
							$name = str_replace( '_user', '', $key ) ;
							$set4sql .= ",$name='".$$key."'" ;
						}
						$res = $this->db->query( "INSERT INTO ".$this->table." SET $set4sql" ) ;
						if( ! $res ) $error = $cid ;
						elseif( empty( $nodatesave ) ) $this->date_save_cat_table( $cid ) ;
					}
				}

				$member_handler = & xoops_gethandler( 'member' ) ;
				if( is_array( @$_POST['new_uids'] ) ) foreach( $_POST['new_uids'] as $i => $uid ) {
					if( $this->already_save_uid_check( $cid, intval( $uid ) ) ) continue ;
					$can_post_user = empty( $_POST['new_can_posts'][$i] ) ? 0 : 1 ;
					$can_edit_user = empty( $_POST['new_can_edits'][$i] ) ? 0 : 1 ;
					$can_delete_user = empty( $_POST['new_can_deletes'][$i] ) ? 0 : 1 ;
					$post_auto_approved_user = empty( $_POST['new_post_auto_approveds'][$i] ) ? 0 : 1 ;
					$edit_auto_approved_user = empty( $_POST['new_edit_auto_approved'][$i] ) ? 0 : 1 ;
					$html_user = empty( $_POST['new_html'][$i] ) ? 0 : 1 ;
					$upload_user = empty( $_POST['new_upload'][$i] ) ? 0 : 1 ;
					if( empty( $uid ) ) {
						//require_once XOOPS_ROOT_PATH.'/class/criteria.php' ;
						$criteria = new Criteria( 'uname' , addslashes( @$_POST['new_unames'][$i] ) ) ;
						@list( $user ) = $member_handler->getUsers( $criteria ) ;
					} else {
						$user =& $member_handler->getUser( intval( $uid ) ) ;
					}
					if( is_object( $user ) ) {
						if( $this->already_save_uid_check( $cid, $user->getVar( 'uid' ) ) ) continue ;
						$set4sql = "cid='".$cid."'" ;
						$set4sql .= ",uid='".$user->getVar( 'uid' )."'" ;
						$set4sql .= ", can_read= 1" ;
						foreach( $array4user as $key ) {
							$name = str_replace( '_user', '', $key ) ;
							$set4sql .= ",$name='".$$key."'" ;
						}
						$res = $this->db->query( "INSERT INTO ".$this->table." SET $set4sql" ) ;
						if( ! $res ) $error = $cid ;
						elseif( empty( $nodatesave ) ) $this->date_save_cat_table( $cid ) ;
					}
				}
			}
			return $error ;
		}

		function already_save_uid_check( $cid, $uid )
		{
			$urs = $this->db->query( "SELECT uid FROM ".$this->table." WHERE uid=".$uid." AND cid='".$cid."'" ) ;
			if ( $this->db->getRowsNum( $urs ) == 0 ) return false ;
			else return true ;
		}

		function default_user_access( $cid, $nonerecent=0, $datesave=0 )
		{
			$error = 0 ;
			$this->db->query( "DELETE FROM ".$this->table." WHERE cid='".$cid."' AND groupid > 0" ) ;
			$group_handler =& xoops_gethandler( 'group' ) ;
			$groups =& $group_handler->getObjects() ;

			foreach( $groups as $group ) {
				$groupid = $group->getVar('groupid') ;
				if( empty( $nonerecent ) && $this->is_recentid_group_user_access( $groupid ) ){
					$error = $this->recentid_group_user_access_copy( $cid, $groupid ) ;
				} else {
					if( $this->is_module_admin( $groupid ) ) $error = $this->default_user_access_admin( $cid, $groupid ) ;
					elseif( $groupid == intval( XOOPS_GROUP_USERS ) ) $error = $this->default_user_access_users( $cid, $groupid ) ;
					elseif( $groupid == intval( XOOPS_GROUP_ANONYMOUS ) ) $error = $this->default_user_access_anonymous( $cid, $groupid ) ;
					else $error = $this->default_user_access_anonymous( $cid, $groupid ) ;
				}
			}
			if( ! empty( $datesave ) && empty( $error ) ) $this->date_save_cat_table( $cid ) ;
			return $error ;
		}

		function recentid_group_user_access_copy( $cid, $groupid )
		{
			$error = 0 ;
			$id = $this->get_recent_updatecid( 1 ) ;
			$mars = $this->db->query( "SELECT $this->columns4group FROM ".$this->table." WHERE groupid=".$groupid." AND cid='".$id."'" ) ;

			if ( $this->db->getRowsNum( $mars ) == 0 ) {
				return $cid ;
			}

			$array = $this->db->fetchArray( $mars ) ;
			foreach ( $array as $key=>$value ){
				$$key = intval( $value ) ;
			}

			$set4sql = "cid='".$cid."'" ;
			$set4sql .= ",groupid='".$groupid."'" ;

			foreach( $this->array4user_access as $key ) {
				$set4sql .= ",$key='".$$key."'" ;
			}

			$sql="INSERT INTO ".$this->table." SET $set4sql";
			$res = $this->db->query( $sql ) ;
			if( ! $res ) $error = $cid ;
			return $error ;
		}

		function default_user_access_admin( $cid, $groupid )
		{
			$error = 0 ;
			$irs = $this->db->query( "INSERT INTO ".$this->table." SET cid='".$cid."', groupid='".$groupid."', can_read='1', can_post='1', can_edit='1', can_delete='1', post_auto_approved='1', edit_auto_approved='1',html='0',upload='1'" ) ;
			if( ! $irs ) $error = $cid ;
			return $error ;
		}

		function default_user_access_users( $cid, $groupid )
		{
			$error = 0 ;
			$irs = $this->db->query( "INSERT INTO ".$this->table." SET cid='".$cid."', groupid='".$groupid."', can_read='1', can_post='0', can_edit='0', can_delete='0', post_auto_approved='0', edit_auto_approved='0',html='0',upload='0'" ) ;
			if( ! $irs ) $error = $cid ;
			return $error ;
		}
		
		function default_user_access_anonymous( $cid, $groupid )
		{
			$error = 0 ;
			$irs = $this->db->query( "INSERT INTO ".$this->table." SET cid='".$cid."', groupid='".$groupid."', can_read='1', can_post='0', can_edit='0', can_delete='0', post_auto_approved='0', edit_auto_approved='0',html='0',upload='0'" ) ;
			if( ! $irs ) $error = $cid ;
			return $error ;
		}

// permissions copy part
		function all_user_access_copy( $cid, $mode, $myid=0 )
		{
			if( $mode =='group' ) $idname = "groupid" ;
			elseif( $mode =='user' ) $idname = "uid" ;

			$error = 0 ;
			$sql = "DELETE FROM ".$this->table." WHERE cid NOT IN ('".$cid."') AND ".$idname." = '".$myid."'" ;
			$this->db->query( $sql ) ;
			$sql = "SELECT $this->columns4group FROM ".$this->table." WHERE cid='".$cid."' AND ".$idname." = '".$myid."'" ;
			$crs = $this->db->query( $sql ) ;
			if ( $this->db->getRowsNum( $crs ) == 0 ) {
				return '' ;
			}
			while( $array = $this->db->fetchArray( $crs ) ) {
				foreach ( $array as $key => $value ){
					$$key = intval( $value ) ;
				}
				$ars = $this->db->query("SELECT cid FROM ".$this->cat_table." WHERE pid='0' AND cid NOT IN ('".$cid."')") ;
				while( list( $id ) = $this->db->fetchRow( $ars ) ) {
					$catid = intval( $id ) ;
					$set4sql = "cid='".$catid."'" ;
					$set4sql .= ",".$idname."='".$myid."'" ;

					foreach( $this->array4user_access as $key ) {
						$set4sql .= ",$key='".$$key."'" ;
					}

					$sql="INSERT INTO ".$this->table." SET $set4sql";
					$res = $this->db->query( $sql ) ;
					if( ! $res ) $error = $cid ;
				}
			}
			return $error ;
		}

		function current_select_user_access_copy( $cid, $selectid, $mode, $myid=0 )
		{
			if( $mode =='group' ) $idname = "groupid" ;
			elseif( $mode =='user' ) $idname = "uid" ;

			$error = 0 ;
			$sql = "DELETE FROM ".$this->table." WHERE cid='".$selectid."' AND ".$idname." = '".$myid."'" ;
			$this->db->query( $sql ) ;
			$sql = "SELECT $this->columns4group FROM ".$this->table." WHERE cid='".$cid."' AND ".$idname." = '".$myid."'" ;
			$crs = $this->db->query( $sql ) ;

			if ( $this->db->getRowsNum( $crs ) == 0 ) {
				return '' ;
			}

			$array = $this->db->fetchArray( $crs ) ;
			foreach ( $array as $key => $value ){
				$$key = intval( $value ) ;
			}

			$set4sql = "cid='".$selectid."'" ;
			$set4sql .= ",".$idname."='".$myid."'" ;

			foreach( $this->array4user_access as $key ) {
				$set4sql .= ",$key='".$$key."'" ;
			}

			$sql="INSERT INTO ".$this->table." SET $set4sql";
			$res = $this->db->query( $sql ) ;
			if( ! $res ) $error = $cid ;
			return $error ;
		}

		function select_myuser_access_copy_execution( $cid, $selectid=0, $mode )
		{
			$error = 0 ;
			if( ! empty( $_POST['action_selects_u'] ) ) foreach( $_POST['action_selects_u'] as $id => $value ) {
				if( empty( $value ) ) continue ;
				$uid = intval( $id ) ;
				if( $mode =='selectcat' ) $error = $this->current_select_user_access_copy( $cid, $selectid, 'user', $uid ) ;
				elseif( $mode =='allcat' ) $error = $this->all_user_access_copy( $cid, 'user', $uid ) ;
			}

			$member_handler = & xoops_gethandler( 'member' ) ;
			if( ! empty( $_POST['new_action_selects_u'] ) ) foreach( $_POST['new_action_selects_u'] as $i => $value ) {
				if( empty( $value ) ) continue ;
				if( ! empty( $_POST['new_uids'][$i] ) ) $select_user = intval( @$_POST['new_uids'][$i] ) ;
				if( empty( $select_user ) ) {
					$criteria = new Criteria( 'uname' , addslashes( @$_POST['new_unames'][$i] ) ) ;
					@list( $user ) = $member_handler->getUsers( $criteria ) ;
				} else {
					$user =& $member_handler->getUser( $select_user ) ;
				}
				if( is_object( $user ) ) {
					$uid = $user->getVar( 'uid' ) ;
					if( $mode =='selectcat' ) $error = $this->current_select_user_access_copy( $cid, $selectid, 'user', $uid ) ;
					elseif( $mode =='allcat' ) $error = $this->all_user_access_copy( $cid, 'user', $uid ) ;
				}
			}
			return $error ;
		}

		// category move mode use only
		function current_user_access_copy( $cid, $selectid, $mode, $noupdate=0 )
		{
			if( $mode =='group' ) $idname = "groupid" ;
			elseif( $mode =='user' ) $idname = "uid" ;

			$error = 0 ;
			$currentcolumns = implode( ',' , array_diff( $GLOBALS['d3download_tables']['user_access'] , array( 'cid' ) ) ) ;

			if( $mode =='group' && empty( $noupdate ) ) $error = $this->group_update( $cid ) ;
			if( $mode =='user' && empty( $noupdate ) ) $error = $this->user_update( $cid ) ;

			$sql = "DELETE FROM ".$this->table." WHERE cid='".$selectid."' AND ".$idname." > 0" ;
			$this->db->query( $sql ) ;
			$sql = "SELECT $currentcolumns FROM ".$this->table." WHERE cid='".$cid."' AND ".$idname." > 0" ;
			$crs = $this->db->query( $sql ) ;

			if ( $this->db->getRowsNum( $crs ) == 0 ) {
				return '' ;
			}
			while( $array = $this->db->fetchArray( $crs ) ) {
				foreach ( $array as $key=>$value ){
					$$key = intval( $value ) ;
				}

				$set4sql = "cid='".$selectid."'" ;
				if( $mode =='group' ) $set4sql .= ",groupid='".intval( $groupid )."'" ;
				elseif( $mode =='user' ) $set4sql .= ",uid='".intval( $uid )."'" ;

				foreach( $this->array4user_access as $key ) {
					$set4sql .= ",$key='".$$key."'" ;
				}

				$sql="INSERT INTO ".$this->table." SET $set4sql";
				$res = $this->db->query( $sql ) ;
				if( ! $res ) $error = $cid ;
			}
			return $error ;
		}

// table check part
		function my_user_access_check()
		{
			$child = $this->get_my_cids_array( 0 , '', 0, 1 ) ;
			if( is_array ( $child ) ) foreach( $child as $childid ) {
				$urs = $this->db->query( "SELECT * FROM ".$this->table." WHERE cid='".intval( $childid )."'" ) ;
				if ( $this->db->getRowsNum( $urs ) > 0 ){
					$sql = "DELETE FROM ".$this->table." WHERE cid='".intval( $childid )."'" ;
					$this->db->query( $sql ) or die( "DB error: user_access table." ) ;
				}
			}

			$cids = $this->get_my_cids_array( 0 , '', 1 ) ;
			if( is_array ( $cids ) ) foreach( $cids as $id ) {
				$urs = $this->db->query( "SELECT * FROM ".$this->table." WHERE cid='".intval( $id )."'" ) ;
				if ( $this->db->getRowsNum( $urs ) == 0 ) $this->default_user_access( intval( $id ) ) ;
			}
		}
	}
}

?>