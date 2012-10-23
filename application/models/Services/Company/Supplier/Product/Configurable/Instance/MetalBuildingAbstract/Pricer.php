<?php
namespace Services\Company\Supplier\Product\Configurable\Instance\MetalBuildingAbstract;

abstract class Pricer extends \Services\Company\Supplier\Product\Configurable\Instance\Pricer\PricerAbstract
{    
    /**
     * @var \Services\Company\Supplier\Product\Configurable\Instance\MetalBuildingAbstract\Pricer\Data 
     */
    protected $_Data;
    
    /**
     * @var \Services\Company\Supplier\Product\Configurable\Instance\MetalBuildingAbstract\Mapper 
     */
    protected $_Mapper;
    
    protected function _getBasePrice()
    {
	$prices_array		= $this->_Data->getBasePricesArray();
	$roof_WS_key		= $this->_Mapper->getRoofStyleWindSnowLoadKey();
	$size_code		= $this->_Mapper->getFrameSize();
	
	if(
	    key_exists($roof_WS_key, $prices_array)
	    && key_exists($size_code, $prices_array[$roof_WS_key])
	)
	{
	    $base_price = $prices_array[$roof_WS_key][$size_code];
	    
	    $this->_Price->add((int) $prices_array[$roof_WS_key][$size_code]);
	    $this->_Price->addDetail($base_price." - Base: ".$this->_Mapper->getRoofStyleName()."/".$this->_Mapper->getWindSnowLoadName()."/".$size_code);
	}
	else throw new \Exception("$size_code is not in Base Price Array");
    }
    
    protected function _priceFrameGauge()
    {
	$framegauge_code = $this->_Mapper->getFrameGauge();
	
	if($framegauge_code !== false)
	{
	    $prices_array = $this->_Data->getFrameGaugePricesArray();
	    
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
	    
	    $type		= $this->_Mapper->getWallCoveredType($side);
	    $type_name		= $this->_Mapper->getWallCoveredTypeName($side);
	    $partial_height	= $this->_Mapper->getWallCoveredHeight($side);
	    $orientation	= $this->_Mapper->getWallCoveredOrientationIndex($side) !== "vertical" ? "horizontal" : "vertical";
	    $orientation_name	= $this->_Mapper->getWallCoveredOrientationName($side) !== "Vertical" ? "Horizontal" : "Vertical";
	    $certified		= $this->_Mapper->isCertified() ? "certified" : "noncertified";
	    $width		= (int) $this->_Mapper->getFrameWidth();
	    $length		= (int) $this->_Mapper->getFrameLength();
	    $leg_height		= (int) $this->_Mapper->getLegHeight();
	    $side_location	= $side_location_array[$side];
	    
	    #--Is it an end or side?
	    switch ($side_location) 
	    {
		case "end":
		    switch($type)
		    {
			case "GB"://gable
			    $this->_Price->add($this->_Data->getWallEndGablePrice($this->_Mapper->isCertified()));
			    $this->_Price->addDetail("End wall gable up to 24' wide");
			    
			    if($this->_Mapper->isWallCoveredOrientationVertical($side))
			    {
				$this->_Price->add($this->_Data->getWallEndGablePrice($this->_Mapper->isCertified()));
				$this->_Price->addDetail("End wall gable up to 24' wide");
			    }
			break;
			case "PT"://partial top
			case "PB"://partial bottom
			    $bracing		= $this->_Data->getWallsPartialCoverageBracingPricesArray();
			    $panel_length_array = $this->_Data->getWallsPartialCoverageEndPanelPricesArray();
			    $amount_of_panels	= ceil($partial_height/3);
			    $price		= (($amount_of_panels*$panel_length_array[$width])+($bracing[$width]*$amount_of_panels));
			    
			    $this->_Price->add((int) $price);
			    $this->_Price->addDetail($price." - ".$side_upper." wall coverage:".
							$type_name."-".$partial_height."ft w/ bracing - orientation:".$orientation_name);
			    break;
			case "CL"://closed
			    $price = $walls_pricing_array["location"][$side_location]
							["type"]["closed"]
							["certified"][$certified]
							["orientation"][$orientation]
							["width"][$width]
							["leg_height"][$leg_height];
			    $this->_Price->add((int) $price);
			    $this->_Price->addDetail($price." - ".$side_upper." wall coverage:".$type_name."-".$certified." - orientation:".$orientation_name);
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
							$type_name." ".$partial_height."ft  - orientation:".$orientation_name);
			    break;
			//closed
			case "CL"://closed
			    $price = $walls_pricing_array["location"][$side_location]
							["orientation"][$orientation]
							["length"][$length]
							["leg_height"][$leg_height];
			    $this->_Price->add((int) $price);
			    $this->_Price->addDetail($price." - ".$side_upper." wall coverage:".$type_name."  - orientation:".$orientation_name);
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
	$roof_WS_key		= $this->_Mapper->getRoofStyleWindSnowLoadKey();
	$price_array		= $this->_Data->getModelLegHeightPricesArray();
	$length			= (int)$this->_Mapper->getFrameLength();
	$price			= $price_array[$roof_WS_key]["leg_height"][$leg_height]["length"][$length];
	
	$this->_Price->add((int) $price);	
	$this->_Price->addDetail($price." - Leg Height:".$leg_height." ft");
    }
}