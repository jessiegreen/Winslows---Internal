<?php

namespace Entities\Company\Sale\Transaction;

/** 
 * @Entity (repositoryClass="Repositories\Company\Sale\Transaction\TransactionAbstract") 
 * @Table(name="company_sale_transaction_transactionabstracts") 
 * @InheritanceType("JOINED")
 * @DiscriminatorColumn(name="discr", type="string")
 * @DiscriminatorMap({
 *			"company_sale_transaction_payment_paymentgateway_creditcard" = "\Entities\Company\Sale\Transaction\Payment\PaymentGateway\CreditCard",
 *			"company_sale_transaction_payment_cash" = "\Entities\Company\Sale\Transaction\Payment\Cash",
 *			"company_sale_transaction_payment_check" = "\Entities\Company\Sale\Transaction\Payment\Check"
 *			})
 * @HasLifecycleCallbacks
 */
abstract class TransactionAbstract extends \Dataservice_Doctrine_Entity implements \Interfaces\Company\Sale\Transaction
{
    /**
     * @Id @Column(type="integer")
     * @GeneratedValue(strategy="AUTO")
     * @var integer $id
     */
    protected $id;
    
    /**
     * @Column(type="decimal", precision=40, scale=2)
     * @var integer $amount
     */
    protected $amount = 0;
    
    /**
     * @ManyToOne(targetEntity="\Entities\Company\Sale\SaleAbstract", inversedBy="Items")
     * @var \Entities\Company\Sale\SaleAbstract $Sale
     */
    protected $Sale;
    
    /**
     * @param \Entities\Company\Sale\SaleAbstract $Sale
     */
    public function setSale(\Entities\Company\Sale\SaleAbstract $Sale)
    {
	$this->Sale = $Sale;
    }
    
    /**
     * @return \Entities\Company\Sale\SaleAbstract
     */
    public function getSale()
    {
	return $this->Sale;
    }
    
    /**
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }
    
    /**
     * @param float $amount
     */
    public function setAmount($amount)
    {
	$this->amount = $amount;
    }
    
    public function getAmount()
    {
	return $this->amount;
    }
}