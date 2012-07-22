<?php
	/*
		Created by:

		Fransjo Leihitu (http://www.leihitu.nl);

		Inspired by LiveValidation (http://www.livevalidation.com/).

		This file has 3 classes

			* LiveValidationPHP
			* Validation
			* LiveValidationMassValidatePHP
	*/

	/*

	The MIT License

	LiveValidation is licensed under the terms of the MIT License

	Copyright (c) 2007 Fransjo Leihitu

	Permission is hereby granted, free of charge, to any person obtaining a copy of this software and associated documentation files (the “Software”), to deal in the Software without restriction, including without limitation the rights to use, copy, modify, merge, publish, distribute, sublicense, and/or sell copies of the Software, and to permit persons to whom the Software is furnished to do so, subject to the following conditions:

	The above copyright notice and this permission notice shall be included in all copies or substantial portions of the Software.

	THE SOFTWARE IS PROVIDED “AS IS”, WITHOUT WARRANTY OF ANY KIND, EXPRESS OR IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY, FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM, OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE SOFTWARE.

	*/

	define("LiveValidationPHP_Version_Major",1);
	define("LiveValidationPHP_Version_Minor","0.4.1");
	define("LiveValidationPHP_Version",LiveValidationPHP_Version_Major . " " . LiveValidationPHP_Version_Minor);

if( ! class_exists( 'LiveValidationPHP' ) )
{
	class LiveValidationPHP
	{
		var $elementID;
		var $args;

		var $rules;
		var $data;
		var $errors;
		var $varname;
		var $parentData;
		var $display;

		function LiveValidationPHP($data=array(),$elementID="",$args=array(),$display="")
		{
			$this->parentData=$data;
			$this->elementID="";
			$this->args=array();

			//$this->args["validMessage"]="Ok";

			$this->args=array_merge($this->args,$args);

			$this->rules=array();

			$elementID=trim(stripslashes(strip_tags($elementID)));
			if($elementID!="") $this->elementID=$elementID;
			$this->display=trim($this->elementID);

			$display=trim(stripslashes(strip_tags($display)));
			if($display!="") $this->display=$display;

			$this->data=null;
			if(isSet($data[$elementID]))
			{
				$this->data=$data[$this->elementID];
			}
			$this->errors=array();
			$this->varname="lvphp_" . md5(uniqid(rand(), true));
		}

		function add($type="Validate.Presence",$args=array())
		{
			$this->rules[]=new Validation($this->data,$type,$args,$this->parentData,$this->elementID,$this->display);
		}

		function validate()
		{
			$payload=array();
			$hasErrors=false;

			$count=count($this->rules);
			for($i=0;$i<$count;$i++)
			{
				$currentRule=$this->rules[$i];
				if($resultArray=$currentRule->validate())
				{
					if($resultArray["success"]==false)
					{
						$hasErrors=true;	
						$this->errors[]=$resultArray["payload"];
					}
				}
			}
			return $this->errors;

		}

		function generate()
		{
			$html="";
			$html.="var " . $this->varname . " = new LiveValidation( \"" . $this->elementID ."\"";

			$argsKeys=count(array_keys($this->args));
			$counter=0;
			if($argsKeys>0) $html.= ", { ";

			while($element=each($this->args))
			{
				$key=trim($element["key"]);
				$value=$element["value"];

				$html.=$key . ":";

				$theType=gettype($value);
				switch($theType)
				{
					default:
					{
						$html.="\"" . $value . "\"";
						break;
					}

					case "boolean":
					{
						if($value==true)
						{
							$html.="true";
						} else {
							$html.="false";
						}
						break;
					}

					case "int":{}
					case "double":{}
					case "float":{}
					case "integer":
					{
						$html.= $value;
						break;
					}
				}

				if(($counter+1)<$argsKeys)
				{
					$html.=",";
				}

				$counter++;
			}

			if($argsKeys>0) $html.= " } ";
			$html.=");\n";

			$count=count($this->rules);
			for($i=0;$i<$count;$i++)
			{
				$currentRule=$this->rules[$i];
				$html.=$currentRule->generate($this->varname);
			}

			return $html;
		}
	}
}

if( ! class_exists('Validation') )
{
	class Validation
	{
		var $args;
		var $type;
		var $method;
		var $data;
		var $parentData;
		var $elementID;
		var $display;

		function Validation($data,$type="Validate.Presence",$args=array(),$parentData=array(),$elementID="",$display="")
		{
			$this->elementID=$elementID;
			$this->display=$this->elementID;

			$this->parentData=$parentData;

			$this->data=$data;

			$this->type=$type;

			$this->method=$this->type;
			$this->method=strtolower($this->method);
			$this->method=str_replace("validate.","",$this->method);
			$this->method=ucfirst($this->method);

			$this->args=array();
			$this->args=array_merge($this->args,$args);

			$display=trim(stripslashes(strip_tags($display)));
			if($display!="") $this->display=$display;
		}

		function debugArgs()
		{
			$this->debug($this->args);
		}

		function validate()
		{
			$payload=array();
			$payload["success"]=false;

			if($this->method!="")
			{
				$actionFunction=$this->method;

				if(method_exists($this,$actionFunction)) 
				{
					if($this->$actionFunction()==false)
					{
						$payload["payload"]="[" . $this->display . "] " . $this->args["failureMessage"];
					} else {
						$payload["success"]=true;
						unset($payload["payload"]);
					}
				}
			}

			return $payload;
		}

		function isValidEmail($emailToCheck="")
		{
			if(trim($emailToCheck)!="")
			{
				$Result = ereg ("^[^@ ]+@[^@ ]+\.[^@ \.]+$",$emailToCheck);
				if ($Result)
				{
					return true;
				}
			}
			return false;
		}

		function array_in_array($needle, $haystack) {
		    //Make sure $needle is an array for foreach
		    if(!is_array($needle)) $needle = array($needle);
		    //For each value in $needle, return TRUE if in $haystack
		    foreach($needle as $pin)
		        if(in_array($pin, $haystack)) return TRUE;
		    //Return FALSE if none of the values from $needle are found in $haystack
		    return FALSE;
		}

		function Inclusion()
		{
			if(!isSet($this->args["failureMessage"])) $this->args["failureMessage"]="Must be included in the list!";

			if($this->data!=null || $this->data!="")
			{
				if(isSet($this->args["within"]) && is_array($this->args["within"]))
				{
					if(isSet($this->args["partialMatch"]) && $this->args["partialMatch"]==true)
					{
						$words1=split(" ",$this->data);
						$words=array();

						$count=count($words1);
						if(count($words1)==1)
						{
							$words=array($words1[0]);
						} else {
							$words=$words1;
						}

						if($this->array_in_array($words, $this->args["within"]))
						{
							unset($this->args["failureMessage"]);
							return true;
						}
					} else {
						if(in_array($this->data, $this->args["within"]))
						{
							unset($this->args["failureMessage"]);
							return true;
						}
					}
				}
			}
			return false;
		}

		function Exclusion()
		{
			if(!isSet($this->args["failureMessage"])) $this->args["failureMessage"]="Must not be included in the list!";

			if($this->data!=null || $this->data!="")
			{
				if(isSet($this->args["within"]) && is_array($this->args["within"]))
				{
					if(isSet($this->args["partialMatch"]) && $this->args["partialMatch"]==true)
					{
						$words1=split(" ",$this->data);
						$words=array();

						$count=count($words1);
						if(count($words1)==1)
						{
							$words=array($words1[0]);
						} else {
							$words=$words1;
						}

						if(!$this->array_in_array($words, $this->args["within"]))
						{
							unset($this->args["failureMessage"]);
							return true;
						}
					} else {

						if(!in_array($this->data, $this->args["within"]))
						{
							unset($this->args["failureMessage"]);
							return true;
						}
					}
				}
			}
			return false;
		}

		function Confirmation()
		{
			if(!isSet($this->args["failureMessage"])) $this->args["failureMessage"]="Does not match!";
			if($this->data!=null || $this->data!="")
			{
				if(isSet($this->args["match"]))
				{
					$match=trim("" . $this->args["match"]);

					if(isSet($this->parentData[$match]))
					{
						$data1=trim("" . $this->data);

						if($data1==$this->parentData[$match])
						{
							unset($this->args["failureMessage"]);
							return true;
						}
					}
				}
			}
			return false;
		}

		function Acceptance()
		{
			if(!isSet($this->args["failureMessage"])) $this->args["failureMessage"]="Must be accepted!";

			if($this->Presence())
			{
				return true;
			}

			return false;
		}

		function Presence()
		{
			if(!isSet($this->args["failureMessage"])) $this->args["failureMessage"]="Can't be empty!";

			if($this->data!=null || $this->data!="")
			{
				unset($this->args["failureMessage"]);
				return true;
			}
			return false;
		}

		function Format()
		{
			if(!isSet($this->args["failureMessage"])) $this->args["failureMessage"]="Not valid!";

			if($this->data!=null || $this->data!="")
			{
				$pattern=$this->args["pattern"];

				preg_match($pattern, $this->data,$matches);
				if($matches)
				{
					unset($this->args["failureMessage"]);
					return true;
				}
			}
			return false;	
		}

		function Email()
		{
			if(!isSet($this->args["failureMessage"])) $this->args["failureMessage"]="Must be a valid email address!";
			if($this->data!=null || $this->data!="")
			{
				$this->data=trim("" . $this->data);
				if($this->isValidEmail($this->data))
				{
					unset($this->args["failureMessage"]);
					return true;
				}
			}
			return false;
		}

		function resolveNumber($data)
		{
			// now cast the data to float or int
			$pos1 = strpos($data, ".");
			$pos2 = strpos($data, ",");

			if($pos1>0  || $pos2>0)
			{
				$data=(float)$data;
			} else {
				$data=(int)$data;
			}

			return $data;
		}

		function Numericality()
		{
			if(!isSet($this->args["failureMessage"])) $this->args["failureMessage"]="Not a number";

			if($this->data!=null || $this->data=="")
			{

				if(!isSet($this->args["onlyInteger"]) && !isSet($this->args["is"]) && !isSet($this->args["minimum"]) && !isSet($this->args["maximum"]))
				{
					if(is_numeric($this->data))
					{
						unset($this->args["failureMessage"]);
						return true;
					}
				} else {

					if(is_numeric($this->data))
					{
						$this->data=$this->resolveNumber($this->data);

						// ----------------------------------------- 

						if($this->args["onlyInteger"]==true)
						{
							if(!isSet($this->args["minimum"]) && !isSet($this->args["maximum"]) && !isSet($this->args["is"]))
							{
								if(is_int($this->data))
								{
									unset($this->args["failureMessage"]);
									return true;
								} else {
									$this->args["failureMessage"]="Must be an integer!";
								}
							}
						}

						if(isSet($this->args["is"]))
						{
							$isValue=$this->resolveNumber($this->args["is"]);
							if($isValue==$this->data)
							{
								unset($this->args["failureMessage"]);
								return true;
							} else {
								$this->args["failureMessage"]="Must be " . $isValue;
								return false;
							}
						}

						if(isSet($this->args["minimum"]) && isSet($this->args["maximum"]))
						{
							if($this->args["onlyInteger"]==true)
							{
								if(!is_int($this->data))
								{
									$this->args["failureMessage"]="Must be an integer!";
									return false;
								}
							}

							$minValue=$this->resolveNumber($this->args["minimum"]);
							$maxValue=$this->resolveNumber($this->args["maximum"]);

							if($this->data>=$minValue && $this->data<=$maxValue)
							{
								unset($this->args["failureMessage"]);
								return true;
							} else {
								$this->args["failureMessage"]="Must be between " .  $minValue . " and " . $maxValue . "!";
								return false;
							}
						} else {
							if(isSet($this->args["minimum"]))
							{
								if($this->args["onlyInteger"]==true)
								{
									if(!is_int($this->data))
									{
										$this->args["failureMessage"]="Must be an integer!";
										return false;
									}
								}
								$minValue=$this->resolveNumber($this->args["minimum"]);
								if($this->data>=$minValue) 
								{
									unset($this->args["failureMessage"]);
									return true;
								} else {
									$this->args["failureMessage"]="Must not be less than " .  $minValue . "!";
									return false;
								}
							} else {
								if($this->args["onlyInteger"]==true)
								{
									if(!is_int($this->data))
									{
										$this->args["failureMessage"]="Must be an integer!";
										return false;
									}
								}
								
								$maxValue=$this->resolveNumber($this->args["maximum"]);
								if($this->data<=$maxValue) 
								{
									unset($this->args["failureMessage"]);
									return true;
								} else {
									$this->args["failureMessage"]="Must not be more than " .  $maxValue . "!";
									return false;
								}
							}
						}
					}
				}
			}
			return false;
		}

		function Length()
		{
			if($this->data!=null || $this->data=="")
			{
				$dataPayload=trim(""  . $this->data);
				$strCount=strlen($dataPayload);

				if(isSet($this->args["is"]))
				{
					$equalValue=intval($this->args["is"]);

					if($strCount==$equalValue) 
					{
						unset($this->args["failureMessage"]);
						return true;
					} else {
						$this->args["failureMessage"]="Must be " .  $equalValue . " characters long!";
						return false;
					}
				} else {
					if(isSet($this->args["minimum"]) && isSet($this->args["maximum"]))
					{
						$minValue=intval($this->args["minimum"]);
						$maxValue=intval($this->args["maximum"]);
						
						if($strCount>=$minValue && $strCount<=$maxValue) 
						{
							unset($this->args["failureMessage"]);
							return true;
						} else {
							$this->args["failureMessage"]="Must be between " .  $minValue . " and " . $maxValue . " characters long!";
							return false;
						}
					} else {
						if(isSet($this->args["minimum"]))
						{
							$minValue=intval($this->args["minimum"]);

							if($strCount>=$minValue) 
							{
								unset($this->args["failureMessage"]);
								return true;
							} else {
								$this->args["failureMessage"]="Must not be less than " .  $minValue . " characters long!";
								return false;
							}
						} else {
							if(isSet($this->args["maximum"]))
							{
								$maxValue=intval($this->args["maximum"]);

								if($strCount<=$maxValue) 
								{
									unset($this->args["failureMessage"]);
									return true;
								} else {
									$this->args["failureMessage"]="Must not be more than " .  $maxValue . " characters long!";
									return false;
								}
							}
						}
					}
				}
			}
			return false;
		}

		function debug($data=null)
		{
			print "<pre>";
			print_r($data);
			print "</pre>";
		}

		function generate($varName="")
		{
			$html="";
			if(trim($varName)!="")
			{
				$html.=$varName . ".add( Validate." . $this->method ;

				$argsKeys=count(array_keys($this->args));
				if($argsKeys>0) $html.= ", { ";

				$counter=0;
				while($element=each($this->args))
				{
					$key=trim($element["key"]);
					$value=$element["value"];

					$theType=gettype($value);

					$html.=$key . ":";

					switch($theType)
					{
						default:
						{
							if($key=="pattern")
							{
								$html.="" . $value . "";
							} else{
								$html.="\"" . $value . "\"";
							}
							break;
						}

						case "boolean":
						{
							$html.="true";
							break;
						}
						
						case "int":{}
						case "double":{}
						case "float":{}
						case "integer":
						{
							$html.= $value;
							break;
						}

						case "array":
						{
							$html.="[";

							$counter=count($value);
							for($v=0;$v<$counter;$v++)
							{

								$value1=$value[$v];
								if(is_numeric($value1)){
								} else {
									$html.="'" . $value1 . "'"; 
								}

								if(($v+1)<$counter) $html.=",";
							}

							$html.="]";
						}
					}

					if(($counter+1)<$argsKeys)
					{
						$html.=",";
					}

					$counter++;
				}

				if($argsKeys>0) $html.= " } ";
				$html.= ");\n";
			}
			return $html;
		}
	}
}

if( ! class_exists('LiveValidationMassValidatePHP') )
{
	class LiveValidationMassValidatePHP
	{
		var $fields;
		var $formID;
		var $varname;
		var $rules;

		function LiveValidationMassValidatePHP($formID="",$data=array())
		{
			$this->data=$data;
			$this->formID=trim(stripslashes(strip_tags($formID)));
			$this->fields=array();
			
			$this->varname="lvphp_frm_" . md5(uniqid(rand(), true));
			$this->rules=array();
		}

		function addRules($rules=array())
		{
			$this->rules=$rules;

			while($element=each($this->rules))
			{
				$key=trim($element["key"]);
				$currentElement=$this->rules[$key];

				$dummyRule=null;

				$args=array();
				if(isSet($currentElement["args"]))
				{
					$args=array_merge($currentElement["args"],$args);
				}

				$display="";
				if(isSet($currentElement["display"]))
				{
					$display=$currentElement["display"];
				}

				$dummyRule=new LiveValidationPHP($this->data,$key,$args,$display);

				if(isSet($currentElement["rules"]))
				{
					$currentRules=$currentElement["rules"];

					$countCurrentelementRules=count($currentRules);
					for($q=0;$q<$countCurrentelementRules;$q++)
					{
						$dummyRule->add($currentRules[$q]["method"],$currentRules[$q]["args"]);
					}
				}

				$this->add($dummyRule);
			}
		}

		function add($element=null)
		{
			if($element!=null)
			{
				$this->fields[]=$element;
			}
		}

		function validate()
		{
			$errors=array();

			$countElements=count($this->fields);
			for($q=0;$q<$countElements;$q++)
			{
				$currentElement=$this->fields[$q];

				$errors=array_merge($currentElement->validate(),$errors);
			}

			return $errors;

		}

		function generateElements()
		{
			$html="";
			$countElements=count($this->fields);
			for($q=0;$q<$countElements;$q++)
			{
				$html.=$this->fields[$q]->generate() . "\n";
			}

			return $html;
		}

		function generateAll()
		{
			$html="";
			$html.=$this->generateElements();
			$html.=$this->generate();

			return $html;
		}

		function generate()
		{
			$html="";

			if($this->formID!="")
			{
				$html.="var " . $this->varname . " = document.getElementById( \"" . $this->formID ."\" );\n";
				$html.=$this->varname . ".onsubmit = function(e){\n";
				$html.="var result_" . $this->formID . "=LiveValidation.massValidate([";

				$count=count($this->fields);
				for($i=0;$i<$count;$i++)
				{
					$currentField=$this->fields[$i];
					$html.=$currentField->varname;

					if(($i+1)<$count) $html.=", ";
				}

				$html.="]);\n";

				//$html.="alert(result_" . $this->formID .");\n";
				$html.="return result_" . $this->formID . ";\n";

				$html.="};\n";
			}
			return $html;
		}
	}
}

?>