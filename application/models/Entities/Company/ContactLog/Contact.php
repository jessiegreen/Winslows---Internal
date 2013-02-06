<?php
namespace Entities\Company\ContactLog;

use \Doctrine\Common\Collections\ArrayCollection;

/** 
 * @Entity(repositoryClass="Repositories\Company\ContactLog\Contact") 
 * @Table(name="company_contactlog_contacts") 
 * @Crud\Entity\Url(value="contact-log-contact")
 * @Crud\Entity\Permissions(view={"Admin"}, edit={"Admin"}, create={"Admin"}, delete={"Admin"})
 */
class Contact extends \Dataservice_Doctrine_Entity
{
    /**
     * @Id @Column(type="integer")
     * @GeneratedValue(strategy="AUTO")
     * @var integer $id
     */
    protected $id;
    
    /** 
     * @Column(type="string", length=1500) 
     * @var string $description
     */
    protected $description;
    
    /** 
     * @Column(type="datetime") 
     * @var \DateTime $updated
     */
    protected $datetime;
    
    /**
     * @ManytoMany(targetEntity="\Entities\Company\Person\PersonAbstract", inversedBy="Contacts", cascade={"persist"})
     * @JoinTable(name="company_contactlog_contact_person_joins")
     * @var array $People
     * @Crud\Relationship\Permissions(add={"Admin"}, remove={"Admin"})
     * @OrderBy({"first_name" = "ASC"})
     */
    protected $People;
    
    /** 
     * @ManyToOne(targetEntity="\Entities\Company\ContactLog\Contact\MediumAbstract", inversedBy="Contacts")
     * @var \Entities\Contact\Medium
     */
    protected $Medium;
    
    /** 
     * @ManyToOne(targetEntity="\Entities\Company\ContactLog", inversedBy="Entries", cascade="persist")
     * @Crud\Relationship\Permissions()
     * @var \Entities\Company\ContactLog $ContactLog
     */
    protected $ContactLog;
    
    public function __construct()
    {
	$this->People = new ArrayCollection();
	
	parent::__construct();
    }
    
    /**
     * @param \Entities\Company\Person\Person\Abstract $Party
     */
    public function addPerson(Person $Person)
    {
	$Person->addContact($this);
	
	$this->People[] = $Person;
    }
    
    /**
     * @return ArrayCollection
     */
    public function getPeople()
    {
	return $this->People;
    }
    
    /**
     * @param \Entities\Company\ContactLog\Contact\Medium $Medium
     */
    public function setMedium(Medium $Medium)
    {
	$this->Medium = $Medium;
    }
    
    /**
     * @return Medium
     */
    public function getMedium()
    {
	return $this->Medium;
    }
    
    /**
     * @param \Entities\Company\ContactLog $ContactLog
     */
    public function setContactLog(\Entities\Company\ContactLog $ContactLog)
    {
	$this->ContactLog = $ContactLog;
    }
    
    /**
     * @return \Entities\Company\ContactLog
     */
    public function getContactLog()
    {
	return $this->ContactLog;
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
    public function getDescription()
    {
        return $this->Description;
    }

    /**
     * @param string $description
     */
    public function setDescription($description)
    {
        $this->description = $description;
    }
    
    /**
     * @return \Dataservice\DateTime
     */
    public function getDateTime()
    {
        return $this->datetime;
    }

    /**
     * @param \DateTime $DateTime
     */
    public function setDateTime(\DateTime $DateTime)
    {
        $this->datetime = $DateTime;
    }
}