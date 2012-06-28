<?php

require_once dirname(dirname(__FILE__)).'/class/gtickets.php' ;
require_once dirname(dirname(__FILE__)).'/include/main_functions.php' ;
//require_once XOOPS_ROOT_PATH.'/class/xoopsblock.php' ;
require_once XOOPS_ROOT_PATH.'/class/template.php' ;

$myts =& MyTextSanitizer::getInstance() ;
$db =& Database::getInstance() ;

$module_handler =& xoops_gethandler( 'module' );
$module =& $module_handler->getByDirname( $mydirname );
$mid = $module->getVar('mid') ;

// PERMISSION ERROR
$moduleperm_handler =& xoops_gethandler( 'groupperm' ) ;
if( ! is_object( @$xoopsUser ) || ! $moduleperm_handler->checkRight( 'module_admin' , $mid , $xoopsUser->getGroups() ) ) {
	die( 'Only administrator can use this feature.' ) ;
}

// GET TPLSETS

$tplset_handler =& xoops_gethandler( 'tplset' );
$tplsets = array_keys( $tplset_handler->getList() );

$sql = "SELECT distinct tpl_tplset FROM ".$db->prefix("tplfile")." ORDER BY tpl_tplset='default' DESC,tpl_tplset";
$srs = $db->query($sql);
while( list( $tplset ) = $db->fetchRow( $srs ) ) {
	if( ! in_array( $tplset , $tplsets ) ) $tplsets[] = $tplset;
	$num_by_tplset[$tplset] = 0;
}

$config_tplsets = $xoopsConfig['template_set'] ;

// GET TPL_FILE OWNED BY THE MODULE

$sql = "SELECT tpl_file,tpl_desc,tpl_type,COUNT(tpl_id) FROM ".$db->prefix("tplfile")." WHERE tpl_file LIKE '%.css' AND tpl_module='$mydirname' GROUP BY tpl_file ORDER BY tpl_type, tpl_file" ;
$frs = $db->query($sql);
$tpl_files = array();
while( list( $tpl_file , $tpl_desc , $type , $count ) = $db->fetchRow( $frs ) ) {
	$tpl_files[] = $tpl_file;
}

// STYLE FOR DISTINGUISHING FINGERPRINTS
$fingerprint_styles = array( '' , 'background-color:#00FF00' , 'background-color:#00CC88' , 'background-color:#00FFFF' , 'background-color:#0088FF' , 'background-color:#FF8800' , 'background-color:#0000FF' , 'background-color:#FFFFFF' ) ;

$cssfiles = array();

// GET CSS TPL_FILE BELONGED TO THE MODULE
$frs = $db->query($sql);
while( list( $tpl_file , $tpl_desc , $type , $count ) = $db->fetchRow( $frs ) ) {
    $fingerprint_style_count = 0 ;

	$cssfile = array();
	$cssfile['file_name'] = htmlspecialchars($tpl_file,ENT_QUOTES);
	$cssfile['file_description'] = htmlspecialchars($tpl_desc,ENT_QUOTES);
    $cssfile['count'] = intval($count);

	// THE BASE FILE TEMPLATE COLUMN
	$name_string = explode($mydirname.'_',$tpl_file ,2 ) ;
	$css_file = $name_string[1];

	$basefilepath =  XOOPS_TRUST_PATH.'/uploads/'.$mydirname.'/'.$css_file;
	if( file_exists( $basefilepath ) ) {
		$str = '' ;
		$lines = file( $basefilepath );
		foreach( $lines as $line ) {
			if( trim( $line ) ) {
				$str .= md5( trim( $line ) ) ;
			}
		}
		$fingerprint = md5( $str ) ;

		$fingerprints[ $fingerprint ] = 1 ;
		$cssfile['file_last_modified'] = formatTimestamp(filemtime($basefilepath),'m');
		$cssfile['file_fingerprint'] = substr($fingerprint,0,16);
	}

	// DB TEMPLATE COLUMNS
	foreach( $tplsets as $tplset ) {
		$tplset4disp = htmlspecialchars( $tplset , ENT_QUOTES ) ;

		// QUERY FOR TEMPLATES IN DB
		$drs = $db->query( "SELECT * FROM ".$db->prefix("tplfile")." f NATURAL LEFT JOIN ".$db->prefix("tplsource")." s WHERE tpl_file='".addslashes($tpl_file)."' AND tpl_tplset='".addslashes($tplset)."'" ) ;
		$numrows = $db->getRowsNum( $drs ) ;
		$tpl = $db->fetchArray( $drs ) ;
		$db_tpls = array();
		$db_tpls['numrows'] = $numrows;
		$num_by_tplset[$tplset] += $numrows;
		if( !empty( $tpl['tpl_id'] ) ) {
			$str = '' ;
			$lines = explode( "\n" , $tpl['tpl_source']);
			foreach( $lines as $line ) {
				if( trim( $line ) ) {
				$str .= md5( trim( $line ) ) ;
				}
			}
			$fingerprint = md5( $str ) ;

			if( isset( $fingerprints[ $fingerprint ] ) ) {
				$style = $fingerprints[ $fingerprint ] ;
			} else {
				$fingerprint_style_count ++ ;
				$style = $fingerprint_styles[$fingerprint_style_count] ;
				$fingerprints[ $fingerprint ] = $style ;
			}

			$lid = intval($tpl['tpl_id']);
			$sql = "SELECT exportdir FROM ".$db->prefix($mydirname."_cssexport")." WHERE lid='".$lid."'";
			$res = $db->query( $sql);
			$exportdir = "";
			while( list( $dir ) = $db->fetchRow( $res ) ) {
				$exportdir = $myts->makeTboxData4Edit( $dir );
			}
			$db_tpls['lid'] = $lid;
			$db_tpls['style'] = $style;
			$db_tpls['tpl_tplset'] = htmlspecialchars($tpl['tpl_tplset'],ENT_QUOTES);
			$db_tpls['tpl_file'] = htmlspecialchars($tpl['tpl_file'],ENT_QUOTES);
			$db_tpls['tpl_lastmodified'] = intval($tpl['tpl_lastmodified']);
			$db_tpls['tpl_last_modified'] = formatTimestamp($tpl['tpl_lastmodified'],'m');
			$db_tpls['tpl_fingerprint'] = substr($fingerprint,0,16);
			$db_tpls['exportdir'] = $exportdir;
		}
		$cssfile['db_tpls'][] = $db_tpls;
		$num_by_tplset[$tplset] += $numrows;
	}
	$cssfiles[] = $cssfile; 
}

// CSS EXPORT DIR

$config_handler =& xoops_gethandler( 'config' );
$mod_config =& $config_handler->getConfigsByCat( 0, $module->getVar( 'mid' ) );
$css_export_dir = XOOPS_ROOT_PATH.'/'.htmlspecialchars ( @$mod_config['css_export_dir'] , ENT_QUOTES ) ;

// CSS EXPORT DIR UPDATE

if( ! empty( $_POST['submit_exportdir'] ) ) {
	if ( ! $xoopsGTicket->check( true , 'dbcss' ) ) {
		redirect_header(XOOPS_URL.'/modules/'.$mydirname.'/admin/index.php',3,$xoopsGTicket->getErrors());
	}

	$errors = array() ;
	foreach( $_POST['exportdir'] as $lid => $exportdir ) {
		$lid = intval( $lid ) ;
		$exportdir = "'".mysql_real_escape_string($myts->stripSlashesGPC( @$_POST['exportdir'][$lid] ))."'" ;

		$sql = "SELECT COUNT(*) FROM ".$db->prefix($mydirname."_cssexport")." WHERE lid='".$lid."'";
		list($count) = $db->fetchRow( $db->query($sql) );
		if( $count > 0 ){
			$result = $db->query( "UPDATE ".$db->prefix($mydirname."_cssexport")." SET exportdir=$exportdir WHERE lid=$lid" ) ;
			if( ! $result ) $errors[] = $lid ;
		} else {
			$result = $db->query( "INSERT INTO ".$db->prefix($mydirname."_cssexport")." ( lid, exportdir ) VALUES ( $lid, $exportdir ) " );
			if( ! $result ) $errors[] = $lid ;
		}
	}
	redirect_header( XOOPS_URL."/modules/$mydirname/admin/index.php?page=export" , 2 , $errors ? sprintf( _MD_DBCSS_ERROR_MESSEAGE , implode( ',' , $errors ) ) : _MD_DBCSS_REGSTERED ) ;
	exit();
}

// EXPORT
if( ! empty( $_POST['submitexport'] ) ) {
	if ( ! $xoopsGTicket->check( true , 'dbcss' ) ) {
		redirect_header(XOOPS_URL.'/modules/'.$mydirname.'/admin/index.php',3,$xoopsGTicket->getErrors());
	}

	$tplset = implode( '', array_keys( $_POST['submitexport'] ) );

	if( empty( $_POST[$tplset.'_check'] ) ) {
		redirect_header( XOOPS_URL."/modules/$mydirname/admin/index.php?page=export", 2, _MD_DBCSS_EXPORT_CHECK_NONE);
		exit();
	} else {
		foreach( @$_POST[$tplset.'_check'] as $lid => $value ) {
			if( empty( $value ) ) continue ;
			$lid = intval( $lid ) ;

			$result = $db->query( "SELECT exportdir FROM ".$db->prefix($mydirname."_cssexport")." WHERE lid='".$lid."'");
			$myexportdir = "";
			while( list( $exportdir ) = $db->fetchRow( $result ) ) {
				$myexportdir = $exportdir ? XOOPS_ROOT_PATH.'/'.htmlspecialchars ( $exportdir , ENT_QUOTES ) : "" ;
			}

			if( ! empty( $myexportdir ) ){
				$export_dir = $myexportdir ;
			} else {
				$export_dir = $css_export_dir ;
			}

			if( ! file_exists( $export_dir ) ) {
				redirect_header( XOOPS_URL."/modules/$mydirname/admin/index.php?page=export", 2, _MD_DBCSS_EXPORT_DIR_NONE);
				exit();
			} elseif( ! is_writable( $export_dir ) ) {
				redirect_header( XOOPS_URL."/modules/$mydirname/admin/index.php?page=export", 2, _MD_DBCSS_EXPORT_DIR_NONEWRITABLE);
				exit();
			} else {
				$css_tpl = "" ;
				$res = $db->query( "SELECT distinct tpl_id, tpl_file, tpl_tplset, tpl_source FROM ".$db->prefix("tplfile")." NATURAL LEFT JOIN ".$db->prefix("tplsource")." WHERE tpl_id=\"".$lid."\" AND tpl_tplset=\"$tplset\"") ;

				while( list( $id, $tpl_file, $tpl_tplset, $tpl_source ) = $db->fetchRow( $res ) ) {
					$css_tpl = htmlspecialchars( $tpl_file, ENT_QUOTES );
					$data = $myts->stripSlashesGPC( $tpl_source ) ;
				}
				$css_export_file = '';
				$name_string = explode($mydirname.'_',$css_tpl ,2 ) ;
				$filename = $name_string[1];
				$css_export_file = $export_dir.$filename ;

				$fp = fopen( $css_export_file, 'w' );
				fwrite( $fp, $data );
				fclose( $fp );
				if( ! file_exists( $css_export_file ) ) {
					redirect_header( XOOPS_URL."/modules/$mydirname/admin/index.php?page=export", 2, _MD_DBCSS_EXPORT_ERROR);
					exit();
				}
			}
		}
		redirect_header( XOOPS_URL."/modules/$mydirname/admin/index.php?page=export", 2, _MD_DBCSS_EXPORTTED);
		exit();
	}
}

// UPLOAD

$import_tplsets = dbcss_getimport_tplsets();
$css_path = XOOPS_TRUST_PATH.'/uploads/'.$mydirname ;

if( isset( $_FILES['file_inport'] ) && isset( $_POST['submit_inport'] ) ) {
	if ( ! $xoopsGTicket->check( true , 'dbcss' ) ) {
		redirect_header(XOOPS_URL.'/modules/'.$mydirname.'/admin/index.php',3,$xoopsGTicket->getErrors());
	}

	if( ! file_exists( $css_path ) ) {
		redirect_header( XOOPS_URL."/modules/$mydirname/admin/index.php?page=export", 2, _MD_DBCSS_CSS_DIR_NONE );
		exit();
	}

	if( ! is_writable( $css_path ) ) {
		redirect_header( XOOPS_URL."/modules/$mydirname/admin/index.php?page=export", 2, _MD_DBCSS_CSS_DIR_NOWRITABLE );
		exit();
	}

	$errors = array() ;
	$request4inport = $_FILES['file_inport']  ;
	$file_name = htmlspecialchars( $_FILES['file_inport']['name'], ENT_QUOTES );

	// $file_type = htmlspecialchars( $request4inport['type'], ENT_QUOTES );
	$file_tmp_name = htmlspecialchars( $request4inport['tmp_name'], ENT_QUOTES );
	// $file_size = intval( $request4inport['size'] );
	// $file_error = intval( $request4inport['error'] );
	$uploads_path = XOOPS_TRUST_PATH.'/uploads/'.$mydirname.'/'.$file_name;
	// SET EXTENSION.
	$permit_ext = array('css');

	$select_tplsets = isset($_POST['import_tplsets']) ? htmlspecialchars($_POST['import_tplsets'], ENT_QUOTES ) : "";

	if( is_uploaded_file ( $file_tmp_name ) ){
		$f_info = pathinfo( $file_name );
		$f_ext = $f_info['extension'];

		// EXTENSION CHECK.
		if( in_array( $f_ext, $permit_ext ) ){

			// ATTACK CHECK FOR SECURITY.
			$fileline = file_get_contents( $file_tmp_name );

			if ( ! empty( $fileline) ) {
				if ( preg_match( '/<\\?php./i' , $fileline ) ) {
					die('Attack detected');
				} elseif ( preg_match( '/<script./i' , $fileline ) ) {
					die('Attack detected');
				}
			}
			$result = move_uploaded_file ( $file_tmp_name , $uploads_path );
		} else {
			redirect_header( XOOPS_URL."/modules/$mydirname/admin/index.php?page=export", 2, _MD_DBCSS_UPLOADERROR.$f_ext._MD_DBCSS_UPLOADEXITERROR);
			exit();
		}
	} else {
		redirect_header( XOOPS_URL."/modules/$mydirname/admin/index.php?page=export", 2, _MD_DBCSS_UPLOADE_ERROR);
		exit();
	}

// IMPORT

	if ( $result == true ) {
		$file_path = $css_path . '/' . $file_name ;

		if ( is_file( $file_path ) && substr( $file_name , -4 ) == '.css'){
			$mtime = mysql_real_escape_string( intval( @filemtime( $file_path ) ) );
			$tpl_source = mysql_real_escape_string( file_get_contents( $file_path ) );
			$upload_tpl = mysql_real_escape_string( $mydirname.'_'.$file_name);
			$inported_file = $mydirname.'_'.$file_name ;

			$sql = "SELECT COUNT(*) FROM ".$db->prefix("tplfile")." WHERE tpl_module=\"".$mydirname."\" AND tpl_tplset=\"default\" AND tpl_file=\"".$upload_tpl."\"";
			list( $count ) = $db->fetchRow( $db->query( $sql ) );

			if( ! empty( $select_tplsets ) ){
				$select_sql = "SELECT COUNT(*) FROM ".$db->prefix("tplfile")." WHERE tpl_module=\"".$mydirname."\" AND tpl_tplset=\"".$select_tplsets."\" AND tpl_file=\"".$upload_tpl."\"";
				list( $select_count ) = $db->fetchRow( $db->query( $select_sql ) );
			}

			// NEW TPL IMPORT
			if( empty( $count ) ){
				$sql  = "INSERT INTO ".$db->prefix("tplfile")." ( tpl_id, tpl_refid, tpl_module, tpl_tplset, tpl_file, tpl_desc, tpl_lastmodified, tpl_lastimported, tpl_type ) ";
				$sql .= "VALUES( 'NULL', '".$mid."','".$mydirname."', 'default', '".$upload_tpl."', '', '".$mtime."', '0', 'module' )"; 
				$result = $db->query($sql);
				$tpl_id = $db->getInsertId() ;
				if( ! $result ) $errors[] = $file_name ;

				if( empty ( $tpl_id ) ){
					redirect_header( XOOPS_URL."/modules/$mydirname/admin/index.php?page=export", 2, sprintf( _MD_DBCSS_INSERTTEMPLATEERROR , $file_name ) );
					exit();
				} else {
					$sql  = "INSERT INTO ".$db->prefix("tplsource")." ( tpl_id, tpl_source) ";
					$sql .= "VALUES( '".$tpl_id."', '".$tpl_source."')"; 
					$result = $db->query($sql);
					xoops_template_touch( $tpl_id ) ;
					if( ! $result ) $errors[] = $file_name ;
				}
			}

			// NEW SELECT TPL IMPORT
			if( ! empty( $select_tplsets ) && empty( $select_count ) ){
				if( empty( $select_count ) ) {
					$select_sql  = "INSERT INTO ".$db->prefix("tplfile")." ( tpl_id, tpl_refid, tpl_module, tpl_tplset, tpl_file, tpl_desc, tpl_lastmodified, tpl_lastimported, tpl_type ) ";
					$select_sql .= "VALUES( 'NULL', '".$mid."','".$mydirname."', '".$select_tplsets."', '".$upload_tpl."', '', '".$mtime."', '0', 'module' )"; 
					$result = $db->query($select_sql);
					$select_tplid = $db->getInsertId() ;
					if( ! $result ) $errors[] = $file_name ;

					if( empty ( $select_tplid ) ){
						redirect_header( XOOPS_URL."/modules/$mydirname/admin/index.php?page=export", 2, sprintf( _MD_DBCSS_INSERTTEMPLATEERROR , implode( ',' , $file_name ) ));
						exit();
					} else {
						$select_sql  = "INSERT INTO ".$db->prefix("tplsource")." ( tpl_id, tpl_source) ";
						$select_sql .= "VALUES( '".$select_tplid."', '".$tpl_source."')"; 
						$result = $db->query($select_sql);
						xoops_template_touch( $select_tplid ) ;
						if( ! $result ) $errors[] = $file_name ;
					}
				}
			}

			// TPL UPDATE
			if( empty( $tpl_id ) && empty( $select_tplid ) ) {
				$res = $db->query("SELECT * FROM ".$db->prefix( "tplfile" )." WHERE tpl_module=\"".$mydirname."\" AND tpl_file=\"".$upload_tpl."\"");
				while( list( $id ) = $db->fetchRow( $res ) ) {
					$update_id = intval( $id ) ;
					$result = $db->query( "UPDATE ".$db->prefix( "tplfile" )." SET tpl_lastmodified=$mtime,tpl_lastimported=UNIX_TIMESTAMP() WHERE tpl_id='$update_id'" ) ;
					if( ! $result ) $errors[] = $file_name ;
					$result = $db->queryF( "UPDATE ".$db->prefix( "tplsource" )." SET tpl_source=\"".$tpl_source."\" WHERE tpl_id=\"".$update_id."\"" ) ;
					if( ! $result ) $errors[] = $file_name ;
					xoops_template_touch( $update_id ) ;
				}
			}
			if( ! empty( $update_id ) ) {
				redirect_header( XOOPS_URL."/modules/$mydirname/admin/index.php?page=export" , 2 , $errors ? sprintf( _MD_DBCSS_INSERTTEMPLATEERROR , implode( ',' , $errors ) ) : $inported_file._MD_DBCSS_UPLOADED ) ;
				exit();
			} else {
				redirect_header( XOOPS_URL."/modules/$mydirname/admin/index.php?page=export", 2, $errors ? sprintf( _MD_DBCSS_INSERTTEMPLATEERROR , implode( ',' , $errors ) ) : $inported_file._MD_DBCSS_INPORTED);
				exit();
			}
		}
	} else {
		redirect_header( XOOPS_URL."/modules/$mydirname/admin/index.php?page=export", 2, _MD_DBCSS_UPLOADE_ERROR);
		exit();
	}

}

// COPY TPL
$copy_tplsets = dbcss_copy_tplsets() ;

if( ! empty( $_POST['submitcopy'] ) ) {
	if ( ! $xoopsGTicket->check( true , 'dbcss' ) ) {
		redirect_header(XOOPS_URL.'/modules/'.$mydirname.'/admin/index.php',3,$xoopsGTicket->getErrors());
	}

	$tplset = implode( '', array_keys( $_POST['submitcopy'] ) );
	$copy4tplsets = '';
	$copy4tplsets = htmlspecialchars( $_POST['copy_tplsets'][$tplset], ENT_QUOTES);

	if( empty( $_POST[$tplset.'_check'] ) || empty( $copy4tplsets ) ) {
		redirect_header( XOOPS_URL."/modules/$mydirname/admin/index.php?page=export", 2, _MD_DBCSS_COPY_CHECK_NONE);
		exit();
	} else {
		$errors = array() ;
		foreach( @$_POST[$tplset.'_check'] as $lid => $value ) {
			if( empty( $value ) ) continue ;
			$tpl_id = intval( $lid ) ;

			$result = $db->query( "SELECT tpl_id, tpl_refid, tpl_module, tpl_tplset, tpl_file, tpl_desc, tpl_lastmodified, tpl_lastimported, tpl_type,tpl_source FROM ".$db->prefix("tplfile")." NATURAL LEFT JOIN ".$db->prefix("tplsource")." WHERE tpl_id=\"".$tpl_id."\" AND tpl_tplset=\"".$tplset."\"") ;
			while( list( $id, $tpl_refid, $tpl_module, $tpl_tplset, $tpl_file, $tpl_desc, $tpl_lastmodified, $tpl_lastimported, $tpl_type, $tpl_source ) = $db->fetchRow( $result ) ) {
				$org_refid = mysql_real_escape_string( $myts->stripSlashesGPC( $id ) );
				$org_module = mysql_real_escape_string( $myts->stripSlashesGPC( $tpl_module ) );
				$org_tplset = mysql_real_escape_string( $myts->stripSlashesGPC( $tpl_tplset ) );
				$org_file = mysql_real_escape_string( $myts->stripSlashesGPC( $tpl_file ) );
				$org_desc = mysql_real_escape_string( $myts->stripSlashesGPC( $tpl_desc ) );
				$org_lastmodified = mysql_real_escape_string( intval( $tpl_lastmodified ) );
				$org_lastimported = mysql_real_escape_string( intval( $tpl_lastimported ) );
				$org_type = mysql_real_escape_string( $myts->stripSlashesGPC( $tpl_type ) );
				$org_source = mysql_real_escape_string( $myts->stripSlashesGPC( $tpl_source ) );
			}
			if( $org_tplset == $copy4tplsets ){
				redirect_header( XOOPS_URL."/modules/$mydirname/admin/index.php?page=export", 2, _MD_DBCSS_COPYABORT);
				exit();
			} else {
				$copy4_id = '';
				$res = $db->query( "SELECT tpl_id, tpl_tplset FROM ".$db->prefix("tplfile")." WHERE tpl_file=\"".$org_file."\" AND tpl_tplset=\"".$copy4tplsets."\"" ) ;
				while( list( $id ) = $db->fetchRow( $res ) ) {
					$copy4_id = mysql_real_escape_string( intval( $id ) );
				}
				if( ! empty( $copy4_id ) ){
					// UPDATE TPL
					$result = $db->query( "UPDATE ".$db->prefix("tplfile")." SET tpl_refid='".$org_refid."', tpl_module='".$org_module."', tpl_tplset='".$copy4tplsets."', tpl_file='".$org_file."',tpl_desc='".$org_desc."',tpl_lastmodified='".$org_lastmodified."',tpl_lastimported='".$org_lastimported."',tpl_type='".$org_type."' WHERE tpl_id='$copy4_id'" ) ;
					if( ! $result ) $errors[] = $tpl_id ;
					$result = $db->query( "UPDATE ".$db->prefix("tplsource")." SET tpl_source='".$org_source."' WHERE tpl_id='$copy4_id'" ) ;
					if( ! $result ) $errors[] = $tpl_id ;
					xoops_template_touch( $copy4_id ) ;
				} else {
					// INSERT TPL
					$sql  = "INSERT INTO ".$db->prefix("tplfile")." ( tpl_id, tpl_refid, tpl_module, tpl_tplset, tpl_file, tpl_desc, tpl_lastmodified, tpl_lastimported, tpl_type ) ";
					$sql .= "VALUES( 'NULL', '".$org_refid."','".$org_module."', '$copy4tplsets', '".$org_file."', '$org_desc', '".$org_lastmodified."', '$org_lastimported', '$org_type' )"; 
					$result = $db->query($sql);
					$copyed_id = $db->getInsertId() ;
					if( ! $result ){
						$errors[] = $tpl_id ;
						redirect_header( XOOPS_URL."/modules/$mydirname/admin/index.php?page=export", 2, sprintf( _MD_DBCSS_COPYTEMPLATEERROR , implode( ',' , $errors ) ));
						exit();
					} else {
						$sql  = "INSERT INTO ".$db->prefix("tplsource")." ( tpl_id, tpl_source ) ";
						$sql .= "VALUES( '".$copyed_id."', '".$org_source."')"; 
						$result = $db->query($sql);
						xoops_template_touch( $copyed_id ) ;
						if( ! $result ) $errors[] = $tpl_id ;
					}
				}
			}
		}
	}
	redirect_header( XOOPS_URL."/modules/$mydirname/admin/index.php?page=export" , 2 , $errors ? sprintf( _MD_DBCSS_ERROR_MESSEAGE , implode( ',' , $errors ) ) : _MD_DBCSS_COPYED ) ;
	exit();
}

// FILE TO DB COPY

if( ! empty( $_POST['submitcopy2db'] ) ) {
	if ( ! $xoopsGTicket->check( true , 'dbcss' ) ) {
		redirect_header(XOOPS_URL.'/modules/'.$mydirname.'/admin/index.php',3,$xoopsGTicket->getErrors());
	}

	$copy4db = '';
	$copy4db = htmlspecialchars( $_POST['copy2dbselect'], ENT_QUOTES );

	if( empty( $copy4db ) || empty( $_POST['basecheck'] ) ){
		redirect_header( XOOPS_URL."/modules/$mydirname/admin/index.php?page=export", 2, _MD_DBCSS_COPY_CHECK_NONE);
		exit();
	} else {
		$css_tpls = array_keys($_POST['basecheck']);
		$errors = array() ;
		foreach( $css_tpls as $value ) {
			if( empty( $value ) ) continue ;
			$tpl_name =  htmlspecialchars( $value, ENT_QUOTES );
			$name_string = explode($mydirname.'_',$tpl_name ,2 ) ;
			$file_name = $name_string[1];
			$file_path = $css_path . '/' . $file_name ;

			if ( is_file( $file_path ) && substr( $file_name , -4 ) == '.css'){
				$mtime = mysql_real_escape_string( intval( @filemtime( $file_path ) ) );
				$tpl_source = mysql_real_escape_string( file_get_contents( $file_path ) );
			}

			$sql = "SELECT COUNT(*) FROM ".$db->prefix("tplfile")." WHERE tpl_module=\"".$mydirname."\" AND tpl_tplset=\"$copy4db\" AND tpl_file=\"".$tpl_name."\"";
			list( $count ) = $db->fetchRow( $db->query( $sql ) );

			// UPDATE TPL
			if( ! empty( $count ) ){
				$result = $db->query( "SELECT tpl_id, tpl_tplset, tpl_file FROM ".$db->prefix("tplfile")." WHERE tpl_tplset=\"".$copy4db."\" AND tpl_file=\"".$tpl_name."\"") ;
				while( list( $id, $tpl_tplset, $tpl_file ) = $db->fetchRow( $result ) ) {
					$update_id = intval( $id ) ;
					$tpl_file = $myts->makeTboxData4Save( $tpl_file ) ;
				}
				$result = $db->query( "UPDATE ".$db->prefix( "tplfile" )." SET tpl_lastmodified=$mtime,tpl_lastimported=UNIX_TIMESTAMP() WHERE tpl_id='$update_id'" ) ;
				if( ! $result ) $errors[] = $tpl_name ;
				$result = $db->queryF( "UPDATE ".$db->prefix( "tplsource" )." SET tpl_source=\"$tpl_source\" WHERE tpl_id=\"".$update_id."\"" ) ;
				if( ! $result ) $errors[] = $tpl_name ;
				xoops_template_touch( $update_id ) ;
			} else {
				// NEW INSERT TPL
				$sql  = "INSERT INTO ".$db->prefix("tplfile")." ( tpl_id, tpl_refid, tpl_module, tpl_tplset, tpl_file, tpl_desc, tpl_lastmodified, tpl_lastimported, tpl_type ) ";
				$sql .= "VALUES( 'NULL', '".$mid."','".$mydirname."', '$copy4db', '".$tpl_name."', '', '".$mtime."', '0', 'module' )"; 
				$result = $db->query($sql);
				$copyed_id = $db->getInsertId() ;
				if( ! $result ){
					$errors[] = $tpl_name ;
					redirect_header( XOOPS_URL."/modules/$mydirname/admin/index.php?page=export" , 2 , $errors ? sprintf( _MD_DBCSS_INSERTTEMPLATEERROR , implode( ',' , $errors ) ) : _MD_DBCSS_COPYED ) ;
					exit();
				} else {
					$sql  = "INSERT INTO ".$db->prefix("tplsource")." ( tpl_id, tpl_source ) ";
					$sql .= "VALUES( '".$copyed_id."', '".$tpl_source."')"; 
					$result = $db->query($sql);
					xoops_template_touch( $copyed_id ) ;
					if( ! $result ) $errors[] = $tpl_name ;
				}
			}
		}
		redirect_header( XOOPS_URL."/modules/$mydirname/admin/index.php?page=export" , 2 , $errors ? sprintf( _MD_DBCSS_INSERTTEMPLATEERROR , implode( ',' , $errors ) ) : _MD_DBCSS_COPYED ) ;
		exit();
	}
}

// DELETE TPL

$getdelete_btn = dbcss_getdelete_btn( $mydirname );

if( ! empty( $_POST['submitdelete'] ) ) {
	if ( ! $xoopsGTicket->check( true , 'dbcss' ) ) {
		redirect_header(XOOPS_URL.'/modules/'.$mydirname.'/admin/index.php',3,$xoopsGTicket->getErrors());
	}

	$tplset = implode( '', array_keys( $_POST['submitdelete'] ) );

	if( empty( $_POST[$tplset.'_check'] ) ) {
		redirect_header( XOOPS_URL."/modules/$mydirname/admin/index.php?page=export", 2, _MD_DBCSS_DELETE_CHECK_NONE);
		exit();
	} else {
		$errors = array() ;
		foreach( @$_POST[$tplset.'_check'] as $lid => $value ) {
			if( empty( $value ) ) continue ;
			$tpl_id = intval( $lid ) ;
			$result = $db->query( "SELECT tpl_file FROM ".$db->prefix("tplfile")." WHERE tpl_id=\"".$tpl_id."\" AND tpl_tplset=\"".$tplset."\"") ;
			while( list( $tplfile ) = $db->fetchRow( $result ) ) {
				$tpl_file = htmlspecialchars( $tplfile, ENT_QUOTES ) ;
				$name_string = explode($mydirname.'_', $tpl_file ,2 ) ;
				$delete_file = $name_string[1];
			}
			$t_sql = "DELETE FROM ".$db->prefix("tplfile")." WHERE tpl_id = '$tpl_id'";
			$result = $db->query($t_sql);
			if( ! $result ) $errors[] = $tpl_id ;

			$s_sql = "DELETE FROM ".$db->prefix("tplsource")." WHERE tpl_id = '$tpl_id'";
			$result = $db->query($s_sql);
			if( ! $result ) $errors[] = $tpl_id ;

			$d_sql = "SELECT COUNT(*) FROM ".$db->prefix("tplfile")." WHERE tpl_module=\"".$mydirname."\" AND tpl_file=\"".$tpl_file."\"";
			list( $count ) = $db->fetchRow( $db->query( $d_sql ) );

			// DELETE CSS FILE
			if( empty( $count ) ){
				$delete_path = XOOPS_TRUST_PATH.'/uploads/'.$mydirname.'/'.$delete_file ;
				if( file_exists( $delete_path ) ){
					unlink( $delete_path );
				}
			}
		}
		redirect_header( XOOPS_URL."/modules/$mydirname/admin/index.php?page=export" , 2 , $errors ? sprintf( _MD_DBCSS_ERROR_MESSEAGE , implode( ',' , $errors ) ) : _MD_DBCSS_DELETED ) ;
		exit();
	}
}

// CONFIG CHECK
if( file_exists( $css_path ) ){
	$upload_dir = true;
}

if( is_writable( $css_path ) ){
	$upload_writable = true;
}

if( file_exists( $css_export_dir ) ){
	$cache_dir = true;
}

if( is_writable( $css_export_dir ) ){
	$writable = true;
}

// DISPLAY STAGE

xoops_cp_header();
include dirname(__FILE__).'/mymenu.php' ;
$tpl =& new XoopsTpl() ;
$tpl->assign( array(
	'mydirname' => $mydirname ,
	'mod_url' => XOOPS_URL.'/modules/'.$mydirname ,
	'page' => 'export' ,
	'tplset' => $tplset ,
    'tplsets' => $tplsets,
    'cssfiles' => $cssfiles,
    'xoopsModuleConfig' => $xoopsModuleConfig,
    'config_tplsets' => $config_tplsets,
    'num_by_tplset' => $num_by_tplset,
	'css_export_dir' => $css_export_dir ,
	'copytplsets' => $copy_tplsets ,
	'getdelete_btn' => $getdelete_btn ,
	'cache_dir' => $cache_dir ,
	'writable' => $writable ,
	'css_path' => $css_path.'/' ,
	'import_tplsets' => $import_tplsets ,
	'upload_dir' => $upload_dir ,
	'upload_writable' => $upload_writable ,
	'gticket_hidden' => $xoopsGTicket->getTicketHtml( __LINE__ , 1800 , 'dbcss') ,
) ) ;
$tpl->display( 'db:'.$mydirname.'_admin_export.html' ) ;
xoops_cp_footer();

?>