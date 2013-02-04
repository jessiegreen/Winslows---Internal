<?php
namespace Entities\Company\Location;

/** 
 * @Entity (repositoryClass="Repositories\Company\Location\Address") 
 * @Crud\Entity\Url(value="location-address")
 * @Crud\Entity\Permissions(view={"Admin"}, edit={"Admin"}, create={"Admin"}, delete={"Admin"})
 * @Table(name="company_location_addresses") 
 */
class Address extends \Entities\Company\Address\AddressAbstract
{
    /** 
     * @OneToOne(targetEntity="\Entities\Company\Location", inversedBy="Address")
     * @Crud\Relationship\Permissions()
     * @var \Entities\Company\Location $Location 
     */     
    protected $Location;
    
    /**
     * Add Location to address.
     * @param \Entities\Company\Location $Location
     */
    public function setLocation(\Entities\Company\Location $Location)
    {
        $this->Location = $Location;
    }
    
    /**
     * @return \Entities\Company\Location
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