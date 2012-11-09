<?php
namespace Services\Company\Supplier\Product\Configurable\Instance\CarportEndCombo;

class Pricer extends \Services\Company\Supplier\Product\Configurable\Instance\MetalBuildingAbstract\Pricer
{    
    /**
     * @var \Services\Company\Supplier\Product\Configurable\Instance\CarportEndCombo\Pricer\Data 
     */
    protected $_Data;
    
    /**
     * @var \Services\Company\Supplier\Product\Configurable\Instance\CarportEndCombo\Mapper 
     */
    protected $_Mapper;
    
    /**
     * @return \Dataservice_Price
     */
    public function price()
    {
	$this->_Price->setPrice(0);	
	$this->_addBasePrice();
	$this->_addFrameGaugePrice();
	$this->_addLegHeightPrice();
	$this->_addStoragePortionPrice();
	$this->_addCertifiedPrice();
	$this->_addAugerAnchorsPrice();
	$this->_addExtraKneeBracesPrice();
	$this->_addExtraStormBracesPrice();
	$this->_addRollUpDoorsPrice();
	
	return $this->_Price;
    }
    
    private function _addStoragePortionPrice()
    {
	$this->_addWallEndClosedPrice("front");
	$this->_addWallEndClosedPrice("back");
	
	$this->_addEndComboSidePrice();
    }
    
    private function _addEndComboSidePrice()
    {
	$this->_Price->addPriceDetail(
		$this->_Data->getEndComboSidesPrice(
		    $this->_Mapper->getLegHeight(), 
		    $this->_Mapper->getEndComboDepth()
		), "Combo Sides");
	
	if($this->_Mapper->isEndComboMetalOrientationVertical())
	{
	    $this->_Price->addWithPriceDetail(
			($this->_Data->getWallEndClosedVerticalPrice($this->_Mapper->getFrameWidth()) * 2),
			"Combo end walls vertical charge up to 24' wide"
		    );
	    $this->_Price->addWithPriceDetail(
			(
			    $this->_Data->getWallSideClosedVerticalPrice(
				$this->_getWallSideClosedVerticalPriceClosestToEndComboDepth()
			    ) * 2
			),
			"Combo side walls vertical"
		    );
	}
    }
    
    /**
     * @return string
     */
    private function _getWallSideClosedVerticalPriceClosestToEndComboDepth()
    {
	$lengths	= $this->_Data->getWallSideClosedVerticalFrameLengthsArray();
	$combo_depth	= $this->_Mapper->getEndComboDepth();
	
	sort($lengths, SORT_NUMERIC);
	
	foreach($lengths as $length)
	{
	    if($length > $combo_depth)return (string) $length;
	}
    }
}