<?php
class Dataservice_Doctrine_Entity 
{
    /** 
     * @Column(type="datetime") 
     * @var \DateTime $created
     */
    protected $created;

    /** 
     * @Column(type="datetime") 
     * @var \DateTime $updated
     */
    protected $updated;
    
    public function __construct()
    {
	$this->created	= $this->updated = new \DateTime("now");
    }

    /**
     * @PreUpdate
     */
    public function updated()
    {
        $this->updated = new \DateTime("now");
    }
    
    /**
     * @return \Dataservice\DateTime
     */
    public function getCreated()
    {
        return $this->created;
    }

    /**
     * @param \DateTime $created
     */
    public function setCreated(\DateTime $created)
    {
        $this->created = $created;
    }

    /**
     * @return \Dataservice\DateTime
     */
    public function getUpdated()
    {
        return \Dataservice\DateTime(strtotime($this->updated));
    }
    
    public function populate(array $array)
    {
	foreach ($array as $key => $value) 
	{
	    if(property_exists($this, $key))
	    {
		$this->$key = $value;
	    }
	}
    }
    
    public function filterCollectionByfield(\Doctrine\Common\Collections\ArrayCollection $ArrayCollection, $field, $value)
    {
	$method = "get".ucfirst(strtolower($field));
	
	return $ArrayCollection->filter(
		    function($Entity) use ($method, $value)
		    {
			return $Entity->$method() == $value ? true : false;
		    }
		);
    }
    
    /**
     * @param string $collection_property_name
     * @
     */
    public function getCollectionCrudPermissions($collection_property_name)
    {
	return \Services\Entity::factory()
		->getCollectionCrudPermissions(get_called_class(), $collection_property_name);
    }
    
    public function toString()
    {
	return "";
    }

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
    
    /**
     * @return string
     */
    public function getClassName(\Dataservice_Doctrine_Entity $Entity = null)
    {
	$class = $Entity ? get_class($Entity) : get_called_class();
	return end(explode('\\', $class));
    }
}