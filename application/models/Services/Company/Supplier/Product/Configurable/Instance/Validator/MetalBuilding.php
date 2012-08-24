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
	self::_validateDoors();
	self::_validateWallsCovered();
	self::_validateAnchors();
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
		$message = $Option->getOption()->getCategory()->getName()." &raquo; ".
			    $Parameter->getOption()->getName()." &raquo; ".$Parameter->getName()." is ";
		if($Option->getOption()->isRequired())$message .= "required.";
		else $message .= " is missing. Select it or remove the option";
		
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
	    throw new \Exception("Size '".$size. "' is not a valid size. Change Frame &raquo; Width/Length.");
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
		    "Frame &raquo; Frame Gauge option not valid. Maximum frame gauge already standard with model '".
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
		"Frame &raquo; Leg Height is not allowed for ".self::$_Mapper->getModelName().
		". Change leg height or model."
		);
	
	
	#--Check if leg height is sufficient for the chosen doors and windows
	if(((int) self::$_Mapper->getLegHeight()*12) < ((int) self::$_Mapper->getTallestDoorHeight()+10))
	    throw new \Exception(
		"Frame &raquo; Leg Height is insufficient to allow for the chosen door heights. ".
		"Increase leg height or remove/shorten doors that are too tall for the chosen leg height"
	    );
    }
    
    static private function _validateWalls()
    {
	$door_widths_array  = self::$_Mapper->getDoorWindowTotalWidthsArray();
	$wall_length	    = 0;
	
	foreach(self::$_Data->getSidesArray() as $side_initial => $side)
	{
	    #--Check if wall has doors
	    if($door_widths_array[$side_initial] > 0 && !self::$_Mapper->isWallClosed($side))
		throw new \Exception(
			ucfirst($side)." wall has a door/doors but is not a closed wall. Remove door/doors".
			" or change the Walls &raquo; Covered ".  ucfirst($side)." &raquo; Type to 'closed'"
		    );
	    #--Check if wall has too many doors for the wall
	    $wall_length = in_array($side, array("left", "right")) ? 
				((int) self::$_Mapper->getFrameLength()*12) : 
				((int) self::$_Mapper->getFrameWidth()*12);
	    
	    if((int) $door_widths_array[$side_initial] > $wall_length)
		throw new \Exception(
			ucfirst($side)." wall has too many doors or windows. Increase the ".
			"frame size or reduce the amount of doors/windows on the ".$side." side."
		    );
	}
    }
    
    static private function _validateDoors()
    {
	
    }
    
    static private function _validateWallsCovered()
    {
	foreach(self::$_Data->getSidesArray() as $side_initial => $side)
	{
	    switch(self::$_Mapper->getWallCoveredType($side))
	    {
		case "NO":
		case "CL":
		    if(self::$_Mapper->getWallCoveredHeight($side) !== false)
			throw new \Exception(
			    "Walls &raquo; Covered ".  ucfirst($side)." &raquo; Type is set to '".
			    self::$_Mapper->getWallCoveredTypeName($side)."' but Height is set. Set type ".
			    " to Partial Coverage or unset Height."
			);
		break;
		case "PT":
		case "PB":
		    if(self::$_Mapper->getWallCoveredHeight($side) === false)
			throw new \Exception(
			    "Walls &raquo; Covered ".  ucfirst($side)." &raquo; Type is set to '".
			    self::$_Mapper->getWallCoveredTypeName($side)."' but Height is not set. Set ".
			    " Height."
			);
	    }
	}
    }
    
    static private function _validateAnchors()
    {
	if(self::$_Mapper->getAnchorsHasAnchors() === "Y")
	{
	    if(self::$_Mapper->getAnchorsType() === false)
		throw new \Exception(
			    "Installation &raquo; Anchors &raquo; Has Anchors is set to ".
			    "'Yes' but Type is not set. Set Type."
			);
	    
	    if(self::$_Mapper->getAnchorsQuantity() === false)
		throw new \Exception(
			    "Installation &raquo; Anchors &raquo; Has Anchors is set to ".
			    "'Yes' but Quantity is not set. Set Quantity."
			);
	}
	else
	{
	    if(self::$_Mapper->getAnchorsType() !== false)
		throw new \Exception(
			    "Installation &raquo; Anchors &raquo; Has Anchors is set to ".
			    "'No' but Type is set. Unset Type or set Has Anchors to 'Yes'."
			);
	    
	    if(self::$_Mapper->getAnchorsQuantity() !== false)
		throw new \Exception(
			    "Installation &raquo; Anchors &raquo; Has Anchors is set to ".
			    "'No' but Quantity is set. Unset Quantity or set Has Anchors to 'Yes'."
			);
	}
    }
    
    static private function _validateRoof()
    {
	
    }
}