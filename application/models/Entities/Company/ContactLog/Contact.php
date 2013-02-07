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
     * @Crud\Relationship\Permissions(add={"Admin"}, remove={"Admin"})
     * @OrderBy({"first_name" = "ASC"})
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
    public function addPerson(\Entities\Company\Person\PersonAbstract $Person)
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
        return $this->description;
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
    
    public function populate(array $array)
    {
	$ContactLog = $this->_getEntityFromArray($array, "Entities\Company\ContactLog", "contactlog_id");
	
	if($ContactLog)$this->setContactLog($ContactLog);
	
	if(isset($array["people"]))
	{
	    $people = json_decode($array["people"]);
	    
	    foreach($people as $key => $person)
	    {
		$PersonAbstract = \Services\Company\Entity::factory()->find("Entities\Company\Person\PersonAbstract", $key);
		
		if($PersonAbstract && $PersonAbstract->getId())
		{
		    if(!$this->getPeople()->contains($PersonAbstract))
			$this->addPerson($PersonAbstract);
		}
	    }
	}
	
	if(isset($array["date_time_value"]))
	{
	    $DateTime = \DateTime::createFromFormat("Y-m-d H:i:s", $array["date_time_value"]);

	    if($DateTime)
		$this->setDateTime($DateTime);
	}
	
	parent::populate($array);
    }
    
    public function toString()
    {
	return $this->getDateTime()->format("Y-m-d H:i:s");
    }
}