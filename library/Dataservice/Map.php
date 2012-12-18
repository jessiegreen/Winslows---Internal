<?php
namespace Dataservice;

class Map 
{
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
}