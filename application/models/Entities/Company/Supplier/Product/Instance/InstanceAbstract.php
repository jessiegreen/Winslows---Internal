<?php

namespace Entities\Company\Supplier\Product\Instance;

use Doctrine\Common\Collections\ArrayCollection;

/** 
 * @Entity (repositoryClass="Repositories\Company\Supplier\Product\Instance\InstanceAbstract") 
 * @Table(name="company_supplier_product_instance_instanceabstracts") 
 * @InheritanceType("JOINED")
 * @DiscriminatorColumn(name="discr", type="string")
 * @DiscriminatorMap({
 *			"company_supplier_product_configurable_instance" = "\Entities\Company\Supplier\Product\Configurable\Instance",
 *			"company_supplier_product_simple_instance" = "\Entities\Company\Supplier\Product\Simple\Instance",
 *		    })
 * @HasLifecycleCallbacks
 * @Crud\Entity\Url("supplier-product-instance")
 * @Crud\Entity\Permissions(view={"Admin"}, edit={"Admin"}, create={"Admin"}, delete={"Admin"})
 */
abstract class InstanceAbstract extends \Dataservice_Doctrine_Entity implements \Interfaces\Company\Supplier\Product\Instance\InstanceAbstract
{
    /**
     * @Id @Column(type="integer")
     * @GeneratedValue(strategy="AUTO")
     * @var integer $id
     */
    protected $id;

    /** 
     * @Column(type="string", length=2000) 
     * @var string $note
     */
    protected $note;
    
    /**
     * @ManyToOne(targetEntity="\Entities\Company\Supplier\Product\ProductAbstract")
     * @Crud\Relationship\Permissions(add={"Admin"}, remove={"Admin"})
     * @var \Entities\Company\Supplier\Product\ProductAbstract $Product
     */
    protected $Product;
    
    /**
     * @OneToOne(targetEntity="\Entities\Company\Inventory\Item", mappedBy="Instance", cascade={"persist"}, orphanRemoval=true)
     * @Crud\Relationship\Permissions()
     * @var \Entities\Company\Inventory\Item $InventoryItem
     */
    protected $InventoryItem;
    
    /**
     * @OneToOne(targetEntity="\Entities\Company\Lead\Quote\Item", mappedBy="Instance", cascade={"persist"}, orphanRemoval=true)
     * @Crud\Relationship\Permissions()
     * @var \Entities\Company\Lead\Quote\Item $QuoteItem
     */
    protected $QuoteItem;
    
    /**
     * @OnetoMany(targetEntity="\Entities\Company\Supplier\Product\Instance\File\Image", cascade={"persist", "remove"}, mappedBy="Instance", orphanRemoval=true)
     * @Crud\Relationship\Permissions(add={"Admin"}, remove={"Admin"})
     * @var ArrayCollection $Images
     */
    private $Images;

    public function __construct(\Entities\Company\Supplier\Product\ProductAbstract $Product)
    {
	$this->Product	= $Product;
	$this->Images	= new ArrayCollection();
	
	parent::__construct();
    }
    
    /**
     * @return \Entities\Company\Supplier\Product\ProductAbstract 
     */
    public function getProduct()
    {
	return $this->Product;
    }
    
    /**
     * @param \Entities\Company\Inventory\Item $Item
     */
    public function setInventoryItem(\Entities\Company\Inventory\Item $Item)
    {
	$this->InventoryItem = $Item;
    }
    
    /**
     * @return \Entities\Company\Inventory\Item
     */
    public function getInventoryItem()
    {
	return $this->InventoryItem;
    }
    
    /**
     * @param \Entities\Company\Lead\Quote\Item $Item
     */
    public function setQuoteItem(\Entities\Company\Lead\Quote\Item $Item)
    {
	$this->QuoteItem = $Item;
    }
    
    /**
     * @return \Entities\Company\Lead\Quote\Item
     */
    public function getQuoteItem()
    {
	return $this->QuoteItem;
    }
    
    /**
     * @param File\Image $Image
     */
    public function addImage(File\Image $Image)
    {
	$Image->setProduct($this);
	
	$this->Images[] = $Image;
    }
    
    /**
     * @param File\Image $Image
     */
    public function removeImage(File\Image $Image)
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
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }
    
    /**
     * @param string $note
     */
    public function setNote($note)
    {
	$this->note = $note;
    }
    
    /**
     * @return string
     */
    public function getNote()
    {
	return $this->note;
    }
    
    /**
     * @return \Doctrine\Common\Collections\ArrayCollection
     */
    public function getDeliveryTypes()
    {
	return $this->getProduct()->getDeliveryTypes();
    }
    
    public function toString()
    {
	return $this->getProduct()->getName()." - ".$this->getPriceSafe()->getDisplayPrice();
    }
}
