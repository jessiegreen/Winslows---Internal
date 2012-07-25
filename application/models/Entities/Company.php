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
     */
    private $id;
    
    /** @Column(type="string", length=255) */
    private $name;
    
    /** @Column(type="string", length=255) */
    private $dba;
    
    /** @Column(type="string", length=255) */
    private $name_index;
    
    /** @Column(type="string", length=65536) */
    private $description;

    /**
     * Bidirectional - One-To-Many (INVERSE SIDE)
     *
     * @OneToMany(targetEntity="Location", mappedBy="Company", cascade={"persist"})
     */
    private $Locations;
    
    /**
     * @ManytoMany(targetEntity="Supplier", mappedBy="Companies", cascade={"ALL"})
     */
    private $Suppliers;
    
    public function __construct()
    {
	$this->Locations = new ArrayCollection();
	$this->Suppliers = new ArrayCollection();
    }
    
    /**
     * Add Location to Company.
     * @param Location $Location
     */
    public function addLocation(Location $Location)
    {
	$Location->setCompany($this);
        $this->Locations[] = $Location;
    }
    
    /**
     * Retrieve company's associated locations.
     */
    public function getLocations()
    {
      return $this->Locations;
    }
    
    public function getSuppliers(){
	return $this->Suppliers;
    }
    
    public function addSupplier(Supplier $Supplier){
	$Supplier->addCompany($this);
	$this->Suppliers[] = $Supplier;
    }
    
    public function removeSupplier($supplier_id)
    {
	foreach ($this->Suppliers as $key => $Suppliers) {
	    if($Suppliers->getId() == $supplier_id){
		$Suppliers->removeResource($this);
		$removed = $this->Suppliers[$key];
		unset($this->Suppliers[$key]);
		return $removed;
	    }
	}
	return false;
    }

    /**
     * Retrieve supplier id
     */
    public function getId()
    {
        return $this->id;
    }

    public function getName()
    {
        return $this->name;
    }

    public function setName($name)
    {
        $this->name = $name;
    }
    
    public function getDba()
    {
        return $this->dba;
    }

    public function setDba($dba)
    {
        $this->dba = $dba;
    }
    
    public function getNameIndex()
    {
        return $this->name_index;
    }

    public function setNameIndex($name_index)
    {
        $this->name_index = $name_index;
    }
    
    public function getDescription()
    {
        return $this->description;
    }

    public function setDescription($description)
    {
        $this->description = $description;
    }    
    
    public function populate(array $array){
	foreach ($array as $key => $value) {
	    if(property_exists($this, $key)){
		$this->$key = $value;
	    }
	}
    }
}