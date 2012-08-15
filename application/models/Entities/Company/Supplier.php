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
     * @Column(type="datetime") 
     * @var \DateTime $created
     */
    private $created;

    /** 
     * @Column(type="datetime") 
     * @var \DateTime $updated
     */
    private $updated;
    
    /**
     * @ManytoMany(targetEntity="\Entities\Company", inversedBy="Suppliers", cascade={"persist"})
     * @JoinTable(name="company_supplier_company_joins",
     *      joinColumns={@JoinColumn(name="supplier_id", referencedColumnName="id")},
     *      inverseJoinColumns={@JoinColumn(name="company_id", referencedColumnName="id")}
     *      )
     * @var array $Companies
     */
    private $Companies;

    /**
     * Bidirectional - One-To-Many (INVERSE SIDE)
     *
     * @OneToMany(targetEntity="\Entities\Company\Supplier\Address", mappedBy="Supplier", cascade={"persist"}, orphanRemoval=true)
     */
    private $Addresses;
    
    /**
     * Bidirectional - One-To-Many (INVERSE SIDE)
     *
     * @OneToMany(targetEntity="\Entities\Company\Supplier\Product\ProductAbstract", mappedBy="Supplier", cascade={"persist"}, orphanRemoval=true)
     */
    private $Products;
    
    public function __construct()
    {
	$this->Companies	    = new ArrayCollection();
	$this->Addresses	    = new ArrayCollection();
	$this->Products		    = new ArrayCollection();
	$this->created		    = $this->updated = new \DateTime("now");
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
	foreach ($this->Companies as $key => $Company2) 
	{
	    if($Company->getId() == $Company2->getId())
	    {
		$this->Companies[$key];
		unset($this->Companies[$key]);
		return true;
	    }
	}
	return false;
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
    public function setName($name)
    {
        $this->name = $name;
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