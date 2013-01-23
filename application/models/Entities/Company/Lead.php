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
     * @OneToMany(targetEntity="\Entities\Company\Lead\Quote", mappedBy="Lead", cascade={"persist", "remove"})
     * @var ArrayCollection $Quotes
     */
    protected $Quotes;
    
    /**
     * Bidirectional - One-To-Many (INVERSE SIDE)
     *
     * @OneToMany(targetEntity="\Entities\Company\RtoProvider\Application", mappedBy="Lead", cascade={"persist", "remove"})
     * @var ArrayCollection $Applications
     */
    protected $Applications;
    
    /** 
     * @OneToOne(targetEntity="\Entities\Company\Lead\Account", inversedBy="Lead")
     * @var \Entities\Company\Lead\Account
     */     
    protected $Account;
    
    /** 
     * @ManyToOne(targetEntity="\Entities\Company", inversedBy="Leads")
     * @var \Entities\Company $Company
     */     
    protected $Company;
    
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
    public function setEmployee(\Entities\Company\Employee $Employee)
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
     * @param string $rto_index
     * @return null | \Entities\Company\RtoProvider\Application
     */
    public function getApplication($rto_index)
    {
	/* @var $Application \Entities\Company\RtoProvider\Application */
	foreach ($this->getApplications() as $Application)
	{
	    /** @var $Application \Entities\Company\RtoProvider\Application */
	    if($Application->getRtoProvider()->getNameIndex() == $rto_index)
		return $Application;
	}
	
	return null;
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
     * @return array
     */
    public function getContactOptionsArray()
    {
	return array();
    }
    
    public function toString()
    {
	return parent::toString()." - ".$this->getEmployee()->getFullName();
    }
}