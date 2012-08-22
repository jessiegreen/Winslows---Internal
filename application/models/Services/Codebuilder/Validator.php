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

class Validator 
{
    
    /**
     * @param array $_messages 
     */
    private $_messages;
    
    /**
     * @param array $_warnings 
     */
    private $_warnings = array();
    
    /**
     * @param array $_errors 
     */
    private $_errors = array();
    
    public function __construct() {
	
    }
    
    public function validateBuilderValuesArray(BuilderArrayMapper $BuilderArrayMapper, $options, $location)
    {
	switch($BuilderArrayMapper->getStructureTypeCode($options)){
	    #--Metal Structure
	    case "MC":
		$this->_validateMetalStructure($BuilderArrayMapper, $options, $location);
		$this->_validateFrameGauge($BuilderArrayMapper, $options);
	    break;
	    #--Wood Structure
	    case "WF":
		#--Set Base Price
		$this->_validateWoodStructure($BuilderArrayMapper, $options);
	    break;
	    default:
	}
    }
    
    private function _validateMetalStructure(BuilderArrayMapper $BuilderArrayMapper, $options, $location = null){
	if($location){
	    $model = $BuilderArrayMapper->getMetalStructureModelCode($options);
	    switch($model){
		case "RA":
		case "BA":
		case "VA":
		    if(!in_array($location, array("ce", "nt")))
		    {
			throw new \Exception($BuilderArrayMapper->getMetalStructureModelCode($options). "  model is not available in your area. Please select a new model.");
		    }
		break;
		case "RW":
		case "BW":
		case "VW":
		    if($location != "fl")
		    {
			throw new \Exception($BuilderArrayMapper->getMetalStructureModelCode($options). " model is not available in your area. Please select a new model.");
		    }
		break;
		case "RS":
		case "BS":
		case "VS":
		    if($location != "ne")
		    {
			throw new \Exception($BuilderArrayMapper->getMetalStructureModelCode($options). " model is not available in your area. Please select a new model.");
		    }
		break;
		case "RX":
		case "BX":
		case "VX":
		    if($location != "mi")
		    {
			throw new \Exception($BuilderArrayMapper->getMetalStructureModelCode($options). "  model is not available in your area. Please select a new model.");
		    }
		break;
		case "":
		    throw new \Exception("Model is required");
		break;
		default:
		    throw new \Exception($BuilderArrayMapper->getMetalStructureModelCode($options). "  model is not available in your area. Please select a new model.");
	    }
	}
	else{
	    $this->_errors[] = "Area is required to get proper options and price";
	}
    }
    
//    private function _validateSize(BuilderArrayMapper $BuilderArrayMapper, $options)
//    {
//	$size		    = $BuilderArrayMapper->getSize($options);
//	$metal_models_array = $this->_data->Metal_Models_Array;
//	if(!key_exists($size, $metal_models_array[$BuilderArrayMapper->getMetalStructureModelCode($options)])){
//	    $this->_errors[] = "'".$size. "' is not a valid size for model '".$BuilderArrayMapper->getMetalStructureModelCode($options)."'";
//	}
//    }
    
//    private function _validateFrameGauge(BuilderArrayMapper $BuilderArrayMapper, $options)
//    {
//	$frame_gauge = $BuilderArrayMapper->getFrameGaugeCode($options);
//	$model_code  = $BuilderArrayMapper->getMetalStructureModelCode($options);
//	if(strlen($frame_gauge) > 0 && in_array($model_code, array("RX", "BX", "VX"))){
//	    $this->_errors[] = "Frame Gauge option not valid. Maximum frame gauge already standard with ".$BuilderArrayMapper->getMetalStructureModelCode($options);
//	}
//    }
    
    #--This-> is a functional test and needs to be moved to the tests
    public function validateValueOptions(){
	/* @var $Option \Entities\CbOption */
	foreach($this->_em->getRepository("\Entities\CbOption")->findAll() as $Option){
	    $Values = $Option->getValues();
	    /* @var $Value \Entities\CbValue */
	    foreach($Values as $Value){
		$length = $Value->getLength();
		/* @var $ValueOption \Entities\CbValueOption */
		foreach ($Value->getValueOptions() as $ValueOption) {
		    if(strlen($ValueOption->getCode()) != $length){
			throw new \Exception($Option->getName()." - ".$Value->getName()."(id=".$Value->getId().") - ".$ValueOption->getName()."'s code of ".$ValueOption->getCode()." is not equal to ".$Value->getName()."'s length of $length");
		    }
		}
	    }
	}
    }
}

?>
