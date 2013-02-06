<?php
namespace Entities\Company\Lead;

/** 
 * @Entity (repositoryClass="Repositories\Company\Lead\EmailAddress") 
 * @Crud\Entity\Url(value="lead-email-address")
 * @Crud\Entity\Permissions(view={"Admin"}, edit={"Admin"}, create={"Admin"}, delete={"Admin"})
 * @Table(name="company_lead_email_addresses") 
 */
class EmailAddress extends \Entities\Company\EmailAddress\EmailAddressAbstract
{
    /** 
     * @ManyToOne(targetEntity="\Entities\Company\Lead", inversedBy="EmailAddresses")
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
