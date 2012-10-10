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
     * @var integer $price
     */
    protected $price = 0;
    
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
    
    public function getBalance()
    {
	$BalancePrice = new \Dataservice_Price();
	
	/* @var $Transaction \Entities\Company\Sale\Transaction\TransactionAbstract */
	foreach ($this->getTransactions() as $Transaction)
	{
	    $BalancePrice->add($Transaction->getAmount());
	}
	
	return $BalancePrice;
    }
}