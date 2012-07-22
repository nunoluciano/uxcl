<?php

include_once dirname( dirname(__FILE__) ).'/class/submit_validate.php' ;
$submit_validate = new Submit_Validate() ;

// submit rules by livevalidationphp
$formRules = array();

$formRules['makedownloadform'] = array(
	// Title check
	'title' => array(
		'args'=>array(
			'validMessage' => _MD_D3DOWNLOADS_TITLE_OK
		),
		'display'=>'',
		'rules'=>array(
			array(
				'method'=>'Validate.Presence',
				'args'=>array(
					'failureMessage' => _MD_D3DOWNLOADS_TITLE_NONE
				)
			),
			array(
				'method'=>'Validate.Length',
				'args'=>array(
					'tooLongMessage' => sprintf( _MD_D3DOWNLOADS_TITLE_TOOLONG, $submit_validate->title_length ) ,
					'maximum'=>$submit_validate->title_length
				)
			),
		)
	),

	// Url check
	'url' => array(
		'args'=>array(
			'validMessage' => _MD_D3DOWNLOADS_URL_OK
		),
		'display'=>'',
		'rules'=>array(
			array(
				'method'=>'Validate.Presence',
				'args'=>array(
					'failureMessage' => _MD_D3DOWNLOADS_URL_NONE
				)
			),
			// Check control code
			array(
				'method'=>'Validate.Format',
				'args'=>array(
					'negate'=>true,
					'pattern' => "/[\\0-\\31]/",
					'failureMessage' => _MD_D3DOWNLOADS_URL_CHECK
				)
			),
			// Check black pattern(deprecated)
			array(
				'method'=>'Validate.Format',
				'args'=>array(
					'negate'=>true,
					'pattern' => '/(javascript|java script|vbscript|about|data):/i',
					'failureMessage' => _MD_D3DOWNLOADS_URL_CHECK
				)
			),
			// Check rfc2396 URI Characters
			array(
				'method'=>'Validate.Format',
				'args'=>array(
					'negate'=>true,
					'pattern' => "/[^-\/?:#@&=+$,\w.!~*;'()%]/",
					'failureMessage' => _MD_D3DOWNLOADS_URL_CHECK
				)
			),
			array(
				'method'=>'Validate.Format',
				'args'=>array(
					'pattern' => '/^(https?|ftp):\/\/.+$|^(XOOPS_TRUST_PATH|XOOPS_ROOT_PATH|XOOPS_URL|'.preg_quote( XOOPS_TRUST_PATH, '/' ).'|'.preg_quote( XOOPS_ROOT_PATH, '/' ).')\/([^\s]*)+$/i',
					'failureMessage' => _MD_D3DOWNLOADS_URL_CHECK
				)
			),
			array(
				'method'=>'Validate.Ajax',
				'args'=>array(
					'pattern' => '/^(XOOPS_TRUST_PATH|XOOPS_ROOT_PATH|'.preg_quote( XOOPS_TRUST_PATH, '/' ).'|'.preg_quote( XOOPS_ROOT_PATH, '/' ).')/i',
					'type'=> 'is_file',
					'failureMessage' => _MD_D3DOWNLOADS_URL_CHECK
				)
			),
			array(
				'method'=>'Validate.Length',
				'args'=>array(
					'tooLongMessage' => sprintf( _MD_D3DOWNLOADS_URL_TOOLONG, $submit_validate->url_length ) ,
					'maximum'=>$submit_validate->url_length
				)
			),
		)
	),

	// Homepagetitle check
	'homepagetitle' => array(
		'args'=>array(
			'validMessage' => _MD_D3DOWNLOADS_HOMEPAGETITLE_OK
		),
		'display'=>'',
		'rules'=>array(
			array(
				'method'=>'Validate.Length',
				'args'=>array(
					'tooLongMessage' => sprintf( _MD_D3DOWNLOADS_HOMEPAGETITLE_TOOLONG, $submit_validate->homepagetitle_length ) ,
					'maximum'=> $submit_validate->homepagetitle_length
				)
			),
		)
	),

	// Homepage check
	'homepage' => array(
		'args'=>array(
			'validMessage' => _MD_D3DOWNLOADS_HOMEPAGE_OK
		),
		'display'=>'',
		'rules'=>array(
			// Check control code
			array(
				'method'=>'Validate.Format',
				'args'=>array(
					'negate'=>true,
					'pattern' => "/[\\0-\\31]/",
					'failureMessage' => _MD_D3DOWNLOADS_HOMEPAGE_CHECK
				)
			),
			// Check black pattern(deprecated)
			array(
				'method'=>'Validate.Format',
				'args'=>array(
					'negate'=>true,
					'pattern' => '/(javascript|java script|vbscript|about|data):/i',
					'failureMessage' => _MD_D3DOWNLOADS_HOMEPAGE_CHECK
				)
			),
			// Check rfc2396 URI Characters
			array(
				'method'=>'Validate.Format',
				'args'=>array(
					'negate'=>true,
					'pattern' => "/[^-\/?:#@&=+$,\w.!~*;'()%]/",
					'failureMessage' => _MD_D3DOWNLOADS_HOMEPAGE_CHECK
				)
			),
			array(
				'method'=>'Validate.Format',
				'args'=>array(
					'pattern' => '/^(https?|ftp):\/\/.+$|^http:\/\/$/',
					'failureMessage' => _MD_D3DOWNLOADS_HOMEPAGE_CHECK
				)
			),
		)
	),

	// Size check
	'size' => array(
		'args'=>array(
			'validMessage' => _MD_D3DOWNLOADS_SIZE_OK
		),
		'display'=>'',
		'rules'=>array(
			array(
				'method'=>'Validate.Format',
				'args'=>array(
					'pattern' => '/^[0-9]+$/',
					'failureMessage' => _MD_D3DOWNLOADS_SIZE_CHECK
				)
			),
			array(
				'method'=>'Validate.Length',
				'args'=>array(
					'tooLongMessage' => sprintf( _MD_D3DOWNLOADS_SIZE_TOOLONG, $submit_validate->size_length ) ,
					'maximum'=>$submit_validate->size_length
				)
			),
		)
	),

	// Version check
	'version' => array(
		'args'=>array(
			'validMessage' => _MD_D3DOWNLOADS_VERSION_OK
		),
		'display'=>'',
		'rules'=>array(
			array(
				'method'=>'Validate.Length',
				'args'=>array(
					'tooLongMessage' => sprintf( _MD_D3DOWNLOADS_VERSION_TOOLONG, $submit_validate->version_length ) ,
					'maximum'=> $submit_validate->version_length
				)
			),
		)
	),

	// Platform check
	'platform' => array(
		'args'=>array(
			'validMessage' => _MD_D3DOWNLOADS_PLATFORM_OK
		),
		'display'=>'',
		'rules'=>array(
			array(
				'method'=>'Validate.Length',
				'args'=>array(
					'tooLongMessage' => sprintf( _MD_D3DOWNLOADS_PLATFORM_TOOLONG, $submit_validate->platform_length ) ,
					'maximum'=>$submit_validate->platform_length
				)
			),
		)
	),

	// Description check
	'desc' => array(
		'args'=>array(
			'validMessage' => _MD_D3DOWNLOADS_DESCRIPTION_OK ,
			'onlyOnSubmit' => true
		),
		'display'=>'',
		'rules'=>array(
			array(
				'method'=>'Validate.Presence',
				'args'=>array(
					'type'=> 'description',
					'failureMessage' => _MD_D3DOWNLOADS_DESCRIPTION_NONE
				)
			),
		)	
	),
);

// set extension data
include_once dirname( dirname(__FILE__) ).'/class/upload_validate.php' ;
$upload_validate = new Upload_Validate() ;
$allowed_extension = '\.'.implode( '|\.',array_diff( $upload_validate->allowed_extension( $mydirname ), $upload_validate->deny_extension() ) );

// 一般設定で設定されている拡張子をチェック
$formRules['fileupload'] = array(
	// File_upload check
	'file_upload_1' => array(
		'args'=>array(
			'validMessage' => _MD_D3DOWNLOADS_URL_OK
		),
		'display'=>'',
		'rules'=>array(
			array(
				'method'=>'Validate.Format',
				'args'=>array(
					'pattern' => '/('.$allowed_extension.')$/i',
					'failureMessage' => _MD_D3DOWNLOADS_EXT_CHECK
				)
			),
		)
	),

	// File_upload2 check
	'file_upload_2' => array(
		'args'=>array(
			'validMessage' => _MD_D3DOWNLOADS_URL_OK
		),
		'display'=>'',
		'rules'=>array(
			array(
				'method'=>'Validate.Format',
				'args'=>array(
					'pattern' => '/('.$allowed_extension.')$/i',
					'failureMessage' => _MD_D3DOWNLOADS_EXT_CHECK
				)
			),
		)
	),
);

$formRules['license'] = array(
	// License check
	'license' => array(
		'args'=>array(
			'validMessage' => _MD_D3DOWNLOADS_LICENSE_OK
		),
		'display'=>'',
		'rules'=>array(
			array(
				'method'=>'Validate.Length',
				'args'=>array(
					'tooLongMessage' => sprintf( _MD_D3DOWNLOADS_LICENSE_TOOLONG, $submit_validate->license_length ) ,
					'maximum'=>$submit_validate->license_length
				)
			),
		)
	),
);

?>