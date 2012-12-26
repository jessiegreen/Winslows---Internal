<?php
namespace Services\Winslows;

class Location extends \Dataservice_Service_ServiceAbstract
{
    private $Company;
    
    /**
     * @return Location
     */
    public static function factory()
    {
	return parent::factory();
    }
    
    public function __construct()
    {
	$this->Company = \Services\Company::factory()->getCurrentCompany();
	
	parent::__construct();
    }
    
    /**
     * @return array
     */
    public function getAllCompanyLocations()
    {
	return \Services\Company\Location::factory()->getLocations();
    }
    
    public function getAllCompanyLocationsWithinDistanceOfAddress($distance = null, $address = null)
    {
	return \Services\Company\Location::factory()->getAllCompanyLocationsWithinDistanceOfAddress($distance, $address);
    }
}