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
    private $id;
    
    /** 
     * @Column(type="integer")
     * @var integer $quantity
     */
    private $quantity;
    
    /** 
     * @Column(type="string")
     * @var string $sale_type
     */
    private $sale_type;
    
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
    
    private $cash_sale_type_index = "cash";
    
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
     * @param string $sale_type
     */
    public function setSaleType($sale_type)
    {
	$this->sale_type = $sale_type;
    }
    
    /**
     * @return string
     */
    public function getSaleType()
    {
	return $this->sale_type;
    }
    
    /**
     * @return boolean
     */
    public function isRtoSaleType()
    {
	if(!$this->getSaleType() || $this->getSaleType() === $this->cash_sale_type_index)
	    return false;
	
	return true;
    }
    
    /**
     * @return string
     */
    public function getSaleTypeDisplay()
    {
	$options = \Services\Company\Lead\Quote\Item::factory()->getSaleTypeOptions($this);
	
	if(key_exists($this->sale_type, $options))
	    return $options[$this->sale_type];
	
	return "";
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
