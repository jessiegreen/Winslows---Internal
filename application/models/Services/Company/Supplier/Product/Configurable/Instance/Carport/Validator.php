<?php
namespace Services\Company\Supplier\Product\Configurable\Instance\Carport;

class Validator extends \Services\Company\Supplier\Product\Configurable\Instance\MetalBuildingAbstract\Validator
{
    /**
     *  @var \Services\Company\Supplier\Product\Configurable\Instance\Carport\Validator\Data $_Data 
     */
    protected $_Data;
    
    /**
     *  @var \Services\Company\Supplier\Product\Configurable\Instance\Carport\Mapper $_Mapper 
     */
    protected $_Mapper;
    
    /**
     * @param string $location
     */
    public function validate($location = null)
    {
	parent::validate($location);
	
	if($location)$this->_validateWindSnowLoad($location);
	
	$this->_validateFrameGauge();
	$this->_validateCertified();
	$this->_validateLegHeight();
	$this->_validateWallsCovered();
    }
}