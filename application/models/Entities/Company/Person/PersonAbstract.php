<?php
namespace Entities\Company\Person;

use Doctrine\Common\Collections\ArrayCollection;

/** 
 * @Entity (repositoryClass="Repositories\Company\Person\PersonAbstract") 
 * @Table(name="company_person_personabstracts") 
 * @InheritanceType("JOINED")
 * @DiscriminatorColumn(name="discr", type="string")
 * @DiscriminatorMap({
 *			"company_employee" = "\Entities\Company\Employee",
 *			"company_lead" = "\Entities\Company\Lead",
 * *			"company_website_guest" = "\Entities\Company\Website\Guest"
 *		    })
 * @HasLifecycleCallbacks
 * @Crud\Entity\Url()
 * @Crud\Entity\Permissions(view={"Admin"}, edit={"Admin"}, create={"Admin"}, delete={"Admin"})
 */
abstract class PersonAbstract extends \Dataservice_Doctrine_Entity
{
    const TYPE_Employee	    = "Employee";
    const TYPE_Lead	    = "Lead";
    const TYPE_Guest	    = "Guest";
    
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
     * @OneToMany(targetEntity="\Entities\Company\Person\Document", mappedBy="Person", cascade={"persist", "remove"}, orphanRemoval=true)
     * @var ArrayCollection $Documents
     */
    protected $Documents;
    
    /**
     * @ManytoMany(targetEntity="\Entities\Company\ContactLog\Contact", mappedBy="People", cascade={"persist"})
     * @var array $Contacts
     * @Crud\Relationship\Permissions(add={"Admin"}, remove={"Admin"})
     * @OrderBy({"datetime" = "ASC"})
     */
    protected $Contacts;

    public function __construct()
    {
	$this->Documents = new ArrayCollection();
      
	parent::__construct();
    }
    
    /**
     * Add person document to person.
     * @param \Entities\Company\Person\Document $Document
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
    
    public function toString()
    {
	return $this->getFullName();
    }
    
    /**
     * @param \Entities\Company\ContactLog\Contact $Contact
     */
    public function addContact(\Entities\Company\ContactLog\Contact $Contact)
    {
	$this->Contacts[] = $Contact;
    }
    
    /**
     * @return ArrayCollection
     */
    public function getContacts()
    {
	return $this->Contacts;
    }
    
    public function getDescriminator()
    {
	return "";
    }
}