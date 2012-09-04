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
     * @return integer
     */
    public function getTotal()
    {
	$this->total = 0;
	
	/* @var $Item \Entities\Company\Lead\Quote\Item */
	foreach ($this->getItems() as $Item)
	{
	    $this->total += $Item->getQuantity() * $Item->getInstance()->getPrice()->getPrice();
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
}
