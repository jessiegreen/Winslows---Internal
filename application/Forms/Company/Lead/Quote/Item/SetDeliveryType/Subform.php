<?php
namespace Forms\Company\Lead\Quote\Item\SetDeliveryType;
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
class Subform extends \Zend_Form_SubForm
{    
    private $_Item;
    
    public function __construct(\Entities\Company\Lead\Quote\Item $Item, $options = null)
    {
	$this->_Item = $Item;
	
	parent::__construct($options);
    }
    
    public function init() 
    {
	$this->addElement(
		"radio", 
		"delivery_type_id", 
		array(
		    "label"	    => "Delivery Type",
		    "required"	    => false,
		    "value"	    => $this->_Item && $this->_Item->getDelivery()? $this->_Item->getDelivery()->getDeliveryType()->getId() : "",
		    "belongsTo"	    => "company_lead_quote_item_setdeliverytype",
		    "multioptions"  => $this->_Item->getDeliveryTypesKeyNameArray()
		)
	    );
	
	parent::init();
    }
}