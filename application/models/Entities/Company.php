<?php

namespace Entities;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * @Entity (repositoryClass="Repositories\Company") 
 * @Table(name="companies")
 * @HasLifecycleCallbacks
 */
class Company extends \Dataservice_Doctrine_Entity
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
     * Bidirectional - One-To-Many (INVERSE SIDE)
     *
     * @OneToMany(targetEntity="\Entities\Company\Location", mappedBy="Company", cascade={"persist"})
     * @var array $Locations
     */
    protected $Locations;
    
    /**
     * @ManytoMany(targetEntity="\Entities\Company\Supplier", mappedBy="Companies", cascade={"persist"})
     * @var array $Suppliers
     */
    protected $Suppliers;
    
    /**
     * Bidirectional - One-To-Many (INVERSE SIDE)
     *
     * @OneToMany(targetEntity="\Entities\Company\RtoProvider", mappedBy="Company", cascade={"persist"})
     * @var array $RtoProviders
     */
    private $RtoProviders;
    
    /**
     * Bidirectional - One-To-Many (INVERSE SIDE)
     *
     * @OneToMany(targetEntity="\Entities\Company\Website", mappedBy="Company", cascade={"persist"})
     * @var array $Websites
     */
    private $Websites;
    
    /**
     * Bidirectional - One-To-Many (INVERSE SIDE)
     *
     * @OneToMany(targetEntity="\Entities\Company\Employee", mappedBy="Company", cascade={"persist"})
     * @var ArrayCollection $Employees
     */
    private $Employees;
    
    /**
     * Bidirectional - One-To-Many (INVERSE SIDE)
     *
     * @OneToMany(targetEntity="\Entities\Company\Lead", mappedBy="Company", cascade={"persist"})
     * @var ArrayCollection $Leads
     */
    private $Leads;
    
    public function __construct()
    {
	$this->Employees    = new ArrayCollection();
	$this->Locations    = new ArrayCollection();
	$this->Suppliers    = new ArrayCollection();
	$this->RtoProviders = new ArrayCollection();
	$this->Leads	    = new ArrayCollection();
	
	parent::__construct();
    }
    
    /**
     * Add Location to Company.
     * @param \Entities\Company\Location $Location
     */
    public function addLocation(Company\Location $Location)
    {
	$Location->setCompany($this);
        $this->Locations[] = $Location;
    }
    
    /**
     * @return array
     */
    public function getLocations()
    {
      return $this->Locations;
    }
    
    /**
     * @return array
     */
    public function getWebsites()
    {
	return $this->Websites;
    }
    
    /**
     * @param \Entities\Company\Website $Website
     */
    public function addWebsite(Company\Website $Website)
    {
	$Website->setCompany($this);
	$this->Websites[] = $Website;
    }
    
    /**
     * @return ArrayCollection
     */
    public function getLeads()
    {
	return $this->Leads;
    }
    
    /**
     * @param Company\Lead $Lead
     */
    public function addLead(Company\Lead $Lead)
    {
	$Lead->setCompany($this);
	$this->Leads[] = $Lead;
    }
    
    /**
     * @return array
     */
    public function getRtoProviders()
    {
	return $this->RtoProviders;
    }
    
    /**
     * @param \Entities\Company\RtoProvider $RtoProvider
     */
    public function addRtoProvider(\Entities\Company\RtoProvider $RtoProvider)
    {
	$RtoProvider->setCompany($this);
	$this->RtoProviders[] = $RtoProvider;
    }
    
    /**
     * @return array
     */
    public function getSuppliers()
    {
	return $this->Suppliers;
    }
    
    /**
     * @param \Entities\Company\Supplier $Supplier
     */
    public function addSupplier(Company\Supplier $Supplier)
    {
	$Supplier->addCompany($this);
	$this->Suppliers[] = $Supplier;
    }
    
    /**
     * @param \Entities\Company\Supplier $Supplier
     * @return boolean
     */
    public function removeSupplier(Company\Supplier $Supplier)
    {
	$this->getSuppliers()->removeElement($Supplier);
    }
    
    /**
     * @param \Entities\Company\Employee $Employee
     */
    public function addEmployee(\Entities\Company\Employee $Employee)
    {
	$Employee->setCompany($this);
        $this->Employees[] = $Employee;
    }
    
    /**
     * @return ArrayCollection
     */
    public function getEmployees()
    {
	return $this->Employees;
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
}