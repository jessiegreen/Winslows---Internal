<?php
namespace Entities\Company\Inventory;

/** 
 * @Entity (repositoryClass="Repositories\Company\Inventory\Item") 
 * @Table(name="company_inventory_items") 
 * @Crud\Entity\Url(value="inventory-item")
 * @Crud\Entity\Permissions(view={"Admin", "Manager"}, edit={"Admin"}, create={"Admin"}, delete={"Admin"})
 * @HasLifecycleCallbacks
 */
class Item extends \Dataservice_Doctrine_Entity
{    
    /**
     * @Id @Column(type="integer")
     * @GeneratedValue(strategy="AUTO")
     * @var integer $id
     */
    protected $id;
    
    /** 
     * @Column(type="integer")
     * @var integer $quantity
     */
    protected $quantity;
    
    /**
     * @OneToOne(targetEntity="\Entities\Company\Supplier\Product\Instance\InstanceAbstract", inversedBy="InventoryItem", cascade={"persist"}, orphanRemoval=true)
     * @Crud\Relationship\Permissions(add={"Admin"}, remove={"Admin"})
     * @var \Entities\Company\Supplier\Product\Instance\InstanceAbstract $Instance
     */
    protected $Instance;
    
    /** 
     * @ManyToOne(targetEntity="\Entities\Company\Inventory", cascade="persist")
     * @Crud\Relationship\Permissions()
     * @var \Entities\Company\Inventory $Inventory
     */     
    protected $Inventory;
    
    /**
     * @ManyToOne(targetEntity="\Entities\Company\Location\LocationAbstract", inversedBy="InventoryItems")
     * @Crud\Relationship\Permissions(add={"Admin"}, remove={"Admin"})
     * @var \Entities\Company\Location\LocationAbstract $Location
     */
    protected $Location;
    
    /**
     * @param \Entities\Company\Supplier\Product\Instance\InstanceAbstract $Instance
     */
    public function setInstance(\Entities\Company\Supplier\Product\Instance\InstanceAbstract $Instance)
    {
	$Instance->setInventoryItem($this);
	
	$this->Instance = $Instance;
    }
    
    /**
     * @return \Entities\Company\Supplier\Product\Instance\InstanceAbstract
     */
    public function getInstance()
    {
	return $this->Instance;
    }
    
    /**
     * @param \Entities\Company\Location\LocationAbstract $Location
     */
    public function setLocation(\Entities\Company\Location\LocationAbstract $Location)
    {
	$this->Location = $Location;
    }
    
    /**
     * @return \Entities\Company\Location\LocationAbstract
     */
    public function getLocation()
    {
	return $this->Location;
    }
    
    /**
     * @param \Entities\Company\Inventory $Inventory
     */
    public function setInventory(\Entities\Company\Inventory $Inventory)
    {
	$this->Inventory = $Inventory;
    }
    
    /**
     * @return \Entities\Company\Inventory
     */
    public function getInventory()
    {
	return $this->Inventory;
    }
    
    /**
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }
    
    /**
     * @param integer $quantity
     */
    public function setQuantity($quantity)
    {
	$this->quantity = $quantity;
    }
    
    /**
     * @return integer
     */
    public function getQuantity()
    {
	return $this->quantity;
    }
    
    public function getImage()
    {
	$InstanceImages = $this->getInstance()->getImages();
	
	if($InstanceImages->count() > 0)
	    return $InstanceImages->first();
	
	$ProductImages = $this->getInstance()->getProduct()->getImages();
	
	if($ProductImages->count() > 0)
	    return $ProductImages->first();
	
	return false;
    }
    
    public function populate(array $array) 
    {
	$Inventory = $this->_getEntityFromArray($array, "Entities\Company\Inventory", "inventory_id");
	
	if($Inventory && $Inventory->getId())
	    $this->setInventory($Inventory);
	
	$Location = $this->_getEntityFromArray($array, "Entities\Company\Location\LocationAbstract", "location_id");
	
	if($Location && $Location->getId())
	    $this->setLocation($Location);
	
	if(!$this->getInstance())
	{
	    /* @var $Product Entities\Company\Supplier\Product\ProductAbstract */
	    $Product = $this->_getEntityFromArray($array, "Entities\Company\Supplier\Product\ProductAbstract", "product_id");
	
	    if($Product && $Product->getId())
	    {
		$this->setInstance($Product->createInstance());
	    }
	}
	
	parent::populate($array);
    }
    
    public function toString() 
    {
	$string = $this->getQuantity()." - ";
	
	$string .= $this->getInstance() ? $this->getInstance()->getProduct()->getName() : " *No product instance* ";
	
	if($this->getLocation())$string .= " - ".$this->getLocation()->getName();
	
	return $string;
    }
}
