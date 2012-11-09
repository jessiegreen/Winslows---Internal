<?php
namespace Services\Company\Supplier\Product\Configurable\Instance\MetalBuildingAbstract;

abstract class Validator extends \Services\Company\Supplier\Product\Configurable\Instance\Validator\ValidatorAbstract
{
    /**
     *  @var \Services\Company\Supplier\Product\Configurable\Instance\MetalBuildingAbstract\Validator\Data $_Data 
     */
    protected $_Data;
    
    /**
     *  @var \Services\Company\Supplier\Product\Configurable\Instance\MetalBuildingAbstract\Mapper $_Mapper 
     */
    protected $_Mapper;
    
    /**
     * @param string $location
     */
    public function validate($location = null)
    {
	parent::validate($location);
    }
    
    /**
     * @param type $location
     * @throws \Exception
     */
    protected function _validateWindSnowLoad($location)
    {
	$valid	    = true;
	$WS_code    = $this->_Mapper->getWindSnowLoad();
	
	switch($WS_code)
	{
	    case "1":
		$array = $this->_Data->getRegularStates();
		
		if(!in_array($location, $array))$valid = false;
	    break;
	    case "2":
		$array = array_merge($array, $this->_Data->getRegularStates(), $this->_Data->getHighWindStates());
		
		if(!in_array($location, $array))$valid = false;
	    break;
	    case "3":
		$array = array_merge($array, $this->_Data->getRegularStates(), $this->_Data->getHighWindStates(), $this->_Data->getSnowWindStates());
		
		if(!in_array($location, $array))$valid = false;
	    break;
	    case "4":
		$array = array_merge($array, $this->_Data->getRegularStates(), $this->_Data->getHighWindStates(), $this->_Data->getSnowWindStates(), $this->_Data->getHighSnowWindStates());
		
		if(!in_array($location, $array))$valid = false;
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
    
    /**
     * @throws \Exception
     */
    protected function _validateWallsCovered()
    {
	foreach($this->_Mapper->getSidesArray() as $side)
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
		    if($this->_Mapper->getWallCoveredDepth($side) !== false)
			throw new \Exception(
			    "Walls &raquo; Covered ".  ucfirst($side)." &raquo; Type is set to '".
			    $this->_Mapper->getWallCoveredTypeName($side)."' but Depth is set. Set type ".
			    " to Partial Coverage or unset Depth."
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
		break;
		case "PS":
		    if($this->_Mapper->getWallCoveredDepth($side) === false)
			throw new \Exception(
			    "Walls &raquo; Covered ".  ucfirst($side)." &raquo; Type is set to '".
			    $this->_Mapper->getWallCoveredTypeName($side)."' but Depth is not set. Set ".
			    " Depth."
			);
	    }
	}
    }
    
    /**
     * @throws \Exception
     */
    protected function _validateFrameGauge()
    {
	$frame_gauge	= $this->_Mapper->getFrameGauge();
	$WS_code	= $this->_Mapper->getWindSnowLoad();

	if(
	    $WS_code == "4" &&
	    $frame_gauge !== false && 
	    strlen($frame_gauge) > 0
	)
	{
	    throw new \Exception(
		    "Frame &raquo; Frame Gauge option not valid. Maximum frame gauge already standard with High Wind Snow Load Frame ".
		    ". Change Wind Snow Load or remove frame gauge option."
		    );
	}
    }
    
    /**
     * @throws \Exception
     */
    protected function _validateCertified()
    {
	if(
	    $this->_Mapper->isCertified() &&
	    ($this->_Mapper->isWindSnowLoadCertified())
	)
	{
	    throw new \Exception(
		    "Frame &raquo; Certified already standard with ".
		    "chosen Frame Snow Load. Change Wind Snow Load or remove certified option."
		    );
	}
    }
    
    /**
     * @throws \Exception
     */
    protected function _validateLegHeight()
    {
	$leg_height		= $this->_Mapper->getLegHeight();
	$roof_style_code	= $this->_Mapper->getRoofStyle();
	$allowed_leg_heights	= $this->_Data->getAllowedLegHeights();
	
	if(
	    !key_exists($roof_style_code, $allowed_leg_heights) || 
	    !in_array($leg_height, $allowed_leg_heights[$roof_style_code])
	)
	    throw new \Exception(
		"Frame &raquo; Leg Height is not allowed for ".$this->_Mapper->getRoofStyleName().
		". Change leg height or roof style."
		);
    }
    
    /**
     * @throws \Exception
     */
    protected function _validateExtraKneeBraces()
    {
	if($this->_Mapper->hasExtraKneeBraces())
	{
	    if($this->_Mapper->isWindSnowLoadWindSnow() || $this->_Mapper->isWindSnowLoadHighWindSnow())
		throw new \Exception(
		    "Frame &raquo; Extra Knee Braces is included in the chosen snow load. Please remove extra knee braces option."
		    );
	    elseif(!$this->_Mapper->getExtraKneeBracesSize())
		throw new \Exception(
		    "Frame &raquo; Extra Knee Braces is set to yes. Please choose a size."
		    );
	}
	elseif(!$this->_Mapper->hasExtraKneeBraces() && $this->_Mapper->getExtraKneeBracesSize())
	    throw new \Exception(
		"Frame &raquo; Extra Knee Braces is set to no but a size has been chosen. Set to yes or unset size."
		);
    }
    
    /**
     * @throws \Exception
     */
    protected function _validateExtraStormBraces()
    {
	if($this->_Mapper->hasExtraStormBraces())
	{
	    if($this->_Mapper->isWindSnowLoadWindSnow() || $this->_Mapper->isWindSnowLoadHighWindSnow())
		throw new \Exception(
		    "Frame &raquo; Extra Storm Braces is included in the chosen snow load. Please remove extra storm braces option."
		    );
	    elseif($this->_Mapper->isCertified() || $this->_Mapper->isWindSnowLoadCertified())
		throw new \Exception(
		    "Frame &raquo; Extra Storm Braces is included with certified frame. Please remove extra storm braces option."
		    );
	    elseif(!$this->_Mapper->getExtraStormBracesSize())
		throw new \Exception(
		    "Frame &raquo; Extra Storm Braces is set to yes. Please choose a size."
		    );
	}
	elseif(!$this->_Mapper->hasExtraStormBraces() && $this->_Mapper->getExtraStormBracesSize())
	    throw new \Exception(
		"Frame &raquo; Extra Storm Braces is set to no but a size has been chosen. Set to yes or unset size."
		);
    }
    
    protected function _validateDoorHeightsForWalls()
    {
	#--Check if leg height is sufficient for the chosen doors and windows
	if($this->_Mapper->getLegHeightInInches() < $this->_Mapper->getDoorsTallestHeightPlusSpaceAboveInInches())
	    throw new \Exception(
		"Frame &raquo; Leg Height is insufficient to allow for the chosen door heights. ".
		"Increase leg height or remove/shorten doors that are too tall for the chosen leg height"
	    );
    }
}