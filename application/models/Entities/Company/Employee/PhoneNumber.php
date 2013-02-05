<?php
namespace Entities\Company\Employee;
/** 
 * @Entity (repositoryClass="Repositories\Company\Employee\PhoneNumber") 
 * @Crud\Entity\Url(value="employee-phone-number")
 * @Crud\Entity\Permissions(view={"Admin"}, edit={"Admin"}, create={"Admin"}, delete={"Admin"})
 * @Table(name="company_employee_phone_numbers") 
 */

class PhoneNumber extends \Entities\Company\PhoneNumber\PhoneNumberAbstract
{
    /** 
     * @ManyToOne(targetEntity="\Entities\Company\Employee", inversedBy="PhoneNumbers")
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
