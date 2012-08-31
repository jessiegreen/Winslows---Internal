<?php

namespace Entities\Company\Supplier\Product\Configurable\Instance;
use Doctrine\Common\Collections\ArrayCollection;

/** 
 * @Entity (repositoryClass="Repositories\Company\Supplier\Product\Configurable\Instance\Option") 
 * @Table(name="company_supplier_product_configurable_instance_options") 
 * @HasLifecycleCallbacks
 */
class Option extends \Dataservice_Doctrine_Entity
{
    /**
     * @Id @Column(type="integer")
     * @GeneratedValue(strategy="AUTO")
     * @var integer $id
     */
    private $id;
        
    /**
     * @ManyToOne(targetEntity="\Entities\Company\Supplier\Product\Configurable\Option", cascade={"persist"})
     * @var \Entities\Company\Supplier\Product\Configurable\Option $Option
     */
    private $Option;
    
    /**
     * @ManyToOne(targetEntity="\Entities\Company\Supplier\Product\Configurable\Instance", cascade={"persist"})
     * @var \Entities\Company\Supplier\Product\Configurable\Instance $Instance
     */
    private $Instance;
    
    /**
     * @ManytoMany(targetEntity="\Entities\Company\Supplier\Product\Configurable\Option\Parameter\Value", cascade={"persist"})
     * @JoinTable(name="company_supplier_product_configurable_instance_option_joins")
     * @var ArrayCollection $Values
     */
    private $Values;
    
    public function __construct(\Entities\Company\Supplier\Product\Configurable\Option $Option)
    {
	$this->Option = $Option;
	$this->Values = new ArrayCollection();
	
	parent::__construct();
    }
    
    /**
     * @param \Entities\Company\Supplier\Product\Configurable\Option\Parameter\Value $Value
     * @return boolean
     * @throws \Exception
     */
    public function addValue(\Entities\Company\Supplier\Product\Configurable\Option\Parameter\Value $Value)
    {
	$Parameter = $Value->getParameter();
	
	if($Parameter->getOption()->getId() != $this->Option->getId())
	    throw new \Exception("Value does not belong to option");
	
	#-- Already exists, don't add
	if($this->Values->contains($Value)) return true;
	
	$ValueWithSameParameter = $this->getValueFromParameterIndex($Parameter->getIndex());
	
	#-- Value from same Parameter exists. Replace it with new
	if($ValueWithSameParameter !== false)
	{
	    $this->Values->removeElement($ValueWithSameParameter);
	}
	
	$this->Values[] = $Value;
	
	return true;
    }
    
    public function setInstance(\Entities\Company\Supplier\Product\Configurable\Instance $Instance)
    {
	$this->Instance = $Instance;
    }
    
    /**
     * @return \Entities\Company\Supplier\Product\Configurable\Option
     */
    public function getOption()
    {
	return $this->Option;
    }
    
    /**
     * @return ArrayCollection
     */
    public function getValues()
    {
	return $this->Values;
    }

    /**
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }
    
    /**
     * @param string $parameter_index
     * @return \Entities\Company\Supplier\Product\Configurable\Option\Parameter\Value|false
     * @throws \Exception
     */
    public function getValueFromParameterIndex($parameter_index)
    {
	$FilteredValues = $this->Values->filter(
		    /* @var $Option \Entities\Company\Supplier\Product\Configurable\Instance\Option */
		    function($Value) use ($parameter_index) 
		    {
			if($Value->getParameter()->getIndex() === $parameter_index)
			    return true;
			else return false;
		    }
		);
	
	$count = $FilteredValues->count();
	
	if($count ==  1)
	{
	    return $FilteredValues->first();
	}
	elseif($count > 1)throw new \Exception("Option Parameter Has More Than 1 Value");
	
	return false;
    }
}
