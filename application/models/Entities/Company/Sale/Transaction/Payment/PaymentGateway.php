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
 * @Entity (repositoryClass="Repositories\Company\Sale\Transaction\Payment\PaymentGateway") 
 * @Table(name="company_sale_transaction_payment_paymentgateways") 
 */
class PaymentGateway extends \Entities\Company\Sale\Transaction\Payment\PaymentAbstract
{
    /**
     * @ManyToOne(targetEntity="\Entities\Company\PaymentGateway", inversedBy="Payments")
     * @var \Entities\Company\PaymentGateway $PaymentGateway
     */
    protected $PaymentGateway;
    
    /**
     * @param \Entities\Company\PaymentGateway $PaymentGateway
     */
    public function setPaymentGateway(\Entities\Company\PaymentGateway $PaymentGateway)
    {
	$this->PaymentGateway = $PaymentGateway;
    }
    
    /**
     * @return \Entities\Company\PaymentGateway
     */
    public function getPaymentGateway()
    {
	return $this->PaymentGateway;
    }
    
    public function getAmount()
    {
	
    }
}
