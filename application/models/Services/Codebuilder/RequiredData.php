<?php

/**
 * Name:
 * Location:
 *
 * Description for class (if any)...
 *
 * @author     Jessie Green <jessie.winslows@gmail.com>
 * @copyright  2012 Winslows inc.
 */
namespace Services\Codebuilder;

class RequiredData 
{   
    private $_type	= array("location");
    private $_model	= array("location", "type");
    private $_size	= array("location", "type", "model");
    private $_walls	= array("location", "type", "model", "size");
    private $_colors	= array("location", "type", "model", "size");
    private $_doors	= array("location", "type", "model", "size", "walls");
    
    public function getRequired($index){
	$index_string = "_".$index;
	if(property_exists($this, $index_string))
	    return $this->$index_string;
	else throw new Exception($index_string." does not exist as a required array.");
    }
}
?>