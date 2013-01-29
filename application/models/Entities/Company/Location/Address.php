<?php
namespace Entities\Company\Location;

/** 
 * @Entity (repositoryClass="Repositories\Company\Location\Address") 
 * @Table(name="company_location_addresses") 
 */
class Address extends \Entities\Company\Address\AddressAbstract
{
    /** 
     * @OneToOne(targetEntity="\Entities\Company\Location\LocationAbstract", inversedBy="Address")
     * @var \Entities\Company\Location\LocationAbstract $Location 
     */     
    protected $Location;
    
    /**
     * Add Location to address.
     * @param \Entities\Company\Location\LocationAbstract $Location
     */
    public function setLocation(\Entities\Company\Location\LocationAbstract $Location)
    {
        $this->Location = $Location;
    }
    
    /**
     * @return \Entities\Company\Location\LocationAbstract
     */
    public function getLocation()
    {
	return $this->Location;
    }
}