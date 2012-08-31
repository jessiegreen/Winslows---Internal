<?php
namespace Entities\Company\Employee;

use Doctrine\Common\Collections\ArrayCollection;

/** 
 * @Entity (repositoryClass="Repositories\Company\Employee\Role") 
 * @Table(name="company_employee_roles") 
 */
class Role extends \Entities\Role\RoleAbstract
{
    /**
     * @ManytoMany(targetEntity="\Entities\Company\Employee", mappedBy="Roles", cascade={"persist"})
     * @var ArrayCollection $Employees
     */
    private $Employees;
    
    public function __construct()
    {
	$this->Employees = new ArrayCollection();
	
	parent::__construct();
    }
    
    /**
     * @param \Entities\Company\Employee $Employee
     */
    public function addEmployee(\Entities\Company\Employee $Employee)
    {
        $this->Employees[] = $Employee;
    }
    
    /**
     * @return ArrayCollection
     */
    public function getEmployees()
    {
	return $this->Employees;
    }
    
    /**
     * @param \Entities\Company\Employee $Employee
     */
    public function removeEmployee(\Entities\Company\Employee $Employee)
    {
	$Employee->removeRole($this);
	$this->Employees->removeElement($Employee);
    }
}