<?php
namespace Dataservice\Html\CRUD;

class CollectionList
{
    private $collection;
    
    private $collectionName;

    private $parentEntity;
    
    private $parentClass;
    
    private $parentClassName;
    
    private $entityClass;
    
    private $entityClassName;
    
    private $entityUrl;

    private $permissions= array(
				"add" => array(), 
				"edit" => array(), 
				"delete" => array(), 
				"remove" => array(), 
				"view" => array()
			    );
    
    /**
     * @param \Dataservice_Doctrine_Entity $parentEntity
     * @param string $collectionName
     * @return \Dataservice\Html\CRUD\CollectionList
     */
    public static function factory($parentEntity, $collectionName)
    {
	return new CollectionList($parentEntity, $collectionName);
    }
    
    public function __construct($parentEntity, $collectionName)
    {
	$collection_method	= "get".$collectionName;
	$this->collection	= $parentEntity->$collection_method();
	$this->collectionName	= $collectionName;
	$this->parentEntity	= $parentEntity;
	$entityService		= \Services\Entity::factory();
	$this->parentClass	= get_class($parentEntity);
	$this->parentClassName	= end(explode('\\', $this->parentClass));
	$this->entityClass	= $entityService->getAssociationTargetClass($this->parentClass, $collectionName);
	$this->entityClassName	= end(explode('\\', $this->entityClass));
	$entity_permissions	= $entityService->getEntityCrudPermissions($this->entityClass);
	$this->entityUrl	= $entityService->getEntityUrl($this->entityClass);
	$collection_permissions	= $entityService->getCollectionCrudPermissions($this->parentClass, $collectionName);
	$this->permissions	= array_merge_recursive($this->permissions, (array) $entity_permissions);
	$this->permissions	= array_merge_recursive($this->permissions, (array) $collection_permissions);
	
	return $this;
    }
    
    public function getHtml()
    {
	$Anchor	    = new \Dataservice\Html\Anchor;
	$html	    = '<h4>';
	$html	    .= $this->collectionName;
	$Account    = \Services\Company\Website::factory()->getCurrentWebsite()->getCurrentUserAccount(\Zend_Auth::getInstance());
	
	if($Account->hasRoleByRoleNames($this->permissions["add"]))
	    $html .= $Anchor->addIcon(
			"", 
			"/".$this->entityUrl."/edit/id/0/".strtolower($this->parentClassName).
			    "_id/".$this->parentEntity->getId(), 
			"Add ".$this->entityClassName
		    );
	$html .= '</h4>';
	$html .= '<ul>';

	if(!count($this->collection))$html .= "<li>No ".$this->collectionName."</li>";
	else
	    /* @var $Entity \Dataservice_Doctrine_Entity */
	    foreach ($this->collection as $Entity)
	    {
		$html .= "<li>";
		
		if($Account->hasRoleByRoleNames($this->permissions["view"]))
		    $html .= $Anchor->viewIcon("", "/".$this->entityUrl."/view/id/".$Entity->getId(), "View ".$this->entityClassName);
		
		if($Account->hasRoleByRoleNames($this->permissions["remove"]))
		    $html .= $Anchor->deleteIcon("", "/".$this->entityUrl."/delete/id/".$Entity->getId(), true, "Delete ".$this->entityClassName);
		
		$html .= htmlspecialchars($Entity->toString());
		$html .= "</li>";
	    }
	$html .= "</ul>";
	    
	return $html;
    }
    
    public function renderHtml()
    {
	echo $this->returnHtml();
    }
}