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
namespace Entities\Company\Lead\Quote;

/** 
 * @Entity (repositoryClass="Repositories\Company\Lead\Quote\Sale") 
 * @Table(name="company_lead_quote_sales") 
 */

class Sale extends \Entities\Company\Sale\SaleAbstract
{
    /**
     * @OneToOne(targetEntity="\Entities\Company\Lead\Quote", inversedBy="Sale", cascade={"persist"})
     * @var \Entities\Company\Lead\Quote $Quote
     */
    protected $Quote;
    
    public function __construct(\Entities\Company\Lead\Quote $Quote)
    {
	$this->Quote = $Quote;
	
	$this->_persist();
	
	parent::__construct();
    }
    
    /**
     * @return \Entities\Company\Lead\Quote
     */
    public function getQuote()
    {
	return $this->Quote;
    }
    
    private function _persist()
    {
	$this->total_due	    = $this->getQuote()->getTotalSafe();
	$this->total_due_at_sale    = $this->getQuote()->getDueAtSaleTotalPrice()->getPrice();
    }
}
