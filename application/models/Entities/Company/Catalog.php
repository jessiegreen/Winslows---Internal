<?php
namespace Entities\Company;

use Doctrine\Common\Collections\ArrayCollection;

/**
 * @Entity (repositoryClass="Repositories\Company\Catalog") 
 * @Crud\Entity\Url(value="catalog")
 * @Crud\Entity\Permissions(view={"Admin"}, edit={"Admin"}, create={"Admin"}, delete={"Admin"})
 * @Table(name="company_catalogs")
 * @HasLifecycleCallbacks
 */
class Catalog extends \Dataservice_Doctrine_Entity
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
     * @var string $name_index
     */
    protected $name_index;
    
    /** 
     * @ManyToOne(targetEntity="\Entities\Company", inversedBy="Catalogs")
     * @Crud\Relationship\Permissions()
     * @var \Entities\Company $Company
     */     
    protected $Company;
    
    /**
     * @ManytoMany(targetEntity="\Entities\Company\Supplier\Product\ProductAbstract", mappedBy="Catalogs", cascade={"persist"})
     * @Crud\Relationship\Permissions(add={"Admin"}, remove={"Admin"})
     * @var ArrayCollection $Products
     */
    protected $Products;
    
    /**
     * @ManytoMany(targetEntity="\Entities\Company\Website", mappedBy="Catalogs", cascade={"persist"})
     * @Crud\Relationship\Permissions(add={"Admin"}, remove={"Admin"})
     * @var ArrayCollection $Websites
     */
    protected $Websites;
    
    /**
     * Bidirectional - One-To-Many (INVERSE SIDE)
     *
     * @OneToMany(targetEntity="\Entities\Company\Catalog\Category", mappedBy="Catalog", cascade={"persist"})
     * @Crud\Relationship\Permissions(add={"Admin"}, remove={"Admin"})
     * @OrderBy({"index_string" = "ASC"})
     * @var ArrayCollection $Categories
     */
    protected $Categories;
    
    public function __construct()
    {
	$this->Products = new ArrayCollection();
	$this->Websites = new ArrayCollection();
	
	parent::__construct();
    }
    
    /**
     * @return \Entities\Company
     */
    public function getCompany()
    {
	return $this->Company;
    }
    
    /**
     * @param \Entities\Company $Company
     */
    public function setCompany(\Entities\Company $Company)
    {
	$this->Company = $Company;
    }
    
    /**
     * @return ArrayCollection
     */
    public function getProducts()
    {
	return $this->Products;
    }
    
    /**
     * @param \Entities\Company\Supplier\Product\ProductAbstract $Product
     */
    public function addProduct(\Entities\Company\Supplier\Product\ProductAbstract $Product)
    {
	if(!$this->getProducts()->contains($Product))
	{
	    $Product->addCatalog($this);
	    
	    $this->Products[] = $Product;
	}
    }
    
    /**
     * @param \Entities\Company\Supplier\Product\ProductAbstract $Product
     */
    public function removeProduct(\Entities\Company\Supplier\Product\ProductAbstract $Product)
    {
	$Product->removeCatalog($this);
	
	$this->getProducts()->removeElement($Product);
    }
    
    /**
     * @return ArrayCollection
     */
    public function getWebsites()
    {
	return $this->Websites;
    }
    
    /**
     * @param \Entities\Company\Website $Website
     */
    public function addWebsite(\Entities\Company\Website $Website)
    {
	if(!$this->getWebsites()->contains($Website))
	{
	    $Website->addCatalog($this);
	    
	    $this->Websites[] = $Website;
	}
    }
    
    /**
     * @param \Entities\Company\Supplier\Website $Website
     */
    public function removeWebsite(\Entities\Company\Website $Website)
    {
	$Website->removeCatalog($this);
	
	$this->getWebsites()->removeElement($Website);
    }
    
    /**
     * @param Catalog\Category $Category
     */
    public function addCategory(Catalog\Category $Category)
    {
	$Category->setCatalog($this);
	
        $this->Categories[] = $Category;
    }
    
    /**
     * @return ArrayCollection
     */
    public function getCategories()
    {
	return $this->Categories;
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
    public function getNameIndex()
    {
        return $this->name_index;
    }

    /**
     * @param string $name
     */
    public function setNameIndex($name_index)
    {
        $this->name_index = $name_index;
    }
    
    /**
     * @return string
     */
    public function toString()
    {
	return $this->getName()." Catalog";
    }
    
    public function populate(array $array) 
    {
	$Company = $this->_getEntityFromArray($array, "Entities\Company", "company_id");
	
	if($Company && $Company->getId())
	    $this->setCompany($Company);
	
	parent::populate($array);
    }
}