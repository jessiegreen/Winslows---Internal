<?php
namespace Entities\Company\Employee;
/** 
 * @Entity (repositoryClass="Repositories\Company\Employee\EmailAddress") 
 * @Crud\Entity\Url(value="employee-email-address")
 * @Crud\Entity\Permissions(view={"Admin"}, edit={"Admin"}, create={"Admin"}, delete={"Admin"})
 * @Table(name="company_employee_email_addresses") 
 */

class EmailAddress extends \Entities\Company\EmailAddress\EmailAddressAbstract
{
    /** 
     * @ManyToOne(targetEntity="\Entities\Company\Employee", inversedBy="EmailAddresses")
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
	
	parent::populate($array);
    }
}
