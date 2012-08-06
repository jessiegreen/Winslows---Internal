<?php

namespace Entities\Address;

/** 
 * @Entity (repositoryClass="Repositories\Address\AddressAbstract") 
 * @Table(name="address_addressabstracts") 
 * @InheritanceType("JOINED")
 * @DiscriminatorColumn(name="discr", type="string")
 * @DiscriminatorMap({
 *			"person_address" = "\Entities\Person\Address", 
 *			"company_supplier_address" = "\Entities\Company\Supplier\Address", 
 *			"company_location_address" = "\Entities\Company\Location\Address"
 *		    })
 * @HasLifecycleCallbacks
 */
class AddressAbstract
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
     * @var string $address_1
     */
    protected $address_1;
    
    /** 
     * @Column(type="string", length=255) 
     * @var string $address_2
     */
    protected $address_2;
    
    /** 
     * @Column(type="string", length=255) 
     * @var string $city
     */
    protected $city;
    
    /** 
     * @Column(type="string", length=255) 
     * @var string $county
     */
    protected $county;

    /** 
     * @Column(type="string", length=2) 
     * @var string $state
     */
    protected $state;

    /** 
     * @Column(type="string", length=5) 
     * @var string $zip_1
     */
    protected $zip_1;
    
    /** 
     * @Column(type="string", length=5) 
     * @var string $zip_2
     */
    protected $zip_2;

    /** 
     * @Column(type="datetime") 
     * @var \DateTime $created
     */
    protected $created;

    /** 
     * @Column(type="datetime") 
     * @var \DateTime $updated
     */
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
     * @param string $name
     */
    public function setName(string $name)
    {
        $this->name = $name;
    }
    
    /**
     * @return string
     */
    public function getAddress1()
    {
        return $this->address_1;
    }

    /**
     * @param string $address_1
     */
    public function setAddress1(string $address_1)
    {
        $this->address_1 = $address_1;
    }

    /**
     * @return string
     */
    public function getAddress2()
    {
        return $this->address_2;
    }

    /**
     * @param string $address_2
     */
    public function setAddress2(string $address_2)
    {
        $this->address_2 = $address_2;
    }
    
    /**
     * @return string
     */
    public function getCounty()
    {
        return $this->county;
    }

    /**
     * @param string $county
     */
    public function setCounty(string $county)
    {
        $this->county = $county;
    }

    /**
     * @return string
     */
    public function getCity()
    {
        return $this->city;
    }

    /**
     * @param string $city
     */
    public function setCity(string $city)
    {
        $this->city = $city;
    }
    
    /**
     * @return string
     */
    public function getState()
    {
        return $this->state;
    }

    /**
     * @param string $state
     */
    public function setState(string $state)
    {
        $this->state = $state;
    }

    /**
     * @return string
     */
    public function getZip1()
    {
        return $this->zip_1;
    }

    /**
     * @param string $zip_1
     */
    public function setZip1(string $zip_1)
    {
        $this->zip_1 = $zip_1;
    }
    
    /**
     * @return string
     */
    public function getZip2()
    {
        return $this->zip_2;
    }

    /**
     * @param string $zip_2
     */
    public function setZip2(string $zip_2)
    {
        $this->zip_2 = $zip_2;
    }

    /**
     * @return \DateTime
     */
    public function getCreated()
    {
        return $this->created;
    }

    /**
     * @param \DateTime $created
     */
    public function setCreated(\DateTime $created)
    {
        $this->created = $created;
    }

    /**
     * @return \DateTime
     */
    public function getUpdated()
    {
        return $this->updated;
    }
    
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