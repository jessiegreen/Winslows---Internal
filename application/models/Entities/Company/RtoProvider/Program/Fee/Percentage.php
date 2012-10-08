<?php
namespace Entities\Company\RtoProvider\Program\Fee;
/** 
 * @Entity (repositoryClass="Repositories\Company\RtoProvider\Program\Fee\Range") 
 * @Table(name="company_rtoprovider_program_fee_percentages") 
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
    
    public function getFeesPrice(\Dataservice_Price $Price)
    {	
	$dec = $this->percentage / 100;
	
	$Price->multiply($dec);
	
	return $Price;
    }
}