<?php
namespace Services\Company\Supplier\Product\Configurable\Instance\Pricer;

class DataAbstract extends \Dataservice_Service_ServiceAbstract
{
    protected static function _formatNumberForIndex($number)
    {
	return number_format($number, 0, "", "");
    }
}