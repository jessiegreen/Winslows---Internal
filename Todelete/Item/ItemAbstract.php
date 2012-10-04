<?php

namespace Entities\Company\Inventory\Item;

/** 
 * @Entity (repositoryClass="Repositories\Company\Inventory\Item\ItemAbstract") 
 * @Table(name="company_inventory_item_itemabstracts") 
 * @InheritanceType("JOINED")
 * @DiscriminatorColumn(name="discr", type="string")
 * @DiscriminatorMap({
 *			"company_inventory_item_product_configurable" = "\Entities\Company\Inventory\Item\ProductConfigurable",
 *			"company_inventory_item_product_simple" = "\Entities\Company\Inventory\Item\ProductSimple"
 *		    })
 * @HasLifecycleCallbacks
 */
class ItemAbstract extends \Dataservice_Doctrine_Entity
{
    const TYPE_ProductConfigurable  = "ProductConfigurable";
    const TYPE_ProductSimple	    = "ProductSimple";
    
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
     * @ManyToOne(targetEntity="\Entities\Company\Inventory", cascade="persist")
     * @var \Entities\Company\Inventory $Inventory
     */     
    protected $Inventory;
    
    /**
     * @ManyToOne(targetEntity="\Entities\Location\LocationAbstract", inversedBy="InventoryItems")
     * @var \Entities\Location\LocationAbstract $Location
     */
    protected $Location;
    
    /**
     * @param \Entities\Location\LocationAbstract $Location
     */
    public function setLocation(\Entities\Location\LocationAbstract $Location)
    {
	$this->Location = $Location;
    }
    
    /**
     * @return \Entities\Location\LocationAbstract
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
    
    /**
     * @return string
     */
    public function getDescriminator()
    {
	return static::TYPE_Base;
    }
    
    /**
     * @return array
     */
    public function getDisplayFields()
    {
	
    }
}
