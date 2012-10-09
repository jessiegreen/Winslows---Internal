<?php

namespace Entities\Company\Lead\Quote;

/** 
 * @Entity (repositoryClass="Repositories\Company\Lead\Quote\Item") 
 * @Table(name="company_lead_quote_items") 
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
     * @ManyToOne(targetEntity="\Entities\Company\Lead\Quote\Item\SaleType\SaleTypeAbstract", inversedBy="Items")
     * @var \Entities\Company\Lead\Quote\Item\SaleType\SaleTypeAbstract $SaleType
     */
    protected $SaleType;
    
    /** 
     * @Column(type="string")
     * @var string $name
     */
    protected $name;
    
    /**
     * @ManyToOne(targetEntity="\Entities\Company\Lead\Quote", inversedBy="Items")
     * @var \Entities\Company\Lead\Quote $Quote
     */
    protected $Quote;
    
    /**
     * @OneToOne(targetEntity="\Entities\Company\Supplier\Product\Instance\InstanceAbstract", cascade={"persist", "remove"}, orphanRemoval=true)
     * @var \Entities\Company\Supplier\Product\Instance\InstanceAbstract $Instance
     */
    protected $Instance;
    
    public function __construct()
    {
	if(!$this->getSaleType())
	{
	    $SaleType = new Item\SaleType\Cash();
	    
	    $SaleType->addItem($this);
	}
	
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
     * @param \Entities\Company\Lead\Quote $Company_Lead_Quote
     */
    public function setQuote(\Entities\Company\Lead\Quote $Quote)
    {
	$this->Quote = $Quote;
    }
    
    /**
     * @return \Entities\Company\Lead\Quote
     */
    public function getQuote()
    {
	return $this->Quote;
    }
    
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
     * @param string $name
     */
    public function setName($name)
    {
	$this->name = $name;
    }
    
    /**
     * @return string
     */
    public function getName()
    {
	return $this->name;
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
     * @param Item\SaleType\SaleTypeAbstract $SaleType
     */
    public function setSaleType(Item\SaleType\SaleTypeAbstract $SaleType)
    {
	$this->SaleType = $SaleType;
    }
    
    /**
     * @return Item\SaleType\SaleTypeAbstract
     */
    public function getSaleType()
    {
	return $this->SaleType;
    }
    
    /**
     * @return boolean
     */
    public function isRtoSaleType()
    {
	if(!$this->getSaleType() || $this->getSaleType()->getDescriminator() !== "Rto")
	    return false;
	
	return true;
    }
    
    /**
     * @return string
     */
    public function getSaleTypeDisplay()
    {
	if($this->getSaleType())return $this->getSaleType()->getName();
	
	return "Not Set";
    }
    
    public function getTotalWithFeesPrice()
    {
	$Price = $this->getTotalWithFeesEachPrice();
	
	$Price->multiply($this->getQuantity());
	
	return $Price;
    }
    
    /**
     * @return \Dataservice_Price
     */
    public function getTotalWithFeesEachPrice()
    {
	$Price = new \Dataservice_Price();
	
	$Price->addPrice($this->getPaymentsTotalAmountEachPrice());	
	$Price->addPrice($this->getFeesEachPrice());
	
	return $Price;
    }
    
    public function getDueAtSaleEachPrice()
    {
	$Price = new \Dataservice_Price();
	
	$Price->addPrice($this->getDownPaymentEachPrice());
	$Price->addPrice($this->getFeesEachPrice());
	
	return $Price;
    }
    
    public function getDueAtSaleTotalPrice()
    {
	$Price = $this->getDueAtSaleEachPrice();
	
	$Price->multiply($this->quantity);
	
	return $Price;
    }
    
    public function getRemainderDueEachPrice()
    {
	$Price = $this->getPaymentsTotalAmountEachPrice();
	
	$Price->subtract($this->getDownPaymentEachPrice());
	
	return $Price;
    }
    
    public function getRemainderDueTotalPrice()
    {
	$Price = $this->getRemainderDueEachPrice();
	
	$Price->multiply($this->getQuantity());
	
	return $Price;
    }
    
    public function getFeesEachPrice()
    {
	$Price = new \Dataservice_Price();
	
	$this->getSaleType()->getFeesPrice($this->getProductEachPrice());
	
	return $Price;
    }
    
    public function getFeesTotalPrice()
    {
	$Price = $this->getFeesEachPrice();
	
	$Price->multiply($this->getQuantity());
	
	return $Price;
    }
    
    public function getPaymentsTotalAmountEachPrice()
    {
	return $this->getSaleType()->getPaymentsTotalAmountPrice($this->getProductEachPrice());
    }
    
    public function getPaymentsTotalAmountTotalPrice()
    {
	$Price = $this->getPaymentsTotalAmountEachPrice();
	
	$Price->multiply($this->getQuantity());
	
	return $Price;
    }
    
    public function getDownPaymentEachPrice()
    {
	return $this->getSaleType()->getDownPaymentPrice($this->getProductEachPrice());
    }
    
    public function getRemainingPaymentsCount()
    {
	return ($this->getSaleType()->getPaymentsCount($this->getProductEachPrice()) - 1);
    }
    
    public function getRemainingPaymentsAmountEach()
    {
	return $this->getSaleType()->getPaymentsAmountPrice($this->getProductEachPrice());
    }
    
    public function getRemainingPaymentsAmountTotal()
    {
	$Price = $this->getRemainingPaymentsAmountEach();
	
	$Price->multiply($this->getQuantity());
	
	return $Price;
    }
    
    public function getDownPaymentTotalPrice()
    {
	$Price = $this->getDownPaymentEachPrice();
	
	$Price->multiply($this->getQuantity());
	
	return $Price;
    }
    
    public function getProductEachPrice()
    {
	return $this->getInstance()->getPriceSafe();
    }
    
    public function getProductTotalPrice()
    {
	$Price = $this->getProductEachPrice();
	
	$Price->multiply($this->getQuantity());
	
	return $Price;
    }
    
    /**
     * @return \Dataservice_Result
     */
    public function isValid()
    {
	$SaleType   = $this->getSaleType();
	$Result	    = new \Dataservice_Result(true);
	
	if(!$SaleType)$Result->setValidFalse("Sale Type Not Set For Item. Check Items");
	
	if(!$this->getSaleType()->isProductAllowed($this->getInstance()->getProduct()))
	    $Result->setValidFalse("Product Not Allowed With That Sale Type. Change Sale Type");
	
	if($this->isRtoSaleType())
	{
	    $Application = $this->getQuote()->getLead()->getApplication($this->getSaleType()->getProgram()->getRtoProvider()->getNameIndex());

	    if(!$Application)$Result->setValidFalse("No Rto Application On File. Fill Out Rto Provider Application.");
	}
	
	return $Result;
    }
}
