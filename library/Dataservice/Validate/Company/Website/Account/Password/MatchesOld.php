<?php

/**
 * @see Zend_Validate_Abstract
 */
require_once 'Zend/Validate/Abstract.php';

class Dataservice_Validate_Company_Website_Account_Password_MatchesOld extends Zend_Validate_Abstract
{
 
    /**
     * Validation failure message key for when the value of the parent field is an empty string
     */
    const DOES_NOT_MATCH_OLD  = 'doesNotMatch';

    /**
     * Validation failure message template definitions
     *
     * @var array
     */
    protected $_messageTemplates = array(
	self::DOES_NOT_MATCH_OLD  => 'Old Password not correct'
    );

    public function isValid($value, $context = null)
    {
	//TODO: Finish this with authenticate like in login controller;
//	$ProductService	    = Services\Company\Supplier\Product::factory();
//	$Product	    = $ProductService->find($context["product_id"]);
//	$SaleTypeService    = Services\Company\Lead\Quote\Item\SaleType::factory();
//	$SaleType	    = $SaleTypeService->find($value);
//
//	if($SaleType->isProductAllowed($Product))return true;
//	
//	$this->_error(self::DOES_NOT_MATCH_OLD);
	return false;
    }
}