<?php
namespace Entities\Company\RtoProvider\Fee\Range;

/** 
 * @Entity (repositoryClass="Repositories\Company\RtoProvider\Fee\Range\Value") 
 * @Table(name="company_rtoprovider_fee_range_values") 
 * @HasLifecycleCallbacks
 * @Crud\Entity\Url(value="rto-provider-fee-range-value")
 * @Crud\Entity\Permissions(view={"Admin"}, edit={"Admin"}, create={"Admin"}, delete={"Admin"})
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
     * @ManyToOne(targetEntity="\Entities\Company\RtoProvider\Fee\Range", inversedBy="Fees")
     * @Crud\Relationship\Permissions()
     * @var \Entities\Company\RtoProvider\Fee\Range $Range
     */  
    protected $Range;
    
    /**
     * @param \Entities\Company\RtoProvider\Fee\Range $Range
     */
    public function setRange(\Entities\Company\RtoProvider\Fee\Range $Range)
    {
	$this->Range = $Range;
    }
    
    /**
     * @return \Entities\Company\RtoProvider\Fee\Range
     */
    public function getRange()
    {
	return $this->Range;
    }
    
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
    
    public function toString()
    {
	return $this->getLow()." - ".$this->getHigh()." : ".$this->getValue();
    }
    
    public function populate(array $array)
    {
	$Range = $this->_getEntityFromArray($array, "Entities\Company\RtoProvider\Fee\Range", "range_id");
	
	if($Range && $Range->getId())
	    $this->setRange($Range);
	
	parent::populate($array);
    }
}
