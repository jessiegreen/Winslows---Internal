<?php
namespace Entities\Company;

use \Doctrine\Common\Collections\ArrayCollection;

/** 
 * @Entity(repositoryClass="Repositories\Company\Contact") 
 * @Table(name="company_contacts") 
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
     * @ManytoMany(targetEntity="\Entities\Company\Person\PersonAbstract", mappedBy="Contacts", cascade={"persist"})
     * @var array $People
     * @Crud\Collection\Permissions(add={"Admin"}, remove={"Admin"})
     * @OrderBy({"first_name" = "ASC"})
     */
    protected $People;
    
    /** 
     * @ManyToOne(targetEntity="\Entities\Company\Contact\MediumAbstract", inversedBy="Contacts")
     * @var \Entities\Contact\Medium
     */
    protected $Medium;
    
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
     * @param \Entities\Company\Contact\Medium $Medium
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