<?php
namespace Forms\Company\Lead\Quote\Item\Delivery\SetAddress;
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
    private $_Delivery;
    
    public function __construct(\Entities\Company\Lead\Quote\Item\Delivery $Delivery, $options = null)
    {
	$this->_Delivery = $Delivery;
	
	parent::__construct($options);
    }
    
    public function init() 
    {
	$options = array();
	
	foreach ($this->_Delivery->getAddresses() as $Address)
	{
	    $options[$Address->getId()] = $Address->getName()." ".$Address->getAddress1()." ".$Address->getCity().", ".$Address->getState();
	}
	
	$this->addElement(
		"radio", 
		"address_id", 
		array(
		    "label"	    => "Delivery Type",
		    "required"	    => false,
		    "value"	    => $this->_Delivery && $this->_Delivery->getAddress()? $this->_Delivery->getAddress()->getId() : "",
		    "belongsTo"	    => "company_lead_quote_item_delivery_setaddress",
		    "multioptions"  => $options
		)
	    );
	
	parent::init();
    }
}