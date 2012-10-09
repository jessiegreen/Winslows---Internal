<?php

namespace Entities\Company\RtoProvider;

use Doctrine\Common\Collections\ArrayCollection;

/**
 * @Entity (repositoryClass="Repositories\Company\RtoProvider\Program") 
 * @Table(name="company_rtoprovider_programs")
 * @HasLifecycleCallbacks
 */
class Program extends \Dataservice_Doctrine_Entity
{
    /**
     * @Id @Column(type="integer")
     * @GeneratedValue(strategy="AUTO")
     * @var integer $id
     */
    protected $id;
    
    /** 
     * @Column(type="string", length=255) 
     * @var string $name
     */
    protected $name;
    
    /** 
     * @Column(type="string", length=255) 
     * @var string $name_index
     */
    protected $name_index;
    
    /** 
     * @Column(type="integer", length=5) 
     * @var integer $payment_count
     */
    protected $payment_count;
    
    /**
     * @Column(type="decimal", precision=40, scale=2)
     * @var integer $factor
     */
    protected $factor;
    
    /** 
     * @ManyToOne(targetEntity="\Entities\Company\RtoProvider", inversedBy="Programs")
     * @var \Entities\Company\RtoProvider
     */  
    protected $RtoProvider;
    
    /**
     * @ManytoMany(targetEntity="\Entities\Company\Supplier\Product\ProductAbstract", mappedBy="Programs", cascade={"ALL"})
     * @var ArrayCollection $Products
     */
    protected $Products;
    
    /**
     * @ManytoMany(targetEntity="\Entities\Company\RtoProvider\Fee\FeeAbstract", mappedBy="Programs", cascade={"ALL"})
     * @var ArrayCollection $Fees
     */
    protected $Fees;
    
    /**
     * @OneToOne(targetEntity="\Entities\Company\Lead\Quote\Item\SaleType\Rto", inversedBy="Program", cascade={"persist", "remove"})
     * @var \Entities\Company\Lead\Quote\Item\SaleType\Rto $RtoSaleType
     */
    protected $RtoSaleType;
    
    public function __construct()
    {
	$this->Products = new ArrayCollection();
	$this->Fees	= new ArrayCollection();
	
	if(!$this->RtoSaleType)
	{
	    $RtoSaleType = new \Entities\Company\Lead\Quote\Item\SaleType\Rto;
	    
	    $RtoSaleType->setProgram($this);
	}
	
	parent::__construct();
    }
    
    /**
     * @return \Entities\Company\RtoProvider
     */
    public function getRtoProvider()
    {
	return $this->RtoProvider;
    }
    
    /**
     * @param \Entities\Company\RtoProvider $RtoProvider
     */
    public function setRtoProvider(\Entities\Company\RtoProvider $RtoProvider)
    {
	$this->RtoProvider = $RtoProvider;
    }
    
    /**
     * @return \Entities\Company\Lead\Quote\Item\SaleType\Rto
     */
    public function getRtoSaleType()
    {
	return $this->RtoSaleType;
    }
    
    /**
     * @param \Entities\Company\Lead\Quote\Item\SaleType\Rto $RtoProvider
     */
    public function setRtoSaleType(\Entities\Company\Lead\Quote\Item\SaleType\Rto $RtoSaleType)
    {
	$this->RtoSaleType = $RtoSaleType;
    }
    
    /**
     * @return ArrayCollection
     */
    public function getProducts()
    {
	return $this->Products;
    }
    
    /**
     * @param \Entities\Company\Supplier\Product\ProductAbstract $Product
     */
    public function addProduct(\Entities\Company\Supplier\Product\ProductAbstract $Product)
    {
	if(!$this->getProducts()->contains($Product))
	{
	    $Product->addProgram($this);
	    $this->Products[] = $Product;
	}
    }
    
    public function removeProduct(\Entities\Company\Supplier\Product\ProductAbstract $Product)
    {
	$Product->removeProgram($this);
	$this->getProducts()->removeElement($Product);
    }
    
    /**
     * @return ArrayCollection
     */
    public function getFees()
    {
	return $this->Fees;
    }
    
    /**
     * @param Fee\FeeAbstract $Fee
     */
    public function addFee(Fee\FeeAbstract $Fee)
    {
	if(!$this->getFees()->contains($Fee))
	{
	    $Fee->addProgram($this);
	    $this->Fees[] = $Fee;
	}
    }
    
    /**
     * @param \Entities\Company\RtoProvider\Fee\FeeAbstract $Fee
     */
    public function removeFee(Fee\FeeAbstract $Fee)
    {
	$Fee->removeProgram($this);
	$this->getFees()->removeElement($Fee);
    }
    
    /**
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }
    
    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param type $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }
    
    /**
     * @return integer
     */
    public function getPaymentCount()
    {
        return $this->payment_count;
    }

    /**
     * @param integer $payment_count
     */
    public function setPaymentCount($payment_count)
    {
        $this->payment_count = $payment_count;
    }
    
    /**
     * @return integer
     */
    public function getFactor()
    {
        return $this->factor;
    }

    /**
     * @param type $factor
     */
    public function setFactor($factor)
    {
        $this->factor = $factor;
    }
    
    /**
     * @return string
     */
    public function getNameIndex()
    {
        return $this->name_index;
    }

    /**
     * @param string $name_index
     */
    public function setNameIndex($name_index)
    {
        $this->name_index = $name_index;
    }
}