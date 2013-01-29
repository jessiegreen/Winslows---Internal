<?php
namespace Dataservice\Html\CRUD;

class EntityView
{
    /**
     * @var \Dataservice_Doctrine_Entity 
     */
    private $entity;
    
    /**
     * @var string 
     */
    private $entityClass;
    
    /**
     * @var string 
     */
    private $entityClassName;
    
    /**
     * @var string 
     */
    private $entityUrl;

    /**
     * @var array 
     */
    private $permissions    = array("add" => array(), "edit" => array(), "delete" => array(), "remove" => array());
    
    /** 
     * @param \Dataservice_Doctrine_Entity $entity
     * @return \Dataservice\Html\CRUD\EntityView
     */
    public static function factory(\Dataservice_Doctrine_Entity $entity)
    {
	return new EntityView($entity);
    }
    
    /**
     * @param \Dataservice_Doctrine_Entity $entity
     * @return \Dataservice\Html\CRUD\EntityView
     */
    public function __construct(\Dataservice_Doctrine_Entity $entity)
    {
	$entityService		= \Services\Entity::factory();
	$this->entity		= $entity;
	$this->entityClass	= get_class($this->entity);
	$this->entityClassName	= end(explode('\\', $this->entityClass));
	$entity_permissions	= $entityService->getEntityCrudPermissions($this->entityClass);
	$this->entityUrl	= $entityService->getEntityUrl($this->entityClass);
	$this->permissions	= array_merge_recursive($this->permissions, (array) $entity_permissions);
	
	return $this;
    }
    
    public function getHtml()
    {
	$Anchor	    = new \Dataservice\Html\Anchor;
	$html	    = '<h4>';
	$html	    .= $this->entityClassName;
	$Account    = \Services\Company\Website::factory()->getCurrentWebsite()->getCurrentUserAccount(\Zend_Auth::getInstance());
	$html .= '</h4>';
	$html .= '<ul>';

	$html .= "<li>";
	
	if($Account->hasRoleByRoleNames($this->permissions["edit"]))
	    $html .= $Anchor->editIcon("", "/".$this->entityUrl."/edit/id/".$this->entity->getId(), "Edit ".$this->entityClassName);
	
	if($Account->hasRoleByRoleNames($this->permissions["delete"]))
	    $html .= $Anchor->deleteIcon("", "/".$this->entityUrl."/delete/id/".$this->entity->getId(), true, "Delete ".$this->entityClassName);
	
	$html .= htmlspecialchars($this->entity->toString());
	$html .= "</li>";
	    
	return $html;
    }
    
    public function renderHtml()
    {
	echo $this->returnHtml();
    }
}