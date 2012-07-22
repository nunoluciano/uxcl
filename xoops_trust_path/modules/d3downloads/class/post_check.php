<?php

if( ! class_exists( 'Post_Check' ) )
{
	class Post_Check
	{
		var $error_count;
		var $error_message;

		function check( $params )
		{
			$this->error_count = 0;
			$this->error_message = array();
			$result = array();
			for( $loop = 0 ; $loop < count( $params ) ; $loop++ ) {
				$check_value = $params[$loop]["value"];
				$check_types = $params[$loop]["type"];
				for( $check_loop = 0 ; $check_loop < count( $check_types ) ; $check_loop++ ) {
					$check_type = $check_types[$check_loop];
					$check_result = $this->checkIndividual( $check_value, $check_type );
					if( ! $check_result ) {
						$this->error_count++;
						$this->error_message[] = $params[$loop]["message"];
					}
				}
				$result[] = array(
					'error'   => $this->error_count ,
					'message' => $this->error_message ,
				) ;
			}
			return $result;
		}

		function getErrorCount()
		{
			return $this->error_count;
		}

		function getErrorMessege()
		{
			return $this->error_message;
		}

		function checkIndividual( $check_value, $check_type )
		{
			$result = false;
			switch( $check_type ) {
				case "void":
					$result = $this->voidCheck( $check_value );
					break;
				case "mail":
					$result = $this->mailCheck( $check_value );
					break;
				case "url":
					$result = $this->urlCheck( $check_value );
					break;
				case "imgurl":
					$result = $this->imgurlCheck( $check_value );
					break;
				case "alpha":
					$result = $this->alphaCheck( $check_value );
					break;
				case "alnum":
					$result = $this->alnumCheck( $check_value );
					break;
				case "numeric":
					$result = $this->numericCheck( $check_value );
					break;
				case "integer":
					$result = $this->integerCheck( $check_value );
					break;
				case "same":
					$result = $this->sameValueCheck( $check_value );
					break;
				case "equal":
					$result = $this->lengthEqualCheck( $check_value );
					break;
				case "max":
					$result = $this->lengthMaxCheck( $check_value );
					break;
				case "min":
					$result = $this->lengthMinCheck( $check_value );
					break;
				case "format":
					$result = $this->formatCheck( $check_value );
					break;
				case "file_exists":
					$result = $this->fileexistsCheck( $check_value );
					break;
				case "is_file":
					$result = $this->is_fileCheck( $check_value );
					break;
			}
			return $result;
		}

		// 空白
		function voidCheck( $value )
		{
			$result = ( $value != "" ) ? true : false;
			return $result;
		}

		// メールアドレス
		function mailCheck( $value )
		{
			$result = ( preg_match('`^([a-z0-9_]|\-|\.|\+)+@(([a-z0-9_]|\-)+\.)+[a-z]{2,6}$`i', $value ) ) ? true : false;
			return $result;
		}

		// URL
		function urlCheck( $value, $schemes = '', $imgurl = '' )
		{
			// Set initial data
			if ( ! is_array( $schemes ) ) $schemes = array( 'http', 'https', 'ftp' );
			$deprecated = array( 'javascript', 'java script', 'vbscript', 'about', 'data' );

			$allowed_schemes = implode( '|', $schemes );
			$black_pattern = implode( '|', $deprecated );

			// Check void
			if ( preg_match("`^http://$`i", $value ) ) {
				return false;
			}

			// Check control code
			if ( preg_match("`[\\0-\\31]`", $value ) ) {
				return false;
			}

			// Check black pattern(deprecated)
			if ( preg_match("`(".$black_pattern."):`i", $value ) ) {
				return false;
			}

			// Check rfc2396 URI Characters
			if ( empty( $imgurl ) && preg_match( "`[^-/?:#@&=+$,\w.!~*;'()%]`", $value ) ) {
				return false;
			}

			// check scheme
			if ( ! preg_match(
				"`^(?:".$allowed_schemes.")://"  // allowed_schemes
				. "(?:\w+:\w+@)?"      // ( user:pass )?
				. "("
				. "(?:[-_0-9a-z]+\.)+(?:[a-z]+)\.?|"   // ( domain name | host name | IP Address )
				. "(?:[-_0-9a-z]+)|"
				. "\d{1,3}\.\d{1,3}\.\d{1,3}\.\d{1,3}|"
				. ")"
				. "(?::\d{1,5})?(?:/|$)`iD",   // ( :Port )?
				$value )
			) {
				return false;
			}
			return true;
		}

		// IMGURL
		function imgurlCheck( $value, $schemes = '' )
		{
			if ( ! preg_match( "`(\.gif|\.jpe?g|\.png)$`i",$value ) ) {
				return false;
			} else {
				return $this->urlCheck( $value, $schemes, 1 );
			}
		}

		// アルファベット
		function alphaCheck( $value )
		{
			$result = ( ctype_alpha( $value ) ) ? true : false;
			return $result;
		}

		// アルファベット・数字
		function alnumCheck( $value )
		{
			$result = ( ctype_alnum( $value ) ) ? true : false;
			return $result;
		}

		// 数字
		function numericCheck( $value )
		{
			$result = ( is_numeric( $value ) ) ? true : false;
			return $result;
		}

		// 整数
		function integerCheck( $value )
		{
			$result = ( preg_match( '`^[0-9]+$`' , $value ) ) ? true : false;
			return $result;
		}

		// 同じ値
		function sameValueCheck( $values )
		{
			$result = ( strcmp( $values[0], $values[1] ) == 0 ) ? true : false;
			return $result;
		}

		// 長さ
		function lengthEqualCheck( $values )
		{
			$result = ( strlen( $values[0] ) == $values[1] ) ? true : false;
			return $result;
		}

		function lengthMaxCheck( $values )
		{
			$result = ( strlen( $values[0] ) <= $values[1] ) ? true : false;
			return $result;
		}

		function lengthMinCheck( $values ) {
			$result = ( strlen( $values[0] ) >= $values[1] ) ? true : false;
			return $result;
		}

		// 正規表現
		function formatCheck( $values )
		{
			$result = ( preg_match( $values[1] , $values[0] ) ) ? true : false;
			return $result;
		}

		// file_exists
		function fileexistsCheck( $value )
		{
			$result = ( file_exists( $value ) ) ? true : false;
			return $result;
		}

		// is_file
		function is_fileCheck( $value )
		{
			$result = ( is_file( $value ) ) ? true : false;
			return $result;
		}
	}
}

if( ! class_exists( 'My_ValidatePHP' ) )
{
	require_once dirname( dirname(__FILE__) ).'/class/livevalidationphp.class.php' ;

	class My_ValidatePHP extends LiveValidationPHP
	{
		var $elementID ;
		var $args ;

		var $rules ;
		var $data ;
		var $errors ;
		var $varname ;
		var $parentData ;
		var $display ;

		function My_ValidatePHP( $data = array(), $elementID = '', $args = array(), $display = '' )
		{
			$this->parentData = $data ;
			$this->elementID = '' ;
			$this->args = array() ;

			$this->args = array_merge( $this->args, $args ) ;

			$this->rules = array() ;

			$elementID = trim( stripslashes( strip_tags( $elementID ) ) ) ;
			if( $elementID != '' ) $this->elementID = $elementID ;
			$this->display = trim( $this->elementID ) ;

			$display = trim( stripslashes( strip_tags( $display ) ) ) ;
			if( $display !='' ) $this->display = $display ;

			$return = $this->parse( $data, $elementID ) ;
			if( isset( $return ) ) $this->data = $return ;

			$this->errors = array() ;
			$this->varname = 'lvphp_' . md5( uniqid( rand(), true ) ) ;
		}

		function parse( $data = '', $elementId = '' )
		{
			$return = '';
			if ( ! empty( $data ) && ! empty( $elementId ) ) {
				$childId = strstr( $elementId, '[' ) ;
				if ( $childId !== false )
				{
					$parentId = str_replace( $childId, '', $elementId ) ;
					if ( isset( $data[$parentId] ) )
					{
						$variable = $data[$parentId] ;
						if ( is_array( $variable ) )
						{
							$childId = substr( $childId, 1 ) ;
							if ( in_array( substr( $childId, 0, 1 ), array("'", '"') ) )
							{
								$childId = substr( $childId, 1 ) ;
							}
							$grandChildId = strstr( $childId, ']' ) ;
							$childId = str_replace( $grandChildId, '', $childId ) ;
							if ( in_array( substr( $childId, -1 ), array( "'", '"' ) ) )
							{
								$childId = substr( $childId, 0, strlen( $childId ) - 1 ) ;
							}
							$return = $this->parse( $variable, $childId ) ;
						} else {
							$return = $variable ;
						}
					}
				} else {
					if( isset( $data[$elementId] ) )
					{
						$return = $data[$elementId] ;
					}
				}
			}
			return $return ;
		}

		function add( $type='Validate.Presence', $args=array() )
		{
			$this->rules[] = new My_Validate( $this->data, $type, $args, $this->parentData, $this->elementID, $this->display ) ;
		}
	}
}

if( ! class_exists('My_Validate') )
{
	require_once dirname( dirname(__FILE__) ).'/class/livevalidationphp.class.php' ;

	class My_Validate extends Validation
	{
		var $args ;
		var $type ;
		var $method ;
		var $data ;
		var $parentData ;
		var $elementID ;
		var $display ;

		function validate()
		{
			$payload = array() ;
			$payload['success'] = false ;

			if( $this->method != '' )
			{
				$actionFunction = $this->method ;

				if( method_exists( $this, $actionFunction ) ) 
				{
					if( $this->$actionFunction() == false )
					{
						$payload['payload'] = $this->args['failureMessage'] ;
					} else {
						$payload['success'] = true ;
						unset( $payload['payload'] ) ;
					}
				}
			}

			return $payload ;
		}

		function isValidEmail( $emailToCheck = '' )
		{
			return ( preg_match('`^([a-z0-9_]|\-|\.|\+)+@(([a-z0-9_]|\-)+\.)+[a-z]{2,6}$`i', trim( $emailToCheck ) ) ) ? true : false;
		}

		function Inclusion()
		{
			if( ! isset( $this->args['failureMessage'] ) ) $this->args['failureMessage'] = 'Must be included in the list!' ;

			if( $this->data != null || $this->data != '' )
			{
				if( isset( $this->args['within'] ) && is_array( $this->args['within'] ) )
				{
					if( isset( $this->args['partialMatch'] ) && $this->args['partialMatch'] == true )
					{
						$words1 = split( ' ', $this->data ) ;
						$words = array() ;

						$count = count( $words1 ) ;
						if( count( $words1 ) == 1 )
						{
							$words = array( $words1[0] ) ;
						} else {
							$words = $words1 ;
						}

						if( $this->array_in_array( $words, $this->args['within'] ) )
						{
							unset( $this->args['failureMessage'] ) ;
							return true ;
						} else {
							return false ;
						}
					} else {
						if( in_array( $this->data, $this->args['within'] ) )
						{
							unset( $this->args['failureMessage'] ) ;
							return true ;
						} else {
							return false ;
						}
					}
				}
			}
			return true ;
		}

		function Exclusion()
		{
			if( ! isset( $this->args['failureMessage'] ) ) $this->args['failureMessage'] = 'Must not be included in the list!' ;

			if( $this->data != null || $this->data != '' )
			{
				if( isset( $this->args['within'] ) && is_array( $this->args['within'] ) )
				{
					if( isset( $this->args['partialMatch'] ) && $this->args['partialMatch'] == true )
					{
						$words1 = split( ' ', $this->data ) ;
						$words = array() ;

						$count = count( $words1 ) ;
						if( count( $words1 ) == 1 )
						{
							$words = array( $words1[0] ) ;
						} else {
							$words = $words1 ;
						}

						if( ! $this->array_in_array( $words, $this->args['within'] ) )
						{
							unset( $this->args['failureMessage'] ) ;
							return true ;
						} else {
							return false ;
						}
					} else {

						if( ! in_array( $this->data, $this->args['within'] ) )
						{
							unset( $this->args['failureMessage'] ) ;
							return true ;
						} else {
							return false ;
						}
					}
				}
			}
			return true ;
		}

		function Confirmation()
		{
			if( ! isset( $this->args['failureMessage'] ) ) $this->args['failureMessage'] = 'Does not match!' ;
			if( $this->data != null || $this->data != '' )
			{
				if( isset( $this->args['match'] ) )
				{
					$match = trim( '' . $this->args['match'] ) ;

					if( isset( $this->parentData[$match] ) )
					{
						$data1 = trim( '' . $this->data ) ;

						if( $data1 == $this->parentData[$match] )
						{
							unset( $this->args['failureMessage'] ) ;
							return true ;
						}
					}
				}
			}
			return false ;
		}

		function Acceptance()
		{
			if( ! isset( $this->args['failureMessage'] ) ) $this->args['failureMessage'] = 'Must be accepted!' ;

			if( $this->Presence() )
			{
				return true ;
			}

			return false ;
		}

		function Presence()
		{
			if( ! isset( $this->args['failureMessage'] ) ) $this->args['failureMessage'] = 'Cannot be empty!' ;

			if( $this->data !== null && $this->data !== '' )
			{
				unset( $this->args['failureMessage'] ) ;
				return true ;
			}
			return false ;
		}

		function Format()
		{
			if( ! isset( $this->args['failureMessage'] ) ) $this->args['failureMessage'] = 'Not valid!' ;

			if( $this->data != null || $this->data != '' )
			{
				$pattern = $this->args['pattern'] ;

				if( preg_match( $pattern, $this->data ) )
				{
					unset( $this->args['failureMessage'] ) ;
					return true ;
				} else {
					return false ;
				}
			}
			return true ;
		}

		function Email()
		{
			if( ! isset( $this->args['failureMessage'] ) ) $this->args['failureMessage'] = 'Must be a valid email address!' ;

			if( $this->data != null || $this->data != '' )
			{
				$this->data = trim( '' . $this->data ) ;
				if( $this->isValidEmail( $this->data ) )
				{
					unset( $this->args['failureMessage'] ) ;
					return true ;
				} else {
					return false ;
				}
			}
			return true ;
		}

		function Numericality()
		{
			if( ! isset( $this->args['failureMessage'] ) ) $this->args['failureMessage'] = 'Not a number' ;

			if( $this->data != null || $this->data != '' )
			{

				if( ! isset( $this->args['onlyInteger'] ) && ! isset( $this->args['is'] ) && ! isset( $this->args['minimum'] ) && ! isset( $this->args['maximum'] ) )
				{
					if( is_numeric( $this->data ) )
					{
						unset( $this->args['failureMessage'] ) ;
						return true ;
					} else {
						return false ;
					}
				} else {
					if( ! is_numeric( $this->data ) )
					{
						return false ;
					} else {
						$this->data = $this->resolveNumber( $this->data ) ;

						// ----------------------------------------- 

						if( $this->args['onlyInteger'] == true )
						{
							if( ! isset( $this->args['minimum'] ) && ! isset( $this->args['maximum'] ) && ! isset( $this->args['is'] ) )
							{
								if( is_int( $this->data ) )
								{
									unset( $this->args['failureMessage'] ) ;
									return true ;
								} else {
									$this->args['failureMessage'] = 'Must be an integer!' ;
								}
							}
						}

						if( isset( $this->args['is'] ) )
						{
							$isValue = $this->resolveNumber( $this->args['is'] ) ;
							if( $isValue == $this->data )
							{
								unset( $this->args['failureMessage'] ) ;
								return true ;
							} else {
								$this->args['failureMessage'] = 'Must be ' . $isValue ;
								return false ;
							}
						}

						if( isset( $this->args['minimum'] ) && isset( $this->args['maximum'] ) )
						{
							if( $this->args['onlyInteger'] == true )
							{
								if( ! is_int( $this->data ) )
								{
									$this->args['failureMessage'] = 'Must be an integer!' ;
									return false ;
								}
							}

							$minValue = $this->resolveNumber( $this->args['minimum'] ) ;
							$maxValue = $this->resolveNumber( $this->args['maximum'] ) ;

							if( $this->data >= $minValue && $this->data <= $maxValue )
							{
								unset( $this->args['failureMessage'] ) ;
								return true ;
							} else {
								$this->args['failureMessage'] = 'Must be between ' .$minValue . ' and ' . $maxValue . '!' ;
								return false ;
							}
						} else {
							if( isset( $this->args['minimum'] ) )
							{
								if( $this->args['onlyInteger'] == true )
								{
									if( ! is_int( $this->data ) )
									{
										$this->args['failureMessage'] = 'Must be an integer!' ;
										return false ;
									}
								}
								$minValue = $this->resolveNumber( $this->args['minimum'] ) ;
								if( $this->data >= $minValue ) 
								{
									unset( $this->args['failureMessage'] ) ;
									return true ;
								} else {
									$this->args['failureMessage'] = 'Must not be less than ' .$minValue . '!' ;
									return false ;
								}
							} else {
								if( $this->args['onlyInteger'] == true )
								{
									if( ! is_int( $this->data ) )
									{
										$this->args['failureMessage'] = 'Must be an integer!' ;
										return false ;
									}
								}
								
								$maxValue = $this->resolveNumber( $this->args['maximum'] ) ;
								if( $this->data<=$maxValue ) 
								{
									unset( $this->args['failureMessage'] ) ;
									return true ;
								} else {
									$this->args['failureMessage'] = 'Must not be more than ' .$maxValue . '!' ;
									return false ;
								}
							}
						}
					}
				}
			}
			return true ;
		}

		function Length()
		{
			if( $this->data != null || $this->data == '' )
			{
				$dataPayload = trim( ''. $this->data ) ;
				$strCount = strlen( $dataPayload ) ;

				if( isset( $this->args['is'] ) )
				{
					$equalValue = intval( $this->args['is'] ) ;

					if( $strCount == $equalValue ) 
					{
						unset( $this->args['failureMessage'] ) ;
						return true ;
					} else {
						$this->args['failureMessage'] =( isset( $this->args['wrongLengthMessage'] ) ) ? $this->args['tooLongMessage'] : 'Must be ' .$equalValue . ' characters long!' ;
						return false ;
					}
				} else {
					if( isset( $this->args['minimum'] ) && isset( $this->args['maximum'] ) )
					{
						$minValue = intval( $this->args['minimum'] ) ;
						$maxValue = intval( $this->args['maximum'] ) ;
						
						if( $strCount >= $minValue && $strCount <= $maxValue ) 
						{
							unset( $this->args['failureMessage'] ) ;
							return true ;
						} else {
							$this->args['failureMessage'] = 'Must be between ' .$minValue . ' and ' . $maxValue . ' characters long!' ;
							return false ;
						}
					} else {
						if( isset( $this->args['minimum'] ) )
						{
							$minValue = intval( $this->args['minimum'] ) ;

							if( $strCount >= $minValue ) 
							{
								unset( $this->args['failureMessage'] ) ;
								return true ;
							} else {
								$this->args['failureMessage'] =( isset( $this->args['tooShortMessage'] ) ) ? $this->args['tooLongMessage'] : 'Must not be less than ' .$minValue . ' characters long!' ;
								return false ;
							}
						} else {
							if( isset( $this->args['maximum'] ) )
							{
								$maxValue = intval( $this->args['maximum'] ) ;

								if( $strCount <= $maxValue ) 
								{
									unset( $this->args['failureMessage'] ) ;
									return true ;
								} else {
									$this->args['failureMessage'] =( isset( $this->args['tooLongMessage'] ) ) ? $this->args['tooLongMessage'] : 'Must not be more than ' .$maxValue . ' characters long!' ;
									return false ;
								}
							}
						}
					}
				}
			}
			return false ;
		}
	}
}

if( ! class_exists('My_MassValidatePHP') )
{
	require_once dirname( dirname(__FILE__) ).'/class/livevalidationphp.class.php' ;

	class My_MassValidatePHP extends LiveValidationMassValidatePHP
	{
		var $fields ;
		var $formID ;
		var $varname ;
		var $rules ;

		function addRules( $rules = array() )
		{
			$this->rules = $rules ;

			while( $element = each( $this->rules ) )
			{
				$key = trim( $element['key'] ) ;
				$currentElement = $this->rules[$key] ;

				$dummyRule = null ;

				$args = array() ;
				if( isset( $currentElement['args'] ) )
				{
					$args = array_merge( $currentElement['args'], $args ) ;
				}

				$display = '' ;
				if( isset( $currentElement['display'] ) )
				{
					$display = $currentElement['display'] ;
				}

				$dummyRule = new My_ValidatePHP( $this->data, $key, $args, $display ) ;

				if( isset( $currentElement['rules'] ) )
				{
					$currentRules = $currentElement['rules'] ;

					$countCurrentelementRules = count( $currentRules ) ;
					for( $q = 0 ; $q < $countCurrentelementRules ; $q++ )
					{
						$dummyRule->add( $currentRules[$q]['method'], $currentRules[$q]['args'] ) ;
					}
				}

				$this->add( $dummyRule ) ;
			}
		}
	}
}

?>