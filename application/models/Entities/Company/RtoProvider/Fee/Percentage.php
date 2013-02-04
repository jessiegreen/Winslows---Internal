<?php
namespace Entities\Company\RtoProvider\Fee;

/** 
 * @Entity (repositoryClass="Repositories\Company\RtoProvider\Fee\Range") 
 * @Table(name="company_rtoprovider_fee_percentages") 
 * @Crud\Entity\Url(value="rto-provider-fee-percentage")
 * @Crud\Entity\Permissions(view={"Admin"}, edit={"Admin"}, create={"Admin"}, delete={"Admin"})
 */
class Percentage extends FeeAbstract implements \Interfaces\Company\RtoProvider\Fee
{
    /** 
     * @Column(type="integer")
     * @var integer $percentage
     */
    protected $percentage;
    
    /**
     * @param integer $percentage
     */
    public function setPercentage($percentage)
    {
	$this->percentage = $percentage;
    }
    
    /**
     * @return integer
     */
    public function getPercentage()
    {
	return $this->percentage;
    }
    
    /**
     * @param \Dataservice_Price $Price
     * @return \Dataservice_Price
     */
    public function getFeePrice(\Dataservice_Price $Price)
    {	
	$FeePrice = new \Dataservice_Price();
	
	$FeePrice->addPrice($Price);
	
	$dec = ($this->percentage / 100);
	
	$FeePrice->multiply($dec);
	
	return $FeePrice;
    }
    
    /**
     * @return string
     */
    public function getDescriminator()
    {
	return static::TYPE_Percentage;
    }
}