<?php
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
namespace Entities\Company\Sale\Transaction\Payment;

/** 
 * @Entity (repositoryClass="Repositories\Company\Sale\Transaction\Payment\Cash") 
 * @Table(name="company_sale_transaction_payment_cash") 
 */
class Cash extends \Entities\Company\Sale\Transaction\Payment\PaymentAbstract
{
    public function getAmount()
    {
	
    }
}
