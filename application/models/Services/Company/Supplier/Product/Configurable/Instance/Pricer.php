<?php
namespace Services\Company\Supplier\Product\Configurable\Instance;

class Pricer extends \Dataservice_Service_ServiceAbstract
{
    public function getPricer($name)
    {
	$class = "\Services\Company\Supplier\Product\Configurable\Instance\Pricer\\".$name;
	return new $class;
    }
}