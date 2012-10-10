<?php
/**
 * Name:
 * Location:
 *
 * Description for class (if any)...
 *
 * @author     Jessie Green <jessie.winslows@gmail.com>
 * @copyright  2012 Winslows inc.
 * @version    Release: @package_version@
 */
namespace Entities\Company\Lead;

use Doctrine\Common\Collections\ArrayCollection;

/** 
 * @Entity (repositoryClass="Repositories\Company\Lead\Quote") 
 * @Table(name="company_lead_quotes") 
 */

class Quote extends Quote\QuoteAbstract
{    
    /** 
     * @ManyToOne(targetEntity="\Entities\Company\Lead", inversedBy="Quotes")
     * @var \Entities\Company\Lead $Lead
     */     
    protected $Lead;
    
    /**
     * Bidirectional - One-To-Many (INVERSE SIDE)
     *
     * @OneToMany(targetEntity="\Entities\Company\Lead\Quote\Item", mappedBy="Quote", cascade={"persist", "remove"}, orphanRemoval=true)
     * @var array $Items
     */
    protected $Items;
    
    /** 
     * @OneToOne(targetEntity="\Entities\Company\Lead\Quote\Sale", inversedBy="Quote")
     * @var \Entities\Company\Lead\Quote\Sale
     */     
    protected $Sale;
    
    public function __construct()
    {
	$this->Items = new ArrayCollection();
	
	parent::__construct();
    }
    
    /**
     * @param \Entities\Company\Lead\Quote\Item $Item
     */
    public function addItem(Quote\Item $Item)
    {
	$Item->setQuote($this);
        $this->Items[] = $Item;
    }
    
    /**
     * @return array
     */
    public function getItems()
    {
	return $this->Items;
    }
    
    /**
     * @param \Entities\Company\Lead $Lead
     */
    public function setLead(\Entities\Company\Lead $Lead)
    {
        $this->Lead = $Lead;
    }
    
    /**
     * @return \Entities\Company\Lead
     */
    public function getLead()
    {
	return $this->Lead;
    }
    
    /** 
     * @return Quote\Sale
     */
    public function getSale()
    {
	return $this->Sale;
    }
    
    /**
     * @param Quote\Sale $Sale
     */
    public function setSale(Quote\Sale $Sale)
    {
	$Sale->setQuote($this);
	
	$this->Sale = $Sale;
    }
    
    public function getDueAtSaleTotalPrice()
    {
	$DuePrice = new \Dataservice_Price();
	
	/* @var $Item \Entities\Company\Lead\Quote\Item */ 
	foreach ($this->getItems() as $Item)
	{
	    $DuePrice->addPrice($Item->getDueAtSaleTotalPrice());
	}
	
	return $DuePrice;
    }
    
    /**
     * @return integer
     */
    public function getTotal()
    {
	$this->total = 0;
	
	/* @var $Item \Entities\Company\Lead\Quote\Item */
	foreach ($this->getItems() as $Item)
	{
	    try 
	    {
		$this->total += 
			$Item->getQuantity() * 
			$Item->getInstance()
			    ->getPriceSafe()
			    ->getPrice();
	    } 
	    catch (\Exception $exc) 
	    {
		$this->total = 0;
	    }
	}
	
        return $this->total;
    }
    
    public function getTotalSafe()
    {
	try
	{
	    $total = $this->getTotal();
	}
	catch (\Exception $exc)
	{
	    $total = 0;
	}
	
	return $total;
    }
    
    public function getTotalItemsQuantity()
    {
	$total = 0;
	
	/* @var $Item \Entities\Company\Lead\Quote\Item */
	foreach ($this->getItems() as $Item)
	{
	    $total += $Item->getQuantity();
	}
	
        return $total;
    }
    
    /**
     * @param \Entities\Company\Lead\Quote\Item $Item
     * @return boolean
     */
    public function removeItem(\Entities\Company\Lead\Quote\Item $Item)
    {
	$this->Items->removeElement($Item);
    }
    
    public function isValid()
    {
	$QuoteResult = new \Dataservice_Result(true);
	$Items	     = $this->getItems();
	
	if($Items->count() < 1)
	{
	    $QuoteResult->setValidFalse("Quote has no Items. Please add an Item.");
	}
	
	/* @var $Item \Entities\Company\Lead\Quote\Item */
	foreach ($this->getItems() as $Item)
	{
	    $ItemResult = $Item->isValid();
	    
	    if(!$ItemResult->isValid())
	    {
		$QuoteResult->setValidFalse();
		$QuoteResult->addErrorMessages($ItemResult->getErrorMessages());
	    }
	}
	
	return $QuoteResult;
    }
}
