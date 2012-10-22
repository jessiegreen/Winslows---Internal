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
	$this->_getBasePrice();
	$this->_priceFrameGauge();
	$this->_priceWalls();
	$this->_priceLegHeight();
    }
}