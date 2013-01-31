<?php

namespace Entities\Company\Lead\Quote\Item;

/** 
 * @Entity (repositoryClass="Repositories\Company\Lead\Quote\Item\Delivery") 
 * @Table(name="company_lead_quote_item_deliveries") 
 * @Crud\Entity\Url(value="lead-quote-item-delivery")
 * @Crud\Entity\Permissions(view={"Admin", "Manager"}, edit={"Admin"}, create={"Admin"}, delete={"Admin"})
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
     * @ManyToOne(targetEntity="\Entities\Company\Address\AddressAbstract", cascade={"persist"})
     * @var \Entities\Company\Address\AddressAbstract $Origination_Address
     */
    protected $Origination_Address;
    
    /**
     * @ManyToOne(targetEntity="\Entities\Company\Address\AddressAbstract", cascade={"persist"})
     * @var \Entities\Company\Address\AddressAbstract $Destination_Address
     */
    protected $Destination_Address;
    
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
     * @return \Entities\Company\Address\AddressAbstract
     */
    public function getDestinationAddress()
    {
	return $this->Destination_Address;
    }
    
    /**
     * @param \Entities\Company\Address\AddressAbstract $Address
     */
    public function setDestinationAddress(\Entities\Company\Address\AddressAbstract $Address)
    {
	$this->Destination_Address = $Address;
    }
    
    /**
     * @return \Entities\Company\Address\AddressAbstract
     */
    public function getOriginationAddress()
    {
	return $this->Origination_Address;
    }
    
    /**
     * @param \Entities\Company\Address\AddressAbstract $Address
     */
    public function setOriginationAddress(\Entities\Company\Address\AddressAbstract $Address)
    {
	$this->Origination_Address = $Address;
    }
    
    public function getAddressLabel()
    {
	return $this->getDeliveryType()->getAddressLabel();
    }
    
    /**
     * @return \Doctrine\Common\Collections\ArrayCollection
     */
    public function getOriginationAddresses()
    {
	return $this->getDeliveryType()->getOriginationAddresses($this->getItem());
    }
    
    /**
     * @return \Doctrine\Common\Collections\ArrayCollection
     */
    public function getDestinationAddresses()
    {
	return $this->getDeliveryType()->getDestinationAddresses($this->getItem());
    }
}
