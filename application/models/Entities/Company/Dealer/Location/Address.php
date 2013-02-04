<?php
namespace Entities\Company\Dealer\Location;

/** 
 * @Entity (repositoryClass="Repositories\Company\Dealer\Location\Address") 
 * @Crud\Entity\Url(value="dealer-location-address")
 * @Crud\Entity\Permissions(view={"Admin"}, edit={"Admin"}, create={"Admin"}, delete={"Admin"})
 * @Table(name="company_dealer_location_addresses") 
 */
class Address extends \Entities\Company\Address\AddressAbstract
{
    /** 
     * @OneToOne(targetEntity="\Entities\Company\Dealer\Location", inversedBy="Address")
     * @Crud\Relationship\Permissions()
     * @var \Entities\Company\Dealer\Location $Location 
     */     
    protected $Location;
    
    /**
     * Add Location to address.
     * @param \Entities\Company\Dealer\Location $Location
     */
    public function setLocation(\Entities\Company\Dealer\Location $Location)
    {
        $this->Location = $Location;
    }
    
    /**
     * @return \Entities\Company\Dealer\Location
     */
    public function getLocation()
    {
	return $this->Location;
    }
    
    public function populate(array $array)
    {
	$Location = $this->_getEntityFromArray($array, "Entities\Company\Dealer\Location", "location_id");
	
	if($Location)$this->setLocation($Location);
	
	parent::populate($array);
    }
}