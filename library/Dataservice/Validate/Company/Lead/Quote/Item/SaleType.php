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

    /**
     * Key to test against
     *
     * @var integer
     */
    protected $_Item;

    public function __construct($value, \Entities\Company\Lead\Quote\Item $Item)
    {
	$this->_Item = $Item;
    }

    public function isValid($value)
    {
	  echo $this->_Item;exit;
	if($this->_Item->isRtoSaleType())
	{
	    $sales_options = \Services\Company\Lead\Quote\Item::factory()->getSaleTypeOptions($this->_Item);
	    print_r($sales_options);
	    if(!in_array($this->_Item->getSaleType(), $sales_options))
	    {
		echo "Invalid";exit;
		$this->_error(self::SALE_TYPE_NOT_ALLOWED);
		return false;
	    }
	}
	echo "Valid";Exit;
	return true;
    }
    
    public function getMessages()
    {
	parent::getMessages();
    }
}