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
    //dsd
    private $_Delivery;
    
    public function __construct(\Entities\Company\Lead\Quote\Item\Delivery $Delivery, $options = null)
    {
	$this->_Delivery = $Delivery;
	
	parent::__construct($options);
    }
    
    public function init() 
    {
	$options = array();
	
	foreach ($this->_Delivery->getOriginationAddresses() as $Address)
	{
	    $options[$Address->getId()] = $Address->getName()." - ".$Address->getAddress1()." ".$Address->getCity().", ".$Address->getState();
	}
	
	$this->addElement(
		"radio", 
		"origination_address_id", 
		array(
		    "label"	    => "Origination Address",
		    "required"	    => false,
		    "value"	    => $this->_Delivery && $this->_Delivery->getOriginationAddress()? $this->_Delivery->getOriginationAddress()->getId() : "",
		    "belongsTo"	    => "company_lead_quote_item_delivery_setaddress",
		    "multioptions"  => $options
		)
	    );
	
	$options = array();
	
	if($this->_Delivery->getDestinationAddresses()->count())
	{
	    foreach ($this->_Delivery->getDestinationAddresses() as $Address)
	    {
		$options[$Address->getId()] = $Address->getName()." - ".$Address->getAddress1()." ".$Address->getCity().", ".$Address->getState();
	    }
	
	    $this->addElement(
		    "radio", 
		    "destination_address_id", 
		    array(
			"label"		=> "Destination Address",
			"required"	=> false,
			"value"		=> $this->_Delivery && $this->_Delivery->getDestinationAddress()? $this->_Delivery->getDestinationAddress()->getId() : "",
			"belongsTo"	=> "company_lead_quote_item_delivery_setaddress",
			"multioptions"  => $options
		    )
		);
	}
	else
	{
	    $this->addElement(
		    "hidden", 
		    "destination_address_id", 
		    array(
			"label"		=> "Destination Address:",
			"value"		=> 0,
			"description"	=> "Lead has no addresses on file. Please add an address.",
			"belongsTo"	=> "company_lead_quote_item_delivery_setaddress"
		    )
		);
	}
	
	parent::init();
    }
}