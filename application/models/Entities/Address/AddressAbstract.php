<?php

namespace Entities\Address;

/** 
 * @Entity (repositoryClass="Repositories\Address\AddressAbstract") 
 * @Table(name="address_addressabstracts") 
 * @InheritanceType("JOINED")
 * @DiscriminatorColumn(name="discr", type="string")
 * @DiscriminatorMap({
 *			"person_address" = "Person\Address", 
 *			"company_supplier_address" = "Company\Supplier\Address", 
 *			"company_location_address" = "Company\Location\Address"
 *		    })
 * @HasLifecycleCallbacks
 */
class AddressAbstract
{
    /**
     * @Id @Column(type="integer")
     * @GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /** @Column(type="string", length=255) */
    protected $name;
    
    /** @Column(type="string", length=255) */
    protected $address_1;
    
    /** @Column(type="string", length=255) */
    protected $address_2;
    
    /** @Column(type="string", length=255) */
    protected $city;
    
    /** @Column(type="string", length=255) */
    protected $county;

    /** @Column(type="string", length=2) */
    protected $state;

    /** @Column(type="string", length=5) */
    protected $zip_1;
    
    /** @Column(type="string", length=5) */
    protected $zip_2;

    /** @Column(type="datetime") */
    protected $created;

    /** @Column(type="datetime") */
    protected $updated;

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