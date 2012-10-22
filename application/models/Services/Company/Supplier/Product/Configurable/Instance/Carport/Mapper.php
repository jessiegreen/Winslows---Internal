<?php
namespace Services\Company\Supplier\Product\Configurable\Instance\Carport;

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
}