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
     * @Column(type="integer")
     * @var integer $quantity
     */
    private $quantity;
    
    /**
     * @ManyToOne(targetEntity="Company\Lead\Quote", inversedBy="Company_Lead_Quote_Products")
     * @var \Entities\Company\Lead\Quote $Company_Lead_Quote
     */
    private $Company_Lead_Quote;
    
    /**
     * @OneToOne(targetEntity="Company\Supplier\Product\Instance")
     * @var \Entities\Company\Supplier\Product\Instance $Company_Supplier_Product_Instance
     */
    private $Company_Supplier_Product_Instance;

    /**
     * @param \Entities\Company\Lead\Quote $Company_Lead_Quote
     */
    public function setCompanyLeadQuote(\Entities\Company\Lead\Quote $Company_Lead_Quote){
	$this->Company_Lead_Quote = $Company_Lead_Quote;
    }
    
    /**
     * @return \Entities\Company\Lead\Quote
     */
    public function getCompanyLeadQuote(){
	return $this->Company_Lead_Quote;
    }
    
    /**
     * @param \Entities\Company\Lead\Quote\Company\Supplier\Product\Instance $Company_Supplier_Product_Instance
     */
    public function setCompanySupplierProductInstance(Company\Supplier\Product\Instance $Company_Supplier_Product_Instance){
	$this->Company_Supplier_Product_Instance = $Company_Supplier_Product_Instance;
    }
    
    /**
     * @return \Entities\Company\Supplier\Product\Instance
     */
    public function getProductInstance(){
	return $this->Company_Supplier_Product_Instance;
    }
    
    /**
     * @param integer $quantity
     */
    public function setQuantity(integer $quantity){
	$this->quantity = $quantity;
    }
    
    /**
     * @return integer
     */
    public function getQuantity(){
	return $this->quantity;
    }
    
    /**
     * @param array $array
     */
    public function populate(array $array){
	foreach ($array as $key => $value) {
	    if(property_exists($this, $key)){
		$this->$key = $value;
	    }
	}
    }
}
