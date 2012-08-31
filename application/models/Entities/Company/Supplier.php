<?php

namespace Entities\Company;
use Doctrine\Common\Collections\ArrayCollection;

/** 
 * @Entity (repositoryClass="Repositories\Company\Supplier") 
 * @Table(name="company_suppliers")
 * @HasLifecycleCallbacks
 */
class Supplier extends \Dataservice_Doctrine_Entity
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
     * @ManytoMany(targetEntity="\Entities\Company", inversedBy="Suppliers", cascade={"persist"})
     * @JoinTable(name="company_supplier_company_joins",
     *      joinColumns={@JoinColumn(name="supplier_id", referencedColumnName="id")},
     *      inverseJoinColumns={@JoinColumn(name="company_id", referencedColumnName="id")}
     *      )
     * @var ArrayCollection $Companies
     */
    private $Companies;

    /**
     * Bidirectional - One-To-Many (INVERSE SIDE)
     *
     * @OneToMany(targetEntity="\Entities\Company\Supplier\Address", mappedBy="Supplier", cascade={"persist"}, orphanRemoval=true)
     * @var ArrayCollection $Addresses
     */
    private $Addresses;
    
    /**
     * Bidirectional - One-To-Many (INVERSE SIDE)
     *
     * @OneToMany(targetEntity="\Entities\Company\Supplier\Product\ProductAbstract", mappedBy="Supplier", cascade={"persist"}, orphanRemoval=true)
     * @var ArrayCollection $Products
     */
    private $Products;
    
    public function __construct()
    {
	$this->Companies	    = new ArrayCollection();
	$this->Addresses	    = new ArrayCollection();
	$this->Products		    = new ArrayCollection();
	
	parent::__construct();
    }
    
    /**
     * @param \Entities\Company $Company
     */
    public function addCompany(\Entities\Company $Company)
    {
        $this->Companies[] = $Company;
    }
    
    /**
     * @param \Entities\Company $Company
     * @return boolean
     */
    public function removeCompany(\Entities\Company $Company)
    {
	$this->getCompanies()->removeElement($Company);
    }
    
    /**
     * @return array
     */
    public function getCompanies()
    {
	return $this->Companies;
    }
   
    /**
     * @param \Entities\Company\Supplier\Address $Address
     */
    public function addSupplierAddress(Supplier\Address $Address)
    {
	$Address->setSupplier($this);
        $this->Addresses[] = $Address;
    }
    
    /**
     * @return array
     */
    public function getAddresses()
    {
      return $this->Addresses;
    }
    
    /**
     * @param \Entities\Company\Supplier\Product\ProductAbstract $Product
     */
    public function addProduct(Supplier\Product\ProductAbstract $Product)
    {
	$Product->setSupplier($this);
        $this->Products[] = $Product;
    }
    
    /**
     * @return array
     */
    public function getProducts()
    {
      return $this->Products;
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
    public function setName($name)
    {
        $this->name = $name;
    }
}