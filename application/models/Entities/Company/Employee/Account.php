<?php
namespace Entities\Company\Employee;

class Account extends \Entities\Company\Website\Account\AccountAbstract
{
    /**
     * @OneToOne(targetEntity="\Entities\Company\Employee", inversedBy="Account", cascade={"persist"})
     * @var \Entities\Company\Employee $Employee
     */
    private $Employee;
    
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
}