<?php
namespace Services\Company\Supplier\Product\Configurable\Instance\MetalBuildingAbstract;

class Mapper extends \Services\Company\Supplier\Product\Configurable\Instance\Mapper\MapperAbstract
{
    /**
     * @var Mapper\Data 
     */
    protected $_Data;
    
    /**
     * @return false|\Entities\Company\Supplier\Product\Configurable\Option\Parameter\Value
     */
    protected function _getRoofStyleValue()
    {
	return $this->_Instance->getFirstValueFromIndexes("metal_roof_style", "style");
    }
    
    /**
     * @return false|\Entities\Company\Supplier\Product\Configurable\Option\Parameter\Value
     */
    protected function _getLegHeightValue()
    {
	return $this->_Instance->getFirstValueFromIndexes("leg_height", "height");
    }
    
    /**
     * @return false|\Entities\Company\Supplier\Product\Configurable\Option\Parameter\Value
     */
    protected function _getFrameGaugeValue()
    {
	return $this->_Instance->getFirstValueFromIndexes("frame_gauge", "gauge");
    }
    
    /**
     * @return false|\Entities\Company\Supplier\Product\Configurable\Option\Parameter\Value
     */
    protected function _getFrameWidthValue()
    {
	return $this->_Instance->getFirstValueFromIndexes("metal_frame_width", "width");
    }
    
    /**
     * @return false|\Entities\Company\Supplier\Product\Configurable\Option\Parameter\Value
     */
    protected function _getFrameLengthValue()
    {
	return $this->_Instance->getFirstValueFromIndexes("metal_frame_length", "length");
    }
    
    /**
     * @return false|\Entities\Company\Supplier\Product\Configurable\Option\Parameter\Value
     */
    protected function _getWindSnowLoadValue()
    {
	return $this->_Instance->getFirstValueFromIndexes("wind_snow_load_type", "type");
    }
    
    /**
     * @param string $side left, right, front, back
     * @return false|\Entities\Company\Supplier\Product\Configurable\Option\Parameter\Value
     */
    protected function _getWallCoveredTypeValue($side)
    {
	return $this->_Instance->getFirstValueFromIndexes("covered_".$side, "type");
    }
    
    /**
     * @param string $side left, right, front, back
     * @return false|\Entities\Company\Supplier\Product\Configurable\Option\Parameter\Value
     */
    protected function _getWallCoveredHeightValue($side)
    {
	return $this->_Instance->getFirstValueFromIndexes("covered_".$side, "height");
    }
    
    /**
     * @param string $side left, right
     * @return false|\Entities\Company\Supplier\Product\Configurable\Option\Parameter\Value
     */
    protected function _getWallCoveredDepthValue($side)
    {
	return $this->_Instance->getFirstValueFromIndexes("covered_".$side, "depth");
    }
    
    /**
     * @param string $side left, right, front, back
     * @return false|\Entities\Company\Supplier\Product\Configurable\Option\Parameter\Value
     */
    protected function _getWallCoveredOrientationValue($side)
    {
	return $this->_Instance->getFirstValueFromIndexes("covered_".$side, "metal_orientation");
    }
    
    /**
     * @param string $side left, right, front, back
     * @return false|\Entities\Company\Supplier\Product\Configurable\Option\Parameter\Value
     */
    protected function _getWallCoveredJTrimValue($side)
    {
	return $this->_Instance->getFirstValueFromIndexes("covered_".$side, "j_trimmed");
    }
    
    /**
     * @return false|\Entities\Company\Supplier\Product\Configurable\Option\Parameter\Value
     */
    protected function _getCertifiedValue()
    {
	return $this->_Instance->getFirstValueFromIndexes("certified", "certified");
    }
    
    /**
     * @return false|\Entities\Company\Supplier\Product\Configurable\Option\Parameter\Value
     */
    protected function _getAugerAnchorsValue()
    {
	return $this->_Instance->getFirstValueFromIndexes("auger_anchors", "quantity");
    }
    
    /**
     * @return false|\Entities\Company\Supplier\Product\Configurable\Option\Parameter\Value
     */
    protected function _getExtraKneeBracesHasValue()
    {
	return $this->_Instance->getFirstValueFromIndexes("knee_braces", "has_extra");
    }
    
    /**
     * @return false|\Entities\Company\Supplier\Product\Configurable\Option\Parameter\Value
     */
    protected function _getExtraKneeBracesSizeValue()
    {
	return $this->_Instance->getFirstValueFromIndexes("knee_braces", "size");
    }
    
    /**
     * @return false|\Entities\Company\Supplier\Product\Configurable\Option\Parameter\Value
     */
    protected function _getExtraStormBracesHasValue()
    {
	return $this->_Instance->getFirstValueFromIndexes("storm_braces", "has_extra_storm_braces");
    }
    
    /**
     * @return false|\Entities\Company\Supplier\Product\Configurable\Option\Parameter\Value
     */
    protected function _getExtraStormBracesSizeValue()
    {
	return $this->_Instance->getFirstValueFromIndexes("storm_braces", "size");
    }
    
    /**
     * @return false|\Entities\Company\Supplier\Product\Configurable\Option\Parameter\Value
     */
    protected function _getDoorRollUpSideValue()
    {
	return $this->_Instance->getFirstValueFromIndexes("door_rollup", "side");
    }
    
    /**
     * @return false|\Entities\Company\Supplier\Product\Configurable\Option\Parameter\Value
     */
    protected function _getDoorRollUpSizeValue()
    {
	return $this->_Instance->getFirstValueFromIndexes("door_rollup", "size");
    }
    
    /**
     * @return false|string
     */
    public function getRoofStyle()
    {
	$Value = $this->_getRoofStyleValue();
	
	return $this->_returnCodeOrFalse($Value);
    }
    
    /**
     * @return false|string
     */
    public function getRoofStyleName()
    {
	$Value = $this->_getRoofStyleValue();
	
	return $this->_returnNameOrFalse($Value);
    }
    
    /**
     * @return false|string
     */
    public function getLegHeight()
    {
	$Value = $this->_getLegHeightValue();
	
	return $this->_returnCodeOrFalse($Value);
    }
    
    /**
     * @return false|string
     */
    public function getFrameGauge()
    {
	$Value = $this->_getFrameGaugeValue();
	
	return $this->_returnCodeOrFalse($Value);
    }
    
    /**
     * @return false|string
     */
    public function getFrameGaugeName()
    {
	$Value = $this->_getFrameGaugeValue();
	
	return $this->_returnNameOrFalse($Value);
    }
    
    public function isFrameGauge12()
    {
	return $this->getFrameGauge() == "12" ? true : false;
    }
    
    /**
     * @return string|false
     */
    public function getFrameWidth()
    {
	$Value = $this->_getFrameWidthValue();
	
	return $this->_returnCodeOrFalse($Value);
    }
    
    public function getFrameWidthInInches()
    {
	return ((int) $this->getFrameWidth() * 12);
    }
    
    /**
     * @return string|false
     */
    public function getFrameLength()
    {
	$Value = $this->_getFrameLengthValue();
	
	return $this->_returnCodeOrFalse($Value);
    }
    
    /**
     * @return string
     * @throws \Exception
     */
    public function getFrameSize()
    {
	$width  = $this->getFrameWidth();
	$length = $this->getFrameLength();
	
	if($width === false || $length === false)
	    throw new \Exception("No width or length selected.");
	
	return $width."X".$length;
    }
    
    /**
     * @return string|false
     */
    public function getWindSnowLoad()
    {
	$Value = $this->_getWindSnowLoadValue();
	
	return $this->_returnCodeOrFalse($Value);
    }
    
    /**
     * @return string|false
     */
    public function getWindSnowLoadName()
    {
	$Value = $this->_getWindSnowLoadValue();
	
	return $this->_returnNameOrFalse($Value);
    }
    
    /**
     * @return boolean
     */
    public function isWindSnowLoadCertified()
    {
	return in_array($this->getWindSnowLoad(), array("2", "4")) ? true : false;
    }
    
    /**
     * @return boolean
     */
    public function isWindSnowLoadHighWindSnow()
    {
	return $this->getWindSnowLoad() == "4" ? true : false;
    }
    
    /**
     * @return boolean
     */
    public function isWindSnowLoadStandard()
    {
	return $this->getWindSnowLoad() == "1" ? true : false;
    }
    
    /**
     * @return boolean
     */
    public function isWindSnowLoadWindSnow()
    {
	return $this->getWindSnowLoad() == "3" ? true : false;
    }
    
    /**
     * @return string
     */
    public function getRoofStyleWindSnowLoadKey()
    {	
	return $this->getRoofStyle()."_".$this->getWindSnowLoad();
    }
    
    /**
     * @return array
     */
    public function getSidesArray()
    {
	return $this->_Data->getSidesArray();
    }
    
    /**
     * @return array
     */
    public function getSidesLocationsArray()
    {
	return $this->_Data->getSidesLocationsArray();
    }
    
    /**
     * @param string $side
     * @return string
     */
    public function getSideLocation($side)
    {
	$locations_array = $this->getSidesLocationsArray();
	
	return $locations_array[$side];
    }
    
    /**
     * @param string $side
     * @return bool
     */
    public function isSideLocationASide($side)
    {
	return $this->getSideLocation($side) == "side" ? true : false;
    }
    
    /**
     * @param string $side
     * @return bool
     */
    public function isSideLocationAnEnd($side)
    {
	return $this->getSideLocation($side) == "end" ? true : false;
    }
    
    /**
     * @param string $side
     * @return boolean
     */
    public function isWallClosed($side)
    {
	if($this->getWallCoveredType($side) == "CL")return true;
	
	return false;
    }
    
    /**
     * @param string $side
     * @return boolean
     */
    public function isWallPartiallyCovered($side)
    {
	if(in_array($this->getWallCoveredType($side), array("PT", "PB", "PS")))return true;
	
	return false;
    }
    
    /**
     * @param string $end front or back
     * @return boolean
     */
    public function doesWallHaveGableEnd($end)
    {
	if($this->getWallCoveredType($end) == "GB")return true;
	
	return false;
    }
    
    /**
     * @param string $side
     * @return false|string
     */
    public function getWallCoveredType($side)
    {
	$Value = $this->_getWallCoveredTypeValue($side);
	
	return $this->_returnCodeOrFalse($Value);
    }
    
    /**
     * @param string $side
     * @return false|string
     */
    public function getWallCoveredTypeName($side)
    {
	$Value = $this->_getWallCoveredTypeValue($side);
	
	return $this->_returnNameOrFalse($Value);
    }
    
    /**
     * @param string $side
     * @return false|string
     */
    public function getWallCoveredHeight($side)
    {
	$Value = $this->_getWallCoveredHeightValue($side);
	
	return $this->_returnCodeOrFalse($Value);
    }
    
    /**
     * @param string $side
     * @return false|string
     */
    public function getWallCoveredHeightName($side)
    {
	$Value = $this->_getWallCoveredHeightValue($side);
	
	return $this->_returnNameOrFalse($Value);
    }
    
    /**
     * @param string $side
     * @return false|string
     */
    public function getWallCoveredDepth($side)
    {
	$Value = $this->_getWallCoveredDepthValue($side);
	
	return $this->_returnCodeOrFalse($Value);
    }
    
    /**
     * @param string $side
     * @return false|string
     */
    public function getWallCoveredOrientation($side)
    {
	$Value = $this->_getWallCoveredOrientationValue($side);
	
	return $this->_returnCodeOrFalse($Value);
    }
    
    /**
     * @param string $side
     * @return false|string
     */
    public function getWallCoveredOrientationName($side)
    {
	$Value = $this->_getWallCoveredOrientationValue($side);
	
	return $this->_returnNameOrFalse($Value);
    }
    
    /**
     * @param string $side
     * @return false|string
     */
    public function getWallCoveredOrientationIndex($side)
    {
	$Value = $this->_getWallCoveredOrientationValue($side);
	
	return $this->_returnIndexOrFalse($Value);
    }
    
    /**
     * @param string $side
     * @return boolean
     */
    public function isWallCoveredOrientationVertical($side)
    {
	if($this->getWallCoveredOrientationIndex($side) == "vertical")return true;
	
	return false;
    }
    
    /**
     * @param string $side
     * @return false|string
     */
    public function getWallCoveredJTrim($side)
    {
	$Value = $this->_getWallCoveredJTrimValue($side);
	
	return $this->_returnCodeOrFalse($Value);
    }
    
    /**
     * @param string $side
     * @return boolean
     */
    public function hasWallCoveredJTrim($side)
    {
	return $this->getWallCoveredJTrim($side) == "Y" ? true : false;
    }
    
    /**
     * @return boolean
     */
    public function isCertified()
    {
	if($this->getCertified() === "Y")
	    return true;
	
	return false;
    }
    
    /**
     * @return false|string
     */
    public function getCertified()
    {
	$Value = $this->_getCertifiedValue();
	
	return $this->_returnCodeOrFalse($Value);
    }
    
    /**
     * @return false|string
     */
    public function getAugerAnchorsCount()
    {
	$Value = $this->_getAugerAnchorsValue();
	
	return $this->_returnCodeOrFalse($Value);
    }
    
    /**
     * @return bool
     */
    public function hasAugerAnchors()
    {
	return (int) $this->getAugerAnchorsCount() > 0 ? true : false;
    }
    
    /**
     * @return false|string
     */
    public function getExtraKneeBracesHas()
    {
	$Value = $this->_getExtraKneeBracesHasValue();
	
	return $this->_returnCodeOrFalse($Value);
    }
    
    /**
     * @return bool
     */
    public function hasExtraKneeBraces()
    {
	return $this->getExtraKneeBracesHas() == "Y" ? true : false;
    }
    
    /**
     * @return false|string
     */
    public function getExtraKneeBracesSize()
    {
	$Value = $this->_getExtraKneeBracesSizeValue();
	
	return $this->_returnCodeOrFalse($Value);
    }
    
    /**
     * @return false|string
     */
    public function getExtraStormBracesHas()
    {
	$Value = $this->_getExtraStormBracesHasValue();
	
	return $this->_returnCodeOrFalse($Value);
    }
    
    /**
     * @return bool
     */
    public function hasExtraStormBraces()
    {
	return $this->getExtraStormBracesHas() == "Y" ? true : false;
    }
    
    /**
     * @return false|string
     */
    public function getExtraStormBracesSize()
    {
	$Value = $this->_getExtraStormBracesSizeValue();
	
	return $this->_returnCodeOrFalse($Value);
    }
    
    /**
     * @param \Entities\Company\Supplier\Product\Configurable\Instance\Option $DoorOption
     * @return false|string
     */
    public function getDoorRollUpSize(\Entities\Company\Supplier\Product\Configurable\Instance\Option $DoorOption)
    {
	$Value = $DoorOption->getValueFromParameterIndex("size");
	
	return $this->_returnCodeOrFalse($Value);
    }
    
    /**
     * @param \Entities\Company\Supplier\Product\Configurable\Instance\Option $DoorOption
     * @return false|string
     */
    public function getDoorRollUpSizeIndex(\Entities\Company\Supplier\Product\Configurable\Instance\Option $DoorOption)
    {
	$Value = $DoorOption->getValueFromParameterIndex("size");
	
	return $this->_returnIndexOrFalse($Value);
    }
    
    /**
     * @param \Entities\Company\Supplier\Product\Configurable\Instance\Option $DoorOption
     * @return false|string
     */
    public function getDoorRollUpSizeName(\Entities\Company\Supplier\Product\Configurable\Instance\Option $DoorOption)
    {
	$Value = $DoorOption->getValueFromParameterIndex("size");
	
	return $this->_returnNameOrFalse($Value);
    }
    
    /**
     * @param \Entities\Company\Supplier\Product\Configurable\Instance\Option $DoorOption
     * @return false|string
     */
    public function getDoorRollUpSide(\Entities\Company\Supplier\Product\Configurable\Instance\Option $DoorOption)
    {
	$Value = $DoorOption->getValueFromParameterIndex("side");
	
	return $this->_returnCodeOrFalse($Value);
    }
    
    /**
     * @param \Entities\Company\Supplier\Product\Configurable\Instance\Option $DoorOption
     * @return false|string
     */
    public function getDoorRollUpSideIndex(\Entities\Company\Supplier\Product\Configurable\Instance\Option $DoorOption)
    {
	$Value = $DoorOption->getValueFromParameterIndex("side");
	
	return $this->_returnIndexOrFalse($Value);
    }
    
    /**
     * @param \Entities\Company\Supplier\Product\Configurable\Instance\Option $DoorOption
     * @return string
     */
    public function getDoorRollUpWidth(\Entities\Company\Supplier\Product\Configurable\Instance\Option $DoorOption)
    {
	return $this->_getWidthFromSizeString($this->getDoorRollUpSizeIndex($DoorOption));
    }
    
    /**
     * @return \Doctrine\Common\Collections\ArrayCollection
     */
    public function getDoorRollups()
    {
	return $this->_Instance->getOptionsFromOptionIndex("door_rollup");
    }
    
    /**
     * @param string $side
     * @return int
     */
    public function getDoorRollUpsCountForSide($side)
    {
	$Mapper = $this;
	
	return (int) $this->getDoorRollups()->filter(
		    function ($DoorOption) use ($side, $Mapper)
		    {
			return $Mapper->getDoorRollUpSideIndex($DoorOption) == $side ? true : false;
		    }
		)->count();
    }
    
    /**
     * @param string $side
     * @return int
     */
    public function getDoorsCountForSide($side)
    {
	$count = 0;
	
	$count += $this->getDoorRollUpsCountForSide($side);
	
	return $count;
    }
    
    /**
     * @param string $side
     * @return int
     */
    public function getWindowsCountForSide($side)
    {
	$count = 0;
	
	return $count;
    }
    
    /**
     * @param string $side
     * @return int
     */
    public function getDoorAndWindowCountForSide($side)
    {
	$count = 0;
	
	$count += $this->getDoorsCountForSide($side);
	$count += $this->getWindowsCountForSide($side);
	
	return $count;
    }
    
    /**
     * @param string $side
     * @return int
     */
    public function getDoorRollUpTotalWidthsForSideInInches($side)
    {
	$width = 0;
	
	foreach($this->getDoorRollups() as $DoorOption)
	{
	    if($this->getDoorRollUpSideIndex($DoorOption) == $side)
		$width += ((int) $this->getDoorRollUpWidth($DoorOption) * 12);
	}
	
	return $width;
    }
    
    /**
     * @param string $side
     * @return integer
     */
    public function getDoorWidthsTotalForSideInInches($side)
    {
	$width = 0;
	
	$width += $this->getDoorRollUpTotalWidthsForSideInInches($side);
	
	return $width;
    }
    
    /**
     * @param string $side
     * @return integer
     */
    public function getWindowWidthsTotalForSideInInches($side)
    {
	$width = 0;
	
	return $width;
    }
    
    /**
     * @param string $side
     * @return int
     */
    public function getDoorAndWindowWidthsTotalForSideInInches($side)
    {
	return ($this->getDoorWidthsTotalForSideInInches($side) + $this->getWindowWidthsTotalForSideInInches($side));
    }
    
    public function getDoorAndWindowWidthsTotalPlusSpaceBetweenForSideInInches($side)
    {
	$added_inches = (12 * $this->getDoorAndWindowCountForSide($side));
	
	return ($this->getDoorAndWindowWidthsTotalForSideInInches($side) + $added_inches);
    }
    
    /**
     * @param string $size
     * @return string
     */
    protected function _getWidthFromSizeString($size)
    {
	$size_array = explode("X", $size);
	
	return $size_array[0];
    }
}
