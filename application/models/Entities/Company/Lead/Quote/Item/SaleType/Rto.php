<?php
namespace Entities\Company\Lead\Quote\Item\SaleType;

/** 
 * @Entity (repositoryClass="Repositories\Company\Lead\Quote\Item\SaleType\Rto") 
 * @Table(name="company_lead_quote_item_saletype_rtos") 
 * @Crud\Entity\Url(value="lead-quote-item-sale-type-rto")
 * @Crud\Entity\Permissions(view={"Admin", "Manager"}, edit={"Admin"}, create={"Admin"}, delete={"Admin"})
 */
class Rto extends \Entities\Company\Lead\Quote\Item\SaleType\SaleTypeAbstract
{
    /**
     * @OneToOne(targetEntity="\Entities\Company\RtoProvider\Program")
     * @var \Entities\Company\RtoProvider\Program $Program
     */
    protected $Program;
    
    /**
     * @param \Entities\Company\RtoProvider\Program $Program
     */
    public function setProgram(\Entities\Company\RtoProvider\Program $Program)
    {
	$Program->setRtoSaleType($this);
	
	$this->Program = $Program;
    }
    
    /**
     * @return \Entities\Company\RtoProvider\Program
     */
    public function getProgram()
    {
	return $this->Program;
    }
    
    /**
     * @return string
     */
    public function getDescriminator()
    {
	return static::TYPE_Rto;
    }
    
    /**
     * @param \Entities\Company\Supplier\Product\ProductAbstract $Product
     * @return boolean
     */
    public function isProductAllowed(\Entities\Company\Supplier\Product\ProductAbstract $Product)
    {
	if($this->getProgram()->getProducts()->contains($Product))return true;
	
	return false;
    }
    
    /**
     * @return string
     */
    public function getName()
    {
	$Program = $this->getProgram();
	
	return $this->getDescriminator()." - ".$Program->getRtoProvider()->getDba()." - ".$Program->getName();
    }
    
    public function getPaymentsTotalAmountPrice(\Dataservice_Price $Price)
    {
	$ProductPrice = $this->getPaymentsAmountPrice($Price);
	
	$ProductPrice->multiply($this->getPaymentsCount());
	
	return $ProductPrice;
    }
    
    public function getFeesPrice(\Dataservice_Price $Price)
    {
	$FeesPrice = new \Dataservice_Price();
	
	/* @var $Fee \Entities\Company\RtoProvider\Fee\FeeAbstract */
	foreach($this->getProgram()->getFees() as $Fee)
	{
	    $FeePrice = $Fee->getFeePrice($Price);
	    
	    $FeesPrice->addPrice($FeePrice);
	}
	
	return $FeesPrice;
    }
    
    public function getDownPaymentPrice(\Dataservice_Price $Price)
    {
	$DownPrice = new \Dataservice_Price();
	
	#--First Month
	$DownPrice->addPrice($this->getPaymentsAmountPrice($Price));
	#--Fees
	$DownPrice->addPrice($this->getFeesPrice($Price));
	
	return $DownPrice;
    }
    
    public function getPaymentsCount()
    {
	return $this->getProgram()->getPaymentCount();
    }
    
    public function getPaymentsAmountPrice(\Dataservice_Price $Price)
    {
	$PaymentAmountPrice = new \Dataservice_Price();
	
	$PaymentAmountPrice->addPrice($Price);
	$PaymentAmountPrice->divide($this->getProgram()->getFactor());
	
	return $PaymentAmountPrice;
    }
}