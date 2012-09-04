<?php
namespace Entities\Company;

use Doctrine\Common\Collections\ArrayCollection;
use Entities\Person\PersonAbstract as PersonAbstract;

/** 
 * @Entity (repositoryClass="Repositories\Company\Employee") 
 * @Table(name="company_employees") 
 */
class Employee extends PersonAbstract
{
    /** 
     * @Column(type="string", length=255) 
     * @var string $title
     */
    protected $title;
    
    /**
     * @ManyToOne(targetEntity="\Entities\Company\Location", inversedBy="Employees")
     * @var \Entities\Company\Location $Location
     */
    protected $Location;
    
    /**
     * @ManyToOne(targetEntity="\Entities\Company", inversedBy="Employees")
     * @var \Entities\Company $Company
     */
    protected $Company;
    
    /**
     * Bidirectional - One-To-Many (INVERSE SIDE)
     *
     * @OneToMany(targetEntity="\Entities\Company\Lead", mappedBy="Employee", cascade={"persist"})
     * @var ArrayCollection $Leads
     */
    protected $Leads;
    
    /**
     * @ManytoMany(targetEntity="\Entities\Company\Employee\Role", cascade={"persist"})
     * @JoinTable(name="company_employee_role_joins")
     * @var ArrayCollection $Roles
     */
    protected $Roles;
    
    /**
     * @OneToOne(targetEntity="\Entities\Company\Employee\Account", mappedBy="Employee", cascade={"persist"}, orphanRemoval=true)
     * @var \Entities\Company\Employee\Account $Account
     */
    protected $Account;
    
    public function __construct()
    {
	$this->Leads	= new ArrayCollection();
	$this->Roles	= new ArrayCollection();
	
	parent::__construct();
    }
    
    /**
     * @return ArrayCollection
     */
    public function getLeads()
    {
	return $this->Leads;
    }
    
    
    /**
     * @param \Entities\Company\Employee\Role $Role
     */
    public function addRole(Employee\Role $Role)
    {
	$Role->addEmployee($this);
        $this->Roles[] = $Role;
    }
    
    /**
     * @param \Entities\Company\Employee\Role $Role
     * @return boolean
     */
    public function removeRole(Employee\Role $Role)
    {
	$this->getRoles()->removeElement($Role);
    }

    /**
     * @return ArrayCollection
     */
    public function getRoles()
    {
	return $this->Roles;
    }
    
    /**
     * @param \Entities\Company\Employee\Role $Role
     * @return boolean
     */
    public function hasRole($Role)
    {
	if($this->getLeads()->contains($Role))
	    return true;
	
	return false;
    }
    
    /** 
     * @return \Entities\Company\Location
     */
    public function getLocation()
    {
	return $this->Location;
    }
    
    /**
     * @param \Entities\Company\Location $Location
     */
    public function setLocation(\Entities\Company\Location $Location)
    {
	$this->Location = $Location;
    }
    
    /** 
     * @return \Entities\Company
     */
    public function getCompany()
    {
	return $this->Company;
    }
    
    /**
     * @param \Entities\Company $Location
     */
    public function setCompany(\Entities\Company $Company)
    {
	$this->Company = $Company;
    }
    
    /** 
     * @return \Entities\Company\Employee\Account
     */
    public function getAccount()
    {
	return $this->Account;
    }
    
    /**
     * @param \Entities\Company\Employee\Account $Account
     */
    public function setAccount(\Entities\Company\Employee\Account $Account)
    {
	$this->Account = $Account;
    }
    
    /**
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @param string $title
     */
    public function setTitle($title)
    {
        $this->title = $title;
    }
}