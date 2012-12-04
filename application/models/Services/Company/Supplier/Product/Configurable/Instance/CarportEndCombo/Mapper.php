<?php
namespace Services\Company\Supplier\Product\Configurable\Instance\CarportEndCombo;

class Mapper extends \Services\Company\Supplier\Product\Configurable\Instance\MetalBuildingAbstract\Mapper
{    
    /**
     * @var Mapper\Data 
     */
    protected $_Data;
    
    /**
     * Overwriting Parent Frame Widths For Carport Frame Widths
     * @return false|\Entities\Company\Supplier\Product\Configurable\Option\Parameter\Value
     */
    protected function _getFrameWidthValue()
    {
	return $this->_Instance->getFirstValueFromIndexes("carport_frame_width", "width");
    }
    
    /**
     * Overwriting Parent Frame Widths For Carport Frame Lengths
     * @return false|\Entities\Company\Supplier\Product\Configurable\Option\Parameter\Value
     */
    protected function _getFrameLengthValue()
    {
	return $this->_Instance->getFirstValueFromIndexes("carport_frame_length", "length");
    }
    
    /**
     * @return false|\Entities\Company\Supplier\Product\Configurable\Option\Parameter\Value
     */
    protected function _getEndComboDepthValue()
    {
	return $this->_Instance->getFirstValueFromIndexes("end_combo", "depth");
    }
    
    /**
     * @return false|\Entities\Company\Supplier\Product\Configurable\Option\Parameter\Value
     */
    protected function _getEndComboMetalOrientationValue()
    {
	return $this->_Instance->getFirstValueFromIndexes("end_combo", "metal_orientation");
    }
    
    /**
     * return false|string
     */
    public function getEndComboDepth()
    {
	$Value = $this->_getEndComboDepthValue();
	
	return $this->_returnCodeOrFalse($Value);
    }
    
    public function getEndComboDepthInInches()
    {
	return ((int) $this->getEndComboDepth() * 12);
    }
    
    /**
     * return false|string
     */
    public function getEndComboMetalOrientation()
    {
	$Value = $this->_getEndComboMetalOrientationValue();
	
	return $this->_returnCodeOrFalse($Value);
    }
    
    /**
     * @return bool
     */
    public function isEndComboMetalOrientationHorizontal()
    {
	return $this->getEndComboMetalOrientation() === "1" ? true : false;
    }
    
    /**
     * @return bool
     */
    public function isEndComboMetalOrientationVertical()
    {
	return $this->getEndComboMetalOrientation() === "2" ? true : false;
    }
    
    /**
     * @return int
     */
    public function getEndComboSquareFeet()
    {
	return ((int) $this->getFrameWidth() * (int) $this->getEndComboDepth());
    }
}