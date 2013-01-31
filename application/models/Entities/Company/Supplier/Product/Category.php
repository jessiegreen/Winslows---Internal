<?php

namespace Entities\Company\Supplier\Product;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * @Entity (repositoryClass="Repositories\Company\Supplier\Product\Category") 
 * @Table(name="company_supplier_product_categories")
 * @HasLifecycleCallbacks
 * @Crud\Entity\Url(value="supplier-product-category")
 * @Crud\Entity\Permissions(view={"Admin"}, edit={"Admin"}, create={"Admin"}, delete={"Admin"})
 */
class Category extends \Dataservice_Doctrine_Entity
{
    /**
     * @Id @Column(type="integer")
     * @GeneratedValue(strategy="AUTO")
     * @var integer $id
     */
    private $id;
    
    /** 
     * @Column(type="string", length=255) 
     * @var string $index_string
     */
    protected $index_string;
    
    /** 
     * @Column(type="string", length=255) 
     * @var string $name
     */
    protected $name;
    
    /** 
     * @Column(type="integer", length=11) 
     * @var integer $sort_order
     */
    protected $sort_order;
    
    /**
     * @ManyToOne(targetEntity="\Entities\Company\Supplier\Product\Category", inversedBy="children")
     * @JoinColumn(name="parent", referencedColumnName="id")
     * @var $parent null | Category
     */
    protected $parent;
    
    /**
     * Bidirectional - One-To-Many (INVERSE SIDE)
     *
     * @OneToMany(targetEntity="\Entities\Company\Supplier\Product\Category", mappedBy="parent", cascade={"persist"}, orphanRemoval=true)
     * @var ArrayCollection $children
     */
    protected $children;

    /**
     * @ManytoMany(targetEntity="\Entities\Company\Supplier\Product\ProductAbstract", inversedBy="Categories", cascade={"persist"})
     * @JoinTable(name="company_supplier_product_productabstract_category_joins")
     * @var ArrayCollection $Products
     */
    private $Products;
    
    /**
     * @OnetoMany(targetEntity="\Entities\Company\Supplier\Product\Category\File\Image", cascade={"persist", "remove"}, mappedBy="Category", orphanRemoval=true)
     * @var ArrayCollection $Images
     */
    private $Images;
    
    public function __construct()
    {
	$this->Products  = new ArrayCollection();
	$this->Images		= new ArrayCollection();
	
	parent::__construct();
    }
    
    /**
     * @param \Entities\Company\Supplier\Product\ProductAbstract $Product
     */
    public function addProduct(\Entities\Company\Supplier\Product\ProductAbstract $Product)
    {
	$Product->addCategory($this);
	
        $this->Products[] = $Product;
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
    public function removeProduct(ProductAbstract $Product)
    {
	$Product->removeCategory($this);
	$this->Products->removeElement($Product);
    }
    
    /**
     * @param Image $Image
     */
    public function addImage(Category\File\Image $Image)
    {
	$Image->setCategory($this);
	
	$this->Images[] = $Image;
    }
    
    /**
     * @param Category\File\Image $Image
     */
    public function removeImage(Category\File\Image $Image)
    {
	$this->Images->removeElement($Image);
    }
    
    /**
     * @return \Doctrine\Common\Collections\ArrayCollection
     */
    public function getImages()
    {
	return $this->Images;
    }
    
    /**
     * @param Category $Category
     */
    public function setParent(Category $Category)
    {
	$this->parent = $Category;
    }
    
    /**
     * @return null | Category
     */
    public function getParent()
    {
	return $this->parent;
    }
    
    /**
     * @param Category $child
     */
    public function AddChild(Category $Category)
    {
	$Category->setParent($this);
	
	$this->children[] = $Category;
    }
    
    /**
     * @return ArrayCollection
     */
    public function getChildren()
    {
	return $this->children;
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
    public function getIndex()
    {
        return $this->index_string;
    }

    /**
     * @param string $index
     */
    public function setIndex($index)
    {
        $this->index_string = $index;
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
     * @return integer
     */
    public function getSortOrder()
    {
        return $this->sort_order;
    }

    /**
     * @param integer $sort_order
     */
    public function setSortOrder($order)
    {
        $this->sort_order = $order;
    }
    
    public function getNameWithParentsString()
    {
	$string = "";
	
	return $this->_prependParentString($string, $this);
    }
    
    private function _prependParentString($string, Category $Category)
    {
	$string = $Category->getName().(!$string ? "" : " - ").$string;
	
	if($Category->getParent())
	{
	    $TempCategory   = $Category->getParent();
	    $string	    = $this->_prependParentString($string, $TempCategory);
	}
	
	return $string;
    }
}