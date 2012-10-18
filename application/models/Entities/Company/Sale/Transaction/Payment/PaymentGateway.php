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
abstract class PaymentGateway extends \Entities\Company\Sale\Transaction\Payment\PaymentAbstract
{
    /**
     * @Column(type="string", length=100)
     * @var string $transaction_id
     */
    protected $transaction_id;
    
    /**
     * @Column(type="string", length=100)
     * @var string $authorization_code
     */
    protected $authorization_code;
    
    /**
     * @Column(type="string", length=100)
     * @var string $response_code
     */
    protected $response_code;
    
    /**
     * @Column(type="string", length=1500)
     * @var string $response_string
     */
    protected $response_string;
    
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
    
    /**
     * @return string
     */
    public function getTransactionId()
    {
	return $this->transaction_id;
    }
    
    /**
     * @param string $transaction_id
     */
    public function setTransactionId($transaction_id)
    {
	$this->transaction_id = $transaction_id;
    }
    
    /**
     * @return string
     */
    public function getAuthorizationCode()
    {
	return $this->authorization_code;
    }
    
    /**
     * @param string $authorization_code
     */
    public function setAuthorizationCode($authorization_code)
    {
	$this->authorization_code = $authorization_code;
    }
    
    /**
     * @return string
     */
    public function getResponseCode()
    {
	return $this->response_code;
    }
    
    /**
     * @param string $response_code
     */
    public function setResponseCode($response_code)
    {
	$this->response_code = $response_code;
    }
    
    /**
     * @return string
     */
    public function getResponseString()
    {
	return $this->response_string;
    }
    
    /**
     * @param string $response_string
     */
    public function setResponseString($response_string)
    {
	$this->response_string = $response_string;
    }
}
