<?php

namespace Entities\Person;
use Doctrine\Common\Collections\ArrayCollection;

/** 
 * @Entity (repositoryClass="Repositories\Person\PersonAbstract") 
 * @Table(name="person_personabstracts") 
 * @InheritanceType("JOINED")
 * @DiscriminatorColumn(name="discr", type="string")
 * @DiscriminatorMap({
 *			"company_location_employee" = "\Entities\Company\Location\Employee", 
 *			"company_customer" = "\Entities\Company\Customer", 
 *			"company_lead" = "\Entities\Company\Lead"
 *		    })
 * @HasLifecycleCallbacks
 */
class PersonAbstract
{
    /**
     * @Id @Column(type="integer")
     * @GeneratedValue(strategy="AUTO")
     * @var integer $id
     */
    protected $id;

    /** 
     * @Column(type="string", length=255) 
     * @var string $first_name
     */
    protected $first_name;

    /** 
     * @Column(type="string", length=255) 
     * @var string $middle_name
     */
    protected $middle_name;
    
    /** 
     * @Column(type="string", length=255) 
     * @var string $last_name
     */
    protected $last_name;
    
    /** 
     * @Column(type="string", length=255) 
     * @var string $suffix
     */
    protected $suffix;

    /** 
     * @Column(type="datetime") 
     * @var DateTime $created
     */
    protected $created;

    /** 
     * @Column(type="datetime") 
     * @var DateTime $updated
     */
    protected $updated;

    /**
     * Bidirectional - One-To-Many (INVERSE SIDE)
     *
     * @OneToMany(targetEntity="\Entities\Person\Address", mappedBy="Person", cascade={"persist"}, orphanRemoval=true)
     * @var array
     */
    protected $Addresses;
    
    /**
     * Bidirectional - One-To-Many (INVERSE SIDE)
     *
     * @OneToMany(targetEntity="\Entities\Person\Document", mappedBy="Person", cascade={"persist"}, orphanRemoval=true)
     * @var array
     */
    protected $Documents;
    
    /**
     * @OneToMany(targetEntity="\Entities\Person\PhoneNumber", mappedBy="Person", cascade={"persist"}, orphanRemoval=true)
     */
    private $PhoneNumbers;
    
    /**
     * @OneToMany(targetEntity="\Entities\Person\EmailAddress", mappedBy="Person", cascade={"persist"}, orphanRemoval=true)
     */
    private $EmailAddresses;
    
    /**
     * @OneToOne(targetEntity="\Entities\Website\Account", mappedBy="Person", cascade={"persist"}, orphanRemoval=true)
     * @var \Entities\Website\Account $Account
     */
    protected $Account;

    public function __construct()
    {
      $this->Addresses		= new ArrayCollection();
      $this->Documents		= new ArrayCollection();
      $this->PhoneNumbers	= new ArrayCollection();
      $this->EmailAddresses	= new ArrayCollection();
      $this->created		= $this->updated = new \DateTime("now");
    }
   
    /**
     * Add address to person.
     * @param \Entities\Person\Address $Address
     */
    public function addAddress(Address $Address)
    {
	$Address->setPerson($this);
        $this->Addresses[] = $Address;
    }
    
    /** 
     * @return array
     */
    public function getAddresses()
    {
	return $this->Addresses;
    }
    
    /**
     * Add person document to person.
     * @param \Entities\Person\Document $Document
     */
    public function addDocument(Document $Document)
    {
	$Document->setPerson($this);
        $this->Documents[] = $Document;
    }
    
    /**
     * @return array
     */
    public function getDocuments()
    {
      return $this->Documents;
    }
    
    /**
     * Add phonenumber to person.
     * @param \Entities\Person\PhoneNumber $PhoneNumber
     */
    public function addPhoneNumber(PhoneNumber $PhoneNumber)
    {
	$PhoneNumber->setPerson($this);
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
     * Add email to person.
     * @param \Entities\Person\EmailAddress $EmailAddress
     */
    public function addEmailAddress(EmailAddress $EmailAddress)
    {
	$EmailAddress->setPerson($this);
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
     * @return \Entities\Website\Account
     */
    public function getAccount() {
	return $this->Account;
    }
    
    /**
     * @param \Entities\Website\Account $Account
     */
    public function setAccount(\Entities\Website\Account $Account) {
	$Account->setPerson($this);
	$this->Account = $Account;
    }
    
    public function removeWebAccount(){
	unset($this->WebAccount);
    }

    /**
     * @PreUpdate
     */
    public function updated()
    {
        $this->updated = new \DateTime("now");
    }

    /**
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getFirstName()
    {
        return $this->first_name;
    }

    /**
     * @param string $first_name
     */
    public function setFirstName(string $first_name)
    {
        $this->first_name = $first_name;
    }
    
    /**
     * @return string
     */
    public function getLastName()
    {
        return $this->last_name;
    }

    /**
     * @param string $last_name
     */
    public function setLastName(string $last_name)
    {
        $this->last_name = $last_name;
    }
    
    /**
     * @return string
     */
    public function getMiddleName()
    {
        return $this->middle_name;
    }

    /**
     * @param string $middle_name
     */
    public function setMiddleName(string $middle_name)
    {
        $this->middle_name = $middle_name;
    }
    
    /**
     * @return string
     */
    public function getSuffix()
    {
        return $this->suffix;
    }

    /**
     * @return string
     */
    public function setSuffix(string $suffix)
    {
        $this->suffix = $suffix;
    }
    
    /**
     * @return string
     */
    public function getFullName(){
	return $this->getFirstName()." ".$this->getMiddleName()." ".$this->getLastName()." ".$this->getSuffix();
    }

    /**
     * @return \DateTime
     */
    public function getCreated()
    {
        return $this->created;
    }

    /**
     * @param \DateTime $created
     */
    public function setCreated(\DateTime $created)
    {
        $this->created = $created;
    }

    /**
     * @return \DateTime
     */
    public function getUpdated()
    {
        return $this->updated;
    }

    public function populate(array $array){
	foreach ($array as $key => $value) {
	    if(property_exists($this, $key)){
		$this->$key = $value;
	    }
	}
    }
}