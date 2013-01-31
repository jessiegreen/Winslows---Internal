<?php
namespace Dataservice\Html\CRUD\Content\Relationship;

class RelationshipAbstract
{
    /**
     * @var \Dataservice_Doctrine_Entity 
     */
    protected $parentEntity;
    
    protected $parentClass;
    
    protected $parentClassName;
    
    protected $parentClassPermissions;
    
    protected $relationshipPermissions;
    
    protected $relationshipPropertyName;
    
    protected $relationshipClass;
    
    protected $relationshipClassName;
    
    protected $relationshipClassPermissions;
    
    protected $relationshipClassUrl;
    
    public function __construct(\Dataservice_Doctrine_Entity $parentEntity, $relationshipPropertyName)
    {
	$this->parentEntity		    = $parentEntity;
	$this->parentClass		    = get_class($parentEntity);
	$this->parentClassName		    = end(explode('\\', $this->parentClass));
	$this->parentClassPermissions	    = $this->parentEntity->getCrudPermissions();
	$this->relationshipPermissions	    = $this->parentEntity->getRelationshipCrudPermissions($relationshipPropertyName);
	$this->relationshipPropertyName	    = $relationshipPropertyName;
	$this->relationshipClass	    = $this->parentEntity->getRelationshipClass($this->relationshipPropertyName);
	$this->relationshipClassName	    = end(explode('\\', $this->relationshipClass));
	$this->relationshipClassUrl	    = $parentEntity->getRelationshipCrudUrl($relationshipPropertyName);
	$this->relationshipClassPermissions = $this->parentEntity->getRelationshipClassCrudPermissions($relationshipPropertyName);
    }
}