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
    
    /**
     * @return \Doctrine\Common\Collections\ArrayCollection
     */
    public function getLocations()
    {	
	return $this->getCompany()->getLocations();
    }
    
    /** 
     * @param mixed $distance
     * @param string $address
     * @return \Doctrine\Common\Collections\ArrayCollection
     */
    public function getAllCompanyLocationsWithinDistanceOfAddress($distance = null, $address = null)
    {
	if(!$distance || !$address)
	    return $this->getLocations();
	
	$latlong = \Dataservice\Map::getLatLongFromAddress($address);
	
	return $this->getAllCompanyLocationsWithinDistanceOfLatLong($distance, $latlong["latitude"], $latlong["longitude"]);
    }
    
    /**
     * 
     * @param mixed $distance
     * @param string $lat
     * @param string $long
     * @return \Doctrine\Common\Collections\ArrayCollection
     */
    public function getAllCompanyLocationsWithinDistanceOfLatLong($distance, $lat, $long)
    {
	return $this->getCompany()->getLocationsWithinXMilesOfLatLong($distance, $lat, $long);
    }
    
    /**
     * @return \Entities\Company
     */
    private function getCompany()
    {
	return \Services\Company::factory()->getCurrentCompany();
    }
}