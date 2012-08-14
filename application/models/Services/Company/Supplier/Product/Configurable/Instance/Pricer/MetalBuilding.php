<?php
namespace Services\Company\Supplier\Product\Configurable\Instance\Pricer;

class MetalBuilding implements \Interfaces\Company\Supplier\Product\Configurable\Instance\Pricer
{
    /**
     * @param \Entities\Company\Supplier\Product\Configurable\Instance $Instance
     */
    public static function price($Instance)
    {
	return 3.99;
    }
}