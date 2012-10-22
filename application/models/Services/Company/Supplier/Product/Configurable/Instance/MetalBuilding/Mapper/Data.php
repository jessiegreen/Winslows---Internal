<?php
namespace Services\Company\Supplier\Product\Configurable\Instance\MetalBuilding\Mapper;

class Data extends \Services\Company\Supplier\Product\Configurable\Instance\Mapper\DataAbstract
{
    #STATIC METHODS AND PROPERTIES ONLY!!!
    static private $_sides_array = array("L" => "left", "R" => "right", "F" => "front", "B" => "back");
    
    static private $_sides_locations_array = array("left" => "side", "right" => "side", "front" => "end", "back" => "end");
    
    static private $_high_snow_wind_models = array("RX", "BX", "VX");
    
    static private $_aframe_models = array("BA", "VA", "BW", "VW", "BS", "VS", "BX", "VX");
    
    static public function getHighSnowAndWindModelsArray()
    {
	return self::$_high_snow_wind_models;
    }
    
    static public function getSidesArray()
    {
	return self::$_sides_array;
    }
    
    static public function getSidesLocationsArray()
    {
	return self::$_sides_locations_array;
    }
    
    static public function getAframeModels()
    {
	return self::$_aframe_models;
    }
}