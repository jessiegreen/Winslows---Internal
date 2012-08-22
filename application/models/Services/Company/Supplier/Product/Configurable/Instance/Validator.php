<?php
namespace Services\Company\Supplier\Product\Configurable\Instance;

class Validator extends \Dataservice_Service_ServiceAbstract
{
    public function getValidator($name)
    {
	$class = "Services\Company\Supplier\Product\Configurable\Instance\Validator\\".$name;
	return new $class;
    }
    
    static protected function _getCalledClassName()
    {
	$class = explode('\\', get_called_class());
	return end($class); 
    }
}