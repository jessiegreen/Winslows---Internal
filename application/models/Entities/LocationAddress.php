<?php
/**
 * Name:
 * Location:
 *
 * @author     Jessie Green <jessie.winslows@gmail.com>
 * @copyright  2012 Winslows inc.
 * @version    Release: @package_version@
 */
namespace Entities;
/** 
 * @Entity (repositoryClass="Repositories\LocationAddress") 
 * @Table(name="location_addresses") 
 */

class LocationAddress extends Address
{
    /** 
     * @OneToOne(targetEntity="Location", inversedBy="LocationAddress")
     */     
    private $Location;
    
    /**
     * Add Location to address.
     * @param Location $Location
     */
    public function setLocation(Location $Location)
    {
        $this->Location = $Location;
    }
    
    /**
     * Retrieve address's associated location.
     */
    public function getLocation()
    {
	return $this->Location;
    }
    
    public function populate(array $array){
	foreach ($array as $key => $value) {
	    if(property_exists($this, $key)){
		$this->$key = $value;
	    }
	}
    }
}