<?php

namespace Entities\Company\RtoProvider\Program\Fee\Range;

/** 
 * @Entity (repositoryClass="Repositories\Company\RtoProvider\Program\Fee\Range\Value") 
 * @Table(name="company_rtoprovider_program_fee_range_values") 
 * @HasLifecycleCallbacks
 */
class Value extends \Dataservice_Doctrine_Entity
{    
    /**
     * @Id @Column(type="integer")
     * @GeneratedValue(strategy="AUTO")
     * @var integer $id
     */
    protected $id;
    
    /** 
     * @Column(type="integer")
     * @var integer $high
     */
    protected $high;
    
    /** 
     * @Column(type="integer")
     * @var integer $low
     */
    protected $low;
    
    /** 
     * @Column(type="integer")
     * @var integer $value
     */
    protected $value;
    
    /**
     * @return integer
     */
    public function getId()
    {
	return $this->id;
    }
    
    /**
     * @param integer $high
     */
    public function setHigh($high)
    {
	$this->high = $high;
    }
    
    /**
     * @return integer
     */
    public function getHigh()
    {
	return $this->high;
    }
    
    /**
     * @param integer $low
     */
    public function setLow($low)
    {
	$this->low = $low;
    }
    
    /**
     * @return integer
     */
    public function getLow()
    {
	return $this->low;
    }
    
    /**
     * @param integer $value
     */
    public function setValue($value)
    {
	$this->value = $value;
    }
    
    /**
     * @return integer
     */
    public function getValue()
    {
	return $this->value;
    }
    
    public function isInRange($number)
    {
	return ($number > $this->getLow() && $number < $this->getHigh());
    }
}
