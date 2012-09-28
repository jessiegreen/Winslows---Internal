<?php
namespace Forms\Company\Lead\Quote\Sell;
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
class PaymentTypes extends \Dataservice_Form
{
    public function init()
    {
	$form = new PaymentTypes\Subform();
	
	$this->addSubForm($form, "company_lead_quote_sell_payment_types");

        $this->addElement('submit', 'Checkout', array(
            'ignore'   => true,
        ));
    }
}