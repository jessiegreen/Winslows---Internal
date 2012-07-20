<?php

namespace Entities;
use Doctrine\Common\Collections\ArrayCollection;

/** 
 * @Entity (repositoryClass="Repositories\Address") 
 * @Table(name="addresses") 
 * @InheritanceType("JOINED")
 * @DiscriminatorColumn(name="discr", type="string")
 * @DiscriminatorMap({"personaddress" = "PersonAddress", "supplieraddress" = "SupplierAddress", "locationaddress" = "LocationAddress"})
 * @HasLifecycleCallbacks
 */
class Address
{
    /**
     * @Id @Column(type="integer")
     * @GeneratedValue(strategy="AUTO")
     */
    private $id;

    /** @Column(type="string", length=255) */
    private $name;
    
    /** @Column(type="string", length=255) */
    private $address_1;
    
    /** @Column(type="string", length=255) */
    private $address_2;
    
    /** @Column(type="string", length=255) */
    private $city;
    
    /** @Column(type="string", length=255) */
    private $county;

    /** @Column(type="string", length=2) */
    private $state;

    /** @Column(type="string", length=5) */
    private $zip_1;
    
    /** @Column(type="string", length=5) */
    private $zip_2;

    /** @Column(type="datetime") */
    private $created;

    /** @Column(type="datetime") */
    private $updated;

    public function __construct()
    {
	$this->created	= $this->updated = new \DateTime("now");
    }
   
    /**
     * @PreUpdate
     */
    public function updated()
    {
        $this->updated = new \DateTime("now");
    }

    /**
     * Retrieve address id
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
    
    public function getAddress1()
    {
        return $this->address_1;
    }

    public function setAddress1($address_1)
    {
        $this->address_1 = $address_1;
    }

    public function getAddress2()
    {
        return $this->address_2;
    }

    public function setAddress2($address_2)
    {
        $this->address_2 = $address_2;
    }
    
    public function getCounty()
    {
        return $this->county;
    }

    public function setCounty($county)
    {
        $this->county = $county;
    }

    public function getCity()
    {
        return $this->city;
    }

    public function setCity($city)
    {
        $this->city = $city;
    }
    
    public function getState()
    {
        return $this->state;
    }

    public function setState($state)
    {
        $this->state = $state;
    }

    public function getZip1()
    {
        return $this->zip_1;
    }

    public function setZip1($zip_1)
    {
        $this->zip_1 = $zip_1;
    }
    
    public function getZip2()
    {
        return $this->zip_2;
    }

    public function setZip2($zip_2)
    {
        $this->zip_2 = $zip_2;
    }

    public function getCreated()
    {
        return $this->created;
    }

    public function setCreated($created)
    {
        $this->created = $created;
    }

    public function getUpdated()
    {
        return $this->updated;
    }
    
    public function populate(array $array){
	foreach ($array as $key => $value) {
	    if(property_exists($this, $key)){
		$this->$key = $value;
	    }
	}
    }
}