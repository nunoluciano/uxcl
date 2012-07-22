<?php

include_once dirname( dirname(__FILE__) ).'/class/broken_download.php' ;
$broken_report = new broken_report( $mydirname ) ;

$formRules['brokenreport'] = array(
	'message' => array(
		'args'=>array(
			'validMessage' => _MD_D3DOWNLOADS_MESSAGE_THANKS ,
			'onlyOnBlur' => true
		),
		'display'=>'',
	),
	'name' => array(
		'args'=>array(
			'validMessage' => _MD_D3DOWNLOADS_NAME_THANKS ,
			'onlyOnBlur' => true
		),
		'display'=>'',
		'rules'=>array(
			array(
				'method'=>'Validate.Length',
				'args'=>array(
					'tooLongMessage' => sprintf( _MD_D3DOWNLOADS_NAME_TOOLONG, $broken_report->name_length ) ,
					'maximum'=>$broken_report->name_length
				)
			),
		)
	),
	'email' => array(
		'args'=>array(
			'validMessage' => _MD_D3DOWNLOADS_EMAIL_THANKS ,
			'onlyOnBlur' => true
		),
		'display'=>'',
		'rules'=>array(
			array(
				'method'=>'Validate.Email',
				'args'=>array(
					'failureMessage' => _MD_D3DOWNLOADS_EMAIL_CHECK ,
				)
			),
			array(
				'method'=>'Validate.Length',
				'args'=>array(
					'tooLongMessage' => sprintf( _MD_D3DOWNLOADS_EMAIL_TOOLONG, $broken_report->email_length ) ,
					'maximum'=>$broken_report->email_length
				)
			),
		)
	),
);

?>