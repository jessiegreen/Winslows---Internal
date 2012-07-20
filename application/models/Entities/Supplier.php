<?php

namespace Entities;
use Doctrine\Common\Collections\ArrayCollection;

/** 
 * @Entity (repositoryClass="Repositories\Supplier") 
 * @Table(name="suppliers")
 * @HasLifecycleCallbacks
 */
class Supplier
{
    /**
     * @Id @Column(type="integer")
     * @GeneratedValue(strategy="AUTO")
     */
    private $id;

    /** @Column(type="string", length=255) */
    private $name;

    /** @Column(type="datetime") */
    private $created;

    /** @Column(type="datetime") */
    private $updated;

    /**
     * Bidirectional - One-To-Many (INVERSE SIDE)
     *
     * @OneToMany(targetEntity="SupplierAddress", mappedBy="Supplier", cascade={"persist", "remove"}, orphanRemoval=true)
     */
    private $SupplierAddresses;
    
    /**
     * Bidirectional - One-To-Many (INVERSE SIDE)
     *
     * @OneToMany(targetEntity="Product", mappedBy="Supplier", cascade={"persist", "remove"}, orphanRemoval=true)
     */
    private $Products;
    
    public function __construct()
    {
      $this->SupplierAddresses	= new ArrayCollection();
      $this->Products		= new ArrayCollection();
      $this->created		= $this->updated = new \DateTime("now");
    }
   
    /**
     * Add address to supplier.
     * @param Supplier $SupplierAddress
     */
    public function addSupplierAddress(SupplierAddress $SupplierAddress)
    {
	$SupplierAddress->setSupplier($this);
        $this->SupplierAddresses[] = $SupplierAddress;
    }
    
    /**
     * Retrieve person's associated addresses.
     */
    public function getSupplierAddresses()
    {
      return $this->SupplierAddresses;
    }
    
    /**
     * Add product to supplier.
     * @param Product $product
     */
    public function addProduct(Product $Product)
    {
	$Product->setProduct($this);
        $this->Products[] = $Product;
    }
    
    /**
     * Retrieve person's associated addresses.
     */
    public function getProducts()
    {
      return $this->Products;
    }

    /**
     * @PreUpdate
     */
    public function updated()
    {
        $this->updated = new \DateTime("now");
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