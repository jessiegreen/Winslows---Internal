<?php
namespace Dataservice\Html\CRUD\Content\Relationship;

class OneToOne extends RelationshipAbstract
{
    protected $relationshipEntity;

    /**
     * @param \Dataservice_Doctrine_Entity $parentEntity
     * @param string $relationshipPropertyName
     * @return OneToOne
     */
    public static function factory(\Dataservice_Doctrine_Entity $parentEntity, $relationshipPropertyName)
    {
	return new OneToOne($parentEntity, $relationshipPropertyName);
    }
    
    /**
     * @param \Dataservice_Doctrine_Entity $parentEntity
     * @param string $relationshipPropertyName
     * @return \Dataservice\Html\CRUD\Content\Relationship\OneToOne
     */
    public function __construct(\Dataservice_Doctrine_Entity $parentEntity, $relationshipPropertyName)
    {
	parent::__construct($parentEntity, $relationshipPropertyName);
	
	$method			    = "get".$this->relationshipPropertyName;
	$this->relationshipEntity   = $parentEntity->$method(); 
	
	return $this;
    }
    
    public function buildRelationshipHeaderHtml()
    {
	$this->addHtmlHeaderContent($this->relationshipPropertyName);
	
	if(!$this->relationshipEntity && $this->currentUserAccount->hasRoleByRoleNames($this->relationshipPermissions->add))
	    $this->addHtmlHeaderContent(
		    $this->anchorObject->addIcon(
			"", 
			"/".$this->relationshipClassUrl."/edit/id/0/".strtolower($this->parentClassName).
			    "_id/".$this->parentEntity->getId(), 
			"Add ".$this->relationshipClassName
		    )
		);
    }
    
    public function buildRelationshipBodyHtml()
    {
	$this->addHtmlBodyContent('<ul>');

	if(!count($this->relationshipEntity))
	    $this->addHtmlBodyContent("<li>No ".$this->relationshipPropertyName." set.</li>");
	else
	{
	    $this->addHtmlBodyContent("<li>");

	    if($this->currentUserAccount->hasRoleByRoleNames($this->relationshipClassPermissions->view))
		$this->addHtmlBodyContent(
			$this->anchorObject->viewIcon(
				"", 
				"/".$this->relationshipEntity->getCrudUrl()."/view/id/".$this->relationshipEntity->getId(), 
				"View ".$this->relationshipClassName
				)
		    );

	    if($this->currentUserAccount->hasRoleByRoleNames($this->relationshipPermissions->remove))
		$this->addHtmlBodyContent(
			$this->anchorObject->deleteIcon(
				"", 
				"/".$this->relationshipEntity->getCrudUrl()."/delete/id/".$this->relationshipEntity->getId(), 
				true, 
				"Delete ".$this->relationshipClassName
				)
		    );

	    $this->addHtmlBodyContent(htmlspecialchars($this->relationshipEntity->toString()));
	    $this->addHtmlBodyContent("</li>");
	}
	
	$this->addHtmlBodyContent("</ul>");
	    
	return $this;
    }
}