<?php

namespace Entities;
use Doctrine\Common\Collections\ArrayCollection;

/** 
 * @Entity (repositoryClass="Repositories\Order") 
 * @Table(name="orders") 
 * @HasLifecycleCallbacks
 */
class Order
{
    /**
     * @Id @Column(type="integer")
     * @GeneratedValue(strategy="AUTO")
     */
    private $id;

    /** @Column(type="datetime") */
    private $purchased_date;
    
    /** @Column(type="string", length=255) */
    private $origin;
    
    /** @Column(type="datetime") */
    private $created;

    /**
     * Bidirectional - One-To-Many (INVERSE SIDE)
     * 
     * @OneToMany(targetEntity="OrderItem", mappedBy="order", cascade={"persist", "remove"}, orphanRemoval=true)
     */
    private $order_items;

    public function __construct()
    {
	$this->order_items	= new ArrayCollection();
	$this->created	= $this->updated = new \DateTime("now");
    }
    
    /**
     * Add item to order.
     * @param OrderItem $order_item
     */
    public function addOrderItem(OrderItem $order_item)
    {
	$order_item->setOrder($this);
        $this->order_items[] = $order_item;
    }
    
    /**
     * Retrieve order's associated products.
     */
    public function getOrderItems()
    {
      return $this->order_items;
    }

    /**
     * Retrieve Order id
     */
    public function getId()
    {
        return $this->id;
    }
    
    public function getPurchasedDate()
    {
	return $this->purchased_date;
    }

    public function getOrigin()
    {
        return $this->origin;
    }

    public function setOrigin($origin)
    {
        $this->origin = $origin;
    }
    
    public function getPartNumber()
    {
        return $this->part_number;
    }

    public function setPartNumber($partnumber)
    {
        $this->part_number = $partnumber;
    }
    
    public function getDescription()
    {
        return $this->description;
    }

    public function setDescription($description)
    {
        $this->description = $description;
    }
    
    public function getCreated()
    {
        return $this->created;
    }

    public function setCreated($created)
    {
        $this->created = $created;
    }

    public function getUpdated()
    {
        return $this->updated;
    }
    
    /**
     * @PreUpdate
     */
    public function updated()
    {
        $this->updated = new \DateTime("now");
    }

}
