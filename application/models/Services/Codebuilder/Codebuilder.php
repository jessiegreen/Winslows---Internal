<?php

/**
 * Name:
 * Location:
 *
 * Description for class (if any)...
 *
 * @author     Jessie Green <jessie.winslows@gmail.com>
 * @copyright  2012 Winslows inc.
 */
namespace Services\Codebuilder;

class Codebuilder 
{
    /**
     * @var \Doctrine\ORM\EntityManager $_em
     */
    private $_em;
    
    /**
     * @var FormOptions $formoptions 
     */
    private $_formoption;
    
    /**
     * @var Parser $_parser 
     */
    private $_parser;
    
    /**
     * @var Data $_data 
     */
    private $_data;
    
    /**
     * @var Pricing $_pricing 
     */
    private $_pricing;
    
    /**
     * @var BuilderArrayMapper $_builder_array_mapper 
     */
    private $_builder_array_mapper;
    
    /**
     * @var \Repositories\CbOption  $_option_repos
     */
    private $_option_repos;
    
    /**
     * @var \Repositories\CbValue  $_value_repos
     */
    private $_value_repos;
    
    /**
     * @var \Repositories\CbValueOption  $_valueoption_repos
     */
    private $_valueoption_repos;
    
    /**
     * @var RequiredData $_required_data
     */
    private $_required_data;
    
    public function __construct()
    {
	$front			= \Zend_Controller_Front::getInstance();
	$bootstrap		= $front->getParam("bootstrap");
	$this->_em		= $bootstrap->getResource('entityManager');
	$this->_option_repos	= $this->_em->getRepository("\Entities\CbOption");
	$this->_value_repos	= $this->_em->getRepository("\Entities\CbValue");
	$this->_valueoption_repos    = $this->_em->getRepository("\Entities\CbValueOption");
	$this->_formoption	= Factory::factoryFormOption($this->_em);
	$this->_parser		= Factory::factoryParser();
	$this->_builder_array_mapper = Factory::factoryBuilderArrayMapper();
	$this->_validator	= Factory::factoryValidator();
	$this->_pricing		= Factory::factoryPricing();
	$this->_data		= Factory::factoryData();
	$this->_required_data	= Factory::factoryRequiredData();
    }
    
    public function getCodeFromBuilderArray($array)
    {//foreach($values_array as $index => $value_array)
	$code_array = array();
	
	foreach ($array as $option => $values_array) {
	    if(is_array($values_array)){
		switch ($option) {
		    case "type": //AA
			if(!isset($values_array[0]["type"]))continue;
			$code_array[] = "AA".$values_array[0]["type"];
			break;
		    case "metal_model": //CP
			if(!isset($values_array[0]["name"]))continue;
			$code_array[] = "CP".$values_array[0]["name"];
			break;
		    case "size": //AB and AC
			break;
		    case "width":
			if(!isset($values_array[0]["width"]))continue;
			$code_array[] = "AB".$this->_getNa($values_array[0]["width"],2);
			break;
		    case "length":
			if(!isset($values_array[0]["length"]))continue;
			$code_array[] = "AC".$this->_getNa($values_array[0]["length"],2);
			break;
		    case "covered_left":
			$type	= $values_array[0]["type"];
			$height = isset($values_array[0]["height"]) ? $this->_getNa($values_array[0]["height"],1) : "_";
			$code_array[] = "AI".$type.$height;
			break;
		    case "covered_right":
			$type	= $values_array[0]["type"];
			$height = isset($values_array[0]["height"]) ? $this->_getNa($values_array[0]["height"],1) : "_";
			$code_array[] = "AJ".$type.$height;
			break;
		    case "covered_front":
			$type	= $values_array[0]["type"];
			$height = isset($values_array[0]["height"]) ? $this->_getNa($values_array[0]["height"],1) : "_";
			$code_array[] = "AK".$type.$height;
			break;
		    case "covered_back":
			$type	= $this->_getNa($values_array[0]["type"], 2);
			$height = isset($values_array[0]["height"]) ? $this->_getNa($values_array[0]["height"],1) : "_";
			$code_array[] = "AL".$type.$height;
			break;
		    case "orientation_left":
			if($values_array[0]["orientation"])
			    $code_array[] = "AO".$this->_getNa($values_array[0]["orientation"],1);
			break;
		    case "orientation_right":
			if($values_array[0]["orientation"])
			    $code_array[] = "AP".$this->_getNa($values_array[0]["orientation"],1);
			break;
		    case "orientation_front":
			if($values_array[0]["orientation"])
			    $code_array[] = "AQ".$this->_getNa($values_array[0]["orientation"],1);
			break;
		    case "orientation_back":
			if($values_array[0]["orientation"])
			    $code_array[] = "AR".$this->_getNa($values_array[0]["orientation"],1);
			break;
		    case "leg_height":
			if($values_array[0]["height"])
			    $code_array[] = "AD".$this->_getNa($values_array[0]["height"],2);
			break;
		    case "color_roof":
			if($values_array[0]["color"])
			    $code_array[] = "AE".$this->_getNa($values_array[0]["color"],2);
			break;
		    case "color_trim":
			if($values_array[0]["color"])
			    $code_array[] = "AF".$this->_getNa($values_array[0]["color"],2);
			break;
		    case "color_sides":
			if($values_array[0]["color"])
			    $code_array[] = "AG".$this->_getNa($values_array[0]["color"],2);
			break;
		    case "color_ends":
			if($values_array[0]["color"])
			    $code_array[] = "AH".$this->_getNa($values_array[0]["color"],2);
			break;
		    case "door":
			foreach($values_array as $door){
			    $location	    = $door["location"];
			    $type	    = $door["type"];
			    $width	    = $door["width"];
			    $height	    = $door["height"];
			    $from_left	    = $this->_getNa($door["from_left"], 3);
			    $code_array[]   = "AV".$location.$type.$width.$height.$from_left;
			}
			break;
		    case "window":
			foreach($values_array as $window_number => $window){
			    $location	    = $window["location"];
			    $type	    = $window["type"];
			    $width	    = $window["width"];
			    $height	    = $window["height"];
			    $from_left	    = $this->_getNa($window["from_left"], 3);
			    $from_bottom    = $this->_getNa($window["from_bottom"], 3);
			    $code_array[]   = "AW".$location.$type.$width.$height.$from_left.$from_bottom;
			}
			break;
		    default:
			throw new \Exception($option." is not a valid parameter for getting building code");
		}
	    }
	}
	ksort($code_array);
	return implode("", $code_array);
    }
    
    public function getBuilderArrayFromCode($code){
	return $this->_parser->parseToArray($code);
    }
    
    private function _getNa($value, $length) {
	if(!trim($value)){
	    $na_code = "";
	    for($i=$length;$i>=1;$i--)
	    {
		$na_code .= "_";
	    }
	    return $na_code;
	}
	return $value;
    }
    
    public function getPriceFromCode($code){
	$builder_values_array = array();
	
	if(is_string($code) && strlen($code)>0){
	    $builder_values_array = $this->_parser->parseToArray($code);
	}
	
	return $this->getPriceFromBuilderValuesArray($builder_values_array, $location);
    }
    
    /**
     * @param \Services\Codebuilder\BuilderArrayMapper $BuilderArrayMapper
     * @param array $builder_values_array
     * @param string $location 
     */
    public function validateBuilderValuesArray(\Services\Codebuilder\BuilderArrayMapper $BuilderArrayMapper, $builder_values_array, $location)
    {
	$this->_validator->validateBuilderValuesArray($BuilderArrayMapper, $builder_values_array, $location);
    }
    
    /**
     * @param array $builder_values_array
     * @param string $location
     * @return int 
     */
    public function getPriceFromBuilderValuesArray($builder_values_array, $location) 
    {
	$price_array = array();
	$price	    = 0;
	$details    = array();
	try {
	    $price	    = $this->_pricing->price($this->_builder_array_mapper, $builder_values_array, $location);
	    $details	    = $this->_pricing->getDetails();
	} catch (Exception $exc) {
	    throw new \Exception($exc->getMessage());
	}
	$price_array["price"]	= $price;
	$price_array["details"]	= $details;
	return $price_array;
    }
    
    /**
     * @return BuilderArrayMapper
     */
    public function getBuilderArrayMapper()
    {
	return $this->_builder_array_mapper;
    }
    
    /**
     * @return FormOptions
     */
    public function getFormOptions()
    {
	return $this->_formoption;
    }
    
    /**
     * 
     */
    public function hasRequiredValues($index, $builder_values_array)
    {
	try {
	    $required_array = $this->_required_data->getRequired($index);
	    foreach($required_array as $required_value)
	    {
		$mapper_method_string = "get".ucfirst(strtolower($index)."Code");
		if($this->_builder_array_mapper->$mapper_method_string)return true;
	    }
	} catch (Exception $exc) {
	    throw new \Exception($exc->getMessage());
	}
	
	return false;
    }
    
    /**
     * @param string $index
     * @return \Entities\CbOption
     */
    private function _getOptionObjectFromIndex($index)
    {
	return $this->_option_repos->findBy(array("index_string" => $index));
    }
    
    /**
     * @param string $index
     * @return array 
     */
    public function getOptionDetailsFromIndex($index)
    {
	return $this->_getOptionObjectFromIndex($index)->toArray();
    }
    
    /**
     * @param string $index
     * @return \Entities\CbOption
     */
    private function _getValueObjectFromIndex($option_index, $value_index)
    {
	$option = $this->_option_repos->findOneBy(array("index_string" => $option_index));
	if($option) return $this->_value_repos->findOneBy (array("index_string" => $value_index, "option_id" => $option->getId()));
	return false;
    }
    
    /**
     * @param string $index
     * @return array 
     */
    public function getValueDetailsFromIndex($option_index, $value_index)
    {
	$this->_getValueObjectFromIndex($option_index, $value_index)->toArray();
    }
    
    /**
     * @param string $index
     * @return \Entities\CbValue
     */
    private function _getValueOptionObjectFromIndex($option_index, $value_index, $valueoption_index){
	$value = $this->_getValueObjectFromIndex($option_index, $value_index, $valueoption_index);
	if($value) return $this->_valueoption_repos->findOneBy (array("index_string" => $valueoption_index, "value_id" => $value->getId ()));
    }
    
    /**
     * @param string $index
     * @return array 
     */
    public function getValueOptionDetailsFromIndex($option_index, $value_index, $valueoption_index){
	return $this->_getValueOptionObjectFromIndex($option_index, $value_index, $valueoption_index)->toArray();
    }
    
    /**
     * @param string $index
     * @return \Entities\CbValue
     */
    private function _getValueOptionObjectFromCode($option_index, $value_index, $valueoption_code){
	$value = $this->_getValueObjectFromIndex($option_index, $value_index);
	if($value) return $this->_valueoption_repos->findOneBy (array("code" => $valueoption_code, "value_id" => $value->getId ()));
    }
    
    /**
     * @param string $index
     * @return array 
     */
    public function getValueOptionDetailsFromCode($option_index, $value_index, $valueoption_code){
	$value_object = $this->_getValueOptionObjectFromCode($option_index, $value_index, $valueoption_code);
	if(is_object($value_object))return $value_object->toArray();

	return array();
    }
}

?>
