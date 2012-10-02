<?php
/**
 * Name:
 * Location:
 *
 * @author     Jessie Green <jessie.winslows@gmail.com>
 * @copyright  2012 Winslows inc.
 * @version    Release: @package_version@
 */
namespace Entities\Location;
/** 
 * @Entity (repositoryClass="Repositories\Location\Address") 
 * @Table(name="location_addresses") 
 */
class Address extends \Entities\Address\AddressAbstract
{
    /** 
     * @OneToOne(targetEntity="\Entities\Location\LocationAbstract", inversedBy="Address")
     * @var \Entities\Location\LocationAbstract $Location 
     */     
    protected $Location;
    
    /**
     * Add Location to address.
     * @param \Entities\Location\LocationAbstract $Location
     */
    public function setLocation(\Entities\Location\LocationAbstract $Location)
    {
        $this->Location = $Location;
    }
    
    /**
     * @return \Entities\Location\LocationAbstract
     */
    public function getLocation()
    {
	return $this->Location;
    }
}