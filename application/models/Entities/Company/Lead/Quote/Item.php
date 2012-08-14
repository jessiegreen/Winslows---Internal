<?php

namespace Entities\Company\Lead\Quote;

/** 
 * @Entity (repositoryClass="Repositories\Company\Lead\Quote\Item") 
 * @Table(name="company_lead_quote_items") 
 * @HasLifecycleCallbacks
 */
class Item
{    
    /**
     * @Id @Column(type="integer")
     * @GeneratedValue(strategy="AUTO")
     * @var integer $id
     */
    private $id;
    
    /** 
     * @Column(type="integer")
     * @var integer $quantity
     */
    private $quantity;
    
    /**
     * @ManyToOne(targetEntity="\Entities\Company\Lead\Quote", inversedBy="Items")
     * @var \Entities\Company\Lead\Quote $Quote
     */
    private $Quote;
    
    /**
     * @OneToOne(targetEntity="\Entities\Company\Supplier\Product\Instance\InstanceAbstract", cascade={"persist", "remove"}, orphanRemoval=true)
     * @var \Entities\Company\Supplier\Product\Instance\InstanceAbstract $Instance
     */
    private $Instance;
    
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
     * @param array $array
     */
    public function populate(array $array)
    {
	foreach ($array as $key => $value) 
	{
	    if(property_exists($this, $key))
	    {
		$this->$key = $value;
	    }
	}
    }
}
