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
     * @ManyToOne(targetEntity="Company\Lead", inversedBy="Quotes")
     */     
    private $Lead;
    
    /** 
     * @ManyToOne(targetEntity="Company\Employee", inversedBy="Quotes")
     */     
    private $Employee;
    
    /**
     * Bidirectional - One-To-Many (INVERSE SIDE)
     *
     * @OneToMany(targetEntity="Company\Lead\Quote\Product", mappedBy="Quote", cascade={"persist"})
     */
    private $Products;
    
    public function __construct()
    {
	$this->Products = new ArrayCollection();
	parent::__construct();
    }
    
    public function addProduct(Quote\Product $QuoteProduct)
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
