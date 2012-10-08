<?php
namespace Entities\Company\RtoProvider\Program\Fee;
/** 
 * @Entity (repositoryClass="Repositories\Company\RtoProvider\Program\Fee\Range") 
 * @Table(name="company_rtoprovider_program_fee_ranges") 
 */
class Range extends FeeAbstract
{    
    /**
     * Bidirectional - One-To-Many (INVERSE SIDE)
     *
     * @OneToMany(targetEntity="\Entities\Company\RtoProvider\Program\Fee\Range\Value", mappedBy="Range", cascade={"persist", "remove"}, orphanRemoval=true)
     * @var \Doctrine\Common\Collections\ArrayCollection $Values
     */
    protected $Values;
    
    public function getValues()
    {
	return $this->Values;
    }
    
    public function addValue(\Entities\Company\RtoProvider\Program\Fee\Range\Value $Value)
    {
	$Value->setRange($this);
	
	$this->getValues()->add($Value);
    }
    
    public function removeValue(\Entities\Company\RtoProvider\Program\Fee\Range\Value $Value)
    {
	$this->getValues()->removeElement($Value);
    }
    
    public function getFeesPrice(\Dataservice_Price $Price)
    {
	$FeePrice = new \Dataservice_Price();
	
	/* @var $Value \Entities\Company\RtoProvider\Program\Fee\Range\Value */
	foreach ($this->getValues() as $Value)
	{
	    if($Value->isInRange($Price->getPrice()))
	    {
		$FeePrice->add($Value->getValue());
		$FeePrice->addDetail("Range ".$Value->getLow()."-".$Value->getHigh());
		
		break;
	    }
	}
	
	return $FeePrice;
    }
}