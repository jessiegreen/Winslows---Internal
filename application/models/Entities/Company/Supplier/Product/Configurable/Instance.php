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
     * @OnetoMany(targetEntity="\Entities\Company\Supplier\Product\Configurable\Instance\Option", cascade={"persist", "remove"}, mappedBy="Instance", orphanRemoval=true)
     * @var array $Options
     */
    private $Options;
    
    private $Validator;

    private $Pricer;

    public function __construct(\Entities\Company\Supplier\Product\Configurable $ConfigurableProduct)
    {
	parent::__construct($ConfigurableProduct);
	
	$this->Options = new ArrayCollection();
    }
    
    /**
     * @return \Entities\Company\Supplier\Product\Configurable
     */
    public function getProduct()
    {
	return parent::getProduct();
    }
    
    /**
     * @param \Entities\Company\Supplier\Product\Configurable\Instance\Option $Option
     */
    public function addOption(Instance\Option $Option)
    {
	$Option->setInstance($this);
	
        $this->Options[]    = $Option;
    }
    
    /**
     * @return ArrayCollection
     */
    public function getOptions()
    {
	return $this->Options;
    }
    
    /**
     * @return string
     */
    public function getCode()
    {
	$code	    = "";
	$code_array = array();
	
	/* @var $Option \Entities\Company\Supplier\Product\Configurable\Instance\Option */
	foreach ($this->getOptions() as $Option) 
	{
	    $temp_array = array();
	    /* @var $Value \Entities\Company\Supplier\Product\Configurable\Option\Parameter\Value */
	    foreach ($Option->getValues() as $Value)
	    {
		$temp_array[$Value->getParameter()->getId()] = $Value->getCode();
	    }
	    
	    ksort($temp_array);
	    
	    $Parameter			= $Value->getParameter();
	    $option_code		= $Parameter->getOption()->getCode();
	    $code_array[$option_code][] = $temp_array;
	}
	
	ksort($code_array);
	
	foreach ($code_array as $option_code => $options_array)
	{
	    foreach ($options_array as $value_code_array) 
	    {
		$code .= $option_code.implode("", $value_code_array);
	    }
	}
	
	return $code;
    }
    
    public function hasProductOption(Option $ProductOption)
    {
	return $this->getOptions()->exists(
	    /* @var $Option \Entities\Company\Supplier\Product\Configurable\Instance\Option */
	    function($key, $Option) use ($ProductOption) 
	    {
		$InstanceProductOption = $Option->getOption();

		if($InstanceProductOption->getId() === $ProductOption->getId())
		    return true;
		else return false;
	    }
	);
    }
    
    public function removeAllOptions()
    {
	$this->getOptions()->clear();
    }
    
    /**
     * @return boolean
     */
    public function validate()
    {
	$class		    = "\Services\Company\Supplier\Product\Configurable\Instance\\".$this->Product->getClassName()."\Validator";
	$this->Validator    = new $class($this);
	
	$this->Validator->validate();
	return true;
    }
    
    /**
     * @return integer
     */
    public function getPrice()
    {
	$class		= "\Services\Company\Supplier\Product\Configurable\Instance\\".$this->Product->getClassName()."\Pricer";
	$this->Pricer	= new $class($this);
	
	return $this->Pricer->price();
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
     * Return Value object from option and parameter indexes
     * 
     * @param string $option_index
     * @param string $parameter_index
     * @param \Entities\Company\Supplier\Product\Configurable\Instance\Option $Option
     * @return Option\Parameter\Value|false
     */
    public function getFirstValueFromIndexes($option_index, $parameter_index)
    {
	$FilteredOptions = $this->getOptionsFromOptionIndex($option_index);
	
	if($FilteredOptions->count() > 0)
	{
	    /* @var $Option Instance\Option */
	    $Option = $FilteredOptions->first();
	    
	    return $Value = $Option->getValueFromParameterIndex($parameter_index);
	}
	
	return false;
    }
    
    /**
     * @param string $option_index
     * @return ArrayCollection
     */
    public function getOptionsFromOptionIndex($option_index)
    {
	return $this->getOptions()->filter(
	    /* @var $Option \Entities\Company\Supplier\Product\Configurable\Instance\Option */
	    function($Option) use ($option_index) 
	    {
		$ProductOption = $Option->getOption();

		if($ProductOption->getIndex() === $option_index)
		    return true;
		else return false;
	    }
	);
    }
}
