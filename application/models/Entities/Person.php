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
     * @OneToMany(targetEntity="PersonAddress", mappedBy="person", cascade={"persist", "remove"}, orphanRemoval=true)
     */
    protected $personaddresses;
    
    /**
     * @ManyToMany(targetEntity="Phonenumber", cascade={"persist", "remove"})
     * @JoinTable(name="person_phonenumbers",
     *      joinColumns={@JoinColumn(name="person_id", referencedColumnName="id")},
     *      inverseJoinColumns={@JoinColumn(name="phonenumber_id", referencedColumnName="id", unique=true)}
     *      )
     */
    private $phonenumbers;
    
    /**
     * @ManyToMany(targetEntity="Emailaddress", cascade={"persist", "remove"})
     * @JoinTable(name="person_emailaddresses",
     *      joinColumns={@JoinColumn(name="person_id", referencedColumnName="id")},
     *      inverseJoinColumns={@JoinColumn(name="emailaddress_id", referencedColumnName="id", unique=true)}
     *      )
     */
    private $emailaddresses;
    
    /**
     * @OneToOne(targetEntity="Webaccount", mappedBy="person", cascade={"persist", "remove"}, orphanRemoval=true)
     */
    protected $webaccount;

    public function __construct()
    {
      $this->personaddresses	= new ArrayCollection();
      $this->phonenumbers	= new ArrayCollection();
      $this->created		= $this->updated = new \DateTime("now");
    }
   
    /**
     * Add address to person.
     * @param Address $address
     */
    public function addPersonAddress(PersonAddress $personaddress)
    {
	$personaddress->setPerson($this);
        $this->personaddresses[] = $personaddress;
    }
    
    /**
     * Retrieve person's associated addresses.
     */
    public function getPersonAddresses()
    {
      return $this->personaddresses;
    }
    
    /**
     * Add phonenumber to person.
     * @param Phonenumber $phonenumber
     */
    public function addPhoneNumber(Phonenumber $Phonenumber)
    {
	//$Phonenumber->setPerson($this);
        $this->phonenumbers[] = $Phonenumber;
    }
    
    /**
     * Retrieve person's associated phonenumbers.
     */
    public function getPhoneNumbers()
    {
      return $this->phonenumbers;
    }
    
    /**
     * Add email to person.
     * @param Emailaddress $EmailAddress
     */
    public function addEmailAddress(Emailaddress $EmailAddress)
    {
	//$Phonenumber->setPerson($this);
        $this->emailaddresses[] = $EmailAddress;
    }
    
    /**
     * Retrieve person's associated email addresses.
     */
    public function getEmailAddresses()
    {
      return $this->emailaddresses;
    }
    
    /**
     * Get Web Account
     */
    public function getWebaccount() {
	return $this->webaccount;
    }
    
    public function setWebaccount(Webaccount $webaccount) {
	$webaccount->setPerson($this);
	$this->webaccount = $webaccount;
    }
    
    public function removeWebaccount(){
	unset($this->webaccount);
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

}