<?php
namespace Entities\Company;

use Doctrine\Common\Collections\ArrayCollection;

/** 
 * @Entity (repositoryClass="Repositories\Company\Supplier") 
 * @Table(name="company_suppliers")
 * @Crud\Entity\Url(value="supplier")
 * @Crud\Entity\Permissions(view={"Admin"}, edit={"Admin"}, create={"Admin"}, delete={"Admin"})
 * @HasLifecycleCallbacks
 */
class Supplier extends \Dataservice_Doctrine_Entity
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
     * @ManyToOne(targetEntity="\Entities\Company", inversedBy="Locations")
     * @Crud\Relationship\Permissions()
     * @var \Entities\Company
     */     
    protected $Company;

    /**
     * Bidirectional - One-To-Many (INVERSE SIDE)
     *
     * @OneToMany(targetEntity="\Entities\Company\Supplier\Address", mappedBy="Supplier", cascade={"persist"}, orphanRemoval=true)
     * @Crud\Relationship\Permissions(add={"Admin"}, remove={"Admin"})
     * @var ArrayCollection $Addresses
     */
    protected $Addresses;
    
    /**
     * Bidirectional - One-To-Many (INVERSE SIDE)
     *
     * @OneToMany(targetEntity="\Entities\Company\Supplier\Product\ProductAbstract", mappedBy="Supplier", cascade={"persist"}, orphanRemoval=true)
     * @Crud\Relationship\Permissions(add={"Admin"}, remove={"Admin"})
     * @var ArrayCollection $Products
     */
    protected $Products;
    
    public function __construct()
    {
	$this->Addresses	    = new ArrayCollection();
	$this->Products		    = new ArrayCollection();
	
	parent::__construct();
    }
    
    /**
     * @param \Entities\Company $Company
     */
    public function setCompany(\Entities\Company $Company)
    {
        $this->Company = $Company;
    }
    
    /**
     * @return array
     */
    public function getCompany()
    {
	return $this->Company;
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
    
    /**
     * @return string
     */
    public function toString()
    {
	return $this->getName();
    }
    
    public function populate(array $array)
    {
	$Company = $this->_getEntityFromArray($array, "Entities\Company", "company_id");
	
	if($Company && $Company->getId())
	    $this->setCompany ($Company);
	
	parent::populate($array);
    }
}