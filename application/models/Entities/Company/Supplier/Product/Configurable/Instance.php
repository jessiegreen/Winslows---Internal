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
     * @ManytoMany(targetEntity="Company\Supplier\Product\Configurable\Option\Parameter\Value")
     * @JoinTable(name="company_supplier_product_configurable_instance_value_joins")
     * @var array $Values
     */
    private $Values;
    
    private $Validator;

    private $Pricer;

    public function __construct(\Entities\Company\Supplier\Product\Configurable $ConfigurableProduct)
    {
	parent::__construct($ConfigurableProduct);
	
	$this->Validator    = \Services\Company\Supplier\Product\Configurable\Validator::factory($this->getProduct()->getValidator());
	$this->Pricer	    = \Services\Company\Supplier\Product\Configurable\Pricer::factory($this->getProduct()->getPricer());
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
        $this->Values[] = $Value;
    }
    
    /**
     * @return array
     */
    public function getValues()
    {
	return $this->Values;
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
