<?php
namespace Entities\Company\Supplier\Product\Configurable;

use Doctrine\Common\Collections\ArrayCollection;

/** 
 * @Entity (repositoryClass="Repositories\Company\Supplier\Product\Configurable\Instance") 
 * @Table(name="company_supplier_product_configurable_instances") 
 * @Crud\Entity\Url(value="supplier-product-configurable-instance")
 * @Crud\Entity\Permissions(view={"Admin"}, edit={"Admin"}, create={"Admin"}, delete={"Admin"})
 */
class Instance extends \Entities\Company\Supplier\Product\Instance\InstanceAbstract implements \Interfaces\Company\Supplier\Product\Instance\InstanceAbstract
{    
    /**
     * @OnetoMany(targetEntity="\Entities\Company\Supplier\Product\Configurable\Instance\Option", cascade={"persist", "remove"}, mappedBy="Instance", orphanRemoval=true)
     * @var ArrayCollection $Options
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
    public function getOptionsDisplay($list_class = "", $item_class = "")
    {
	$string = '<ul class="'.$list_class.'">';
	
	/* @var $Option \Entities\Company\Supplier\Product\Configurable\Instance\Option */
	foreach ($this->Options as $Option)
	{
	    $string .= '<li class="'.$item_class.'">';
	    $string .= $Option->getOption()->getName();
	    
	    $string .= '<ul class="'.$list_class.'">';
	    
	    foreach ($Option->getValues() as $Value)
	    {
		$string .= '<li class="'.$item_class.'">';
		$string .= $Value->getParameter()->getName().':'.$Value->getName();
		$string .= '</li>';
	    }
	    
	    $string .= '</ul></li>';
	}
	
	$string .= '</ul>';
	
	return $string;
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
	$class		    = "\Services\Company\Supplier\Product\Configurable\Instance\\".$this->Product->getConfiguratorClassName()."\Validator";
	$this->Validator    = new $class($this);
	
	$this->Validator->validate();
	return true;
    }
    
    /**
     * @return \Dataservice_Price
     */
    public function getPrice()
    {
	$class		= "\Services\Company\Supplier\Product\Configurable\Instance\\".$this->Product->getConfiguratorClassName()."\Pricer";
	$this->Pricer	= new $class($this);
	
	return $this->Pricer->price();
    }
    
    public function getPriceSafe()
    {
	try
	{
	    $Price = $this->getPrice();
	}
	catch (\Exception $exc)
	{
	    $Price = new \Dataservice_Price();
	}
	
	return $Price;
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
    
    /**
     * @return array
     */
    public function getDisplayArray()
    {
	/** @var Entities\Company\Supplier\Product\Configurable $Configurable */
	$Configurable	= $this->getProduct();
	
	$static_array = array(
	    "Name"	=> $Configurable->getName(),
	    "Price"	=> $this->getPriceSafe()->getDisplayPrice(),
	    "Part#"	=> $Configurable->getPartNumber(),
	    "Supplier"	=> $Configurable->getSupplier()->getName()
	);
	
	$options_array	= array();
	
	/* @var $ConfigurableOption \Entities\Company\Supplier\Product\Configurable\Option */	
	/* @var $InstanceOption \Entities\Company\Supplier\Product\Configurable\Instance\Option */
	/* @var $InstanceValue \Repositories\Company\Supplier\Product\Configurable\Option\Parameter\Value */
	
	foreach ($Configurable->getOptionsOrderedByCategory() as $ConfigurableOption)
	{
	    $option_key_name	    = $ConfigurableOption->getName()." ** ";
	    $parameter_key_names    = array();
	    $instance_values_array  = array();
	    $InstanceOptions	    = $this->getOptionsFromOptionIndex($ConfigurableOption->getIndex());
	    
	    /* @var $Parameter \Entities\Company\Supplier\Product\Configurable\Option\Parameter */
	    foreach($ConfigurableOption->getParameters() as $Parameter)
	    {
		$parameter_key_names[] = $Parameter->getName();
		
		foreach($InstanceOptions as $InstanceOption)
		{
		    $InstanceValue = $InstanceOption->getValueFromParameterIndex($Parameter->getIndex());
		    
		    $temp_value	    = $InstanceValue ? $InstanceValue->getName() : "--";
		    
		    $instance_values_array[$InstanceOption->getId()][] = $temp_value;
		}
	    }
	    
	    $option_key_name			.= implode("/", $parameter_key_names);
	    $options_array[$option_key_name]	= "";
	    
	    foreach($instance_values_array as $instance_values)
		$options_array[$option_key_name] .= 
		    ($options_array[$option_key_name] ? "<br />" : "").implode("/", $instance_values);
	}
	
	return array_merge($static_array, $options_array);
    }
    
    /**
     * @return \Entities\Company\Supplier\Product\Configurable\Instance
     */
    public function cloneInstance()
    {
	$Clone = new Instance($this->getProduct());
	
	/* @var $Option \Entities\Company\Supplier\Product\Configurable\Instance\Option */
	foreach ($this->getOptions() as $Option)
	{
	    $CloneOption = $Option->cloneOption();
	    
	    $Clone->addOption($CloneOption);
	}
	
	$Clone->setNote("Cloned from Instance id:".$this->getId());
	
	return $Clone;
    }
}
