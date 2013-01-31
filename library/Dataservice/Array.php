<?php
class Dataservice_Array
{
    /**
     * merges arrays recursively then removes duplicate values recursively
     * @param array $array1
     * @param array $array2
     * @return array
     */
    public static function merge_unique_recursive($array1, $array2)
    {
	return self::unique_recursive(array_merge_recursive($array1, $array2));
    }
    
    /**
     * Removes duplicates recursively
     * @param array $array
     * @return array
     */
    public static function unique_recursive($array)
    {
      $result = array_map("unserialize", array_unique(array_map("serialize", $array)));

      foreach ($result as $key => $value)
      {
	if ( is_array($value) )
	{
	  $result[$key] = self::unique_recursive($value);
	}
      }

      return $result;
    }
}
