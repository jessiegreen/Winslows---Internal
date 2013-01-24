<?php
namespace Entities\Company;

use Entities\Person\PersonAbstract as PersonAbstract;
use Doctrine\Common\Collections\ArrayCollection;

/** 
 * @Entity (repositoryClass="Repositories\Company\Lead") 
 * @Crud\Entity\Url(value="lead")
 * @Crud\Entity\Permissions(view={"Admin"}, edit={"Admin"}, create={"Admin"}, delete={"Admin"})
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
     * @OneToMany(targetEntity="\Entities\Company\Lead\Address", mappedBy="Lead", cascade={"persist", "remove"}, orphanRemoval=true)
     * @Crud\Collection\Permissions(add={"Admin"}, remove={"Admin"})
     * @var ArrayCollection $Addresses
     */
    protected $Addresses;
    
    /**
     * @OneToMany(targetEntity="\Entities\Company\Lead\FaxNumber", mappedBy="Lead", cascade={"persist", "remove"}, orphanRemoval=true)
     * @Crud\Collection\Permissions(add={"Admin"}, remove={"Admin"})
     * @var ArrayCollection $FaxNumbers
     */
    protected $FaxNumbers;
    
    /**
     * @OneToMany(targetEntity="\Entities\Company\Lead\PhoneNumber", mappedBy="Lead", cascade={"persist", "remove"}, orphanRemoval=true)
     * @Crud\Collection\Permissions(add={"Admin"}, remove={"Admin"})
     * @var ArrayCollection $PhoneNumbers
     */
    protected $PhoneNumbers;
    
    /**
     * @OneToMany(targetEntity="\Entities\Company\Lead\EmailAddress", mappedBy="Lead", cascade={"persist", "remove"}, orphanRemoval=true)
     * @Crud\Collection\Permissions(add={"Admin"}, remove={"Admin"})
     * @var ArrayCollection $EmailAddresses
     */
    protected $EmailAddresses;
    
    /**
     * Bidirectional - One-To-Many (INVERSE SIDE)
     *
     * @OneToMany(targetEntity="\Entities\Company\Lead\Contact", mappedBy="Lead", cascade={"persist"})
     * @Crud\Collection\Permissions(add={"Admin"}, remove={"Admin"})
     * @var ArrayCollection $Contacts
     */
    protected $Contacts;
    
    /**
     * Bidirectional - One-To-Many (INVERSE SIDE)
     *
     * @OneToMany(targetEntity="\Entities\Company\Lead\Quote", mappedBy="Lead", cascade={"persist", "remove"})
     * @Crud\Collection\Permissions(add={"Admin"}, remove={"Admin"})
     * @var ArrayCollection $Quotes
     */
    protected $Quotes;
    
    /**
     * Bidirectional - One-To-Many (INVERSE SIDE)
     *
     * @OneToMany(targetEntity="\Entities\Company\RtoProvider\Application", mappedBy="Lead", cascade={"persist", "remove"})
     * @Crud\Collection\Permissions(add={"Admin"}, remove={"Admin"})
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
	$this->Addresses	= new ArrayCollection();
	$this->FaxNumbers	= new ArrayCollection();
	$this->PhoneNumbers	= new ArrayCollection();
	$this->EmailAddresses	= new ArrayCollection();
	$this->Contacts		= new ArrayCollection();
	$this->Quotes		= new ArrayCollection();
	$this->Applications	= new ArrayCollection();
	
	parent::__construct();
    }
    
    /**
     * @param Lead\Address $Address
     */
    public function addAddress(Lead\Address $Address)
    {
	$Address->setLead($this);
	
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
     * @param Lead\PhoneNumber $PhoneNumber
     */
    public function addPhoneNumber(Lead\PhoneNumber $PhoneNumber)
    {
	$PhoneNumber->setLead($this);
	
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
     * @param Lead\FaxNumber $FaxNumber
     */
    public function addFaxNumber(Lead\FaxNumber $FaxNumber)
    {
	$FaxNumber->setLead($this);
	
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
     * @param Lead\EmailAddress $EmailAddress
     */
    public function addEmailAddress(Lead\EmailAddress $EmailAddress)
    {
	$EmailAddress->setLead($this);
	
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