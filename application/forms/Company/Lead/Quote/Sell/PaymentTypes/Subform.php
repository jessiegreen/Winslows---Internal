<?php
namespace Forms\Company\Lead\Quote\Sell\PaymentTypes;
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
    public function init() 
    {
	$this->addElement("radio", "payment_type", 
			    array(
				"label"		=> "Payment Type",
				"multioptions"  => array("Cash", "Check", "Credit Card"),
				"required"	=> true
			    ));
	
	parent::init();
    }
}