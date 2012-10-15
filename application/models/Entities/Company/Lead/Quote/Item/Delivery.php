<?php

namespace Entities\Company\Lead\Quote\Item;

/** 
 * @Entity (repositoryClass="Repositories\Company\Lead\Quote\Item\Delivery") 
 * @Table(name="company_lead_quote_item_deliveries") 
 * @HasLifecycleCallbacks
 */
class Delivery extends \Dataservice_Doctrine_Entity
{    
    /**
     * @Id @Column(type="integer")
     * @GeneratedValue(strategy="AUTO")
     * @var integer $id
     */
    protected $id;
    
    /**
     * @OneToOne(targetEntity="\Entities\Company\Lead\Quote\Item", inversedBy="Delivery", cascade={"persist"})
     * @var \Entities\Company\Lead\Quote\Item $Item
     */
    protected $Item;
    
    /**
     * @ManyToOne(targetEntity="\Entities\Company\Supplier\Product\DeliveryType\DeliveryTypeAbstract", inversedBy="Deliveries")
     * @var \Entities\Company\Supplier\Product\DeliveryType\DeliveryTypeAbstract $DeliveryType
     */
    protected $DeliveryType;
    
    /**
     * @ManyToOne(targetEntity="\Entities\Person\Address", cascade={"persist"})
     * @var \Entities\Person\Address $Address
     */
    protected $Address;
    
    public function __construct(\Entities\Company\Supplier\Product\DeliveryType\DeliveryTypeAbstract $DeliveryType, \Entities\Company\Lead\Quote\Item $Item)
    {
	$this->DeliveryType = $DeliveryType;
	$this->Item	    = $Item;
	
	parent::__construct();
    }
    
    /**
     * @return integer
     */
    public function getId()
    {
	return $this->id;
    }
    
    /**
     * @return \Entities\Company\Supplier\Product\DeliveryType\DeliveryTypeAbstract
     */
    public function getDeliveryType()
    {
	return $this->DeliveryType;
    }
    
    /**
     * @return \Entities\Company\Lead\Quote\Item
     */
    public function getItem()
    {
	return $this->Item;
    }
    
    /**
     * @param \Entities\Company\Lead\Quote\Item $Item
     */
    public function setItem(\Entities\Company\Lead\Quote\Item $Item)
    {
	$this->Item = $Item;
    }
    
    /**
     * @return \Entities\Person\Address
     */
    public function getAddress()
    {
	return $this->Address;
    }
    
    /**
     * @param \Entities\Person\Address $Address
     */
    public function setAddress(\Entities\Person\Address $Address)
    {
	$this->Address = $Address;
    }
    
    public function getAddressLabel()
    {
	return $this->getDeliveryType()->getAddressLabel();
    }
    
    public function getAddresses()
    {
	return $this->getDeliveryType()->getAddresses($this->getItem());
    }
}
