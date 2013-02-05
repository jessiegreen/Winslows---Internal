<?php
namespace Dataservice\Html\CRUD\Content\Relationship;

class RelationshipAbstract
{
    /**
     * @var \Dataservice_Doctrine_Entity 
     */
    public $parentEntity;
    
    public $parentClass;
    
    public $parentClassName;
    
    public $parentClassPermissions;
    
    public $parentClassUrl;
    
    public $relationshipPermissions;
    
    public $relationshipPropertyName;
    
    public $relationshipClass;
    
    public $relationshipClassName;
    
    public $relationshipClassPermissions;
    
    public $relationshipClassUrl;
    
    public $htmlHeaderContent = "";
    
    public $htmlBodyContent = "";
    
    public $anchorObject;
    
    public $currentUserAccount;
    
    public function __construct(\Dataservice_Doctrine_Entity $parentEntity, $relationshipPropertyName)
    {
	$this->parentEntity		    = $parentEntity;
	$this->parentClass		    = get_class($parentEntity);
	$this->parentClassName		    = end(explode('\\', $this->parentClass));
	$this->parentClassPermissions	    = $this->parentEntity->getCrudPermissions();
	$this->parentClassUrl		    = $parentEntity->getCrudUrl();
	$this->relationshipPermissions	    = $this->parentEntity->getRelationshipCrudPermissions($relationshipPropertyName);
	$this->relationshipPropertyName	    = $relationshipPropertyName;
	$this->relationshipClass	    = $this->parentEntity->getRelationshipClass($this->relationshipPropertyName);
	$this->relationshipClassName	    = end(explode('\\', $this->relationshipClass));
	$this->relationshipClassUrl	    = $parentEntity->getRelationshipCrudUrl($relationshipPropertyName);
	$this->relationshipClassPermissions = $this->parentEntity->getRelationshipClassCrudPermissions($relationshipPropertyName);
	$this->anchorObject		    = new \Dataservice\Html\Anchor;
	$this->currentUserAccount	    = \Services\Company\Website::factory()
						->getCurrentWebsite()
						->getCurrentUserAccount(\Zend_Auth::getInstance());
    }
    
    public function build()
    {
	$this->buildRelationshipHeaderHtml();
	$this->buildRelationshipBodyHtml();
	
	return $this;
    }
    
    public function gethtmlHeader()
    {
	return "<h4>".$this->htmlHeaderContent."</h4>";
    }
    
    public function addHtmlHeaderContent($content)
    {
	$this->htmlHeaderContent .= $content;
    }
    
    public function gethtmlBody()
    {
	return $this->htmlBodyContent;
    }
    
    public function addHtmlBodyContent($content)
    {
	$this->htmlBodyContent .= $content;
    }
    
    public function getHtml()
    {
	return $this->gethtmlHeader().$this->gethtmlBody();
    }
    
    public function render()
    {
	echo $this->getHtml();
    }
}