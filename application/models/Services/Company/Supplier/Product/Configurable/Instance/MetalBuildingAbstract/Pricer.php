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
    
    protected function _addBasePrice()
    {
	$this->_Price->addWithPriceDetail(
		$this->_Data->getBasePrice(
			$this->_Mapper->getRoofStyleWindSnowLoadKey(), 
			$this->_Mapper->getFrameSize()
		),
		"Base: ".$this->_Mapper->getRoofStyleName()."/".$this->_Mapper->getWindSnowLoadName().
		    "/".$this->_Mapper->getFrameSize()
	    );
    }
    
    protected function _addFrameGaugePrice()
    {
	if(!$this->_Mapper->isWindSnowLoadHighWindSnow() && $this->_Mapper->isFrameGauge12())
	    $this->_Price->addWithPriceDetail(
		$this->_Data->getFrameGauge12Price($this->_Mapper->getFrameLength()),
		"Frame Gauge: ".$this->_Mapper->getFrameGaugeName()
	    );	    
    }
    
    protected function _addCoveredWallsPrice() 
    {
	$side_location_array = $this->_Mapper->getSidesLocationsArray();
	
	foreach ($this->_Mapper->getSidesArray() as $side) 
	{	    
	    #--Is it an end or side?
	    switch ($side_location_array[$side]) 
	    {
		case "end":
		    if($this->_Mapper->doesWallHaveGableEnd($side))
			$this->_addWallEndGablePrice($side);
		    
		    if($this->_Mapper->isWallPartiallyCovered($side))
			$this->_addWallEndPartialPrice($side);
			    
		    if($this->_Mapper->isWallClosed($side))
			    $this->_addWallEndClosedPrice($side);
		break;
		case "side":
		    if($this->_Mapper->isWallPartiallyCovered($side))
			    $this->_addWallSidePartialPrice($side);
		    
		    if($this->_Mapper->isWallClosed($side))
			    $this->_addWallSideClosedPrice($side);
		    
		break;
		default:
	    }
	}
    }
    
    protected function _addLegHeightPrice()
    {	
	$this->_Price->addWithPriceDetail(
		    $this->_Data->getLegHeightPrice(
			$this->_Mapper->getRoofStyleWindSnowLoadKey(), 
			$this->_Mapper->getLegHeight(), 
			$this->_Mapper->getFrameLength()
		    ),
		    "Leg Height"
		);
    }
    
    protected function _addCertifiedPrice()
    {
	if($this->_Mapper->isCertified() && !$this->_Mapper->isWindSnowLoadCertified())
	{
	    if($this->_Mapper->isWindSnowLoadStandard())
		$this->_Price->addWithPriceDetail(
		    $this->_Data->getCertifiedWindSnowLoadStandardPrice(
			$this->_Mapper->getFrameLength()
		    ),
		    "Certified"
		);
	    
	    if($this->_Mapper->isWindSnowLoadWindSnow())
		$this->_Price->addWithPriceDetail(
		    $this->_Data->getCertifiedWindSnowLoadWindSnowPrice(
			$this->_Mapper->getFrameGauge(),
			$this->_Mapper->getFrameLength()
		    ),
		    "Certified"
		);
	}
    }
    
    protected function _addAugerAnchorsPrice()
    {
	if($this->_Mapper->hasAugerAnchors())
	    $this->_Price->addWithPriceDetail(
		((int) $this->_Mapper->getAugerAnchorsCount() * (float) $this->_Data->getAugerAnchorsPrice()),
		"Auger Anchors"
	    );
    }
    
    protected function _addExtraKneeBracesPrice()
    {
	if($this->_Mapper->hasExtraKneeBraces())
	    $this->_Price->addWithPriceDetail(
		(float) $this->_Data->getExtraKneeBracesPrice(
			    $this->_Mapper->getExtraKneeBracesSize(),
			    $this->_Mapper->getFrameLength()
			),
		"Extra Knee Braces"
	    );
    }
    
    protected function _addExtraStormBracesPrice()
    {
	if($this->_Mapper->hasExtraStormBraces())
	    $this->_Price->addWithPriceDetail(
		(float) $this->_Data->getExtraStormBracesPrice(
			    $this->_Mapper->getExtraStormBracesSize(),
			    $this->_Mapper->getFrameLength()
			),
		"Extra Storm Braces"
	    );
    }
    
    /**
     * @param string $side
     */
    private function _addWallEndGablePrice($side)
    {
	if(#--Certified or High Wind or High Wind & Snow Loads
	    $this->_Mapper->isCertified() || 
	    $this->_Mapper->isWindSnowLoadCertified()
	)
	    $this->_Price->addWithPriceDetail(
		    $this->_Data->getWallEndGableCertifiedPrice(),
		    "End wall gable certified"
		);
	else
	    $this->_Price->addWithPriceDetail(
		    $this->_Data->getWallEndGableUnCertifiedPrice(),
		    "End wall gable uncertified"
		);
	
	if($this->_Mapper->hasWallCoveredJTrim($side))
	    $this->_Price->addWithPriceDetail(
		    ($this->_Data->getJTrimPricePerFoot() * (float) $this->_Mapper->getFrameWidth()),
		    "End wall gable j-trim"
		);

	if($this->_Mapper->isWallCoveredOrientationVertical($side))
	    $this->_Price->addWithPriceDetail(
			$this->_Data->getWallEndGableVerticalPrice(),
			"End wall gable vertical charge"
		    );
    }
    
    /**
     * @param string $side
     */
    protected function _addWallEndClosedPrice($side)
    {
	if(#--Certified or High Wind or High Wind & Snow Loads
	    $this->_Mapper->isCertified() || 
	    $this->_Mapper->isWindSnowLoadCertified()
	)
	    $this->_Price->addWithPriceDetail(
			$this->_Data->getWallEndClosedCertifiedPrice(
				    $this->_Mapper->getFrameWidth(),
				    $this->_Mapper->getLegHeight()
				),
			"End wall closed certified"
		    );
	else
	    $this->_Price->addWithPriceDetail(
			$this->_Data->getWallEndClosedUnCertifiedPrice(
				    $this->_Mapper->getFrameWidth(),
				    $this->_Mapper->getLegHeight()
				),
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
    
    protected function _addRollUpDoorsPrice()
    {
	foreach($this->_Mapper->getDoorRollups() as $DoorOption)
	{
	    $this->_Price->addWithPriceDetail(
		$this->_Data->getDoorRollUpPrice($this->_Mapper->getDoorRollUpSizeIndex($DoorOption)),
		"Roll Up Door - ".$this->_Mapper->getDoorRollUpSizeName($DoorOption)
	    );
	}
    }
    
    /**
     * @param string $side
     */
    private function _addWallEndPartialPrice($side)
    {
	$frame_width	= $this->_Mapper->getFrameWidth();
	$partial_height	= $this->_Mapper->getWallCoveredHeight($side);
	$bracing_price  = $this->_calculateWallEndPartialBracingCost($frame_width);
	$panels_price   = $this->_calculatePanelsPrice($frame_width, $partial_height);

	$this->_Price->addWithPriceDetail(
			($bracing_price + $panels_price),
			ucfirst($side)." End Wall Partial Coverage ".$partial_height."ft w/ bracing"
		    );
    }
    
    private function _addWallSidePartialPrice($side)
    {
	$frame_length	= $this->_Mapper->getFrameLength();
	$partial_height	= $this->_Mapper->getWallCoveredHeight($side);
	$partial_depth	= $this->_Mapper->getWallCoveredDepth($side);
	$leg_height	= $this->_Mapper->getLegHeight();
	$depth		= $partial_depth ? $partial_depth : $frame_length;
	$height		= $partial_height ? $partial_height : $leg_height;
	
	$panels_price	= $this->_calculatePanelsPrice($depth, $height);
	
	$this->_Price->addWithPriceDetail(
			$panels_price,
			ucfirst($side)." Side Wall Partial Coverage ".$depth."'X".$height."'"
		    );
    }
    
    /**
     * @param string $side
     */
    private function _addWallSideClosedPrice($side)
    {
	$this->_Price->addWithPriceDetail(
		    $this->_Data->getWallSideClosedPrice($this->_Mapper->getFrameLength(), $this->_Mapper->getLegHeight()),
		    "Side wall closed."
		);

	if($this->_Mapper->isWallCoveredOrientationVertical($side))
	{	    
	    $this->_Price->addWithPriceDetail(
			$this->_Data->getWallSideClosedVerticalPrice($this->_Mapper->getFrameLength()),
			"Side wall closed vertical charge."
		    );
	}
    }
    
    /**
     * @param string $width
     * @param string $height
     * @return float
     */
    private function _calculatePanelsPrice($width, $height)
    {
	$price = 0;
	
	foreach ($this->_calculatePanelLengthsToBeUsed($width) as $panel_length => $count)
	    $price += (float)((float) $this->_Data->getPanelPrice($panel_length) * (int) $count);
	
	return (float) (
		(int) $this->_calculatePanelRowsToBeUsed($height) * 
		(float) $price
		);
    }
    
    /**
     * @param string|int|float $height
     * @return int
     */
    private function _calculatePanelRowsToBeUsed($height)
    {
	return (int) ceil((float)$height/3);
    }
    
    /**
     * @param string|float|int $width
     * @return array
     */
    private function _calculatePanelLengthsToBeUsed($width)
    {
	$panel_lengths_array	= $this->_Data->getPanelSizes();
	$panel_counts		= $this->_initializePanelCountsArray($panel_lengths_array);
	$width			= (float) $width;
	
	sort($panel_lengths_array);
	
	while($width > 0)
	{
	    #--See if one panel will do
	    $single_panel = $this->getPanelBiggerThanSpan($width, $panel_lengths_array);

	    #--If so add the panel to the array
	    if($single_panel)
	    {
		$panel_counts[$single_panel]++;
		
		$width -= (float) $single_panel;
	    }
	    else
	    {
		$biggest_panel			= $this->_getBiggestPanelSize($panel_lengths_array);
		
		$panel_counts[$biggest_panel]++;
		
		$width				-= (float) $biggest_panel;
	    }
	}
	
	return $panel_counts;
    }
    
    private function _initializePanelCountsArray($panel_lengths_array)
    {
	$panel_counts		= array();
	
	foreach($panel_lengths_array as $panel_length)
	{
	    $panel_counts[$panel_length] = 0;
	}
	
	return $panel_counts;
    }
    
    /**
     * @param array $panel_lengths_array
     * @return string
     */
    public function _getBiggestPanelSize($panel_lengths_array)
    {
	$biggest_panel = 0;
	
	foreach ($panel_lengths_array as $panel_length)
	{
	    if((float) $panel_length > (float) $biggest_panel)$biggest_panel = $panel_length;
	}
	
	return (string) $biggest_panel;
    }
    
    /**
     * 
     * @param string|int|float $width
     * @param array $panel_lengths_array
     * @return boolean|string
     */
    private function getPanelBiggerThanSpan($width, $panel_lengths_array)
    {
	foreach ($panel_lengths_array as $panel_length)
	{
	    if ((float) $panel_length >= (float) $width) return (string) $panel_length;
	}
	
	return false;
    }
    
    /**
     * @param string $width
     * @return string
     */
    private function _calculateWallEndPartialBracingWidthToBeUsed($width)
    {
	$bracing_widths = $this->_Data->getWallEndPartialCoverageBracingWidths();
	
	sort($bracing_widths);
	
	foreach ($bracing_widths as $bracing_width)
	{
	    if ((float) $bracing_width >= (float) $width) return (string) $bracing_width;
	}
    }
    
    /**
     * @param string $width
     * @return float
     */
    private function _calculateWallEndPartialBracingCost($width)
    {
	return (float) $this->_Data->getWallEndPartialCoverageBracingPrice(
		    $this->_calculateWallEndPartialBracingWidthToBeUsed($width)
		);
    }
}