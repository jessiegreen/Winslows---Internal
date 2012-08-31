<?php

namespace Entities\Company;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * @Entity (repositoryClass="Repositories\Company\RtoProvider") 
 * @Table(name="company_rtoproviders")
 * @HasLifecycleCallbacks
 */
class RtoProvider extends \Dataservice_Doctrine_Entity
{
    /**
     * @Id @Column(type="integer")
     * @GeneratedValue(strategy="AUTO")
     * @var integer $id
     */
    private $id;
    
    /** 
     * @Column(type="string", length=255) 
     * @var string $name
     */
    private $name;
    
    /** 
     * @Column(type="string", length=255) 
     * @var string $dba
     */
    private $dba;
    
    /** 
     * @Column(type="string", length=255) 
     * @var string $name_index
     */
    private $name_index;
    
    /** 
     * @Column(type="integer", length=3) 
     * @var int $minimum_points
     */
    private $minimum_points;
    
    /** 
     * @Column(type="string", length=50000)
     * @var string $description
     */
    private $description;
    
    /**
     * @ManytoMany(targetEntity="\Entities\Company\Supplier\Product\ProductAbstract", mappedBy="RtoProviders", cascade={"ALL"})
     * @var ArrayCollection $Products
     */
    private $Products;
    
    /**
     * Bidirectional - One-To-Many (INVERSE SIDE)
     *
     * @OneToMany(targetEntity="\Entities\RtoProvider\Application", mappedBy="RtoProvider", cascade={"persist"})
     * @var ArrayCollection $Applications
     */
    private $Applications;
    
    public function __construct()
    {
	$this->Products	    = new ArrayCollection();
	$this->Applications = new ArrayCollection();
	
	parent::__construct();
    }
    
    /**
     * @return ArrayCollection
     */
    public function getProducts()
    {
	return $this->Products;
    }
    
    /**
     * @param \Entities\Company\Supplier\Product\ProductAbstract $Product
     */
    public function addProduct(\Entities\Company\Supplier\Product\ProductAbstract $Product)
    {
	if(!$this->getProducts()->contains($Product))
	{
	    $Product->addRtoProvider($this);
	    $this->Products[] = $Product;
	}
    }
    
    public function removeProduct(\Entities\Company\Supplier\Product\ProductAbstract $Product)
    {
	$Product->removeRtoProvider($this);
	$this->getProducts()->removeElement($Product);
    }
    
    /**
     * @return ArrayCollection
     */
    public function getApplications()
    {
	return $this->Applications;
    }
    
    /**
     * @param \Entities\RtoProvider\Application $Application
     */
    public function addApplication(RtoProvider\Application $Application)
    {
	$Application->setRtoProvider($this);
	$this->Applications[] = $Application;
    }
    
    /**
     * @param \Entities\RtoProvider\Application $Application
     */
    public function removeApplication(RtoProvider\Application $Application)
    {
	$this->getApplications()->removeElement($Application);
    }
    
    /**
     * @param \Entities\Company\Lead $Lead
     * @param \Entities\RtoProvider\Application $Application
     * @return boolean
     */
    public function hasLeadApplication(\Entities\Company\Lead $Lead)
    {
	if($this->getApplications()->exists(
	    /* @var $Application \Entities\RtoProvider\Application */
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
     * @param \Entities\RtoProvider\Application $Application
     * @return boolean
     */
    public function isApproved(\Entities\Company\Lead $Lead)
    {
	$LeadApplications = $this->getApplications()->filter(
				/* @var $Application \Entities\RtoProvider\Application */
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
}