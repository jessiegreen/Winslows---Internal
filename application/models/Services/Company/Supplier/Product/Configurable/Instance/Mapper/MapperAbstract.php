<?php
namespace Services\Company\Supplier\Product\Configurable\Instance\Mapper;

class MapperAbstract extends \Dataservice_Service_ServiceAbstract
{
    
    /**
     * @var \Entities\Company\Supplier\Product\Configurable\Instance $_Instance 
     */
    protected $_Instance;
    
    /**
     *  @var \Services\Company\Supplier\Product\Configurable\Instance\Mapper\DataAbstract $_Data 
     */
    protected $_Data;
    
    public function __construct(\Entities\Company\Supplier\Product\Configurable\Instance $Instance)
    {
	$class_name	    = $Instance->getProduct()->getConfiguratorClassName();
	$instance_ns	    = "\Services\Company\Supplier\Product\Configurable\Instance\\".$class_name;
	$data_class	    = $instance_ns."\Mapper\Data";
	
	$this->_Instance    = $Instance;
	$this->_Data	    = new $data_class;
    }
    
    /**
     * @param \Entities\Company\Supplier\Product\Configurable\Option\Parameter\Value $Value
     * @return string|false
     */
    protected function _returnCodeOrFalse($Value)
    {
	if($Value !== false)return $Value->getCode();
	
	return false;
    }
    
    /**
     * @param \Entities\Company\Supplier\Product\Configurable\Option\Parameter\Value $Value
     * @return string|false
     */
    protected function _returnNameOrFalse($Value)
    {
	if($Value !== false)return $Value->getName();
	
	return false;
    }
    
    /**
     * @param \Entities\Company\Supplier\Product\Configurable\Option\Parameter\Value $Value
     * @return string|false
     */
    protected function _returnIndexOrFalse($Value)
    {
	if($Value !== false)return $Value->getIndex();
	
	return false;
    }
}
