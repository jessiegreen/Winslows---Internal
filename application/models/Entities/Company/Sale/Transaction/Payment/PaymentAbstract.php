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
 * @Entity (repositoryClass="Repositories\Company\Sale\Transaction\Payment\PaymentAbstract") 
 * @Table(name="company_sale_transaction_payments") 
 */
abstract class PaymentAbstract extends \Entities\Company\Sale\Transaction\TransactionAbstract
{
}
