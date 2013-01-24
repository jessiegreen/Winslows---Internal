<?php

namespace Entities\Company;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * @Entity (repositoryClass="Repositories\Company\Location") 
 * @Table(name="company_locations")
 * @Crud\Entity\Url(value="location")
 * @Crud\Entity\Permissions(view={"Admin"}, edit={"Admin"}, create={"Admin"}, delete={"Admin"})
 * @HasLifecycleCallbacks
 */
class Location extends \Entities\Location\LocationAbstract
{
    /** 
     * @ManyToOne(targetEntity="\Entities\Company", inversedBy="Locations")
     * @var \Entities\Company
     */     
    protected $Company;
    
    /**
     * Bidirectional - One-To-Many (INVERSE SIDE)
     *
     * @OneToMany(targetEntity="\Entities\Company\Employee", mappedBy="Location", cascade={"persist"})
     * @var ArrayCollection $Employees
     */
    protected $Employees;
    
    public function __construct()
    {
	$this->Employees = new ArrayCollection();
	
	parent::__construct();
    }
    
    /**
     * @return \Entities\Company
     */
    public function getCompany()
    {
	return $this->Company;
    }
    
    /**
     * @param \Entities\Company $Company
     */
    public function setCompany(\Entities\Company $Company)
    {
	$this->Company = $Company;
    }
    
    /**
     * @param \Entities\Company\Employee $Employee
     */
    public function addEmployee(\Entities\Company\Employee $Employee)
    {
	$Employee->setLocation($this);
        $this->Employees[] = $Employee;
    }
    
    /**
     * @return ArrayCollection
     */
    public function getEmployees()
    {
	return $this->Employees;
    }
}