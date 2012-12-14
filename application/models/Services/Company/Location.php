<?php
namespace Services\Company;

class Location extends \Dataservice_Service_ServiceAbstract
{
    /**
     * @return Location
     */
    public static function factory() 
    {
	return parent::factory();
    }
    
    public function getLocations()
    {
	return $this->_em->getRepository("Entities\Company\Location")->findAll();
    }
}