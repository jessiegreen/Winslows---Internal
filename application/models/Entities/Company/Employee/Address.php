<?php
namespace Entities\Company\Employee;
/** 
 * @Entity (repositoryClass="Repositories\Company\Employee\Address") 
 * @Crud\Entity\Url(value="employee-address")
 * @Crud\Entity\Permissions(view={"Admin"}, edit={"Admin"}, create={"Admin"}, delete={"Admin"})
 * @Table(name="company_employee_addresses") 
 */

class Address extends \Entities\Company\Address\AddressAbstract
{
    /** 
     * @ManyToOne(targetEntity="\Entities\Company\Employee", inversedBy="Addresses")
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
