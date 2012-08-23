<?php
namespace Services\Company\Supplier\Product\Configurable\Instance\Validator;

class WoodBuilding implements \Interfaces\Company\Supplier\Product\Configurable\Instance\Validator
{
    /**
     *  @var \Entities\Company\Supplier\Product\Configurable\Instance $_Instance 
     */
    static private $_Instance;
    static private $_Data;

    /**
     * @param \Entities\Company\Supplier\Product\Configurable\Instance $Instance
     */
    static public function validate(\Entities\Company\Supplier\Product\Configurable\Instance $Instance)
    {
	$data_class	    = "\Services\Company\Supplier\Product\Configurable\Instance\Validator\Data\\".self::_getCalledClassName();
	self::$_Instance    = $Instance;
	self::$_Data	    = new $data_class;
    }
}