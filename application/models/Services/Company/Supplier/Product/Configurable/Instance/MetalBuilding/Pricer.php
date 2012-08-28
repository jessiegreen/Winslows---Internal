<?php
namespace Services\Company\Supplier\Product\Configurable\Instance\MetalBuilding;

class Pricer extends \Services\Company\Supplier\Product\Configurable\Instance\Pricer\PricerAbstract
{    
    /**
     * @var \Services\Company\Supplier\Product\Configurable\Instance\MetalBuilding\Pricer\Data 
     */
    protected $_Data;
    
    /**
     * @var \Services\Company\Supplier\Product\Configurable\Instance\MetalBuilding\Mapper 
     */
    protected $_Mapper;
    
    /**
     * @return \Dataservice_Price
     */
    public function price()
    {
	$this->_Price->setPrice(0);	
	$this->_getBasePrice();
	$this->_priceFrameGauge();
	$this->_priceWalls();
	$this->_priceLegHeight();
	$this->_priceDoors();
	$this->_priceWindows();
	
	return $this->_Price;
    }
    
    protected function _getBasePrice()
    {
	$prices_array		= $this->_Data->getBasePricesArray();
	$model_code		= $this->_Mapper->getModel();
	$size_code		= $this->_Mapper->getFrameSize();
	
	if(
	    key_exists($model_code, $prices_array)
	    && key_exists($size_code, $prices_array[$model_code])
	)
	{
	    $base_price = $prices_array[$model_code][$size_code];
	    
	    $this->_Price->add((int) $prices_array[$model_code][$size_code]);
	    $this->_Price->addDetail($base_price." - Base Price:".$this->_Mapper->getModelName()."-".$size_code);
	}
	else throw new \Exception("$size_code is not in Base Price Array");
    }
    
    protected function _priceFrameGauge()
    {
	$framegauge_code = $this->_Mapper->getFrameGauge();
	
	if($framegauge_code !== false)
	{
	    $prices_array = $this->_Data->framegauge_prices;
	    
	    if(key_exists($framegauge_code, $prices_array))
	    {
		$price = $prices_array[$framegauge_code];
		
		$this->_Price->add((int) $price);		
		$this->_Price->addDetail($price." - Frame Gauge:".$this->_Mapper->getFrameGaugeName());
	    }
	    else throw new \Exception("Frame Gauge '$framegauge_code' not not valid for pricing");
	}
    }
    
    protected function _priceWalls() 
    {
	$sides			= $this->_Mapper->getSidesArray();
	$side_location_array	= $this->_Mapper->getSidesLocationsArray();
	$walls_pricing_array	= $this->_Data->getWallsPricesArray();
	
	foreach ($sides as $side) 
	{
	    $side_upper	= ucfirst($side);
	    
	    $type	    = $this->_Mapper->getWallCoveredType($side);
	    $type_name	    = $this->_Mapper->getWallCoveredTypeName($side);
	    $partial_height = $this->_Mapper->getWallCoveredHeight($side);
	    $orientation    = $this->_Mapper->getWallOrientationIndex($side) !== "vertical" ? "horizontal" : "vertical";
	    $certified	    = $this->_Mapper->isCertified() ? "certified" : "noncertified";
	    $width	    = (int) $this->_Mapper->getFrameWidth();
	    $length	    = (int) $this->_Mapper->getFrameLength();
	    $leg_height	    = (int) $this->_Mapper->getLegHeight();
	    $side_location  = $side_location_array[$side];
	    
	    #--Is it an end or side?
	    switch ($side_location) 
	    {
		case "end":
		    switch($type)
		    {
			case "GB"://gable
			    $price = $walls_pricing_array["location"][$side_location]
							["type"]["gable"]
							["certified"][$certified]
							["orientation"][$orientation];
			    $this->_Price->add((int) $price);
			    $this->_Price->addDetail($price." - ".$side_upper." wall coverage:".$type_name."-".$certified);
			    break;
			case "PT"://partial top
			case "PB"://partial bottom
			    $bracing		= $this->_Data->getWallsPartialCoverageBracingPricesArray();
			    $panel_length_array = $this->_Data->getWallsPartialCoverageEndPanelPricesArray();
			    $amount_of_panels	= ceil($partial_height/3);
			    $price		= (($amount_of_panels*$panel_length_array[$width])+($bracing[$width]*$amount_of_panels));
			    
			    $this->_Price->add((int) $price);
			    $this->_Price->addDetail($price." - ".$side_upper." wall coverage:".
							$type_name."-".$partial_height."ft w/ bracing");
			    break;
			case "CL"://closed
			    $price = $walls_pricing_array["location"][$side_location]
							["type"]["closed"]
							["certified"][$certified]
							["orientation"][$orientation]
							["width"][$width]
							["leg_height"][$leg_height];
			    $this->_Price->add((int) $price);
			    $this->_Price->addDetail($price." - ".$side_upper." wall coverage:".$type_name."-".$certified);
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
			    $panel_length_array = $this->_Data->getWallsPartialCoverageSidePanelPricesArray();
			    $amount_of_panels	= ceil($partial_height/3);
			    $price = ($amount_of_panels*$panel_length_array[$length]);
			    $this->_Price->add((int) $price);
			    $this->_Price->addDetail($price." - ".$side_upper." wall coverage:".
							$type_name." ".$partial_height."ft");
			    break;
			//closed
			case "CL"://closed
			    $price = $walls_pricing_array["location"][$side_location]
							["orientation"][$orientation]
							["length"][$length]
							["leg_height"][$leg_height];
			    $this->_Price->add((int) $price);
			    $this->_Price->addDetail($price." - ".$side_upper." wall coverage:".$type_name);
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
    
    protected function _priceLegHeight()
    {
	$leg_height		= (int)$this->_Mapper->getLegHeight();
	$model_code		= $this->_Mapper->getModel();
	$price_array		= $this->_Data->getModelLegHeightPricesArray();
	$length			= (int)$this->_Mapper->getFrameLength();
	$price			= $price_array[$model_code]["leg_height"][$leg_height]["length"][$length];
	
	$this->_Price->add((int) $price);	
	$this->_Price->addDetail($price." - Leg Height:".$leg_height." ft");
    }
    
    protected function _priceDoors()
    {
	$DoorOptions = $this->_Mapper->getDoorOptions();
	
	if($DoorOptions->count() > 0)
	{
	    $price_array	= $this->_Data->getDoorsPricingArray();
	    $price		= 0;
	    $certified		= $this->_Mapper->getCertified();
	    $certified		= $certified == "Y" ? "certified" : "uncertified"; 
	    
	    foreach($DoorOptions as $DoorOption)
	    {
		$door_type	= $this->_Mapper->getDoorType($DoorOption);
		$door_type_name	= $this->_Mapper->getDoorTypeName($DoorOption);
		$size		= $this->_Mapper->getDoorSize($DoorOption);
		$price		= $price_array[$certified]["door_type"][$door_type][$size];
		
		$this->_Price->add((int) $price);		
		$this->_Price->addDetail($price." - Door:".$door_type_name."-".$size."-".$certified);
	    }
	}
    }
    
    protected function _priceWindows()
    {
	$WindowOptions = $this->_Mapper->getWindowOptions();
	
	if($WindowOptions->count() > 0)
	{
	    $price_array	= $this->_Data->getWindowsPricingArray();
	    $price		= 0;
	    $certified		= $this->_Mapper->getCertified();
	    $certified		= $certified == "Y" ? "certified" : "uncertified"; 
	    
	    foreach($WindowOptions as $WindowOption)
	    {
		$window_type	    = $this->_Mapper->getWindowType($WindowOption);
		$window_type_name   = $this->_Mapper->getWindowTypeName($WindowOption);
		$size		    = $this->_Mapper->getWindowSize($WindowOption);
		$price		    = $price_array[$certified]["window_type"][$window_type][$size];
		
		$this->_Price->add((int) $price);
		$this->_Price->addDetail($price." - Window:".$window_type_name."-".$size."-".$certified);
	    }
	}
    }
    
    protected function _addDetail($name = "", $price = 0, $note = "")
    {
	$this->_details[] = array("name" => $name, "price" => $price, "note" => $note);
    }
}