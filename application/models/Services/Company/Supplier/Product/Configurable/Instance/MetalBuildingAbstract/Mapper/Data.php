<?php
namespace Services\Company\Supplier\Product\Configurable\Instance\MetalBuildingAbstract\Mapper;

abstract class Data extends \Services\Company\Supplier\Product\Configurable\Instance\Mapper\DataAbstract
{
    #STATIC METHODS AND PROPERTIES ONLY!!!
    static protected $_sides_array = array("L" => "left", "R" => "right", "F" => "front", "B" => "back");
    
    static protected $_sides_locations_array = array("left" => "side", "right" => "side", "front" => "end", "back" => "end");
    
    static public function getSidesArray()
    {
	return self::$_sides_array;
    }
    
    static public function getSidesLocationsArray()
    {
	return self::$_sides_locations_array;
    }
}