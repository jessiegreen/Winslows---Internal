<?php
namespace Services\Company\Supplier\Product\Configurable\Instance\Validator;

class MetalBuilding extends \Services\Company\Supplier\Product\Configurable\Instance\Validator implements \Interfaces\Company\Supplier\Product\Configurable\Instance\Validator
{
    /**
     *  @var \Entities\Company\Supplier\Product\Configurable\Instance $_Instance 
     */
    static private $_Instance;
    static private $_Data;

    /**
     * @param \Entities\Company\Supplier\Product\Configurable\Instance $Instance
     */
    static public function validate(\Entities\Company\Supplier\Product\Configurable\Instance $Instance)
    {
	$data_class	    = "\Services\Company\Supplier\Product\Configurable\Instance\Validator\Data\\".self::_getCalledClassName();
	self::$_Instance    = $Instance;
	self::$_Data	    = new $data_class;
	
	self::_validateFrameSize();
	self::_validateFrameGauge();
    }
    
    static private function _validateFrameSize()
    {
	$_Data	    = self::$_Data;
	$ModelValue = self::$_Instance->getValueFromIndexes("metal_model", "name");
	$size	    = self::_getFrameSize();
	
	if(!key_exists($size, $_Data::allowedMetalModelSizes($ModelValue->getCode())))
	{
	    throw new \Exception("Size '".$size. "' is not a valid size for model '".$ModelValue->getName()."'");
	}
    }
    
    static private function _validateFrameGauge()
    {
	$FrameGaugeValue    = self::$_Instance->getValueFromIndexes("frame_gauge", "gauge");
	$ModelValue	    = self::$_Instance->getValueFromIndexes("metal_model", "name");
	$model_code	    = $ModelValue->getCode();
	
	if($FrameGaugeValue !== false)
	{
	    $frame_gauge = $FrameGaugeValue->getCode();
	    if(
		$frame_gauge !== false && 
		strlen($frame_gauge) > 0 && 
		in_array($model_code, array("RX", "BX", "VX"))
	    )
	    {
		throw new \Exception("Frame Gauge option not valid. Maximum frame gauge already standard with model '".$ModelValue->getName()."'.");
	    }
	}
    }
    
    static private function _getFrameSize()
    {
	$WidthValue  = self::$_Instance->getValueFromIndexes("width", "width");
	$LengthValue = self::$_Instance->getValueFromIndexes("length", "length");
	
	if($LengthValue === false || $WidthValue === false)
	    throw new \Exception("No width or length selected.");
	
	return $WidthValue->getCode()."X".$LengthValue->getCode();
    }
}