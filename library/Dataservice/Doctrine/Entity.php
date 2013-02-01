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
    
    /**
     * @param array $array
     * @param \Doctrine\ORM\EntityManager $em
     * @param type $entityClass
     * @param type $idIndex
     * @return null
     */
    protected function _getEntityFromArray($array, $entityClass, $idIndex)
    {
	$id = isset($array[$idIndex]) && $array[$idIndex] ? $array[$idIndex] : null;
	
	if($id)
	{
	    return \Services\Company\Entity::factory()->find($entityClass, $id);
	}
	
	return null;
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
     * @return array
     */
    public function getCrudPermissions()
    {
	return \Services\Company\Entity::factory()
		->getEntityCrudPermissions($this->getClass());
    }
    
    /**
     * @param string $permission_name
     * @return array
     */
    public function getCrudPermission($permission_name)
    {
	return \Services\Company\Entity::factory()
		->getEntityCrudPermissions($this->getClass(), $permission_name);
    }
    
    /**
     * @param string $collection_property_name
     * @return \Dataservice\Doctrine\ORM\Mapping\Crud\Relationship\Permissions 
     */
    public function getRelationshipCrudPermissions($collection_property_name)
    {
	return \Services\Company\Entity::factory()
		->getRelationshipCrudPermissions(get_called_class(), $collection_property_name);
    }
    
    /**
     * @param string $related_property_name
     * @return type
     */
    public function getRelationshipTypeName($related_property_name)
    {
	return \Services\Company\Entity::factory()
		->getRelationshipTypeName($this->getClass(), $related_property_name);
    }
    
    /**
     * @param string $related_property_name
     * @return string
     */
    public function getRelationshipClass($related_property_name)
    {
	return \Services\Company\Entity::factory()
		->getRelationshipTargetClass($this->getClass(), $related_property_name);
    }
    
    /**
     * @param string $related_property_name
     * @return \Dataservice\Doctrine\ORM\Mapping\Crud\Relationship\Permissions
     */
    public function getRelationshipClassCrudPermissions($related_property_name)
    {
	return \Services\Company\Entity::factory()
		->getEntityCrudPermissions($this->getRelationshipClass($related_property_name));
    }
    
    /**
     * @return string
     */
    public function getCrudUrl()
    {
	return \Services\Company\Entity::factory()
		->getEntityCrudUrl($this->getClass());
    }
    
    /**
     * @param string $related_property_name
     * @return string
     */
    public function getRelationshipCrudUrl($related_property_name)
    {
	return \Services\Company\Entity::factory()
		->getEntityCrudUrl($this->getRelationshipClass($related_property_name));
    }
    
    /**
     * @return string
     */
    public function toString()
    {
	return "";
    }

    /**
     * @return array
     */
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
    public function getClassName()
    {
	return end(explode('\\', $this->getClass()));
    }
    
    /**
     * @return string
     */
    public function getClass()
    {
	return str_replace("Proxies\__CG__\\", "", get_called_class());
    }
    
    /**
     * @return \Dataservice_Form
     */
    public function getEditForm()
    {
	$FormClass  = $this->getEditFormClass();
	$Form	    = new $FormClass($this, array("method" => "post"));
	
	return $Form;
    }
    
    public function getEditFormClass()
    {
	return "\\".str_replace("Entities", "Forms", $this->getClass());
    }
    
    public function getEditSubform()
    {
	$SubformClass	= $this->getEditFormClass()."\\Subform";
	$Subform	= new $SubformClass($this);
	
	return $Subform;
    }
}