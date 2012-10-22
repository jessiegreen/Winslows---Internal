<?php
namespace Services\Company\Supplier\Product\Configurable\Instance\MetalBuildingAbstract\Validator;

class Data extends \Services\Company\Supplier\Product\Configurable\Instance\Validator\DataAbstract
{   
    #STATIC METHODS AND PROPERTIES ONLY!!!
    protected static $_regular_states_array	    = array(
							    "nc", "sc", "ga", "tn", "ky", "va", "wv", 
							    "tx", "ok", "la", "ar", "al", "mo", "ks", 
							    "il", "ia", "ne", "ms"
							);
    
    protected static $_high_wind_states_array	    = array("fl");
    
    protected static $_snow_wind_states_array	    = array("in", "oh", "pa", "md", "de", "nj", "ny", "dc");
    
    protected static $_high_snow_wind_states_array  = array("mi");
    
    protected static $_allowed_leg_heights	    = array(
							    "1" => array(5,6,7,8,9,10,11,12),
							    "2" => array(6,7,8,9,10,11,12,13),
							    "3" => array(6,7,8,9,10,11,12,13)
							);
    
    public static function getRegularStates()
    {
	return self::$_regular_states_array;
    }
    
    public static function getHighWindStates()
    {
	return self::$_high_wind_states_array;
    }
    
    public static function getSnowWindStates()
    {
	return self::$_snow_wind_states_array;
    }
    
    public static function getHighSnowWindStates()
    {
	return self::$_high_snow_wind_states_array;
    }
    
    public static function getAllowedLegHeights()
    {
	return self::$_allowed_leg_heights;
    }
}