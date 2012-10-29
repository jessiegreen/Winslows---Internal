<?php
namespace Services\Company\Supplier\Product\Configurable\Instance\MetalBuildingAbstract;
//test
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
	if(in_array($this->getWallCoveredType($side), array("PT", "PB")))return true;
	
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
    
    public function hasAugerAnchors()
    {
	return (int) $this->getAugerAnchorsCount() > 0 ? true : false;
    }
}