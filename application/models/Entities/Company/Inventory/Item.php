<?php

namespace Entities\Company\Inventory;

/** 
 * @Entity (repositoryClass="Repositories\Company\Inventory\Item") 
 * @Table(name="company_inventory_items") 
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
     * @OneToOne(targetEntity="\Entities\Company\Supplier\Product\Instance\InstanceAbstract", cascade={"persist", "remove"}, orphanRemoval=true)
     * @var \Entities\Company\Supplier\Product\Instance\InstanceAbstract $Instance
     */
    protected $Instance;
    
    /** 
     * @ManyToOne(targetEntity="\Entities\Company\Inventory", cascade="persist")
     * @var \Entities\Company\Inventory $Inventory
     */     
    protected $Inventory;
    
    /**
     * @ManyToOne(targetEntity="\Entities\Company\Location\LocationAbstract", inversedBy="InventoryItems")
     * @var \Entities\Company\Location\LocationAbstract $Location
     */
    protected $Location;
    
    /**
     * @param \Entities\Company\Supplier\Product\Instance\InstanceAbstract $Instance
     */
    public function setInstance(\Entities\Company\Supplier\Product\Instance\InstanceAbstract $Instance)
    {
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
}
