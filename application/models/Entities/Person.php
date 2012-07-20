<?php

namespace Entities;
use Doctrine\Common\Collections\ArrayCollection;

/** 
 * @Entity (repositoryClass="Repositories\Person") 
 * @Table(name="people") 
 * @InheritanceType("JOINED")
 * @DiscriminatorColumn(name="discr", type="string")
 * @DiscriminatorMap({"employee" = "Employee", "customer" = "Customer", "lead" = "Lead"})
 * @HasLifecycleCallbacks
 */
class Person
{
    /**
     * @Id @Column(type="integer")
     * @GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /** @Column(type="string", length=255) */
    protected $first_name;
    
    /** @Column(type="string", length=255) */
    protected $middle_name;
    
    /** @Column(type="string", length=255) */
    protected $last_name;
    
    /** @Column(type="string", length=255) */
    protected $suffix;

    /** @Column(type="datetime") */
    protected $created;

    /** @Column(type="datetime") */
    protected $updated;

    /**
     * Bidirectional - One-To-Many (INVERSE SIDE)
     *
     * @OneToMany(targetEntity="PersonAddress", mappedBy="Person", cascade={"persist", "remove"}, orphanRemoval=true)
     */
    protected $PersonAddresses;
    
    /**
     * Bidirectional - One-To-Many (INVERSE SIDE)
     *
     * @OneToMany(targetEntity="PersonDocument", mappedBy="Person", cascade={"persist", "remove"}, orphanRemoval=true)
     */
    protected $PersonDocuments;
    
    /**
     * @OneToMany(targetEntity="PersonPhoneNumber", mappedBy="Person", cascade={"persist", "remove"}, orphanRemoval=true)
     */
    private $PersonPhoneNumbers;
    
    /**
     * @OneToMany(targetEntity="PersonEmailAddress", mappedBy="Person", cascade={"persist", "remove"}, orphanRemoval=true)
     */
    private $PersonEmailAddresses;
    
    /**
     * @OneToOne(targetEntity="WebAccount", mappedBy="Person", cascade={"persist", "remove"}, orphanRemoval=true)
     */
    protected $WebAccount;

    public function __construct()
    {
      $this->PersonAddresses	= new ArrayCollection();
      $this->PersonDocuments	= new ArrayCollection();
      $this->PersonPhoneNumbers	= new ArrayCollection();
      $this->created		= $this->updated = new \DateTime("now");
    }
   
    /**
     * Add address to person.
     * @param Address $address
     */
    public function addPersonAddress(PersonAddress $PersonAddress)
    {
	$PersonAddress->setPerson($this);
        $this->PersonAddresses[] = $PersonAddress;
    }
    
    /**
     * Retrieve person's associated addresses.
     */
    public function getPersonAddresses()
    {
      return $this->PersonAddresses;
    }
    
    /**
     * Add person document to person.
     * @param PersonDocument $address
     */
    public function addPersonDocument(PersonDocument $PersonDocument)
    {
	$PersonDocument->setPerson($this);
        $this->PersonDocuments[] = $PersonDocument;
    }
    
    /**
     * Retrieve person's associated person documents.
     */
    public function getPersonDocuments()
    {
      return $this->PersonDocuments;
    }
    
    public function getAllDocuments(){
	return $this->getPersonDocuments();
    }
    
    /**
     * Add phonenumber to person.
     * @param PhoneNumber $phonenumber
     */
    public function addPersonPhoneNumber(PersonPhoneNumber $PersonPhoneNumber)
    {
	$PersonPhoneNumber->setPerson($this);
        $this->PersonPhoneNumbers[] = $PhoneNumber;
    }
    
    /**
     * Retrieve person's associated phonenumbers.
     */
    public function getPersonPhoneNumbers()
    {
      return $this->PersonPhoneNumbers;
    }
    
    /**
     * Add email to person.
     * @param Emailaddress $EmailAddress
     */
    public function addPersonEmailAddress(PersonEmailAddress $PersonEmailAddress)
    {
	$PersonEmailAddress->setPerson($this);
        $this->PersonEmailAddresses[] = $PersonEmailAddress;
    }
    
    /**
     * Retrieve person's associated email addresses.
     */
    public function getPersonEmailAddresses()
    {
      return $this->PersonEmailAddresses;
    }
    
    /**
     * Get Web Account
     */
    public function getWebAccount() {
	return $this->WebAccount;
    }
    
    public function setWebAccount(WebAccount $WebAccount) {
	$WebAccount->setPerson($this);
	$this->WebAccount = $WebAccount;
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
     * Retrieve person id
     */
    public function getId()
    {
        return $this->id;
    }

    public function getFirstName()
    {
        return $this->first_name;
    }

    public function setFirstName($first_name)
    {
        $this->first_name = $first_name;
    }
    
    public function getLastName()
    {
        return $this->last_name;
    }

    public function setLastName($last_name)
    {
        $this->last_name = $last_name;
    }
    
    public function getMiddleName()
    {
        return $this->middle_name;
    }

    public function setMiddleName($middle_name)
    {
        $this->middle_name = $middle_name;
    }
    
    public function getSuffix()
    {
        return $this->suffix;
    }

    public function setSuffix($suffix)
    {
        $this->suffix = $suffix;
    }
    
    public function getFullName(){
	return $this->getFirstName()." ".$this->getMiddleName()." ".$this->getLastName()." ".$this->getSuffix();
    }

    public function getCreated()
    {
        return $this->created;
    }

    public function setCreated($created)
    {
        $this->created = $created;
    }

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