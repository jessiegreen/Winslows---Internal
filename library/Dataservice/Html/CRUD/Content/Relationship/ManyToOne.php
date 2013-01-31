<?php
namespace Dataservice\Html\CRUD\Content\Relationship;

class ManyToOne extends RelationshipAbstract
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
    
    /**
     * @return string
     */
    public function getHtml()
    {
	$Anchor	    = new \Dataservice\Html\Anchor;
	$html	    = '<h4>';
	$html	    .= $this->relationshipPropertyName;
	$Account    = \Services\Company\Website::factory()->getCurrentWebsite()->getCurrentUserAccount(\Zend_Auth::getInstance());
	
	if(!$this->relationshipEntity && $Account->hasRoleByRoleNames($this->relationshipPermissions->add))
	    $html .= $Anchor->addIcon(
			"", 
			"/".$this->relationshipClassUrl."/edit/id/0/".strtolower($this->parentClassName).
			    "_id/".$this->parentEntity->getId(), 
			"Add ".$this->relationshipClassName
		    );
	$html .= '</h4>';
	$html .= '<ul>';

	if(!count($this->relationshipEntity))$html .= "<li>No ".$this->relationshipPropertyName." set.</li>";
	else
	{
	    $html .= "<li>";

	    if($Account->hasRoleByRoleNames($this->relationshipClassPermissions->view))
		$html .= $Anchor->viewIcon("", "/".$this->relationshipClassUrl."/view/id/".$this->relationshipEntity->getId(), "View ".$this->relationshipClassName);

	    if($Account->hasRoleByRoleNames($this->relationshipPermissions->remove))
		$html .= $Anchor->deleteIcon("", "/".$this->relationshipClassUrl."/delete/id/".$this->relationshipEntity->getId(), true, "Delete ".$this->relationshipClassName);

	    $html .= htmlspecialchars($this->relationshipEntity->toString());
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