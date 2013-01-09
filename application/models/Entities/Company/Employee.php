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
     * Bidirectional - One-To-Many (INVERSE SIDE)
     *
     * @OneToMany(targetEntity="\Entities\Company\TimeClock\Entry", mappedBy="Employee", cascade={"persist", "remove"})
     * @var ArrayCollection $TimeClockEntries
     */
    protected $TimeClockEntries;
    
    /**
     * @OneToOne(targetEntity="\Entities\Company\Employee\Account", mappedBy="Employee", cascade={"persist"}, orphanRemoval=true)
     * @var \Entities\Company\Employee\Account $Account
     */
    protected $Account;
    
    public function __construct()
    {
	$this->Leads		= new ArrayCollection();
	$this->TimeClockEntries	= new ArrayCollection();
	
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
     * @param \Entities\Company\Lead $Lead
     */
    public function addLead(Lead $Lead)
    {
	$Lead->setEmployee($this);
	
	$this->Leads[] = $Lead;
    }
    
    /**
     * @return ArrayCollection
     */
    public function getAllAllowedLeads()
    {
	return $this->canSeeAllLeads() ? $this->getCompany()->getLeads() : $this->getLeads();
    }
    
    /**
     * @return boolean
     */
    public function canSeeAllLeads()
    {
	return $this->getAccount()->hasRoleByRoleName("Admin") || 
	    $this->getAccount()->hasRoleByRoleName("Sales Manager") ? true : false;	
    }
    
    /**
     * @param \Entities\Company\Lead $Lead
     * @return bool
     */
    public function canSeeLead(Lead $Lead)
    {
	return $this->canSeeAllLeads() || $Lead->getEmployee()->getId() == $this->getId() ? true : false;
    }
    
    /**
     * @param string $term
     * @param integer $count
     * @return array
     */
    public function getAllAllowedLeadsAutocomplete($term, $count = 20)
    {
	$Employee = $this->canSeeAllLeads() ? null : $this;
	
	return \Services\Company\Employee::factory()->getAutocompleteLeadsArrayFromTerm($term, $count, $Employee);
    }
    
    /**
     * @return ArrayCollection
     */
    public function getTimeClockEntries()
    {
	return $this->TimeClockEntries;
    }
    
    /**
     * @param \Entities\Company\TimeClock\Entry $Entry
     */
    public function addTimeClockEntry(TimeClock\Entry $Entry)
    {
	$Entry->setEmployee($this);
	
	$this->TimeClockEntries[] = $Entry;
    }
    
    public function clockInOut()
    {
	\Services\Company\Employee::factory()->clockInOutEmployee($this);
    }
    
    public function getTodaysTimeClockEntries()
    {
	return \Services\Company\Employee::factory()->isEmployeeClockedIn($this);
    }
    
    public function isClockedIn()
    {
	return count($this->getTodaysTimeClockEntries()) % 2 == 0 ? false : true;
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