<?php

namespace Entities\Company\Lead\Quote\Item\SaleType;

use Doctrine\Common\Collections\ArrayCollection;

/** 
 * @Entity (repositoryClass="Repositories\Company\Lead\Quote\Item\SaleType\SaleTypeAbstract") 
 * @Table(name="company_lead_quote_item_saletype_saletypeabstracts") 
 * @InheritanceType("JOINED")
 * @DiscriminatorColumn(name="discr", type="string")
 * @DiscriminatorMap({
 *			"company_lead_quote_item_saletype_rto" = "\Entities\Company\Lead\Quote\Item\SaleType\Rto",
 *			"company_lead_quote_item_saletype_cash" = "\Entities\Company\Lead\Quote\Item\SaleType\Cash",
 *		    })
 * @HasLifecycleCallbacks
 */
class SaleTypeAbstract extends \Dataservice_Doctrine_Entity implements \Interfaces\Company\Lead\Quote\Item\SaleType
{
    const TYPE_Cash	= "Cash";
    const TYPE_Rto	= "Rto";
    const TYPE_Base	= "Base";
    
    /**
     * @Id @Column(type="integer")
     * @GeneratedValue(strategy="AUTO")
     * @var integer $id
     */
    protected $id;
    
    /**
     * Bidirectional - One-To-Many (INVERSE SIDE)
     *
     * @OneToMany(targetEntity="\Entities\Company\Lead\Quote\Item", mappedBy="SaleType", cascade={"persist"})
     * @var ArrayCollection $Dealers
     */
    private $Items;
    
    public function __construct()
    {
	$this->Items	= new ArrayCollection();
	
	parent::__construct();
    }

    /**
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }
    
    /**
     * @param \Entities\Company\Lead\Quote\Item $Item
     */
    public function addItem(\Entities\Company\Lead\Quote\Item $Item)
    {
	$Item->setSaleType($this);
	$this->Items->add($Item);
    }
    
    /**
     * @return ArrayCollection
     */
    public function getItems()
    {
	return $this->Items;
    }
    
    public function isProductAllowed(\Entities\Company\Supplier\Product\ProductAbstract $Product)
    {
	
    }
    
    public function getName()
    {
	
    }
    
    public function isApproved()
    {
	
    }
    
    public function getDue()
    {
	
    }
    
    public function getFees()
    {
	
    }
    
    /**
     * @return string
     */
    public function getDescriminator()
    {
	return static::TYPE_Base;
    }
}