<?php
namespace Dataservice\Html\CRUD\Content\Relationship;

class View
{
    private $relationshipObject;
    
    public function __construct(\Dataservice_Doctrine_Entity $Entity, $relationshipPropertyName)
    {
	$relationshipObjectName	    = "Dataservice\\Html\\CRUD\\Content\\Relationship\\".
					$Entity->getRelationshipTypeName($relationshipPropertyName);
	$this->relationshipObject   = new $relationshipObjectName($Entity, $relationshipPropertyName);
    }
    
    /**
     * @param \Dataservice_Doctrine_Entity $Entity
     * @param string $relationshipPropertyName
     * @return \Dataservice\Html\CRUD\Content\Relationship\View
     */
    public static function factory(\Dataservice_Doctrine_Entity $Entity, $relationshipPropertyName)
    {
	return new View($Entity, $relationshipPropertyName);
    }
    
    public function getHTML()
    {
	return $this->relationshipObject->getHtml();
    }
    
    public function render()
    {
	echo $this->getHTML();
    }
}