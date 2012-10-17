<?php
namespace Forms\Company\Lead\Quote\Sale\PaymentTypes;
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
				"multioptions"  => array("cash" => "Cash","check" => "Check","cc" => "Credit Card"),
				"required"	=> true,
				"belongsTo"	=> "company_lead_quote_sale_payment_types"
			    ));
	
	parent::init();
    }
}