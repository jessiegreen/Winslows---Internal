<?php
namespace Entities\Company\Employee;

/** 
 * @Entity (repositoryClass="Repositories\Company\Employee\Account") 
 * @Table(name="company_employee_accounts") 
 */
class Account extends \Entities\Website\Account\AccountAbstract
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
	return $this->Employee;
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
}