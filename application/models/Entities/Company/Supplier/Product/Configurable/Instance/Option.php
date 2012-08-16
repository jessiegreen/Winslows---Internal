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
     * @var array $Values
     */
    private $Values;
    
    public function __construct(\Entities\Company\Supplier\Product\Configurable\Option $Option)
    {
	$this->Option = $Option;
	$this->Values = new ArrayCollection();
    }
    
    /**
     * @param \Entities\Company\Supplier\Product\Configurable\Option\Parameter\Value $Value
     */
    public function addValue(\Entities\Company\Supplier\Product\Configurable\Option\Parameter\Value $Value)
    {
	if($Value->getParameter()->getOption()->getId() != $this->Option->getId())
	    throw new \Exception("Value does not belong to option");
	
        $this->Values[]	    = $Value;
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
    
    public function populate(array $array)
    {
	foreach ($array as $key => $value) 
	{
	    if(property_exists($this, $key))
	    {
		$this->$key = $value;
	    }
	}
    }
    
    /**
     * @return array
     */
    public function toArray(){
	$array			= array();
	$array['name']		= $this->getName();
	$array['code']		= $this->getCode();
	$array['description']	= $this->getDescription();
	return $array;
    }
}
