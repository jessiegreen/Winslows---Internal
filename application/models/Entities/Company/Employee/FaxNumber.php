<?php
namespace Entities\Company\Employee;
/** 
 * @Entity (repositoryClass="Repositories\Company\Employee\FaxNumber") 
 * @Crud\Entity\Url(value="employee-fax-number")
 * @Crud\Entity\Permissions(view={"Admin"}, edit={"Admin"}, create={"Admin"}, delete={"Admin"})
 * @Table(name="company_employee_fax_numbers") 
 */

class FaxNumber extends \Entities\Company\FaxNumber\FaxNumberAbstract
{
    /** 
     * @ManyToOne(targetEntity="\Entities\Company\Employee", inversedBy="FaxNumbers")
     * @Crud\Relationship\Permissions()
     * @var \Entities\Company\Employee
     */     
    protected $Employee;
    
    /**
     * @param \Entities\Company\Employee $Employee
     */
    public function setEmployee(\Entities\Company\Employee $Employee)
    {
        $this->Employee = $Employee;
    }
    
    /**
     * @return \Entities\Company\Employee 
     */
    public function getEmployee()
    {
	return $this->Employee;
    }
    
    public function populate(array $array)
    {
	$Employee = $this->_getEntityFromArray($array, "Entities\Company\Employee", "employee_id");
	
	if($Employee)$this->setEmployee($Employee);
	
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
