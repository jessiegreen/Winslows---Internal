<?php

namespace Entities\Company\Supplier\Product\Configurable;
use Doctrine\Common\Collections\ArrayCollection;

/** 
 * @Entity (repositoryClass="Repositories\Company\Supplier\Product\Configurable\Instance") 
 * @Table(name="company_supplier_product_configurable_instances") 
 */
class Instance extends \Entities\Company\Supplier\Product\Instance\InstanceAbstract
{    
    /**
     * @ManytoMany(targetEntity="\Entities\Company\Supplier\Product\Configurable\Option\Parameter\Value")
     * @JoinTable(name="company_supplier_product_configurable_instance_value_joins")
     * @var array $Values
     */
    private $Values;
    
    private $Validator;

    private $Pricer;

    public function __construct(\Entities\Company\Supplier\Product\Configurable $ConfigurableProduct)
    {
	parent::__construct($ConfigurableProduct);
	
	$this->Validator    = \Services\Company\Supplier\Product\Configurable\Instance\Validator::factory($this->getProduct()->getValidator());
	$this->Pricer	    = \Services\Company\Supplier\Product\Configurable\Instance\Pricer::factory($this->getProduct()->getPricer());
	$this->Values	    = new ArrayCollection();
    }
    
    /**
     * @return \Entities\Company\Supplier\Product\Configurable
     */
    public function getProduct() {
	parent::getProduct();
    }
    
    /**
     * @param \Entities\Company\Supplier\Product\Configurable\Option\Parameter\Value $Value
     */
    public function addValue(Option\Parameter\Value $Value)
    {
        $this->Values[]	    = $Value;
	$validate_result    = $this->validate();
	
	if($validate_result !== true)
	    throw new Exception($validate_result->getMessage());
    }
    
    /**
     * @return array
     */
    public function getValues()
    {
	return $this->Values;
    }
    
    /**
     * @return \Exception|boolean
     */
    public function validate()
    {
	try
	{
	    call_user_method("validate", $this->Validator, $this);
	    return true;
	} 
	catch(\Exception $exc)
	{
	    return $exc;
	}
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
}
