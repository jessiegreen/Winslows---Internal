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
namespace Entities;
use Doctrine\Common\Collections\ArrayCollection;

/** 
 * @Entity (repositoryClass="Repositories\Quote") 
 * @Table(name="quotes") 
 */

class Quote extends QuoteBase
{    
    /** 
     * @ManyToOne(targetEntity="Lead", inversedBy="Quotes")
     */     
    private $Lead;
    
    /** 
     * @ManyToOne(targetEntity="Employee", inversedBy="Quotes")
     */     
    private $Employee;
    
    /**
     * Bidirectional - One-To-Many (INVERSE SIDE)
     *
     * @OneToMany(targetEntity="QuoteProduct", mappedBy="Quote", cascade={"persist"})
     */
    private $QuoteProducts;
    
    public function __construct()
    {
	$this->QuoteProducts = new ArrayCollection();
	parent::__construct();
    }
    
    public function addQuoteProduct(QuoteProduct $QuoteProduct)
    {
	$QuoteProduct->setQuote($this);
        $this->QuoteProducts[] = $QuoteProduct;
    }
    
    public function getQuoteProducts()
    {
	return $this->QuoteProducts;
    }
    
    public function setLead(Lead $Lead)
    {
        $this->Lead = $Lead;
    }
    
    public function getLead()
    {
	return $this->Lead;
    }
    
    public function setEmployee(Employee $Employee)
    {
        $this->Employee = $Employee;
    }
    
    public function getEmployee()
    {
	return $this->Employee;
    }
    
    public function populate(array $array){
	foreach ($array as $key => $value) {
	    if(property_exists($this, $key)){
		$this->$key = $value;
	    }
	}
    }
}
