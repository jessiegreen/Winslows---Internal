<?php
class Dataservice_Doctrine_Entity 
{
    public function toArray() 
    {
        $reflection = new \ReflectionClass($this);
        $details    = array();
	
        foreach($reflection->getProperties(\ReflectionProperty::IS_PROTECTED) as $property) 
	{
            if(!$property->isStatic()) 
	    {
                $details[$property->getName()] = $this->{$property->getName()};
            }
        }
        return $details;
    }
}