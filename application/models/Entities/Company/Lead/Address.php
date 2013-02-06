<?php
namespace Entities\Company\Lead;

/** 
 * @Entity (repositoryClass="Repositories\Company\Lead\Address") 
 * @Crud\Entity\Url(value="lead-address")
 * @Crud\Entity\Permissions(view={"Admin"}, edit={"Admin"}, create={"Admin"}, delete={"Admin"})
 * @Table(name="company_lead_addresses") 
 */
class Address extends \Entities\Company\Address\AddressAbstract
{
    /** 
     * @ManyToOne(targetEntity="\Entities\Company\Lead", inversedBy="Addresses")
     * @Crud\Relationship\Permissions()
     * @var \Entities\Company\Lead
     */     
    protected $Lead;
    
    /**
     * @param \Entities\Company\Lead $Lead
     */
    public function setLead(\Entities\Company\Lead $Lead)
    {
        $this->Lead = $Lead;
    }
    
    /**
     * @return \Entities\Company\Lead 
     */
    public function getLead()
    {
	return $this->Lead;
    }
    
    public function populate(array $array)
    {
	$Lead = $this->_getEntityFromArray($array, "Entities\Company\Lead", "lead_id");
	
	if($Lead)$this->setLead($Lead);
	
	parent::populate($array);
    }
}
