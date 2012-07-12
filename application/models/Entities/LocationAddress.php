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
 * @Table(name="locationaddress") 
 */

class LocationAddress extends Address
{
    /** 
     * @OneToOne(targetEntity="Location", inversedBy="locationaddress")
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
}

?>
