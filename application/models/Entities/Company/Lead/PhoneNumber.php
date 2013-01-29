<?php
namespace Entities\Company\Lead;
/** 
 * @Entity (repositoryClass="Repositories\Company\Lead\PhoneNumber") 
 * @Crud\Entity\Url(value="lead-phone-number")
 * @Crud\Entity\Permissions(view={"Admin"}, edit={"Admin"}, create={"Admin"}, delete={"Admin"})
 * @Table(name="company_lead_phone_numbers") 
 */

class PhoneNumber extends \Entities\Company\PhoneNumber\PhoneNumberAbstract
{
    /** 
     * @ManyToOne(targetEntity="\Entities\Company\Lead", inversedBy="PhoneNumbers")
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
}
