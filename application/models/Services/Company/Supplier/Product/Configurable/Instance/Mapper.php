<?php
namespace Services\Company\Supplier\Product\Configurable\Instance;

class Mapper extends \Dataservice_Service_ServiceAbstract
{
    public function getMapper(\Entities\Company\Supplier\Product\Configurable\Instance $Instance, $name)
    {
	$class = "Services\Company\Supplier\Product\Configurable\Instance\Mapper\\".$name;
	return new $class($Instance);
    }
    
    static protected function _getCalledClassName()
    {
	$class = explode('\\', get_called_class());
	return end($class); 
    }
}
