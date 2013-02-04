<?php
namespace Entities\Company\Sale\Transaction\Payment\PaymentGateway;

/** 
 * @Entity (repositoryClass="Repositories\Company\Sale\Transaction\Payment\PaymentGateway\CreditCard") 
 * @Table(name="company_sale_transaction_payment_paymentgateway_creditcards") 
 */
class CreditCard extends \Entities\Company\Sale\Transaction\Payment\PaymentGateway
{
    /**
     * @Column(type="integer", length=4)
     * @var integer $last_four
     */
    protected $last_four;
    
    /**
     * @Column(type="integer", length=1)
     * @var integer $approved
     */
    protected $approved;
    
    /**
     * @Column(type="string", length=100)
     * @var string $card_type
     */
    protected $card_type;
    
    public function __construct()
    {
	$this->approved = 1;
	
	parent::__construct();
    }


    /**
     * @param mixed $approved
     * @throws \Exception
     */
    public function setApproved($approved)
    {
	if($approved === 1 || $approved === true || $approved === "true")$this->approved = 1;
	elseif($approved === 0 || $approved === false || $approved === "false")$this->approved = 0;
	else throw new \Exception("Invalid Parameter Sent to setApproved");
    }
    
    public function isApproved()
    {
	if($this->approved === 1)return true;
	
	return false;
    }
    
    /**
     * @param integer $last_four
     */
    public function setLastFour($last_four)
    {
	$this->last_four = $last_four;
    }
    
    /**
     * @return integer
     */
    public function getLastFour()
    {
	return $this->last_four;
    }
    
    /**
     * Sets amount to 0 if not approved
     * @param float $amount
     */
    public function setAmount($amount)
    {
	parent::setAmount($amount);
    }
    
    /**
     * @param string $card_type
     */
    public function setCardType($card_type)
    {
	$this->card_type = $card_type;
    }
    
    /**
     * @return string
     */
    public function getCardType()
    {
	return $this->card_type;
    }
}
