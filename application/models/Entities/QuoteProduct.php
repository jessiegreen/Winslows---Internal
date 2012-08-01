<?php

namespace Entities;
use Doctrine\Common\Collections\ArrayCollection;

/** 
 * @Entity (repositoryClass="Repositories\QuoteProduct") 
 * @Table(name="quote_products") 
 * @HasLifecycleCallbacks
 */
class QuoteProduct
{
    /**
     * @Id @Column(type="integer")
     * @GeneratedValue(strategy="AUTO")
     */
    private $id;

    /** @Column(type="string", length=2000) */
    private $note;
    
    /** @Column(type="integer") */
    private $quantity;
    
    /**
    * @Column(type="decimal", precision=40, scale=2)
    */
    private $price_each;
    
    /**
     * @ManyToOne(targetEntity="Quote", inversedBy="QuoteProducts")
     * @var $Quote Quote
     */
    private $Quote;
    
    /**
     * @ManyToOne(targetEntity="Product")
     * @var $Product Product
     */
    private $Product;
    
    /**
     * Bidirectional - One-To-Many (INVERSE SIDE)
     *
     * @OneToMany(targetEntity="QuoteProductOptionValue", mappedBy="QuoteProduct", cascade={"persist"})
     */
    private $QuoteProductOptionValues;

    /** @Column(type="datetime") */
    private $created;

    /** @Column(type="datetime") */
    private $updated;

    public function __construct()
    {
	$this->QuoteProductOptionValues = new ArrayCollection();
	$this->created			= $this->updated = new \DateTime("now");
    }
           
    /**
     * @PreUpdate
     */
    public function updated()
    {
        $this->updated = new \DateTime("now");
    }
    
    public function addQuoteProductOptionValue(QuoteProductOptionValue $QuoteProductOptionValue)
    {
	$QuoteProductOptionValue->setQuoteProduct($this);
        $this->QuoteProductOptionValues[] = $QuoteProductOptionValue;
    }
    
    public function getQuoteProductOptionValues()
    {
	return $this->QuoteProductOptionValues;
    }

    public function setQuote(Quote $Quote){
	$this->Quote = $Quote;
    }
    
    public function getQuote(){
	return $this->Quote;
    }
    
    public function setProduct(Product $Product){
	$this->Product = $Product;
    }
    
    public function getProduct(){
	return $this->Product;
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
