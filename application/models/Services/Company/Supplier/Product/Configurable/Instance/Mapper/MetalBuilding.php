<?php
namespace Services\Company\Supplier\Product\Configurable\Instance\Mapper;

class MetalBuilding extends \Services\Company\Supplier\Product\Configurable\Instance\Mapper
{
    /**
     * @var \Entities\Company\Supplier\Product\Configurable\Instance $_Instance 
     */
    static private $_Instance;
    
    public function __construct(\Entities\Company\Supplier\Product\Configurable\Instance $Instance)
    {
	self::$_Instance = $Instance;
    }
    
    /**
     * @return false|string
     */
    public static function getModel()
    {
	$ModelValue = self::$_Instance->getFirstValueFromIndexes("metal_model", "name");
	
	if($ModelValue !== false)return $ModelValue->getCode();
	
	return false;
    }
    
    /**
     * @return false|string
     */
    public static function getModelName()
    {
	$ModelValue = self::$_Instance->getFirstValueFromIndexes("metal_model", "name");
	
	if($ModelValue !== false)return $ModelValue->getName();
	
	return false;
    }
    
    /**
     * @return false|string
     */
    public static function getLegHeight()
    {
	$ModelValue = self::$_Instance->getFirstValueFromIndexes("leg_height", "height");
	
	if($ModelValue !== false)return $ModelValue->getCode();
	
	return false;
    }
    
    /**
     * @return false|string
     */
    public static function getFrameGauge()
    {
	$ModelValue = self::$_Instance->getFirstValueFromIndexes("frame_gauge", "gauge");
	
	if($ModelValue !== false)return $ModelValue->getCode();
	
	return false;
    }
    
    /**
     * @return string|false
     */
    static public function getFrameWidth()
    {
	$WidthValue = self::$_Instance->getFirstValueFromIndexes("width", "width");
	
	if($WidthValue !== false)return $WidthValue->getCode();
	
	return false;
    }
    
    /**
     * @return string|false
     */
    static public function getFrameLength()
    {
	$LengthValue = self::$_Instance->getFirstValueFromIndexes("length", "length");
	
	if($LengthValue !== false)return $LengthValue->getCode();
	
	return false;
    }
    
    /**
     * @return string
     * @throws \Exception
     */
    static public function getFrameSize()
    {
	$width  = self::getFrameWidth();
	$length = self::getFrameLength();
	
	if($width === false || $length === false)
	    throw new \Exception("No width or length selected.");
	
	return $width."X".$length;
    }
    
    /**
     * @return array
     */
    static public function getDoorsCountForSidesArray()
    {
	$DoorOptions	= self::$_Instance->getOptionsFromOptionIndex("door");
	$widths_array	= array("L" => 0, "R" => 0, "F" => 0, "B" => 0);
	
	/* @var $DoorOption \Entities\Company\Supplier\Product\Configurable\Instance\Option */
	foreach($DoorOptions as $DoorOption)
	{
	    $widths_array[$DoorOption->getValueFromParameterIndex("location")->getCode()]++;
	}
	
	return $widths_array;
    }
    
    /**
     * @param string $side_initial
     * @return integer
     */
    static public function getDoorsCountForSide($side_initial)
    {
	$sides_count_array = self::getDoorsCountForSidesArray();
	
	return $sides_count_array[$side_initial];
    }

    /**
     * @return array
     */
    static public function getDoorWindowTotalWidthsArray()
    {
	$DoorOptions		= self::$_Instance->getOptionsFromOptionIndex("door");
	$WindowOptions		= self::$_Instance->getOptionsFromOptionIndex("window");
	$widths_array		= array("L" => 0, "R" => 0, "F" => 0, "B" => 0);

	/* @var $DoorOption \Entities\Company\Supplier\Product\Configurable\Instance\Option */
	foreach($DoorOptions as $DoorOption)
	{
	    $widths_array[self::getDoorLocation($DoorOption)] 
		    += (int) self::getDoorWidth($DoorOption);
	}
	
	/* @var $WindowOption \Entities\Company\Supplier\Product\Configurable\Instance\Option */
	foreach($WindowOptions as $WindowOption)
	{
	    $widths_array[$WindowOption->getValueFromParameterIndex("location")] 
		    += (int) $WindowOption->getValueFromParameterIndex("width");
	}
	
	return $widths_array;
    }
    
    /**
     * @return string|false
     */
    static public function getDoorLocation(\Entities\Company\Supplier\Product\Configurable\Instance\Option $DoorOption)
    {
	$LocationValue = $DoorOption->getValueFromParameterIndex("location");
	
	if($LocationValue !== false)return $LocationValue->getCode();
	
	return false;
    }
    
    /**
     * @return string|false
     */
    static public function getDoorWidth(\Entities\Company\Supplier\Product\Configurable\Instance\Option $DoorOption)
    {
	$WidthValue = $DoorOption->getValueFromParameterIndex("width");
	
	if($WidthValue !== false)return $WidthValue->getCode();
	
	return false;
    }
    
    /**
     * @return integer
     */
    static public function getTallestDoorHeight()
    {	
	$DoorOptions	= self::$_Instance->getOptionsFromOptionIndex("door");
	$tallest_door	= 0;

	/* @var $DoorOption \Entities\Company\Supplier\Product\Configurable\Instance\Option */
	foreach($DoorOptions as $DoorOption)
	{
	    $door_height = (int) $DoorOption->getValueFromParameterIndex("height")->getCode();
	    
	    if($door_height > $tallest_door)$tallest_door = $door_height;
	}
	
	return $tallest_door;
    }
    
    /**
     * @param string $side
     * @return boolean
     */
    static public function isWallClosed($side)
    {
	if(self::getWallCoveredType($side) == "CL")return true;
	
	return false;
    }
    
    /**
     * @param string $side
     * @return false|string
     */
    static public function getWallCoveredType($side)
    {
	$CoveredValue = self::$_Instance->getFirstValueFromIndexes("covered_".$side, "type");
	
	if($CoveredValue !== false)
	{
	    return $CoveredValue->getCode();
	}
	
	return false;
    }
    
    /**
     * @param string $side
     * @return false|string
     */
    static public function getWallCoveredTypeName($side)
    {
	$CoveredValue = self::$_Instance->getFirstValueFromIndexes("covered_".$side, "type");
	
	if($CoveredValue !== false)
	{
	    return $CoveredValue->getName();
	}
	
	return false;
    }
    
    /**
     * @param string $side
     * @return false|string
     */
    static public function getWallCoveredHeight($side)
    {
	$CoveredValue = self::$_Instance->getFirstValueFromIndexes("covered_".$side, "height");
	
	if($CoveredValue !== false)
	{
	    return $CoveredValue->getCode();
	}
	
	return false;
    }
    
    /**
     * @param string $side
     * @return false|string
     */
    static public function getWallCoveredHeightName($side)
    {
	$CoveredValue = self::$_Instance->getFirstValueFromIndexes("covered_".$side, "height");
	
	if($CoveredValue !== false)
	{
	    return $CoveredValue->getName();
	}
	
	return false;
    }
    
    /**
     * @return false|string
     */
    static public function getAnchorsHasAnchors()
    {
	$HasAnchorsValue = self::$_Instance->getFirstValueFromIndexes("anchors", "has_anchors");
	
	if($HasAnchorsValue !== false)
	{
	    return $HasAnchorsValue->getCode();
	}
	
	return false;
    }
    
    /**
     * @return false|string
     */
    static public function getAnchorsType()
    {
	$TypeValue = self::$_Instance->getFirstValueFromIndexes("anchors", "type");
	
	if($TypeValue !== false)
	{
	    return $TypeValue->getCode();
	}
	
	return false;
    }
    
    /**
     * @return false|string
     */
    static public function getAnchorsQuantity()
    {
	$QuantityValue = self::$_Instance->getFirstValueFromIndexes("anchors", "quantity");
	
	if($QuantityValue !== false)
	{
	    return $QuantityValue->getCode();
	}
	
	return false;
    }
}