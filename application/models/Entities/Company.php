<?php

namespace Entities;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * @Entity (repositoryClass="Repositories\Company") 
 * @Table(name="companies")
 * @HasLifecycleCallbacks
 */
class Company
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
     * @Column(type="string", length=50000)
     * @var string $description
     */
    private $description;

    /**
     * Bidirectional - One-To-Many (INVERSE SIDE)
     *
     * @OneToMany(targetEntity="\Entities\Company\Location", mappedBy="Company", cascade={"persist"})
     * @var array $Locations
     */
    private $Locations;
    
    /**
     * @ManytoMany(targetEntity="\Entities\Company\Supplier", mappedBy="Companies", cascade={"persist"})
     * @var array $Suppliers
     */
    private $Suppliers;
    
    /**
     * Bidirectional - One-To-Many (INVERSE SIDE)
     *
     * @OneToMany(targetEntity="\Entities\Company\Website", mappedBy="Company", cascade={"persist"})
     * @var array $Websites
     */
    private $Websites;
    
    public function __construct()
    {
	$this->Locations = new ArrayCollection();
	$this->Suppliers = new ArrayCollection();
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
	foreach ($this->Suppliers as $key => $Supplier2) {
	    if($Supplier->getId() == $Supplier2->getId()){
		$removed = $this->Suppliers[$key];
		unset($this->Suppliers[$key]);
		return $removed;
	    }
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
     * @param array $array
     */
    public function populate(array $array)
    {
	foreach ($array as $key => $value) 
	{
	    if(property_exists($this, $key))
	    {
		$this->$key = $value;
	    }
	}
    }
}