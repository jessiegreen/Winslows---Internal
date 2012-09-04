<?php

namespace Entities\Person;
use Doctrine\Common\Collections\ArrayCollection;

/** 
 * @Entity (repositoryClass="Repositories\Person\PersonAbstract") 
 * @Table(name="person_personabstracts") 
 * @InheritanceType("JOINED")
 * @DiscriminatorColumn(name="discr", type="string")
 * @DiscriminatorMap({
 *			"company_employee" = "\Entities\Company\Employee",
 *			"company_lead" = "\Entities\Company\Lead",
 *			"person_personabstract" = "\Entities\Person\PersonAbstract"
 *		    })
 * @HasLifecycleCallbacks
 */
class PersonAbstract extends \Dataservice_Doctrine_Entity
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
     * Bidirectional - One-To-Many (INVERSE SIDE)
     *
     * @OneToMany(targetEntity="\Entities\Person\Address", mappedBy="Person", cascade={"persist"}, orphanRemoval=true)
     * @var ArrayCollection $Addresses
     */
    protected $Addresses;
    
    /**
     * Bidirectional - One-To-Many (INVERSE SIDE)
     *
     * @OneToMany(targetEntity="\Entities\Person\Document", mappedBy="Person", cascade={"persist"}, orphanRemoval=true)
     * @var ArrayCollection $Documents
     */
    protected $Documents;
    
    /**
     * @OneToMany(targetEntity="\Entities\Person\PhoneNumber", mappedBy="Person", cascade={"persist"}, orphanRemoval=true)
     * @var ArrayCollection $PhoneNumbers
     */
    protected $PhoneNumbers;
    
    /**
     * @OneToMany(targetEntity="\Entities\Person\EmailAddress", mappedBy="Person", cascade={"persist"}, orphanRemoval=true)
     * @var ArrayCollection $EmailAddresses
     */
    protected $EmailAddresses;

    public function __construct()
    {
	$this->Addresses	= new ArrayCollection();
	$this->Documents	= new ArrayCollection();
	$this->PhoneNumbers	= new ArrayCollection();
	$this->EmailAddresses	= new ArrayCollection();
      
	parent::__construct();
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
    public function setFirstName($first_name)
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
    public function setLastName($last_name)
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
    public function setMiddleName($middle_name)
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
    public function setSuffix($suffix)
    {
        $this->suffix = $suffix;
    }
    
    /**
     * @return string
     */
    public function getFullName()
    {
	return $this->getFirstName()." ".$this->getMiddleName()." ".$this->getLastName()." ".$this->getSuffix();
    }
}