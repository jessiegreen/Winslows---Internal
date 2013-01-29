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
}
