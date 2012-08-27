<?php

/**
 * Name:
 * Location:
 *
 * Description for class (if any)...
 *
 * @author     Jessie Green <jessie.winslows@gmail.com>
 * @copyright  2012 Winslows inc.
 */
namespace Services\Codebuilder;

class Pricing {
    /**
     * @var decimal $_price
     */
    private $_price = 0;
    
    /**
     * @var \Services\Codebuilder\Data $_data
     */
    private $_data;
    
    /**
     * @var array $_details
     */
    private $_details;
    
       /**
     *  @var \Entities\Company\Supplier\Product\Configurable\Instance $_Instance 
     */
    static private $_Instance;
    /**
     *  @var \Services\Company\Supplier\Product\Configurable\Instance\Validator\Data\MetalBuilding $_Data 
     */
    static private $_Data;
    /**
     *  @var \Services\Company\Supplier\Product\Configurable\Instance\Mapper\MetalBuilding $_Mapper 
     */
    static private $_Mapper;
    
    /**
     * @param \Entities\Company\Supplier\Product\Configurable\Instance $Instance
     */
    static public function price(\Entities\Company\Supplier\Product\Configurable\Instance $Instance)
    {
	$data_class	    = "\Services\Company\Supplier\Product\Configurable\Instance\Pricing\Data\\".self::_getCalledClassName();
	$mapper_class	    = "\Services\Company\Supplier\Product\Configurable\Instance\Mapper\\".self::_getCalledClassName();
	self::$_Instance    = $Instance;
	self::$_Data	    = new $data_class;
	self::$_Mapper	    = new $mapper_class($Instance);
	
	self::_getBasePrice();
	self::_priceFrameGauge();
	self::_priceWalls();
	self::_priceLegHeight();
	self::_priceDoors();
	self::_priceWindows();
	
	$price = self::$_price;
	self::$_price = 0;
	return number_format($price,2);
    }
    
    private function _getBasePrice()
    {
	$prices_array		= self::$_Data->model_sizes_prices;
	$model_code		= self::$_Mapper->getModel();
	$size_code		= self::$_Mapper->getSize();
	
	if(
	    key_exists($model_code, $prices_array)
	    && key_exists($size_code, $prices_array[$model_code])
	)
	{
	    $base_price = $prices_array[$model_code][$size_code];
	    self::_addDetail("Base", $base_price, $size_code);
	    self::$_price += $prices_array[$model_code][$size_code];
	}
    }
    
    private function _priceFrameGauge()
    {
	$framegauge_code = self::$_Mapper->getFrameGaugeCode();
	
	if($framegauge_code)
	{
	    $prices_array = self::$_Data->framegauge_prices;
	    if(key_exists($framegauge_code, $prices_array))
	    {
		$price		= $prices_array[$framegauge_code];
		self::$_price  += $price;
		$this->_addDetail("Frame Gauge", $price, $framegauge_code);
	    }
	}
    }
    
    private function _priceWalls() 
    {
	$sides			= array("left" => "Left", "right" => "Right", "front" => "Front", "back" => "Back");
	$walls_pricing_array	= self::$_Data->walls_prices;
	$side_location_array	= array("left" => "side", "right" => "side", "front" => "end", "back" => "end");
	
	foreach ($sides as $side_lower => $side_upper) 
	{
	    $type	    = self::$_Mapper->getCoveredWallsTypeCodeFromSideString($side_lower);
	    $partial_height = self::$_Mapper->getCoveredWallsHeightCodeFromSideString($side_lower);
	    $orientation    = self::$_Mapper->getOrientationCodeFromSideString($side_lower) == "V" ? "vertical" : "horizontal";
	    $certified	    = self::$_Mapper->isCertified() ? "certified" : "noncertified";
	    $width	    = (int) self::$_Mapper->getFrameWidthCode();
	    $length	    = (int) self::$_Mapper->getFrameLengthCode();
	    $leg_height	    = (int) self::$_Mapper->getLegHeightCode();
	    $side_location  = $side_location_array[$side_lower];
	    #--Is it an end or side?
	    switch ($side_location) 
	    {
		case "end":
		    switch($type)
		    {
			case "GB":
			    $price = $walls_pricing_array["location"][$side_location]
							["type"]["gable"]
							["certified"][$certified]
							["orientation"][$orientation];
			    self::$_price += $price;
			    self::_addDetail($side_upper." wall", $price, $type);
			    break;
			case "PT"://partial top
			case "PB"://partial bottom
			    $bracing		= array("12" => 150, "18" => 150, "20" => 150, "22" => 175, "24" => 175);
			    $panel_length_array = array("12" => 75, "18" => 75 ,"20" => 75, "22" => 90, "24" => 90);
			    $amount_of_panels	= ceil($partial_height/3);
			    $price		= (($amount_of_panels*$panel_length_array[$width])+($bracing[$width]*$amount_of_panels));
			    self::$_price	+= $price;
			    self::_addDetail($side_upper." wall", $price, $type." ".$partial_height."ft w/ bracing");
			    break;
			case "CL"://closed
			    $price = $walls_pricing_array["location"][$side_location]
							["type"]["closed"]
							["certified"][$certified]
							["orientation"][$orientation]
							["width"][$width]
							["leg_height"][$leg_height];
			    self::$_price += $price;
			    self::_addDetail($side_upper." wall", $price, $type);
			    break;
			case "":
			case "NO"://no wall
			default:
		    }
		    break;
		case "side":
		    switch($type)
		    {
			//partial
			case "PB":
			case "PT":
			    $panel_length_array = array("21" => 75, "26" => 90, "31" => 105, "36" => 120, "41" => 170);
			    $amount_of_panels	= ceil($partial_height/3);
			    $price = ($amount_of_panels*$panel_length_array[$length]);
			    self::$_price += $price;
			    self::_addDetail($side_upper." wall", $price, $type." ".$partial_height."ft");
			    break;
			//closed
			case "CL"://closed
			    $price = $walls_pricing_array["location"][$side_location]
							["orientation"][$orientation]
							["length"][$length]
							["leg_height"][$leg_height];
			    self::$_price += $price;
			    self::_addDetail($side_upper." wall", $price, $type);
			    break;
			case "":
			case "NO":
			default:
		    }
		    break;
		default:
		    break;
	    }
	}
    }
    
    private function _priceLegHeight()
    {
	$leg_height		= (int)self::$_Mapper->getLegHeightCode();
	$structure_type_code	= self::$_Mapper->getStructureTypeCode();
	$model_code		= self::$_Mapper->getModel();
	$price_array		= self::$_Data->getModelLegHeightPricesArray();
	$length			= (int)self::$_Mapper->getFrameLengthCode();
	$price			= $price_array["type"][$structure_type_code]["model"][$model_code]["leg_height"][$leg_height]["length"][$length];
	self::$_price		+= $price;
	
	self::_addDetail("Leg Height", $price, $leg_height."ft");
    }
    
    private function _priceDoors()
    {
	$doors_count	= self::$_Mapper->getDoorsCount();
	
	if($doors_count>0)
	{
	    $price_array	= self::$_Data->doors_array;
	    $price		= 0;
	    $type		= self::$_Mapper->getStructureTypeCode();
	    $certified		= self::$_Mapper->getCertifiedCode();
	    $certified		= $certified == "Y" ? "certified" : "uncertified"; 
	    
	    for($i=0;$i<$doors_count;$i++)
	    {
		$door_type  = self::$_Mapper->getDoorTypeCode($i);
		$size	    = self::$_Mapper->getDoorSize($i);
		$price	    = $price_array["type"][$type]["certified"][$certified]["door_type"][$door_type][$size];
		self::$_price += $price;
		self::_addDetail("Door ", $price, $size);
	    }
	}
    }
    
    private function _priceWindows()
    {
	$windows_count	= self::$_Mapper->getWindowsCount();
	if($windows_count>0)
	{
	    $price_array	= self::$_Data->windows_array;
	    $price		= 0;
	    $type		= self::$_Mapper->getStructureTypeCode();
	    $certified		= self::$_Mapper->getCertifiedCode();
	    $certified		= $certified == "Y" ? "certified" : "uncertified"; 
	    
	    for($i=0;$i<$windows_count;$i++)
	    {
		$window_type  = self::$_Mapper->getWindowTypeCode($i);
		$size	    = self::$_Mapper->getWindowSize($i);
		$price	    = $price_array["type"][$type]["certified"][$certified]["window_type"][$window_type][$size];
		self::$_price += $price;
		self::_addDetail("Window ", $price, $size);
	    }
	}
    }
    
    private function _addDetail($name = "", $price = 0, $note = "")
    {
	self::$_details[] = array("name" => $name, "price" => $price, "note" => $note);
    }
    
    public function getDetails()
    {
	return self::$_details;
    }
}