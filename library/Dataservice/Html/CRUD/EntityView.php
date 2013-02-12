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
    
    private $htmlHeader = "";
    
    private $htmlBody = "";
    
    private $websiteUserAccount;
    
    private $anchorObject;
    
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
	$entityService		= \Services\Company\Entity::factory();
	$this->entity		= $entity;
	$this->entityClass	= get_class($this->entity);
	$this->entityClassName	= end(explode('\\', $this->entityClass));
	$entity_permissions	= $entityService->getEntityCrudPermissions($this->entityClass);
	$this->entityUrl	= $entityService->getEntityCrudUrl($this->entityClass);
	$this->permissions	= array_merge_recursive($this->permissions, (array) $entity_permissions);
	$this->websiteUserAccount   = \Services\Company\Website::factory()
					->getCurrentWebsite()
					->getCurrentUserAccount(\Zend_Auth::getInstance());
	$this->anchorObject	    = new \Dataservice\Html\Anchor;
	
	return $this;
    }
    
    /**
     * @return \Dataservice\Html\CRUD\EntityView
     */
    public function build()
    {
	$this->buildHeader();
	$this->buildBody();
	
	return $this;
    }
    
    /**
     * @return \Dataservice\Html\CRUD\EntityView
     */
    public function buildHeader()
    {
	$this->addHeaderHtml($this->entityClassName);
	
	return $this;
    }
    
    /**
     * @return \Dataservice\Html\CRUD\EntityView
     */
    public function buildBody()
    {
	$this->addBodyHtml('<ul>');

	$this->addBodyHtml("<li>");
	
	if($this->websiteUserAccount->hasRoleByRoleNames($this->permissions["edit"]))
	    $this->addBodyHtml($this->anchorObject->editIcon("", "/".$this->entityUrl."/edit/id/".$this->entity->getId(), "Edit ".$this->entityClassName));
	
	if($this->websiteUserAccount->hasRoleByRoleNames($this->permissions["delete"]))
	    $this->addBodyHtml($this->anchorObject->deleteIcon("", "/".$this->entityUrl."/delete/id/".$this->entity->getId(), true, "Delete ".$this->entityClassName));
	
	$this->addBodyHtml(htmlspecialchars($this->entity->toString()));
	
	$this->addBodyHtml("</li>");
	
	$this->addBodyHtml('</ul>');
	
	return $this;
    }
    
    /**
     * @return string
     */
    public function getHeaderHtml()
    {
	$html = '<h4>';
	$html .= $this->htmlHeader;
	$html .= '</h4>';
	
	return $html;
    }
    
    /**
     * @return string
     */
    public function getBodyHtml()
    {
	return $this->htmlBody;
    }
    
    /**
     * @param string $html
     * @return \Dataservice\Html\CRUD\EntityView
     */
    public function addHeaderHtml($html)
    {
	$this->htmlHeader .= $html;
	
	return $this;
    }
    
    /**
     * @param string $html
     * @return \Dataservice\Html\CRUD\EntityView
     */
    public function addBodyHtml($html)
    {
	$this->htmlBody .= $html;
	
	return $this;
    }
    
    /**
     * @return string
     */
    public function getHtml()
    {
	return $this->getHeaderHtml().$this->getBodyHtml();
    }
    
    /**
     * @return \Dataservice\Html\CRUD\EntityView
     */
    public function render()
    {
	echo $this->getHtml();
	
	return $this;
    }
}