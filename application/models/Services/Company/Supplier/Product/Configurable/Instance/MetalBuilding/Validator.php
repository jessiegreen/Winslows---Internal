<?php
namespace Services\Company\Supplier\Product\Configurable\Instance\MetalBuilding;

class Validator extends \Services\Company\Supplier\Product\Configurable\Instance\Validator\ValidatorAbstract
{
    /**
     *  @var \Services\Company\Supplier\Product\Configurable\Instance\MetalBuilding\Validator\Data $_Data 
     */
    protected $_Data;
    
    /**
     *  @var \Services\Company\Supplier\Product\Configurable\Instance\MetalBuilding\Mapper $_Mapper 
     */
    protected $_Mapper;
    
    /**
     * @param string $location
     */
    public function validate($location = null)
    {	
	parent::validate();
	
	if($location)$this->_validateModel($location);
	
	$this->_validateFrameSize();
	$this->_validateFrameGauge();
	$this->_validateLegHeight();
	$this->_validateWalls();
	$this->_validateDoors();
	$this->_validateWallsCovered();
	$this->_validateAnchors();
    }
    
    protected function _validateModel($location)
    {
	$valid = true;
	
	switch($this->_Mapper->getModel())
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
		$this->_Mapper->getModelName()."  model is not available in your area.".
		" Please select a new model or location."
		);
    }
    
    protected function _validateFrameSize()
    {
	$_Data	    = $this->_Data;
	$size	    = $this->_Mapper->getFrameSize();
	
	if(!in_array($size, $_Data::getAllowedMetalModelSizesArray()))
	    throw new \Exception("Size '".$size. "' is not a valid size. Change Frame &raquo; Width/Length.");
    }
    
    protected function _validateFrameGauge()
    {
	$frame_gauge	= $this->_Mapper->getFrameGauge();
	$model_code	= $this->_Mapper->getModel();
	
	if(
	    $frame_gauge !== false && 
	    strlen($frame_gauge) > 0 && 
	    in_array($model_code, $this->_Data->getHighSnowAndWindModelsArray())
	)
	{
	    throw new \Exception(
		    "Frame &raquo; Frame Gauge option not valid. Maximum frame gauge already standard with model '".
		    $this->_Mapper->getModelName()."'. Change model or remove frame gauge."
		    );
	}
    }
    
    protected function _validateLegHeight()
    {
	$leg_height		= $this->_Mapper->getLegHeight();
	$model_code		= $this->_Mapper->getModel();
	$allowed_leg_heights	= $this->_Data->getAllowedLegHeightsArray();
	
	if(
	    !key_exists($model_code, $allowed_leg_heights) || 
	    !in_array($leg_height, $allowed_leg_heights[$model_code])
	)
	    throw new \Exception(
		"Frame &raquo; Leg Height is not allowed for ".$this->_Mapper->getModelName().
		". Change leg height or model."
		);
	
	
	#--Check if leg height is sufficient for the chosen doors and windows
	if(((int) $this->_Mapper->getLegHeight()*12) < ((int) $this->_Mapper->getTallestDoorHeight()+10))
	    throw new \Exception(
		"Frame &raquo; Leg Height is insufficient to allow for the chosen door heights. ".
		"Increase leg height or remove/shorten doors that are too tall for the chosen leg height"
	    );
    }
    
    protected function _validateWalls()
    {
	$door_widths_array  = $this->_Mapper->getDoorWindowTotalWidthsArray();
	$wall_length	    = 0;
	
	foreach($this->_Mapper->getSidesArray() as $side_initial => $side)
	{
	    #--Check if wall has doors
	    if($door_widths_array[$side_initial] > 0 && !$this->_Mapper->isWallClosed($side))
		throw new \Exception(
			ucfirst($side)." wall has doors or windows but is not a closed wall. Remove doors".
			" and windows".
			" or change the Walls &raquo; Covered ".  ucfirst($side)." &raquo; Type to 'closed'"
		    );
	    #--Check if wall has too many doors for the wall
	    $wall_length = in_array($side, array("left", "right")) ? 
				((int) $this->_Mapper->getFrameLength()*12) : 
				((int) $this->_Mapper->getFrameWidth()*12);
	    
	    if((int) $door_widths_array[$side_initial] > $wall_length)
		throw new \Exception(
			ucfirst($side)." wall has too many doors or windows. Increase the ".
			"frame size or reduce the amount of doors/windows on the ".$side." side."
		    );
	}
    }
    
    protected function _validateDoors()
    {
	
    }
    
    protected function _validateWallsCovered()
    {
	foreach($this->_Mapper->getSidesArray() as $side_initial => $side)
	{
	    switch($this->_Mapper->getWallCoveredType($side))
	    {
		case "NO":
		case "CL":
		    if($this->_Mapper->getWallCoveredHeight($side) !== false)
			throw new \Exception(
			    "Walls &raquo; Covered ".  ucfirst($side)." &raquo; Type is set to '".
			    $this->_Mapper->getWallCoveredTypeName($side)."' but Height is set. Set type ".
			    " to Partial Coverage or unset Height."
			);
		break;
		case "PT":
		case "PB":
		    if($this->_Mapper->getWallCoveredHeight($side) === false)
			throw new \Exception(
			    "Walls &raquo; Covered ".  ucfirst($side)." &raquo; Type is set to '".
			    $this->_Mapper->getWallCoveredTypeName($side)."' but Height is not set. Set ".
			    " Height."
			);
	    }
	}
    }
    
    protected function _validateAnchors()
    {
	if($this->_Mapper->getAnchorsHasAnchors() === "Y")
	{
	    if($this->_Mapper->getAnchorsType() === false)
		throw new \Exception(
			    "Installation &raquo; Anchors &raquo; Has Anchors is set to ".
			    "'Yes' but Type is not set. Set Type."
			);
	    
	    if($this->_Mapper->getAnchorsQuantity() === false)
		throw new \Exception(
			    "Installation &raquo; Anchors &raquo; Has Anchors is set to ".
			    "'Yes' but Quantity is not set. Set Quantity."
			);
	}
	else
	{
	    if($this->_Mapper->getAnchorsType() !== false)
		throw new \Exception(
			    "Installation &raquo; Anchors &raquo; Has Anchors is set to ".
			    "'No' but Type is set. Unset Type or set Has Anchors to 'Yes'."
			);
	    
	    if($this->_Mapper->getAnchorsQuantity() !== false)
		throw new \Exception(
			    "Installation &raquo; Anchors &raquo; Has Anchors is set to ".
			    "'No' but Quantity is set. Unset Quantity or set Has Anchors to 'Yes'."
			);
	}
    }
}