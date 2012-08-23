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
     * @return string
     * @throws \Exception
     */
    static public function getFrameSize()
    {
	$WidthValue  = self::$_Instance->getFirstValueFromIndexes("width", "width");
	$LengthValue = self::$_Instance->getFirstValueFromIndexes("length", "length");
	
	if($LengthValue === false || $WidthValue === false)
	    throw new \Exception("No width or length selected.");
	
	return $WidthValue->getCode()."X".$LengthValue->getCode();
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
	    $widths_array[$DoorOption->getValueFromParameterIndex("location")] 
		    += (int) $DoorOption->getValueFromParameterIndex("width");
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
}