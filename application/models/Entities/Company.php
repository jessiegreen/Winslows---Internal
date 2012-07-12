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
     * @OneToMany(targetEntity="Location", mappedBy="company", cascade={"persist", "remove"}, orphanRemoval=true)
     */
    private $locations;
    
    public function __construct()
    {
	$this->locations = new ArrayCollection();
    }
    
    /**
     * Add Location to Company.
     * @param Loaction $Location
     */
    public function addLocation(Location $Location)
    {
	$Location->setCompany($this);
        $this->locations[] = $Location;
    }
    
    /**
     * Retrieve company's associated locations.
     */
    public function getLocations()
    {
      return $this->locations;
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
    
}