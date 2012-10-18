<?php
namespace Forms\Company\Lead\Quote\Sale\Transaction\Payment;
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
class Check extends \Dataservice_Form
{
    public function init()
    {
	$form = new Check\Subform();
	
	$this->addSubForm($form, "company_lead_quote_sale_payment_transaction_payment_check");
	
	$this->addElement('submit', 'submit', array(
            'ignore'   => true,
        ));
    }
}