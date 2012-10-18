<?php

namespace Entities\Company\Sale;

use Doctrine\Common\Collections\ArrayCollection;

/** 
 * @Entity (repositoryClass="Repositories\Company\Sale\SaleAbstract") 
 * @Table(name="company_sale_saleabstracts") 
 * @InheritanceType("JOINED")
 * @DiscriminatorColumn(name="discr", type="string")
 * @DiscriminatorMap({"company_lead_quote_sale" = "\Entities\Company\Lead\Quote\Sale"})
 * @HasLifecycleCallbacks
 */
abstract class SaleAbstract extends \Dataservice_Doctrine_Entity
{
    /**
     * @Id @Column(type="integer")
     * @GeneratedValue(strategy="AUTO")
     * @var integer $id
     */
    protected $id;
    
    /**
     * @Column(type="decimal", precision=40, scale=2)
     * @var integer $total_due
     */
    protected $total_due = 0;
    
    /**
     * @Column(type="decimal", precision=40, scale=2)
     * @var integer $total_due_at_sale
     */
    protected $total_due_at_sale = 0;
    
    /**
     * Bidirectional - One-To-Many (INVERSE SIDE)
     *
     * @OneToMany(targetEntity="\Entities\Company\Sale\Transaction\TransactionAbstract", mappedBy="Sale", cascade={"persist", "remove"}, orphanRemoval=true)
     * @var ArrayCollection $Transactions
     */
    protected $Transactions;

    public function __construct()
    {
	$this->Transactions = new ArrayCollection();
	
	parent::__construct();
    }
    
    /**
     * @param \Entities\Company\Sale\Transaction\TransactionAbstract $Transaction
     */
    public function addTransaction(Transaction\TransactionAbstract $Transaction)
    {
//	$TransactionsWithinLastMinute = $this->getTransactions()->filter(
//		    function ($Transaction2) use ($Transaction) 
//		    {
//			$DiffInterval = $Transaction->getCreated()->diff($Transaction2->getCreated());
//			if($DiffInterval->m < 1)return true;
//		    }
//		);
//		
//	if(!$TransactionsWithinLastMinute->isEmpty())
//	    throw new \Exception("Please wait atleast 60 seconds between each transaction.");
	
	$Transaction->setSale($this);
	
        $this->getTransactions()->add($Transaction);
    }
    
    /**
     * @return ArrayCollection
     */
    public function getTransactions()
    {
	return $this->Transactions;
    }
    
    /**
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }
    
    /**
     * @return \Dataservice_Price
     */
    public function getBalancePrice()
    {
	$BalancePrice = new \Dataservice_Price();
	
	$BalancePrice->setPrice($this->getTotalDue());
	
	/* @var $Transaction \Entities\Company\Sale\Transaction\TransactionAbstract */
	foreach ($this->getTransactions() as $Transaction)
	{
	    $BalancePrice->subtract($Transaction->getAmount());
	}
	
	return $BalancePrice;
    }
    
    /**
     * @return \Dataservice_Price
     */
    public function getBalanceDueAtSalePrice()
    {
	$DueAtSalePrice = $this->getTotalDueAtSalePrice();
	
	$DueAtSalePrice->subtract($this->getTotalPaidPrice()->getPrice());
	
	return $DueAtSalePrice;
    }
    
    /**
     * @return \Dataservice_Price
     */
    public function getTotalPaidPrice()
    {
	$PaidPrice = new \Dataservice_Price();
	
	/* @var $Transaction \Entities\Company\Sale\Transaction\TransactionAbstract */
	foreach ($this->getTransactions() as $Transaction)
	{
	    $PaidPrice->add($Transaction->getAmount());
	}
	
	return $PaidPrice;
    }
    
    public function getTotalDue()
    {
	return $this->total_due;
    }
    
    public function getTotalDueAtSale()
    {
	return $this->total_due_at_sale;
    }
    
    /**
     * @return \Dataservice_Price
     */
    public function getTotalDueAtSalePrice()
    {
	$Price = new \Dataservice_Price();
	
	$Price->setPrice($this->getTotalDueAtSale());
	
	return $Price;
    }
    
    /**
     * @return \Dataservice_Price
     */
    public function getTotalDuePrice()
    {
	$Price = new \Dataservice_Price();
	
	$Price->setPrice($this->getTotalDue());
	
	return $Price;
    }
}