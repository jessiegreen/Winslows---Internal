<?php

/**
 * @see Zend_Validate_Abstract
 */
require_once 'Zend/Validate/Abstract.php';

class Dataservice_Validate_Company_Lead_Quote_Item_SaleType extends Zend_Validate_Abstract
{
 
    /**
     * Validation failure message key for when the value of the parent field is an empty string
     */
    const SALE_TYPE_NOT_ALLOWED  = 'saleTypeNotAllowed';

    /**
     * Validation failure message template definitions
     *
     * @var array
     */
    protected $_messageTemplates = array(
	self::SALE_TYPE_NOT_ALLOWED  => 'Sale Type not allowed with this product'
    );

    public function isValid($value, $context = null)
    {
	$ProductService = Services\Company\Supplier\Product::factory();
	$Product	= $ProductService->find($context["product_id"]);
	
	/* @var $Product Entities\Company\Supplier\Product\ProductAbstract */
	if($Product->isSaleTypeAllowed($value))
	{
	    return true;
	}
	
	$this->_error(self::SALE_TYPE_NOT_ALLOWED);
	return false;
    }
}