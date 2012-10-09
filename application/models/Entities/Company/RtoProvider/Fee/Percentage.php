<?php
namespace Entities\Company\RtoProvider\Fee;
/** 
 * @Entity (repositoryClass="Repositories\Company\RtoProvider\Fee\Range") 
 * @Table(name="company_rtoprovider_fee_percentages") 
 */
class Percentage extends FeeAbstract
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
    public function getFeesPrice(\Dataservice_Price $Price)
    {	
	$dec = $this->percentage / 100;
	
	$Price->multiply($dec);
	
	return $Price;
    }
    
    /**
     * @return string
     */
    public function getDescriminator()
    {
	return static::TYPE_Percentage;
    }
}