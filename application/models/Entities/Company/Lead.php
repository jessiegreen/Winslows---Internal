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
use Entities\Person as Person;
use Doctrine\Common\Collections\ArrayCollection;
/** 
 * @Entity (repositoryClass="Repositories\Company\Lead") 
 * @Table(name="company_leads") 
 */
class Lead extends Person
{
    /** 
     * @ManyToOne(targetEntity="Employee", inversedBy="Leads")
     * @var \Entities\Company\Location\Employee $Employee
     */     
    protected $Employee;
    
    /**
     * Bidirectional - One-To-Many (INVERSE SIDE)
     *
     * @OneToMany(targetEntity="Company\Lead\Contact", mappedBy="Lead", cascade={"persist"})
     * @var array $Contacts
     */
    protected $Contacts;
    
    /**
     * Bidirectional - One-To-Many (INVERSE SIDE)
     *
     * @OneToMany(targetEntity="Company\Lead", mappedBy="Employee", cascade={"persist"})
     * @var array $Leads
     */
    protected $Leads;
    
    /**
     * Bidirectional - One-To-Many (INVERSE SIDE)
     *
     * @OneToMany(targetEntity="Company\Lead\Quote", mappedBy="Lead", cascade={"persist"})
     * @var array $Quotes
     */
    protected $Quotes;
    
    public function __construct()
    {
	$this->Contacts = new ArrayCollection();
	$this->Quotes	= new ArrayCollection();
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
    public function getContacts(){
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
     * @return \Entities\Company\Location\Employee
     */
    public function getEmployee()
    {
        return $this->Employee;
    }

    /**
     * @param \Entities\Company\Location\Employee $Employee
     */
    public function setEmployee(Location\Employee $Employee)
    {
        $this->Employee = $Employee;
    } 
    
    /**
     * @return array
     */
    public function getContactOptionsArray()
    {
	return array();
    }
    
    public function populate(array $array)
    {
	foreach ($array as $key => $value) 
	{
	    if(property_exists($this, $key))
	    {
		$this->$key = $value;
	    }
	}
    }
}