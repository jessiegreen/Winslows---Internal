<?php
namespace Entities\Company\Lead;

/** 
 * @Entity (repositoryClass="Repositories\Company\Lead\FaxNumber") 
 * @Crud\Entity\Url(value="lead-fax-number")
 * @Crud\Entity\Permissions(view={"Admin"}, edit={"Admin"}, create={"Admin"}, delete={"Admin"})
 * @Table(name="company_lead_fax_numbers") 
 */
class FaxNumber extends \Entities\Company\FaxNumber\FaxNumberAbstract
{
    /** 
     * @ManyToOne(targetEntity="\Entities\Company\Lead", inversedBy="FaxNumbers")
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
	
	if(isset($array["fax_number"]))
	{
	    if(isset($array["fax_number"]["area"]))
		$this->setAreaCode($array["fax_number"]["area"]);
	    
	    if(isset($array["fax_number"]["prefix"]))
		$this->setNum1($array["fax_number"]["prefix"]);
	    
	    if(isset($array["fax_number"]["line"]))
		$this->setNum2($array["fax_number"]["line"]);
	}
	
	parent::populate($array);
    }
}
