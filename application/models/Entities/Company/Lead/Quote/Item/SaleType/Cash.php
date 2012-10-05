<?php
namespace Entities\Company\Lead\Quote\Item\SaleType;
/** 
 * @Entity (repositoryClass="Repositories\Company\Lead\Quote\Item\SaleType\Cash") 
 * @Table(name="company_lead_quote_item_saletype_cashes") 
 */
class Cash extends \Entities\Company\Lead\Quote\Item\SaleType\SaleTypeAbstract
{    
    /**
     * @return string
     */
    public function getDescriminator()
    {
	return static::TYPE_Cash;
    }
    
    public function isProductAllowed(\Entities\Company\Supplier\Product\ProductAbstract $Product)
    {
	return true;
    }
    
    /**
     * @return string
     */
    public function getName()
    {
	return "Cash Sale";
    }
    
    /**
     * @return boolean
     */
    public function isApproved()
    {
	return true;
    }
    
    public function getDue()
    {
	
    }
    
    public function getFees()
    {
	
    }
}