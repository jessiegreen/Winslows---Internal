<?php
namespace Entities\Company\Employee;

/** 
 * @Entity (repositoryClass="Repositories\Company\Employee\Account") 
 * @Crud\Entity\Url(value="employee-account")
 * @Crud\Entity\Permissions(view={"Admin", "Manager"}, edit={"Admin"}, create={"Admin"}, delete={"Admin"})
 * @Table(name="company_employee_accounts") 
 */
class Account extends \Entities\Company\Website\Account\AccountAbstract
{
    /**
     * @OneToOne(targetEntity="\Entities\Company\Employee", inversedBy="Account", cascade={"persist"})
     * @var \Entities\Company\Employee $Employee
     */
    protected $Employee;
    
    /**
     * @return \Entities\Company\Employee
     */
    public function getPerson()
    {
	return $this->getEmployee();
    }
    
    /**
     * @return \Entities\Company\Employee
     */
    public function getEmployee()
    {
	return $this->Employee;
    }
    
    /**
     * @param \Entities\Company\Employee $Employee
     */
    public function setEmployee(\Entities\Company\Employee $Employee)
    {
	$this->Employee = $Employee;
    }
    
    public function getDescriminator()
    {
	return self::TYPE_Employee;
    }
    
    public function toString()
    {
	return $this->getWebsite()->getName()." - ".$this->getUsername();
    }
}