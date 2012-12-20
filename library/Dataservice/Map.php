<?php
namespace Dataservice;

class Map 
{
    /**
     * @return \Dataservice\Map
     */
    public static function factory()
    {
	return new Map;
    }

    /**
     * @param string $address
     * @return array
     */
    public static function getLatLongFromAddress($address)
    {
	$return	= array("latitude" => "", "longitude" => "");
	$url	= "http://maps.google.com/maps/api/geocode/json?address=".urlencode($address)."&sensor=false";
	$ch	= curl_init();
	
	curl_setopt($ch, CURLOPT_URL, $url);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($ch, CURLOPT_PROXYPORT, 3128);
	curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
	
	$response = curl_exec($ch);
	
	curl_close($ch);
	
	$response_a = json_decode($response);

	if(isset($response_a->results[0]) && is_object($response_a->results[0]))
	{
	    $return["latitude"]	= $response_a->results[0]->geometry->location->lat;
	    $return["longitude"] = $response_a->results[0]->geometry->location->lng;
	}
	
	return $return;
    }
    
    /**
     * @param string $lat_1
     * @param string $long_1
     * @param string $lat_2
     * @param string $long_2
     * @return float
     */
    public function getDistanceInMilesBetweenTwoLocations($lat_1, $long_1, $lat_2, $long_2)
    {
//	echo '$lat_1'.$lat_1.', $long_1'.$long_1.', $lat_2'.$lat_2.', $long_2'. $long_2."<br />";
        $x  = 69.1 * ($lat_1 - $lat_2);
        $y  = 69.1 * ($long_1 - $long_2);
	
        return sqrt(($x*$x) + ($y*$y));
    }
    
    /**
     * @return string
     */
    public static function getGoogleApiKey()
    {
	$website    = WEBSITE_NAME_INDEX;
	$key	    = \Zend_Registry::get('config')->googleAPI->$website->key;
	
	return $key ? $key : "";
    }
}