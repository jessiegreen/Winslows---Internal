<?php
namespace Services\Company\Supplier\Product\Configurable\Instance;

class Validator extends \Dataservice_Service_ServiceAbstract
{
    public function getValidator($name)
    {
	$class = "Validator\\".$name;
	return new $class;
    }
}