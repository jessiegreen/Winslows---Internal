<?php

namespace Entities;
use Doctrine\Common\Collections\ArrayCollection;

/** 
 * @Entity (repositoryClass="Repositories\Product") 
 * @Table(name="products") 
 * @HasLifecycleCallbacks
 */
class Product
{
    /**
     * @Id @Column(type="integer")
     * @GeneratedValue(strategy="AUTO")
     */
    private $id;

    /** @Column(type="string", length=255) */
    private $name;
    
    /** @Column(type="string", length=255) */
    private $part_number;
    
    /** @Column(type="string", length=2000) */
    private $description;
    
    /** @Column(type="datetime") */
    private $created;

    /** @Column(type="datetime") */
    private $updated;
    
    /** 
     * @ManyToOne(targetEntity="Supplier", inversedBy="products")
     */     
    private $supplier;

    public function __construct()
    {
	$this->created	= $this->updated = new \DateTime("now");
    }
    
    /**
     * Add supplier to address.
     * @param Supplier $supplier
     */
    public function setSupplier(Supplier $supplier)
    {
        $this->supplier = $supplier;
    }
    
    /**
     * Retrieve address's associated supplier.
     */
    public function getSupplier()
    {
	return $this->supplier;
    }

    /**
     * Retrieve Privilege id
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
    
    public function getPartNumber()
    {
        return $this->part_number;
    }

    public function setPartNumber($partnumber)
    {
        $this->part_number = $partnumber;
    }
    
    public function getDescription()
    {
        return $this->description;
    }

    public function setDescription($description)
    {
        $this->description = $description;
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
    
    /**
     * @PreUpdate
     */
    public function updated()
    {
        $this->updated = new \DateTime("now");
    }

    public function populate(array $array){
	foreach ($array as $key => $value) {
	    if(property_exists($this, $key)){
		$this->$key = $value;
	    }
	}
    }
}
