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
     * @OneToMany(targetEntity="SupplierAddress", mappedBy="supplier", cascade={"persist", "remove"}, orphanRemoval=true)
     */
    private $supplieraddresses;
    
    /**
     * Bidirectional - One-To-Many (INVERSE SIDE)
     *
     * @OneToMany(targetEntity="Product", mappedBy="supplier", cascade={"persist", "remove"}, orphanRemoval=true)
     */
    private $products;
    
    public function __construct()
    {
      $this->supplieraddresses	= new ArrayCollection();
      $this->products		= new ArrayCollection();
      $this->created		= $this->updated = new \DateTime("now");
    }
   
    /**
     * Add address to supplier.
     * @param Supplier $supplieraddress
     */
    public function addSupplierAddress(SupplierAddress $supplieraddress)
    {
	$supplieraddress->setSupplier($this);
        $this->supplieraddresses[] = $supplieraddress;
    }
    
    /**
     * Retrieve person's associated addresses.
     */
    public function getSupplierAddresses()
    {
      return $this->supplieraddresses;
    }
    
    /**
     * Add product to supplier.
     * @param Product $product
     */
    public function addProduct(Product $product)
    {
	$product->setProduct($this);
        $this->products[] = $product;
    }
    
    /**
     * Retrieve person's associated addresses.
     */
    public function getProducts()
    {
      return $this->products;
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

}