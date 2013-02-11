<?php
namespace Services\Company\Supplier\Product\Configurable\Instance\Validator;

abstract class ValidatorAbstract extends \Dataservice_Service_ServiceAbstract implements \Interfaces\Company\Supplier\Product\Configurable\Instance\Validator
{
    /**
     *  @var \Entities\Company\Supplier\Product\Configurable\Instance $_Instance 
     */
    protected $_Instance;
    /**
     *  @var \Services\Company\Supplier\Product\Configurable\Instance\Validator\DataAbstract $_Data 
     */
    protected $_Data;
    /**
     *  @var \Services\Company\Supplier\Product\Configurable\Instance\Mapper\MapperAbstract $_Mapper 
     */
    protected $_Mapper;
    
    public function __construct(\Entities\Company\Supplier\Product\Configurable\Instance $Instance)
    {
	$class_name	    = $Instance->getProduct()->getConfiguratorClassName();
	$instance_ns	    = "\Services\Company\Supplier\Product\Configurable\Instance\\".$class_name;
	$data_class	    = $instance_ns."\Validator\Data";
	$mapper_class	    = $instance_ns."\Mapper";
	
	$this->_Instance    = $Instance;
	$this->_Data	    = new $data_class;
	$this->_Mapper	    = new $mapper_class($Instance);	
    }
    
    public function validate()
    {
	$this->_validateRequiredOptionsAndParameters();
    }
    
    protected function _validateRequiredOptionsAndParameters()
    {	
	foreach ($this->_Instance->getProduct()->getRequiredOptions() as $ProductOption)
	{
	    if(!$this->_Instance->hasProductOption($ProductOption))
		throw new \Exception($ProductOption->getName()." is required.");
	}
	
	/* @var $Option Entities\Company\Supplier\Product\Configurable\Instance\Option */
	foreach($this->_Instance->getOptions() as $Option)
	{
	    $RequiredParameters = $Option->getOption()->getRequiredParameters();
	    
	    foreach ($RequiredParameters as $Parameter)
	    {
		$message = $Option->getOption()->getCategory()->getName()." &raquo; ".
			    $Parameter->getOption()->getName()." &raquo; ".$Parameter->getName()." is ";
		if($Option->getOption()->isRequired())$message .= "required.";
		else $message .= " is missing. Select it or remove the option";
		
		if($Option->getValueFromParameterIndex($Parameter->getIndex()) === false)
		    throw new \Exception($message);
	    }
	}
    }
}