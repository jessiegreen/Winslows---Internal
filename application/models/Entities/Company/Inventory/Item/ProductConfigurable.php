<?php

namespace Entities\Company\Inventory\Item;

/** 
 * @Entity (repositoryClass="Repositories\Company\Inventory\Item\ProductConfigurables") 
 * @Table(name="company_inventory_item_productconfigurables") 
 * @HasLifecycleCallbacks
 */
class ProductConfigurable extends ItemAbstract implements \Interfaces\Company\Inventory\Item
{    
    /**
     * @param \Entities\Company\Supplier\Product\Configurable\Instance $Instance
     */
    public function setInstance(\Entities\Company\Supplier\Product\Configurable\Instance $Instance)
    {
	$this->Instance = $Instance;
    }
    
    /**
     * @return \Entities\Company\Supplier\Product\Configurable\Instance
     */
    public function getInstance()
    {
	return $this->Instance;
    }
    
    /**
     * @return array
     */
    public function getDisplayFields()
    {
	$Instance	= $this->getInstance();
	/** @var Entities\Company\Supplier\Product\Configurable $Configurable */
	$Configurable	= $Instance->getProduct();
	
	$static_array = array(
	    "Part#"	=> $Configurable->getPartNumber(),
	    "Supplier"	=> $Configurable->getSupplier()->getName(),
	    "Name"	=> $Configurable->getName(),
	    "Price"	=> $Instance->getPriceSafe()
	);
	
	$options_array	= array();
	
	/* @var $ConfigurableOption \Entities\Company\Supplier\Product\Configurable\Option */	
	/* @var $InstanceOption \Entities\Company\Supplier\Product\Configurable\Instance\Option */
	/* @var $InstanceValue \Repositories\Company\Supplier\Product\Configurable\Option\Parameter\Value */
	
	foreach ($Configurable->getOptionsOrderedByCategory() as $ConfigurableOption)
	{
	    $option_key_name	    = $ConfigurableOption->getName()." - ";
	    $parameter_key_names    = array();
	    $value_key_names	    = array();
	    
	    /* @var $Parameter \Entities\Company\Supplier\Product\Configurable\Option\Parameter */
	    foreach($ConfigurableOption->getParameters() as $Parameter)
	    {
		$parameter_key_names[] = $Parameter->getName();
		
		$InstanceValue = $Instance->getFirstValueFromIndexes($ConfigurableOption->getIndex(), $Parameter->getIndex());
		
		if($InstanceValue)$value_key_names[] = $InstanceValue->getName();
		else $value_key_names[] = "--";
	    }
	    
	    $option_key_name			= implode("/", $parameter_key_names);
	    $options_array[$option_key_name]	= implode("/", $value_key_names);
	}
	
	return array_merge($static_array, $options_array);
    }
    
    /**
     * @return string
     */
    public function getDescriminator()
    {
	return static::TYPE_ProductConfigurable;
    }
}
