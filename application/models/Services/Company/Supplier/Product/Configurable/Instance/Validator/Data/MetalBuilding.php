<?php
namespace Services\Company\Supplier\Product\Configurable\Instance\Validator\Data;

class MetalBuilding extends \Services\Company\Supplier\Product\Configurable\Instance\Data
{
    static private $_sides_array = array("L" => "left", "R" => "right", "F" => "Front", "B" => "Back");
    
    static private $_high_snow_wind_models = array("RX", "BX", "VX");
    
    static private $_allowed_leg_heights = array(
					    "RA" => array(5,6,7,8,9,10,11,12),
					    "BA" => array(6,7,8,9,10,11,12,13),
					    "VA" => array(6,7,8,9,10,11,12,13),
					    "RW" => array(5,6,7,8,9,10,11,12),
					    "BW" => array(6,7,8,9,10,11,12,13),
					    "VW" => array(6,7,8,9,10,11,12,13),
					    "RS" => array(5,6,7,8,9,10,11,12),
					    "BS" => array(6,7,8,9,10,11,12,13),
					    "VS" => array(6,7,8,9,10,11,12,13),
					    "RX" => array(5,6,7,8,9,10,11,12),
					    "BX" => array(6,7,8,9,10,11,12,13),
					    "VX" => array(6,7,8,9,10,11,12,13)
					);
    
    static private $_allowed_sizes = array(
						"12X21",
						"12X26",
						"12X31",
						"12X36",
						"12X41",
						"18X21",
						"18X26",
						"18X31",
						"18X36",
						"18X41",
						"20X21",
						"20X26",
						"20X31",
						"20X36",
						"20X41",
						"22X21",
						"22X26",
						"22X31",
						"22X36",
						"22X41",
						"24X21",
						"24X26",
						"24X31",
						"24X36",
						"24X41"
					);
    
    /**
     * @param string $model_code
     * @return array()
     */
    static public function allowedMetalModelSizes()
    {
	return self::$_allowed_sizes;
    }
    
    static public function allowedLegHeightsArray()
    {
	return self::$_allowed_leg_heights;
    }
    
    static public function getHighSnowAndWindModelsArray()
    {
	return self::$_high_snow_wind_models;
    }
    
    static public function getSidesArray()
    {
	return self::$_sides_array;
    }
}