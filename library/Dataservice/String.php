<?php
namespace Dataservice;

class String
{
    /**
     * @param string $string
     * @param int $length
     * @return string 
     */
    public static function truncate($string, $length)
    {
	if(is_string($string) && is_numeric($length))
	{
	    return strlen($string) > $length ? substr($string, 0, $length)."..." : $string;
	}
	else return "";
    }
}
