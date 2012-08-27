<?php
namespace Services\Company\Supplier\Product\Configurable\Instance\Pricer;

class PricerAbstract extends \Dataservice_Service_ServiceAbstract implements \Interfaces\Company\Supplier\Product\Configurable\Instance\Pricer
{
   /**
     * @var decimal $_price
     */
    protected $_price = 0;
    
    /**
     * @var array $_details
     */
    protected $_details;
    
       /**
     *  @var \Entities\Company\Supplier\Product\Configurable\Instance $_Instance 
     */
    protected $_Instance;
    
    /**
     *  @var \Services\Company\Supplier\Product\Configurable\Instance\Pricer\DataAbstract $_Data 
     */
    protected $_Data;
    
    /**
     *  @var \Services\Company\Supplier\Product\Configurable\Instance\Mapper\MapperAbstract $_Mapper 
     */
    protected $_Mapper;
    
    /**
     * @param \Entities\Company\Supplier\Product\Configurable\Instance $Instance
     */
    public function __construct(\Entities\Company\Supplier\Product\Configurable\Instance $Instance)
    {
	$class_name	    = $Instance->getProduct()->getClassName();
	$instance_ns	    = "\Services\Company\Supplier\Product\Configurable\Instance\\".$class_name;
	$data_class	    = $instance_ns."\Pricer\Data";
	$mapper_class	    = $instance_ns."\Mapper";
	
	$this->_Instance    = $Instance;
	$this->_Data	    = new $data_class;
	$this->_Mapper	    = new $mapper_class($Instance);
    }
    
    public function price()
    {
	
    }
}