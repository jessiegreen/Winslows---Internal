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
    private $name_index;

    /**
     * Bidirectional - One-To-Many (INVERSE SIDE)
     *
     * @OneToMany(targetEntity="Location", mappedBy="Company", cascade={"persist"})
     */
    private $Locations;
    
    public function __construct()
    {
	$this->Locations = new ArrayCollection();
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