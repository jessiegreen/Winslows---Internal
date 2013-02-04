<?php
namespace Entities\Company;

use Doctrine\Common\Collections\ArrayCollection;

/**
 * @Entity (repositoryClass="Repositories\Company\Dealer") 
 * @Crud\Entity\Url(value="dealer")
 * @Crud\Entity\Permissions(view={"Admin"}, edit={"Admin"}, create={"Admin"}, delete={"Admin"})
 * @Table(name="company_dealers")
 * @HasLifecycleCallbacks
 */
class Dealer extends \Dataservice_Doctrine_Entity
{
    /**
     * @Id @Column(type="integer")
     * @GeneratedValue(strategy="AUTO")
     * @var integer $id
     */
    protected $id;
    
    /** 
     * @Column(type="string", length=255) 
     * @var string $name
     */
    protected $name;
    
    /** 
     * @Column(type="string", length=255) 
     * @var string $dba
     */
    protected $dba;
    
    /** 
     * @Column(type="string", length=255) 
     * @var string $name_index
     */
    protected $name_index;
    
    /** 
     * @Column(type="string", length=50000)
     * @var string $description
     */
    protected $description;
    
    /** 
     * @ManyToOne(targetEntity="\Entities\Company", inversedBy="Dealers")
     * @Crud\Relationship\Permissions()
     * @var \Entities\Company $Company
     */  
    protected $Company;
    
    /**
     * Bidirectional - One-To-Many (INVERSE SIDE)
     *
     * @OneToMany(targetEntity="\Entities\Company\Dealer\Location", mappedBy="Dealer", cascade={"persist"})
     * @Crud\Relationship\Permissions(add={"Admin"}, remove={"Admin"})
     * @var ArrayCollection $Locations
     */
    protected $Locations;
    
    public function __construct()
    {
	$this->Locations = new ArrayCollection();
	
	parent::__construct();
    }
    
    public function setCompany(\Entities\Company $Company)
    {
	$this->Company = $Company;
    }
    
    /**
     * @return \Entities\Company
     */
    public function getCompany()
    {
	return $this->Company;
    }
    
    /**
     * @return ArrayCollection
     */
    public function getLocations()
    {
	return $this->Locations;
    }
    
    /**
     * @param \Entities\Company\Dealer\Location $Location
     */
    public function addLocation(\Entities\Company\Dealer\Location $Location)
    {
	$Location->setDealer($this);
	$this->Locations[] = $Location;
    }
    
    /**
     * @param \Entities\Company\Dealer\Location $Location
     */
    public function removeLocation(\Entities\Company\Dealer\Location $Location)
    {
	$this->getApplications()->removeElement($Location);
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
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param type $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }
    
    /**
     * @return string
     */
    public function getDba()
    {
        return $this->dba;
    }

    /**
     * @param string $dba
     */
    public function setDba($dba)
    {
        $this->dba = $dba;
    }
    
    /**
     * @return string
     */
    public function getNameIndex()
    {
        return $this->name_index;
    }

    /**
     * @param string $name_index
     */
    public function setNameIndex($name_index)
    {
        $this->name_index = $name_index;
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
     * @return string
     */
    public function toString()
    {
	return $this->getName();
    }
    
    public function populate(array $array)
    {
	$Company = $this->_getEntityFromArray($array, "Entities\Company", "company_id");
	
	if($Company)$this->setCompany($Company);
	
	parent::populate($array);
    }
}