<?php
namespace Services\Company\Supplier\Product\Configurable\Instance\CarportEndCombo\Pricer;

class Data extends \Services\Company\Supplier\Product\Configurable\Instance\MetalBuildingAbstract\Pricer\Data
{
    #STATIC METHODS AND PROPERTIES ONLY!!!
    
    /**
     * From Upgrades and Additions Price Sheet
     * array("depth" => array(StorageDepth => array("leg_height" => array(LegHeight => value)
     * @var array 
     */
    protected static $_utility_sides_prices_array = 
	    array(
		"depth"   => array(
		    "5"	=> array(
			"leg_height" => array(
			    "5"  => 95,
			    "6"  => 95,
			    "7"  => 190,
			    "8"  => 190,
			    "9"  => 190,
			    "10" => 220,
			    "11" => 220,
			    "12" => 220
			)
		    ),
		    "10"	=> array(
			"leg_height" => array(
			    "5"  => 190,
			    "6"  => 190,
			    "7"  => 285,
			    "8"  => 285,
			    "9"  => 285,
			    "10" => 380,
			    "11" => 380,
			    "12" => 380
			)
		    ),
		    "15"	=> array(
			"leg_height" => array(
			    "5"  => 270,
			    "6"  => 270,
			    "7"  => 375,
			    "8"  => 375,
			    "9"  => 375,
			    "10" => 570,
			    "11" => 570,
			    "12" => 570
			)
		    ),
		    "20"	=> array(
			"leg_height" => array(
			    "5"  => 270,
			    "6"  => 270,
			    "7"  => 375,
			    "8"  => 375,
			    "9"  => 375,
			    "10" => 570,
			    "11" => 570,
			    "12" => 570
			)
		    )
		)
	    );
    
    /**
     * @param string|float|int $leg_height
     * @param string|float|int $combo_length
     * @return float
     */
    static public function getEndComboSidesPrice($leg_height, $combo_length)
    {
	$array = self::$_utility_sides_prices_array;
	
	return (float) $array["depth"][self::_formatNumberForIndex($combo_length)]
				["leg_height"][self::_formatNumberForIndex($leg_height)];
    }
}