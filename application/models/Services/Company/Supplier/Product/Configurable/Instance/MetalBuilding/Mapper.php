<?php
namespace Services\Company\Supplier\Product\Configurable\Instance\MetalBuilding;

class Mapper extends \Services\Company\Supplier\Product\Configurable\Instance\Mapper\MapperAbstract
{    
    /**
     * @var Mapper\Data 
     */
    protected $_Data;
    /**
     * @return false|string
     */
    
    public function getModel()
    {
	$ModelValue = $this->_Instance->getFirstValueFromIndexes("metal_model", "name");
	
	if($ModelValue !== false)return $ModelValue->getCode();
	
	return false;
    }
    
    /**
     * @return false|string
     */
    public function getModelName()
    {
	$ModelValue = $this->_Instance->getFirstValueFromIndexes("metal_model", "name");
	
	if($ModelValue !== false)return $ModelValue->getName();
	
	return false;
    }
    
    /**
     * @return false|string
     */
    public function getLegHeight()
    {
	$ModelValue = $this->_Instance->getFirstValueFromIndexes("leg_height", "height");
	
	if($ModelValue !== false)return $ModelValue->getCode();
	
	return false;
    }
    
    /**
     * @return false|string
     */
    public function getFrameGauge()
    {
	$ModelValue = $this->_Instance->getFirstValueFromIndexes("frame_gauge", "gauge");
	
	if($ModelValue !== false)return $ModelValue->getCode();
	
	return false;
    }
    
    /**
     * @return false|string
     */
    public function getFrameGaugeName()
    {
	$ModelValue = $this->_Instance->getFirstValueFromIndexes("frame_gauge", "gauge");
	
	if($ModelValue !== false)return $ModelValue->getName();
	
	return false;
    }
    
    /**
     * @return string|false
     */
    public function getFrameWidth()
    {
	$WidthValue = $this->_Instance->getFirstValueFromIndexes("width", "width");
	
	if($WidthValue !== false)return $WidthValue->getCode();
	
	return false;
    }
    
    /**
     * @return string|false
     */
    public function getFrameLength()
    {
	$LengthValue = $this->_Instance->getFirstValueFromIndexes("length", "length");
	
	if($LengthValue !== false)return $LengthValue->getCode();
	
	return false;
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
     * @return \Doctrine\Common\Collections\ArrayCollection
     */
    public function getDoorOptions()
    {
	return $this->_Instance->getOptionsFromOptionIndex("door");
    }
    
    /**
     * @return array
     */
    public function getDoorsCountForSidesArray()
    {
	$widths_array	= array("L" => 0, "R" => 0, "F" => 0, "B" => 0);
	
	/* @var $DoorOption \Entities\Company\Supplier\Product\Configurable\Instance\Option */
	foreach($this->getDoorOptions() as $DoorOption)
	{
	    $widths_array[$DoorOption->getValueFromParameterIndex("location")->getCode()]++;
	}
	
	return $widths_array;
    }
    
    /**
     * @param string $side_initial
     * @return integer
     */
    public function getDoorsCountForSide($side_initial)
    {
	$sides_count_array = $this->getDoorsCountForSidesArray();
	
	return $sides_count_array[$side_initial];
    }

    /**
     * @return array
     */
    public function getDoorWindowTotalWidthsArray()
    {
	$widths_array		= array("L" => 0, "R" => 0, "F" => 0, "B" => 0);

	/* @var $DoorOption \Entities\Company\Supplier\Product\Configurable\Instance\Option */
	foreach($this->getDoorOptions() as $DoorOption)
	{
	    $widths_array[$this->getDoorLocation($DoorOption)] 
		    += (int) $this->getDoorWidth($DoorOption);
	}
	
	/* @var $WindowOption \Entities\Company\Supplier\Product\Configurable\Instance\Option */
	foreach($this->getWindowOptions() as $WindowOption)
	{
	    $widths_array[$this->getWindowLocation($WindowOption)] 
		    += (int) $this->getWindowWidth($WindowOption);
	}
	
	return $widths_array;
    }
    
    /**
     * @return string|false
     */
    public function getDoorType(\Entities\Company\Supplier\Product\Configurable\Instance\Option $DoorOption)
    {
	$TypeValue = $DoorOption->getValueFromParameterIndex("type");
	
	if($TypeValue !== false)return $TypeValue->getCode();
	
	return false;
    }
    
    /**
     * @return string|false
     */
    public function getDoorTypeName(\Entities\Company\Supplier\Product\Configurable\Instance\Option $DoorOption)
    {
	$TypeValue = $DoorOption->getValueFromParameterIndex("type");
	
	if($TypeValue !== false)return $TypeValue->getName();
	
	return false;
    }
    
    /**
     * @return string|false
     */
    public function getDoorLocation(\Entities\Company\Supplier\Product\Configurable\Instance\Option $DoorOption)
    {
	$LocationValue = $DoorOption->getValueFromParameterIndex("location");
	
	if($LocationValue !== false)return $LocationValue->getCode();
	
	return false;
    }    
    
    /**
     * @return string|false
     */
    public function getDoorHeight(\Entities\Company\Supplier\Product\Configurable\Instance\Option $DoorOption)
    {
	$HeightValue = $DoorOption->getValueFromParameterIndex("height");
	
	if($HeightValue !== false)return $HeightValue->getCode();
	
	return false;
    }
    
    /**
     * @return string|false
     */
    public function getDoorWidth(\Entities\Company\Supplier\Product\Configurable\Instance\Option $DoorOption)
    {
	$WidthValue = $DoorOption->getValueFromParameterIndex("width");
	
	if($WidthValue !== false)return $WidthValue->getCode();
	
	return false;
    }
    
    /**
     * @return string
     * @throws \Exception
     */
    public function getDoorSize(\Entities\Company\Supplier\Product\Configurable\Instance\Option $DoorOption)
    {
	$width  = (int) $this->getDoorWidth($DoorOption);
	$height = (int) $this->getDoorHeight($DoorOption);
	
	if($width === false || $height === false)
	    throw new \Exception("No width or length selected for door.");
	
	return $width."X".$height;
    }
    
    /**
     * @return integer
     */
    public function getTallestDoorHeight()
    {
	$tallest_door	= 0;

	/* @var $DoorOption \Entities\Company\Supplier\Product\Configurable\Instance\Option */
	foreach($this->getDoorOptions() as $DoorOption)
	{
	    $door_height = (int) $this->getDoorHeight($DoorOption);
	    
	    if($door_height > $tallest_door)$tallest_door = $door_height;
	}
	
	return $tallest_door;
    }
    
    /**
     * @return \Doctrine\Common\Collections\ArrayCollection
     */
    public function getWindowOptions()
    {
	return $this->_Instance->getOptionsFromOptionIndex("window");
    }
    
    /**
     * @return string|false
     */
    public function getWindowType(\Entities\Company\Supplier\Product\Configurable\Instance\Option $WindowOption)
    {
	$TypeValue = $WindowOption->getValueFromParameterIndex("type");
	
	if($TypeValue !== false)return $TypeValue->getCode();
	
	return false;
    }
    
    /**
     * @return string|false
     */
    public function getWindowTypeName(\Entities\Company\Supplier\Product\Configurable\Instance\Option $WindowOption)
    {
	$TypeValue = $WindowOption->getValueFromParameterIndex("type");
	
	if($TypeValue !== false)return $TypeValue->getName();
	
	return false;
    }
    
    /**
     * @return string|false
     */
    public function getWindowLocation(\Entities\Company\Supplier\Product\Configurable\Instance\Option $WindowOption)
    {
	$LocationValue = $WindowOption->getValueFromParameterIndex("location");
	
	if($LocationValue !== false)return $LocationValue->getCode();
	
	return false;
    }    
    
    /**
     * @return string|false
     */
    public function getWindowHeight(\Entities\Company\Supplier\Product\Configurable\Instance\Option $WindowOption)
    {
	$HeightValue = $WindowOption->getValueFromParameterIndex("height");
	
	if($HeightValue !== false)return $HeightValue->getCode();
	
	return false;
    }
    
    /**
     * @return string|false
     */
    public function getWindowWidth(\Entities\Company\Supplier\Product\Configurable\Instance\Option $WindowOption)
    {
	$WidthValue = $WindowOption->getValueFromParameterIndex("width");
	
	if($WidthValue !== false)return $WidthValue->getCode();
	
	return false;
    }
    
    /**
     * @return string
     * @throws \Exception
     */
    public function getWindowSize(\Entities\Company\Supplier\Product\Configurable\Instance\Option $WindowOption)
    {
	$width  = (int) $this->getWindowWidth($WindowOption);
	$height = (int) $this->getWindowHeight($WindowOption);
	
	if($width === false || $height === false)
	    throw new \Exception("No width or length selected for window.");
	
	return $width."X".$height;
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
     * @return false|string
     */
    public function getWallCoveredType($side)
    {
	$CoveredValue = $this->_Instance->getFirstValueFromIndexes("covered_".$side, "type");
	
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
    public function getWallCoveredTypeName($side)
    {
	$CoveredValue = $this->_Instance->getFirstValueFromIndexes("covered_".$side, "type");
	
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
    public function getWallCoveredHeight($side)
    {
	$CoveredValue = $this->_Instance->getFirstValueFromIndexes("covered_".$side, "height");
	
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
    public function getWallCoveredHeightName($side)
    {
	$CoveredValue = $this->_Instance->getFirstValueFromIndexes("covered_".$side, "height");
	
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
    public function getWallOrientationIndex($side)
    {
	$OrientationValue = $this->_Instance->getFirstValueFromIndexes("orientation_".$side, "orientation");
	
	if($OrientationValue !== false)
	{
	    return $OrientationValue->getIndex();
	}
	
	return false;
    }
    
    /**
     * @return false|string
     */
    public function getAnchorsHasAnchors()
    {
	$HasAnchorsValue = $this->_Instance->getFirstValueFromIndexes("anchors", "has_anchors");
	
	if($HasAnchorsValue !== false)
	{
	    return $HasAnchorsValue->getCode();
	}
	
	return false;
    }
    
    /**
     * @return false|string
     */
    public function getAnchorsType()
    {
	$TypeValue = $this->_Instance->getFirstValueFromIndexes("anchors", "type");
	
	if($TypeValue !== false)
	{
	    return $TypeValue->getCode();
	}
	
	return false;
    }
    
    /**
     * @return false|string
     */
    public function getAnchorsQuantity()
    {
	$QuantityValue = $this->_Instance->getFirstValueFromIndexes("anchors", "quantity");
	
	if($QuantityValue !== false)
	{
	    return $QuantityValue->getCode();
	}
	
	return false;
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
	$CertifiedValue = $this->_Instance->getFirstValueFromIndexes("certified", "certified");
	
	if($CertifiedValue !== false)
	{
	    return $CertifiedValue->getCode();
	}
	
	return false;
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
}