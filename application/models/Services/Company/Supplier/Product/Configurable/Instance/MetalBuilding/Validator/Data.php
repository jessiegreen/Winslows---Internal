<?php
namespace Services\Company\Supplier\Product\Configurable\Instance\MetalBuilding\Validator;

class Data extends \Services\Company\Supplier\Product\Configurable\Instance\Validator\DataAbstract
{    
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
     * @return array()
     */
    static public function getAllowedMetalModelSizesArray()
    {
	return self::$_allowed_sizes;
    }
    
    /**
     * @return array()
     */
    static public function getAllowedLegHeightsArray()
    {
	return self::$_allowed_leg_heights;
    }
}