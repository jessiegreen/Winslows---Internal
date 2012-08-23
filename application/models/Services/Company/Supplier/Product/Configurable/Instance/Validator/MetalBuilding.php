<?php
namespace Services\Company\Supplier\Product\Configurable\Instance\Validator;

class MetalBuilding extends \Services\Company\Supplier\Product\Configurable\Instance\Validator implements \Interfaces\Company\Supplier\Product\Configurable\Instance\Validator
{
    /**
     *  @var \Entities\Company\Supplier\Product\Configurable\Instance $_Instance 
     */
    static private $_Instance;
    /**
     *  @var \Services\Company\Supplier\Product\Configurable\Instance\Validator\Data\MetalBuilding $_Data 
     */
    static private $_Data;
    /**
     *  @var \Services\Company\Supplier\Product\Configurable\Instance\Mapper\MetalBuilding $_Mapper 
     */
    static private $_Mapper;

    /**
     * @param \Entities\Company\Supplier\Product\Configurable\Instance $Instance
     */
    static public function validate(\Entities\Company\Supplier\Product\Configurable\Instance $Instance, $location = null)
    {
	$data_class	    = "\Services\Company\Supplier\Product\Configurable\Instance\Validator\Data\\".self::_getCalledClassName();
	$mapper_class	    = "\Services\Company\Supplier\Product\Configurable\Instance\Mapper\\".self::_getCalledClassName();
	self::$_Instance    = $Instance;
	self::$_Data	    = new $data_class;
	self::$_Mapper	    = new $mapper_class($Instance);
	
	self::_validateRequiredOptionsAndParameters();
	
	if($location)self::_validateModel($location);
	
	self::_validateFrameSize();
	self::_validateFrameGauge();
	self::_validateLegHeight();
	self::_validateWalls();
    }
    
    static private function _validateRequiredOptionsAndParameters()
    {	
	foreach (self::$_Instance->getProduct()->getRequiredOptions() as $ProductOption)
	{
	    if(!self::$_Instance->hasProductOption($ProductOption))
		throw new \Exception($ProductOption->getName()." is required.");
	}
	
	/* @var $Option Entities\Company\Supplier\Product\Configurable\Instance\Option */
	foreach(self::$_Instance->getOptions() as $Option)
	{
	    $RequiredParameters = $Option->getOption()->getRequiredParameters();
	    
	    foreach ($RequiredParameters as $Parameter)
	    {
		$message = $Option->getOption()->getCategory()->getName()." -> ".$Parameter->getOption()->getName()." -> ".$Parameter->getName().
			    " is ";
		if($Option->getOption()->isRequired())$message .= "required.";
		else $message .= " is missing. Select it or remove the Option";
		
		if($Option->getValueFromParameterIndex($Parameter->getIndex()) === false)
		    throw new \Exception($message);
	    }
	}
    }
    
    static private function _validateModel($location)
    {
	$valid = true;
	
	switch(self::$_Mapper->getModel())
	{
	    case "RA":
	    case "BA":
	    case "VA":
		if(!in_array($location, array("ce", "nt")))$valid = false;
	    break;
	    case "RW":
	    case "BW":
	    case "VW":
		if($location != "fl")
	    break;
	    case "RS":
	    case "BS":
	    case "VS":
		if($location != "ne")
	    break;
	    case "RX":
	    case "BX":
	    case "VX":
		if($location != "mi")
	    break;
	    case "":
		throw new \Exception("Model is required");
	    break;
	    default:
		$valid = false;
	}
	
	if($valid === false)throw new \Exception(
		self::$_Mapper->getModelName()."  model is not available in your area.".
		" Please select a new model or location."
		);
    }
    
    static private function _validateFrameSize()
    {
	$_Data	    = self::$_Data;
	$size	    = self::$_Mapper->getFrameSize();
	
	if(!in_array($size, $_Data::allowedMetalModelSizes()))
	    throw new \Exception("Size '".$size. "' is not a valid size. Change size.");
    }
    
    static private function _validateFrameGauge()
    {
	$frame_gauge	= self::$_Mapper->getFrameGauge();
	$model_code	= self::$_Mapper->getModel();
	
	if(
	    $frame_gauge !== false && 
	    strlen($frame_gauge) > 0 && 
	    in_array($model_code, self::$_Data->getHighSnowAndWindModelsArray())
	)
	{
	    throw new \Exception(
		    "Frame Gauge option not valid. Maximum frame gauge already standard with model '".
		    self::$_Mapper->getModelName()."'. Change model or remove frame gauge."
		    );
	}
    }
    
    static private function _validateLegHeight()
    {
	$leg_height		= self::$_Mapper->getLegHeight();
	$model_code		= self::$_Mapper->getModel();
	$allowed_leg_heights	= self::$_Data->allowedLegHeightsArray();
	
	if(
	    !key_exists($model_code, $allowed_leg_heights) || 
	    !in_array($leg_height, $allowed_leg_heights[$model_code])
	)
	    throw new \Exception(
		"Leg Height is not allowed for ".self::$_Mapper->getModelName().
		". Change leg height or model."
		);
    }
    
    static private function _validateWalls()
    {
	$dooors_count_array = self::$_Mapper->getDoorsCountForSidesArray();
	
	foreach(self::$_Data->getSidesArray() as $side_initial => $side)
	{
	    if($dooors_count_array[$side_initial] > 0 && !self::$_Mapper->isWallClosed($side))
		throw new \Exception(
			ucfirst($side)." wall has a door/doors but is not a closed wall. Remove door/doors".
			" or close the wall"
		    );
	}
    }
}