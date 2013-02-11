<?php
namespace Entities\Company;

use Doctrine\Common\Collections\ArrayCollection;
use Entities\Company\Person\PersonAbstract as PersonAbstract;

/** 
 * @Entity (repositoryClass="Repositories\Company\Employee") 
 * @Crud\Entity\Url(value="employee")
 * @Crud\Entity\Permissions(view={"Admin"}, edit={"Admin"}, create={"Admin"}, delete={"Admin"})
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
     * @Crud\Relationship\Permissions()
     * @var \Entities\Company\Location $Location
     */
    protected $Location;
    
    /**
     * @ManyToOne(targetEntity="\Entities\Company", inversedBy="Employees")
     * @Crud\Relationship\Permissions()
     * @var \Entities\Company $Company
     */
    protected $Company;
    
    /**
     * Bidirectional - One-To-Many (INVERSE SIDE)
     *
     * @OneToMany(targetEntity="\Entities\Company\Employee\Address", mappedBy="Employee", cascade={"persist", "remove"}, orphanRemoval=true)
     * @Crud\Relationship\Permissions(add={"Admin"}, remove={"Admin"})
     * @var ArrayCollection $Addresses
     */
    protected $Addresses;
    
    /**
     * @OneToMany(targetEntity="\Entities\Company\Employee\FaxNumber", mappedBy="Employee", cascade={"persist", "remove"}, orphanRemoval=true)
     * @Crud\Relationship\Permissions(add={"Admin"}, remove={"Admin"})
     * @var ArrayCollection $FaxNumbers
     */
    protected $FaxNumbers;
    
    /**
     * @OneToMany(targetEntity="\Entities\Company\Employee\PhoneNumber", mappedBy="Employee", cascade={"persist", "remove"}, orphanRemoval=true)
     * @Crud\Relationship\Permissions(add={"Admin"}, remove={"Admin"})
     * @var ArrayCollection $PhoneNumbers
     */
    protected $PhoneNumbers;
    
    /**
     * @OneToMany(targetEntity="\Entities\Company\Employee\EmailAddress", mappedBy="Employee", cascade={"persist", "remove"}, orphanRemoval=true)
     * @Crud\Relationship\Permissions(add={"Admin"}, remove={"Admin"})
     * @var ArrayCollection $EmailAddresses
     */
    protected $EmailAddresses;
    
    /**
     * Bidirectional - One-To-Many (INVERSE SIDE)
     *
     * @OneToMany(targetEntity="\Entities\Company\Lead", mappedBy="Employee", cascade={"persist"})
     * @Crud\Relationship\Permissions(add={"Admin"}, remove={"Admin"})
     * @var ArrayCollection $Leads
     */
    protected $Leads;
    
    /**
     * Bidirectional - One-To-Many (INVERSE SIDE)
     *
     * @OneToMany(targetEntity="\Entities\Company\TimeClock\Entry", mappedBy="Employee", cascade={"persist", "remove"})
     * @Crud\Relationship\Permissions(add={"Admin"}, remove={"Admin"})
     * @var ArrayCollection $TimeClockEntries
     */
    protected $TimeClockEntries;
    
    /**
     * @OneToOne(targetEntity="\Entities\Company\Employee\Account", mappedBy="Employee", cascade={"persist", "remove"}, orphanRemoval=true)
     * @Crud\Relationship\Permissions(add={"Admin"}, remove={"Admin"})
     * @var \Entities\Company\Employee\Account $Account
     */
    protected $Account;
    
    public function __construct()
    {
	$this->Addresses	= new ArrayCollection();
	$this->FaxNumbers	= new ArrayCollection();
	$this->PhoneNumbers	= new ArrayCollection();
	$this->EmailAddresses	= new ArrayCollection();
	$this->Leads		= new ArrayCollection();
	$this->TimeClockEntries	= new ArrayCollection();
	
	parent::__construct();
    }
    
    /**
     * @param Employee\Address $Address
     */
    public function addAddress(Employee\Address $Address)
    {
	$Address->setEmployee($this);
	
        $this->Addresses[] = $Address;
    }
    
    /** 
     * @return ArrayCollection
     */
    public function getAddresses()
    {
	return $this->Addresses;
    }
    
    /**
     * @param Employee\PhoneNumber $PhoneNumber
     */
    public function addPhoneNumber(Employee\PhoneNumber $PhoneNumber)
    {
	$PhoneNumber->setEmployee($this);
	
        $this->PhoneNumbers[] = $PhoneNumber;
    }
    
    /**
     * @return array
     */
    public function getPhoneNumbers()
    {
      return $this->PhoneNumbers;
    }
    
    /**
     * @param Employee\FaxNumber $FaxNumber
     */
    public function addFaxNumber(Employee\FaxNumber $FaxNumber)
    {
	$FaxNumber->setEmployee($this);
	
        $this->FaxNumbers[] = $FaxNumber;
    }
    
    /**
     * @return array
     */
    public function getFaxNumbers()
    {
      return $this->FaxNumbers;
    }
    
    /**
     * @param Employee\EmailAddress $EmailAddress
     */
    public function addEmailAddress(Employee\EmailAddress $EmailAddress)
    {
	$EmailAddress->setEmployee($this);
	
        $this->EmailAddresses[] = $EmailAddress;
    }
    
    /**
     * @return array
     */
    public function getEmailAddresses()
    {
	return $this->EmailAddresses;
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
    
    /**
     * @return array
     */
    public function getTodaysTimeClockEntries()
    {
	return \Services\Company\Employee::factory()->getTimeClockEntriesForToday($this);
    }
    
    /**
     * @param \DateTime $StartDate
     * @return array
     */
    public function getWeeksTimeClockEntries(\DateTime $StartDate)
    {
	return \Services\Company\Employee::factory()->getTimeClockEntriesForWeek($this, $StartDate);
    }
    
    /**
     * @param \DateTime $StartDate
     * @return \DateInterval
     */
    public function getWeeksTimeClockTotalTime(\DateTime $StartDate)
    {
	return $this->getTimeClockTotalTime($this->getWeeksTimeClockEntries($StartDate));
    }
    
    /**
     * @return \DateInterval
     */
    public function getTodaysTimeClockTotalTime()
    {
	$TimeEntries = $this->getTodaysTimeClockEntries();
	
	return $this->getTimeClockTotalTime($TimeEntries);
    }
    
    /**
     * @return \DateInterval
     */
    public function getThisWeeksTimeClockTotalTime()
    {
	$TimeEntries = $this->getThisWeeksTimeClockEntries();
	
	return $this->getTimeClockTotalTime($TimeEntries);
    }
    
    /**
     * @return array
     */
    public function getThisWeeksTimeClockEntries()
    {
	$StartDate	= new \DateTime();
	
	if($StartDate->format("l") !== "Saturday")
	    $StartDate = $StartDate->createFromFormat("U", strtotime("last Saturday"));
	
	return $this->getWeeksTimeClockEntries($StartDate);
    }
    
    public function getTimeClockTotalTime($TimeEntries)
    {
	$clocked_in	= false;
	$e		= new \DateTime('00:00');
	$f		= clone $e;
	$Now		= new \DateTime();
	
	/* @var $PreviousEntry \Entities\Company\TimeClock\Entry */
	$PreviousEntry	= null;
	
	/* @var $Entry \Entities\Company\TimeClock\Entry */
	foreach ($TimeEntries as $Entry)
	{
	    #--If there is a previous day and we are moving to the next day
	    if($PreviousEntry && $PreviousEntry->getDateTime()->format("Y-m-d") !== $Entry->getDateTime()->format("Y-m-d"))
	    {
		#--Finalize the previous day if still clocked in
		if($clocked_in)
		{
		    $EndOfDay   = new \DateTime($PreviousEntry->getDateTime()->format("Y-m-d 23:59:59"));
		    $Interval   = $EndOfDay->diff($PreviousEntry->getDateTime(), true);

		    $e->add($Interval);
		    
		    $clocked_in = false;
		}	
	    }
	    
	    if($clocked_in)
	    {
		$Interval = $PreviousEntry->getDateTime()->diff($Entry->getDateTime(), true);
		
		$e->add($Interval);
		
		$clocked_in = false;
	    }
	    else $clocked_in = true;
	    
	    #--Set Current Entry as Previous and set $clocked in status
	    $PreviousEntry  = $Entry;	    
	}
	
	if($clocked_in)
	{
	    $Now	= new \DateTime();
	    $Interval   = $Now->diff($Entry->getDateTime(), true);
	    
	    $e->add($Interval);
	}
	
	return $f->diff($e);
    }
    
    /**
     * @return bool
     */
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
    
    public function toString()
    {
	return $this->getFullName()." - ".($this->getLocation() ? $this->getLocation()->getName() : "")." - ".$this->getTitle();
    }
    
    public function populate(array $array)
    {
	$Company = $this->_getEntityFromArray($array, "Entities\Company", "company_id");
	
	if($Company)$this->setCompany($Company);
	
	parent::populate($array);
    }
    
    public function getDescriminator()
    {
	return self::TYPE_Employee;
    }
}