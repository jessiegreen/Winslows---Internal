<?php
namespace Entities\Company;

use Doctrine\Common\Collections\ArrayCollection;

/**
 * @Entity (repositoryClass="Repositories\Company\RtoProvider") 
 * @Table(name="company_rtoproviders")
 * @Crud\Entity\Url(value="rto-provider")
 * @Crud\Entity\Permissions(view={"Admin"}, edit={"Admin"}, create={"Admin"}, delete={"Admin"})
 * @HasLifecycleCallbacks
 */
class RtoProvider extends \Dataservice_Doctrine_Entity
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
     * @Column(type="integer", length=3) 
     * @var int $minimum_points
     */
    protected $minimum_points;
    
    /** 
     * @Column(type="string", length=50000)
     * @var string $description
     */
    protected $description;
    
    /** 
     * @ManyToOne(targetEntity="\Entities\Company", inversedBy="RtoProviders")
     * @Crud\Relationship\Permissions()
     * @var \Entities\Company $Company
     */  
    protected $Company;
    
    /**
     * Bidirectional - One-To-Many (INVERSE SIDE)
     *
     * @OneToMany(targetEntity="\Entities\Company\RtoProvider\Application", mappedBy="RtoProvider", cascade={"persist"})
     * @Crud\Relationship\Permissions(add={"Admin"}, remove={"Admin"})
     * @var ArrayCollection $Applications
     */
    protected $Applications;
    
    /**
     * Bidirectional - One-To-Many (INVERSE SIDE)
     *
     * @OneToMany(targetEntity="\Entities\Company\RtoProvider\Fee\FeeAbstract", mappedBy="RtoProvider", cascade={"persist", "remove"}, orphanRemoval=true)
     * @Crud\Relationship\Permissions(add={"Admin"}, remove={"Admin"})
     * @var \Doctrine\Common\Collections\ArrayCollection $Fees
     */
    protected $Fees;
    
    /**
     * Bidirectional - One-To-Many (INVERSE SIDE)
     *
     * @OneToMany(targetEntity="\Entities\Company\RtoProvider\Program", mappedBy="RtoProvider", cascade={"persist"})
     * @Crud\Relationship\Permissions(add={"Admin"}, remove={"Admin"})
     * @var ArrayCollection $Programs
     */
    protected $Programs;
    
    public function __construct()
    {
	$this->Products	    = new ArrayCollection();
	$this->Applications = new ArrayCollection();
	$this->Programs	    = new ArrayCollection();
	$this->Fees	    = new ArrayCollection();
	
	parent::__construct();
    }
    
    /**
     * @param \Entities\Company $Company
     */
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
    public function getPrograms()
    {
	return $this->Programs;
    }
    
    /**
     * @param RtoProvider\Program $Application
     */
    public function addProgram(RtoProvider\Program $Program)
    {
	$Program->setRtoProvider($this);
	
	$this->Programs[] = $Program;
    }
    
    /**
     * @param RtoProvider\Program $Program
     */
    public function removeProgram(RtoProvider\Program $Program)
    {
	$this->getPrograms()->removeElement($Program);
    }
    
    /**
     * @return ArrayCollection
     */
    public function getFees()
    {
	return $this->Fees;
    }
    
    /**
     * @param RtoProvider\Fee\FeeAbstract $Fee
     */
    public function addFee(RtoProvider\Fee\FeeAbstract $Fee)
    {
	$Fee->setRtoProvider($this);
	
	$this->Fees[] = $Fee;
    }
    
    /**
     * @param RtoProvider\Fee\FeeAbstract $Fee
     */
    public function removeFee(RtoProvider\Fee\FeeAbstract $Fee)
    {
	$this->getFees()->removeElement($Fee);
    }
    
    /**
     * @return ArrayCollection
     */
    public function getApplications()
    {
	return $this->Applications;
    }
    
    /**
     * @param \Entities\Company\RtoProvider\Application $Application
     */
    public function addApplication(RtoProvider\Application $Application)
    {
	$Application->setRtoProvider($this);
	$this->Applications[] = $Application;
    }
    
    /**
     * @param \Entities\Company\RtoProvider\Application $Application
     */
    public function removeApplication(RtoProvider\Application $Application)
    {
	$this->getApplications()->removeElement($Application);
    }
    
    /**
     * @param \Entities\Company\Lead $Lead
     * @param \Entities\Company\RtoProvider\Application $Application
     * @return boolean
     */
    public function hasLeadApplication(\Entities\Company\Lead $Lead)
    {
	if($this->getApplications()->exists(
	    /* @var $Application \Entities\Company\RtoProvider\Application */
	    function($key, $Application) use ($Lead) 
	    {
		if(
		    $Application->getLead()->getId() === $Lead->getId()
		)
		    return true;
		else return false;
	    }
	))return true;
	else return false;
    }
    
    /**
     * @param \Entities\Company\Lead $Lead
     * @param \Entities\Company\RtoProvider\Application $Application
     * @return boolean
     */
    public function isApproved(\Entities\Company\Lead $Lead)
    {
	$LeadApplications = $this->getApplications()->filter(
				/* @var $Application \Entities\Company\RtoProvider\Application */
				function($key, $Application) use ($Lead) 
				{
				    if(
					$Application->getLead()->getId() === $Lead->getId()
				    )
					return true;
				    else return false;
				}
			    );
			    
	if($LeadApplications->count() > 0)
	{
	    return $LeadApplications->first()->isApproved();
	}
	
	return false;
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
     * @return int
     */
    public function getMinimumPoints()
    {
        return $this->minimum_points;
    }

    /**
     * @param int $minimum_points
     */
    public function setMinimumPoints($minimum_points)
    {
        $this->minimum_points = $minimum_points;
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
	
	if($Company && $Company->getId())
	    $this->setCompany ($Company);
	
	parent::populate($array);
    }
}