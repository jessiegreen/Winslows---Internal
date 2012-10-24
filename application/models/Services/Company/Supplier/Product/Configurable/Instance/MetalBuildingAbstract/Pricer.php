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
	    $side_upper_case	= ucfirst($side);
	    
	    $type		= $this->_Mapper->getWallCoveredType($side);
	    $type_name		= $this->_Mapper->getWallCoveredTypeName($side);
	    $partial_height	= $this->_Mapper->getWallCoveredHeight($side);
	    $orientation	= $this->_Mapper->getWallCoveredOrientationIndex($side) !== "vertical" ? "horizontal" : "vertical";
	    $orientation_name	= $this->_Mapper->getWallCoveredOrientationName($side) !== "Vertical" ? "Horizontal" : "Vertical";
	    $frame_width	= (int) $this->_Mapper->getFrameWidth();
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
			    $this->_addGablePrice($side);
			break;
			case "PT"://partial top
			case "PB"://partial bottom
			    $this->_addEndWallPartialPrice($side);
			    break;
			case "CL"://closed
			    $this->_addWallEndClosedPrice($side);
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
			    $panel_length	= $this->_calculatePanelLengthToBeUsed($frame_width);
			    $amount_of_panels	= $this->_calculatePanelsCountToBeUsed($partial_height);
			    $panel_price	= $this->_Data->getPanelPrice($panel_length);
			    
			    $price = ($amount_of_panels * $panel_length_array[$length]);
			    $this->_Price->add((int) $price);
			    $this->_Price->addDetail($price." - ".$side_upper_case." wall coverage:".
							$type_name." ".$partial_height."ft  - orientation:".$orientation_name);
			    break;
			//closed
			case "CL"://closed
			    $price = $walls_pricing_array["location"][$side_location]
							["orientation"][$orientation]
							["length"][$length]
							["leg_height"][$leg_height];
			    $this->_Price->add((int) $price);
			    $this->_Price->addDetail($price." - ".$side_upper_case." wall coverage:".$type_name."  - orientation:".$orientation_name);
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
    
    /**
     * @param string $side
     */
    private function _addGablePrice($side)
    {
	if(#--Certified or High Wind or High Wind & Snow Loads
	    $this->_Mapper->isCertified() || 
	    in_array($this->_Mapper->getWindSnowLoad(), array("2", "4"))
	)
	    $this->_Price->addWithPriceDetail(
		    $this->_Data->getWallEndGableCertifiedPrice(),
		    "End wall gable certified up to 24' wide"
		);
	else
	    $this->_Price->addWithPriceDetail(
		    $this->_Data->getWallEndGableUnCertifiedPrice(),
		    "End wall gable uncertified up to 24' wide"
		);

	if($this->_Mapper->isWallCoveredOrientationVertical($side))
	    $this->_Price->addWithPriceDetail(
			$this->_Data->getWallEndGableVerticalPrice(),
			"End wall gable vertical charge up to 24' wide"
		    );
    }
    
    /**
     * @param string $side
     */
    private function _addWallEndClosedPrice($side)
    {
	if(#--Certified or High Wind or High Wind & Snow Loads
	    $this->_Mapper->isCertified() || 
	    in_array($this->_Mapper->getWindSnowLoad(), array("2", "4"))
	)
	    $this->_Price->addWithPriceDetail(
			$this->_Data->getWallEndClosedCertifiedPrice(),
			"End wall closed certified"
		    );
	else
	    $this->_Price->addWithPriceDetail(
			$this->_Data->getWallEndClosedUnCertifiedPrice(),
			"End wall closed uncertified"
		    );

	if($this->_Mapper->isWallCoveredOrientationVertical($side))
	{	    
	    $this->_Price->addWithPriceDetail(
			$this->_Data->getWallEndClosedVerticalPrice($this->_Mapper->getFrameWidth()),
			"End wall closed vertical charge up to 24' wide"
		    );
	}
    }
    
    private function _addEndWallPartialPrice($side)
    {
	$frame_width	= $this->_Mapper->getFrameWidth();
	$partial_height	= $this->_Mapper->getWallCoveredHeight($side);
	$bracing_price  = $this->_calculateWallEndPartialBracingCost($frame_width);
	$panels_price   = $this->_calculatePanelPrice($frame_width, $partial_height);

	$this->_Price->addWithPriceDetail(
			($bracing_price + $panels_price),
			ucfirst($side)." End Wall Partial Coverage ".$partial_height."ft w/ bracing"
		    );
    }
    
    private function _calculatePanelPrice($width, $height)
    {
	return (
		$this->_calculatePanelsCountToBeUsed($height) * 
		$this->_Data->getPanelPrice($this->_calculatePanelLengthToBeUsed($width))
		);
    }
    
    private function _calculatePanelsCountToBeUsed($height)
    {
	return ceil($height/3);
    }
    
    private function _calculatePanelLengthToBeUsed($width)
    {
	$panel_lengths_array = $this->_Data->getPanelSizes();
	
	sort($panel_lengths_array);
	
	foreach ($panel_lengths_array as $panel_length)
	{
	    if ($panel_length >= $width) return $panel_length;
	}
    }
    
    private function _calculateWallEndPartialBracingWidthToBeUsed($width)
    {
	$bracing_widths = $this->_Data->getWallEndPartialCoverageBracingWidths();
	
	sort($bracing_widths);
	
	foreach ($bracing_widths as $bracing_width)
	{
	    if ($bracing_width >= $width) return $bracing_width;
	}
    }
    
    private function _calculateWallEndPartialBracingCost($width)
    {
	return $this->_Data->getWallEndPartialCoverageBracingPrice(
		    $this->_calculateWallEndPartialBracingWidthToBeUsed($width)
		);
    }
}