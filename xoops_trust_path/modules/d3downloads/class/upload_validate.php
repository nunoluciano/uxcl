<?php

if( ! class_exists( 'Upload_Validate' ) )
{
	class Upload_Validate
	{
		var $ext;
		var $allowed_extension;
		var $image_extensions;
		var $deny_extension;
		var $error;

		function Upload_Validate( $mydirname='' )
		{
			if( ! empty( $mydirname ) ){
				$this->mydirname = $mydirname ;
				$module_handler =& xoops_gethandler('module');
				$config_handler =& xoops_gethandler('config');
				$module =& $module_handler->getByDirname( $mydirname );
				$mod_config =& $config_handler->getConfigsByCat( 0, $module->getVar( 'mid' ) );
				$this->mod_config = $mod_config ;
				$this->allowed_extension = $this->allowed_extension( $mydirname );
				$this->deny_extension = $this->deny_extension();
				$this->image_extensions = $this->image_extensions();
			}
		}

		// アップロードを許可する拡張子
		function allowed_extension( $mydirname )
		{
			$module_handler =& xoops_gethandler('module');
			$config_handler =& xoops_gethandler('config');
			$module =& $module_handler->getByDirname( $mydirname );
			$mod_config =& $config_handler->getConfigsByCat( 0, $module->getVar( 'mid' ) );

			$normal_exts = array( 'zip' , 'tgz' , 'lzh' , 'cab' , 'bz2' , 'xls' , 'doc' , 'pdf' ) ;
			if( empty( $mod_config['allow_extension'] ) ) {
				$allowed_extension = $normal_exts ;
			} else {
				$allowed_extension = array_map( 'strtolower' , explode( '|', $mod_config['allow_extension'] ) ) ;
			}
			return $allowed_extension ;
		}

		// アップロードを許可しない拡張子
		function deny_extension()
		{
			return array( 'php' , 'phtml' , 'phtm' , 'php3' , 'php4' , 'cgi' , 'pl' , 'asp' ) ;
		}

		// 拡張子偽造をチェックする画像ファイル
		function image_extensions()
		{
			return array( 1 => 'gif', 2 => 'jpg', 3 => 'png', 4 => 'swf', 5 => 'psd', 6 => 'bmp', 7 => 'tif', 8 => 'tif', 9 => 'jpc', 10 => 'jp2', 11 => 'jpx', 12 => 'jb2', 13 => 'swc', 14 => 'iff', 15 => 'wbmp', 16 => 'xbm' ) ;
		}

		// 各拡張子の先頭部分での正規表現
		function extension_head()
		{
			return array(
				'pdf' => '/^%PDF-\d[\d\.]+[\r\n]%/',
				'ppt' => '/\xD0\xCF\x11\xE0\xA1\xB1\x1A\xE1\x00/',
				'xls' => '/\xD0\xCF\x11\xE0\xA1\xB1\x1A\xE1\x00/',
				'bmp' => '/^BM/',
				'gif' => '/^GIF8[7,9]a/',
				'jpg' => '/^\xFF\xD8/',
				'mng' => '/^\x8aMNG\x0d\x0a\x1a\x0a/',
				'pcd' => '/^PCD_OPA/',
				'png' => '/^\x89PNG/',
				'psd' => '/^8BPS/',
				'ppm' => '/^P[1-7]/',
				'tif' => '/^MM\x00\x2a|^II\x2a\x00/',
				'xbm' => '/\#define\s+\S+\s+\d+/',
				'xpm' => '/\/\* XPM \*\//',
				'swf' => '/^[FC]WS/',
				'bz2' => '/^BZh91AY&SY/',
				'cab' => '/^MSCF/',
				'gca' => '/^GCA0/',
				'gz'  => '/^\x1f\x8b/',
				'ish' => '/^<<< /',
				'lzh' => '/^..-(lz[s45]|lh[0-7d])-/',
				'rar' => '/^Rar\!/',
				'sit' => '/^StuffIt/',
				'yz1' => '/^yz010500/',
				'zip' => '/^PK/',
				'mp3' => '/^(\x00*\xFF\xFB..\x00|ID3\x03\x00{4}|\x00+$)/',
				'ogm' => '/^OggS\x00.*vorbis/',
				'wmv' => '/^\x30\x26\xB2\x75\x8E\x66\xCF\x11\xA6\xD9\x00\xAA\x00\x62\xCE\x6C/',
			) ;
		}

		// 拡張子のチェック
		function check_allowed_extensions( $ext )
		{
			if( ! $this->mydirname ){
				die( 'function check_allowed_extensions() cannot be used.' );
			} else {
				$allowed = 1 ;
				if( ! in_array( $ext, $this->allowed_extension ) ){
					$allowed = 0 ;
				}
				return $allowed ;
			}
		}

		// php など危険な拡張子のファイルのアップロードを防ぐ
		function check_deny_extensions( $ext )
		{
			if( ! $this->mydirname ){
				die( 'function check_deny_extensions() cannot be used.' );
			} else {
				if( in_array( $ext, $this->deny_extension ) ){
					die( 'Attempt to upload '. $ext );
				}
			}
		}

		// PHP 4.3.6 以前のバージョンへの対策( .. と / が含まれている場合強制終了)
		function check_doubledot( $file_name )
		{
			if( strstr( $file_name, '..' ) ){
				die( 'Attempt to multiple dot file  '. $file_name );
			}
			if( strstr( $file_name, '/' ) ){
				die( 'Attempt to multiple dot file  '. $file_name );
			}
		}

		// multiple dot file のチェックを行うかどうか
		// protector が入っていない環境を考慮して、multiple dot file のチェックをする
		// ただ、誤認識もあるかもしれませんので、一般設定で選択できるようにしました
		function config_check_multiple_dot()
		{
			if( ! $this->mydirname ){
				die( 'function config_check_multiple_dot() cannot be used.' );
			} else {
				if( ! empty( $this->mod_config['check_multiple_dot'] ) ) {
					$check_multiple_dot = true ;
				} else {
					$check_multiple_dot = false ;
				}
				return $check_multiple_dot ;
			}
		}

		// multiple dot file のチェック
		function check_multiple_dot( $file_name )
		{
			if( count( explode( '.' , str_replace( '.tar.gz' , '.tgz' , $file_name ) ) ) > 2 ) {
				die( 'Attempt to multiple dot file  '. $file_name );
			}
		}

		// 画像ファイルを対象に拡張子偽造のチェック
		function check_image_extensions( $ext, $tmp_name, $file_name )
		{
			if( ! $this->mydirname ){
				die( 'function check_image_extensions() cannot be used.' );
			} else {
				if( $ext == 'jpeg' ) $ext = 'jpg' ;
				else if( $ext == 'tiff' ) $ext = 'tif' ;
				if( in_array( $ext , $this->image_extensions ) ) {
					$image_attributes = @getimagesize( $tmp_name ) ;
					if( $image_attributes === false || $this->image_extensions[ intval( $image_attributes[2] ) ] != $ext ) {
						die('Attempt to upload camouflaged image file '. $file_name );
					}
				}
			}
		}

		// ヘッダのチェックを行うかどうか
		function config_validate_of_head()
		{
			if( ! $this->mydirname ){
				die( 'function config_validate_of_head() cannot be used.' );
			} else {
				if( ! empty( $this->mod_config['validate_of_head'] ) ) {
					$check_of_head = true ;
				} else {
					$check_of_head = false ;
				}
				return $check_of_head ;
			}
		}

		// 各拡張子の先頭部分での正規表現を定義している場合はそのチェック
		// 定義されていない拡張子については、先頭部分に <?php または <script が含まれていないかチェック
		function Validate_of_head( $filepath, $file_name, $ext )
		{
			$error = 0 ;
			if( $ext == 'jpeg' ) $ext = 'jpg' ;
			else if( $ext == 'tiff' ) $ext = 'tif' ;
			else if( $ext == 'tbz' ) $ext = 'bz2' ;
			$head_arr = $this->extension_head();
			$head = ! empty( $head_arr[$ext] ) ? $head_arr[$ext] : '' ;
			$mtype_arr = $this->return_mtype();
			$mtype = $mtype_arr[$ext];
			if( isset( $mtype ) && strstr( $mtype, 'text/' ) ){
				$handle = @fopen( $filepath, 'r' );
			} else {
				$handle = @fopen( $filepath, 'rb' );
			}
			if ( $handle ) {
				$file_line = fgets( $handle, 255 );
			}
			fclose( $handle );
			if( ! empty( $head ) ){
				if ( ! preg_match( $head, $file_line ) ) {
					die('Attack detected '. $file_name );
				}
			} else {
				if ( preg_match( '/<\\?php./i' , $file_line ) ) {
					die('Attack detected '. $file_name );
				} elseif ( preg_match( '/<script./i' , $file_line ) ) {
					die('Attack detected '. $file_name );
				}
			}
		}

		function return_mtype()
		{
			return array(
				'123'=>'application/vnd.lotus-1-2-3',
				'3g2'=>'video/3gpp2',
				'3gp'=>'video/3gpp',
				'ai'=>'application/postscript',
				'aif'=>'audio/aiff',
				'aifc'=>'audio/aiff',
				'aiff'=>'audio/aiff',
				'ani'=>'application/x-navi-animation',
				'apr'=>'application/vnd.lotus-approach',
				'ar'=>'application/octet-stream',
				'art'=>'application/x-art',
				'asm'=>'text/plain',
				'asp'=>'application/x-asap',
				'au'=>'audio/basic',
				'avi'=>'video/x-msvideo',
				'avx'=>'video/x-rad-screenplay',
				'awe'=>'application/x-candleweb',
				'bas'=>'text/plain',
				'bin'=>'application/x-macbinary',
				'bmp'=>'image/bmp',
				'bny'=>'application/x-binaryii',
				'bqy'=>'application/x-binaryii',
				'bxy'=>'application/x-binaryii',
				'cdf'=>'application/x-netcdf',
				'cf'=>'text/plain',
				'cfg'=>'text/plain',
				'cgi'=>'application/x-httpd-cgi',
				'chat'=>'application/x-chat',
				'class'=>'application/octet-stream',
				'com'=>'application/octet-stream',
				'cpio'=>'application/x-cpio',
				'cpp'=>'text/plain',
				'crl'=>'application/x-pkcs7-crl',
				'csh'=>'application/x-csh',
				'csv'=>'application/csv',
				'dcr'=>'application/x-director',
				'dht'=>'text/html',
				'dhtml'=>'text/html',
				'dir'=>'appliaction/x-director',
				'dll'=>'application/octet-stream',
				'doc'=>'application/msword',
				'dot'=>'application/octet-stream',
				'dp'=>'application/x-commonground',
				'dsk'=>'application/octet-stream',
				'dvi'=>'application/x-dvi',
				'dxr'=>'application/x-director',
				'elm'=>'text/plain',
				'eml'=>'text/plain',
				'eps'=>'application/postscript',
				'epsf'=>'application/postscript',
				'epsi'=>'application/postscript',
				'etx'=>'text/x-setext',
				'euc'=>'text/plain',
				'exe'=>'application/octet-stream',
				'f77'=>'application/x-fortran77',
				'f90'=>'text/plain',
				'faif'=>'audio/x-aiff',
				'fif'=>'application/fractals',
				'fig'=>'application/x-xfig',
				'flc'=>'video/x-flc',
				'fli'=>'video/x-fli',
				'fm'=>'application/vnd.framemaker',
				'fmr'=>'application/x-fmr',
				'fn0'=>'application/octet-stream',
				'fn1'=>'application/octet-stream',
				'fna'=>'application/octet-stream',
				'fon'=>'application/octet-stream',
				'gif'=>'image/gif',
				'gtar'=>'application/x-gtar',
				'gz'=>'application/x-compressed',
				'hdf'=>'application/x-hdf',
				'hlp'=>'application/octet-stream',
				'hqx'=>'application/mac-binhex40',
				'htm'=>'text/html',
				'html'=>'text/html',
				'ice'=>'x-conference/x-cooltalk',
				'ico'=>'application/octet-stream',
				'ief'=>'image/ief',
				'it'=>'audio/x-mod',
				'jar'=>'application/java-archive',
				'jfif'=>'image/jpeg',
				'jis'=>'text/plain',
				'jpe'=>'image/jpeg',
				'jpeg'=>'image/jpeg',
				'jpg'=>'image/jpeg',
				'js'=>'application/x-javascript',
				'jsc'=>'application/x-javascript-config',
				'lam'=>'audio/x-liveaudio',
				'latex'=>'application/x-latex',
				'lha'=>'application/octet-stream',
				'ls'=>'application/x-javascript',
				'lwp'=>'application/vnd.lotus-wordpro',
				'lzh'=>'application/octet-stream',
				'm'=>'application/x-troff-man',
				'mac'=>'text/plain',
				'mag'=>'application/octet-stream',
				'mak'=>'text/plain',
				'man'=>'application/x-troff-man',
				'map'=>'application/x-navimap',
				'mc'=>'application/x-metacard',
				'mda'=>'application/vnd.ms-access',
				'mdb'=>'application/vnd.ms-access',
				'mde'=>'application/vnd.ms-access',
				'me'=>'application/x-troff-me',
				'mid'=>'audio/x-midi',
				'midi'=>'audio/x-midi',
				'mif'=>'application/x-mif',
				'mki'=>'application/octet-stream',
				'mml'=>'text/plain',
				'moc'=>'application/x-javascript',
				'mocha'=>'application/x-javascript',
				'mod'=>'audio/x-mod',
				'mov'=>'video/quicktime',
				'movie'=>'video/x-sgi-movie',
				'mp2'=>'video/mpeg',
				'mp2v'=>'video/mpeg',
				'mp3'=>'video/mpeg',
				'mpa'=>'video/mpeg',
				'mpc'=>'application/vnd.ms-project',
				'mpe'=>'video/mpeg',
				'mpeg'=>'video/mpeg',
				'mpega'=>'video/mpeg',
				'mpegv'=>'video/mpeg',
				'mpg'=>'video/mpeg',
				'mpp'=>'application/vnd.ms-project',
				'mpt'=>'application/vnd.ms-project',
				'mpv'=>'video/mpeg',
				'mpv2'=>'video/mpeg',
				'mpw'=>'application/vnd.ms-project',
				'mpx'=>'application/vnd.ms-project',
				'ms'=>'application/x-troff-ms',
				'mtm'=>'audio/x-mod',
				'nc'=>'application/x-netcdf',
				'nvd'=>'application/x-navidoc',
				'nvm'=>'application/x-navimap',
				'obj'=>'application/octet-stream',
				'oda'=>'application/oda',
				'or2'=>'application/vnd.lotus-organizer',
				'or3'=>'application/vnd.lotus-organizer',
				'org'=>'application/vnd.lotus-organizer',
				'ovl'=>'application/octet-stream',
				'p7c'=>'application/x-pkcs7-mime',
				'p7m'=>'application/x-pkcs7-mime',
				'p7s'=>'application/x-pkcs7-signature',
				'pac'=>'application/x-ns-proxy-autoconfig',
				'pas'=>'text/plain',
				'pbm'=>'image/x-portable-bitmap',
				'pcd'=>'image/x-photo-cd',
				'pdf'=>'application/pdf',
				'pgm'=>'application/x-portable-graymap',
				'pic'=>'image/pict',
				'pict'=>'image/pict',
				'pjp'=>'image/jpeg',
				'pjpeg'=>'image/jpeg',
				'pl'=>'application/x-perl',
				'pm'=>'application/x-perl',
				'png'=>'image/png',
				'pnm'=>'image/x-portable-anymap',
				'pot'=>'application/vnd.ms-powerpoint',
				'ppa'=>'application/vnd.ms-powerpoint',
				'ppm'=>'image/x-portable-anymap',
				'pps'=>'application/vnd.ms-powerpoint',
				'ppt'=>'application/vnd.ms-powerpoint',
				'pre'=>'application/vnd.lotus-freelance',
				'prz'=>'application/vnd.lotus-freelance',
				'ps'=>'application/postscript',
				'pwz'=>'application/vnd.ms-powerpoint',
				'q4'=>'image/x-q4',
				'qt'=>'video/quicktime',
				'ra'=>'audio/x-pn-realaudio',
				'ram'=>'audio/x-pn-realaudio',
				'rar'=>'application/x-rar',
				'ras'=>'image/x-cmu-raster',
				'readme'=>'text/plain',
				'rgb'=>'image/x-rgb',
				'rpm'=>'audio/x-pn-realaudio-plugin',
				'rtf'=>'application/rtf',
				'rtx'=>'text/richtext',
				's'=>'text/plain',
				's3m'=>'audio/x-mod',
				'sam'=>'application/vnd.lotus-wordpro',
				'sc2'=>'application/vnd.ms-schedule',
				'scd'=>'application/vnd.ms-schedule',
				'sch'=>'application/vnd.ms-schedule',
				'scm'=>'application/vnd.lotus-screencam',
				'sdk'=>'application/x-shrinkit',
				'sgm'=>'text/sgml',
				'sgml'=>'text/sgml',
				'shar'=>'application/x-shar',
				'shk'=>'application/x-shrinkit',
				'sht'=>'text/html',
				'shtml'=>'text/html',
				'sit'=>'application/x-stuffit',
				'sj'=>'text/html',
				'sjis'=>'text/html',
				'snd'=>'audio/basic',
				'sql'=>'application/x-sql',
				'src'=>'application/x-wais-source',
				'stl'=>'application/x-navistyle',
				'swf'=>'application/x-shockwave-flash',
				't'=>'application/x-troff',
				'tar'=>'application/x-tar',
				'tcl'=>'application/x-tcl',
				'texi'=>'application/x-texinfo',
				'texinfo'=>'application/x-texinfo',
				'text'=>'text/plain',
				'tsv'=>'text/tab-separated-value',
				'tgz'=>'application/x-compressed',
				'tif'=>'image/tiff',
				'tiff'=>'image/tiff',
				'tk'=>'application/x-tcl',
				'tki'=>'application/x-tkined',
				'tkined'=>'application/x-tkined',
				'tr'=>'application/x-troff',
				'tsv'=>'text/tab-separated-values',
				'txt'=>'text/plain',
				'ult'=>'audio/x-mod',
				'uni'=>'audio/x-mod',
				'vbs'=>'video/mpeg',
				'vcf'=>'text/x-vcard',
				'vcr'=>'video/x-sunvideo',
				'vdo'=>'video/vdo',
				'vew'=>'application/vnd.lotus-approach',
				'vf1'=>'application/octet-stream',
				'vf2'=>'application/octet-stream',
				'vrml'=>'x-world/x-vrml',
				'wav'=>'audio/x-wav',
				'wj2'=>'application/vnd.lotus-1-2-3',
				'wj3'=>'application/vnd.lotus-1-2-3',
				'wk1'=>'application/vnd.lotus-1-2-3',
				'wk3'=>'application/vnd.lotus-1-2-3',
				'wk4'=>'application/vnd.lotus-1-2-3',
				'wk5'=>'application/vnd.lotus-1-2-3',
				'wll'=>'application/msword',
				'wp6'=>'application/wordperfect5.1',
				'wpd'=>'application/wordperfect5.1',
				'wrl'=>'x-world/x-vrml',
				'xbm'=>'image/x-xbitmap',
				'xdm'=>'application/x-xdma',
				'xdma'=>'application/x-xdma',
				'xla'=>'application/vnd.ms-excel',
				'xlc'=>'application/vnd.ms-excel',
				'xld'=>'application/vnd.ms-excel',
				'xll'=>'application/vnd.ms-excel',
				'xlm'=>'application/vnd.ms-excel',
				'xls'=>'application/vnd.ms-excel',
				'xlt'=>'application/vnd.ms-excel',
				'xlw'=>'application/vnd.ms-excel',
				'xm'=>'audio/x-mod',
				'xml'=>'text/xml',
				'xpm'=>'image/x-xpicmap',
				'xwd'=>'image/x-xwindowdump',
				'z'=>'application/x-compressed',
				'zim'=>'image/x-zim',
				'zip'=>'application/x-zip-compressed',
				'zjg'=>'application/octet-stream',
				'zpt'=>'application/octet-stream',
			) ;
		}
	}
}

?>