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
	
	if(isset($array["phone_number"]))
	{
	    if(isset($array["phone_number"]["area"]))
		$this->setAreaCode($array["phone_number"]["area"]);
	    
	    if(isset($array["phone_number"]["prefix"]))
		$this->setNum1($array["phone_number"]["prefix"]);
	    
	    if(isset($array["phone_number"]["line"]))
		$this->setNum2($array["phone_number"]["line"]);
	}
	
	parent::populate($array);
    }
}
