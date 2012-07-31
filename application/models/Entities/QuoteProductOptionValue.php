<?php

namespace Entities;

/** 
 * @Entity (repositoryClass="Repositories\QuoteProductOptionValue") 
 * @Table(name="quote_product_option_values") 
 * @HasLifecycleCallbacks
 */
class QuoteProductOptionValue
{
    /**
     * @Id @Column(type="integer")
     * @GeneratedValue(strategy="AUTO")
     */
    private $id;
    
    /**
     * @ManyToOne(targetEntity="QuoteProduct", inversedBy="QuoteProductOptionValues")
     * @var $QuoteProduct QuoteProduct
     */
    private $QuoteProduct;
    
    /** 
     * @OneToOne(targetEntity="ConfigurableProductOptionValue")
     */     
    private $ConfigurableProductOptionValue;

    /** @Column(type="datetime") */
    private $created;

    /** @Column(type="datetime") */
    private $updated;

    public function __construct()
    {
	$this->created = $this->updated = new \DateTime("now");
    }
           
    /**
     * @PreUpdate
     */
    public function updated()
    {
        $this->updated = new \DateTime("now");
    }

    public function setQuoteProduct(QuoteProduct $QuoteProduct){
	$this->QuoteProduct = $QuoteProduct;
    }
    
    public function getQuoteProduct(){
	return $this->QuoteProduct;
    }
    
    public function setConfigurableProductOptionValue(ConfigurableProductOptionValue $ConfigurableProductOptionValue){
	$this->ConfigurableProductOptionValue = $ConfigurableProductOptionValue;
    }
    
    public function getConfigurableProductOptionValue(){
	return $this->ConfigurableProductOptionValue;
    }
    
    /**
     * Retrieve Option id
     */
    public function getId()
    {
        return $this->id;
    }
    
    public function setQuantity($quantity){
	$this->quantity = $quantity;
    }
    
    public function getQuantity(){
	return $this->quantity;
    }
    
    public function setNote($note){
	$this->note = $note;
    }
    
    public function getNote(){
	return $this->note;
    }
    
    public function getPriceEach(){
	return $this->price_each;
    }
    
    public function setPriceEach($price_each){
	$this->price_each = $price_each;
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
    
    public function populate(array $array){
	foreach ($array as $key => $value) {
	    if(property_exists($this, $key)){
		$this->$key = $value;
	    }
	}
    }
}
