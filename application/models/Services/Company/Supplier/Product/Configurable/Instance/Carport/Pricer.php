<?php
namespace Services\Company\Supplier\Product\Configurable\Instance\Carport;

class Pricer extends \Services\Company\Supplier\Product\Configurable\Instance\MetalBuildingAbstract\Pricer
{    
    /**
     * @var \Services\Company\Supplier\Product\Configurable\Instance\Carport\Pricer\Data 
     */
    protected $_Data;
    
    /**
     * @var \Services\Company\Supplier\Product\Configurable\Instance\Carport\Mapper 
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
	$this->_addCoveredWallsPrice();
	$this->_addCertifiedPrice();
	$this->_addAugerAnchorsPrice();
	$this->_addExtraKneeBracesPrice();
	$this->_addExtraStormBracesPrice();
	
	return $this->_Price;
    }
}