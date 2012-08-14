<?php

namespace Entities\Company\Supplier\Product\Configurable;
use Doctrine\Common\Collections\ArrayCollection;

/** 
 * @Entity (repositoryClass="Repositories\Company\Supplier\Product\Configurable\Instance") 
 * @Table(name="company_supplier_product_configurable_instances") 
 */
class Instance extends \Entities\Company\Supplier\Product\Instance\InstanceAbstract implements \Interfaces\Company\Supplier\Product\Instance\InstanceAbstract
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
	$this->Values	    = new ArrayCollection();
    }
    
    /**
     * @return \Entities\Company\Supplier\Product\Configurable
     */
    public function getProduct()
    {
	return parent::getProduct();
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
     * @return string
     */
    public function getCode()
    {
	$code	    = "";
	$code_array = array();
	
	/* @var $Value \Entities\Company\Supplier\Product\Configurable\Option\Parameter\Value */
	foreach ($this->getValues() as $Value) 
	{
	    $Parameter		    = $Value->getParameter();
	    $code		    = $Parameter->getOption()->getCode();
	    $code_array[$code][]    = (string) $Value->getCode();
	}
	
	ksort($code_array);
	
	foreach ($code_array as $option_code => $value_code_array)
	{
	    $code .= $option_code.implode("", $value_code_array);
	}
	
	return $code;
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
	    $this->Validator    = \Services\Company\Supplier\Product\Configurable\Instance\Validator::factory()
				    ->getValidator($this->Product->getValidator());
	    call_user_func(array($this->Validator, "validate"), $this);
	    return true;
	} 
	catch(\Exception $exc)
	{
	    return $exc;
	}
    }
    
    /**
     * @return \Exception|integer
     */
    public function getPrice()
    {
	try
	{
	    $this->Pricer = \Services\Company\Supplier\Product\Configurable\Instance\Pricer::factory()
				->getPricer($this->Product->getPricer());
	    return call_user_func(array($this->Pricer, "price"), $this);
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
