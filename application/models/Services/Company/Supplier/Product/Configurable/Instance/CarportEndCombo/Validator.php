<?php
namespace Services\Company\Supplier\Product\Configurable\Instance\CarportEndCombo;

class Validator extends \Services\Company\Supplier\Product\Configurable\Instance\MetalBuildingAbstract\Validator
{
    /**
     *  @var \Services\Company\Supplier\Product\Configurable\Instance\CarportEndCombo\Validator\Data $_Data 
     */
    protected $_Data;
    
    /**
     *  @var \Services\Company\Supplier\Product\Configurable\Instance\CarportEndCombo\Mapper $_Mapper 
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
	$this->_validateExtraKneeBraces();
	$this->_validateExtraStormBraces();
	$this->_validateDoorAndWindowWidthsForWalls();
	$this->_validateDoorAndWindowHeightsForWalls();
    }
    
    protected function _validateDoorAndWindowWidthsForWalls()
    {	
	foreach($this->_Mapper->getSidesArray() as $side)
	{
	    $side_length = $this->_Mapper->isSideLocationASide($side) ? 
				$this->_Mapper->getEndComboDepthInInches() : 
				    $this->_Mapper->getFrameWidthInInches();
	    
	    if($this->_Mapper->getDoorAndWindowWidthsTotalPlusSpaceBetweenForSideInInches($side) > 
		    $side_length
	    )
		throw new \Exception(
			ucfirst($side)." wall has too many doors or windows. Increase the ".
			"frame size or reduce the amount of doors/windows on the ".$side." side."
		    );
	}
    }
}