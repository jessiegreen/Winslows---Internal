<?php
namespace Entities\Company\Supplier\Product\DeliveryType;

use Doctrine\Common\Collections\ArrayCollection;

/** 
 * @Entity (repositoryClass="Repositories\Company\Supplier\Product\DeliveryType\DeliveryAbstract") 
 * @Table(name="company_supplier_product_deliverytype_deliverytypeabstracts") 
 * @InheritanceType("JOINED")
 * @DiscriminatorColumn(name="discr", type="string")
 * @DiscriminatorMap({
 *			"company_supplier_product_delivery_woodframe" = "\Entities\Company\Supplier\Product\DeliveryType\WoodFrame", 
 *			"company_supplier_product_delivery_metalframe" = "\Entities\Company\Supplier\Product\DeliveryType\MetalFrame",
 *			})
 * @HasLifecycleCallbacks
 */
class DeliveryTypeAbstract extends \Dataservice_Doctrine_Entity
{
    const TYPE_MetalFrame   = "MetalFrame";
    const TYPE_WoodFrame    = "WoodFrame";
    const TYPE_Base	    = "Base";

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
    protected $name;
    
    /** 
     * @Column(type="string", length=255) 
     * @var string $index_string
     */
    protected $index_string;
    
    /** 
     * @Column(type="string", length=2000) 
     * @var string $part_number
     */
    protected $description;
    
    /**
     * @ManytoMany(targetEntity="\Entities\Company\Supplier\Product\ProductAbstract", mappedBy="DeliveryTypes", cascade={"persist"})
     * @var ArrayCollection $Products
     */
    protected $Products;
    
    /**
     * Bidirectional - One-To-Many (INVERSE SIDE)
     *
     * @OneToMany(targetEntity="\Entities\Company\Lead\Quote\Item\Delivery", mappedBy="DeliveryType", cascade={"persist"})
     * @var ArrayCollection $Deliveries
     */
    private $Deliveries;
    
    public function __construct()
    {
	$this->Products	    = new ArrayCollection();
	$this->Deliveries   = new ArrayCollection();
	
	parent::__construct();
    }
    
    /**
     * @param \Entities\Company\Supplier\Product\ProductAbstract $Product
     */
    public function addProduct(\Entities\Company\Supplier\Product\ProductAbstract $Product)
    {
	if(!$this->Products->contains($Product))
	    $this->Products[] = $Product;
    }
    
    /**
     * @param \Entities\Company\Supplier\Product\ProductAbstract $Product
     */
    public function removeProduct(\Entities\Company\Supplier\Product\ProductAbstract $Product)
    {
	$this->Products->removeElement($Product);
    }
    
    /**
     * @return \Doctrine\Common\Collections\ArrayCollection
     */
    public function getProducts()
    {
	return $this->Products;
    }
    
    /**
     * @param \Entities\Company\Lead\Quote\Item\Delivery $Delivery
     */
    public function addDelivery(\Entities\Company\Lead\Quote\Item\Delivery $Delivery)
    {
	$Delivery->setDeliveryType($this);
	
	$this->Items->add($Delivery);
    }
    
    /**
     * @return ArrayCollection
     */
    public function getDeliveries()
    {
	return $this->Deliveries;
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
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @param string $description
     */
    public function setDescription($description)
    {
        $this->description = $description;
    }
    
    /**
     * @return string
     */
    public function getDescriminator()
    {
	return static::TYPE_Base;
    }
}
