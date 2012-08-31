<?php
/**
 * Name:
 * Location:
 *
 * Description for class (if any)...
 *
 * @author     Jessie Green <jessie.winslows@gmail.com>
 * @copyright  2012 Winslows inc.
 * @version    Release: @package_version@
 */
namespace Entities\Company;

use Entities\Person\PersonAbstract as PersonAbstract;
use Doctrine\Common\Collections\ArrayCollection;

/** 
 * @Entity (repositoryClass="Repositories\Company\Lead") 
 * @Table(name="company_leads") 
 */
class Lead extends PersonAbstract
{
    /** 
     * @ManyToOne(targetEntity="\Entities\Company\Employee", inversedBy="Leads")
     * @var \Entities\Company\Employee $Employee
     */     
    protected $Employee;
    
    /**
     * Bidirectional - One-To-Many (INVERSE SIDE)
     *
     * @OneToMany(targetEntity="\Entities\Company\Lead\Contact", mappedBy="Lead", cascade={"persist"})
     * @var ArrayCollection $Contacts
     */
    protected $Contacts;
    
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
     * @OneToMany(targetEntity="\Entities\Company\Lead\Quote", mappedBy="Lead", cascade={"persist"})
     * @var ArrayCollection $Quotes
     */
    protected $Quotes;
    
    /**
     * Bidirectional - One-To-Many (INVERSE SIDE)
     *
     * @OneToMany(targetEntity="\Entities\Company\RtoProvider\Application", mappedBy="Lead", cascade={"persist"})
     * @var ArrayCollection $Applications
     */
    private $Applications;
    
    /** 
     * @OneToOne(targetEntity="\Entities\Company\Lead\Account", inversedBy="Lead")
     * @var \Entities\Company\Lead\Account
     */     
    private $Account;
    
    public function __construct()
    {
	$this->Contacts	    = new ArrayCollection();
	$this->Quotes	    = new ArrayCollection();
	$this->Applications = new ArrayCollection();
	
	parent::__construct();
    }
    
    /**
     * @param \Entities\Company\Lead\Contact $Contact
     */
    public function AddContact(Lead\Contact $Contact)
    {
	$Contact->setLead($this);
	$this->Contacts[] = $Contact;
    }
    
    /**
     * @return array
     */
    public function getContacts()
    {
	return $this->Contacts;
    }
    
    /**
     * @param \Entities\Company\Lead\Quote $Quote
     */
    public function AddQuote(Lead\Quote $Quote)
    {
	$Quote->setLead($this);
	$this->Quotes[] = $Quote;
    }
    
    /**
     * @return array
     */
    public function getQuotes()
    {
	return $this->Quotes;
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
    public function setEmployee(Location\Employee $Employee)
    {
        $this->Employee = $Employee;
    }
    
    /**
     * @return ArrayCollection
     */
    public function getApplications()
    {
	return $this->Applications;
    }
    
    /** 
     * @return \Entities\Company\Lead\Account
     */
    public function getAccount()
    {
	return $this->Account;
    }
    
    /**
     * @param \Entities\Company\Lead\Account $Account
     */
    public function setAccount(\Entities\Company\Lead\Account $Account)
    {
	$this->Account = $Account;
    }
    
    /**
     * @return array
     */
    public function getContactOptionsArray()
    {
	return array();
    }
}