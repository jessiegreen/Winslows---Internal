<?php
namespace Dataservice\Html\CRUD\Content\Relationship;

class ManyToMany extends RelationshipAbstract
{
    private $relationshipCollection;
    
    /**
     * @param \Dataservice_Doctrine_Entity $parentEntity
     * @param string $relationshipPropertyName
     * @return OneToMany
     */
    public static function factory(\Dataservice_Doctrine_Entity $parentEntity, $relationshipPropertyName)
    {
	return new ManyToMany($parentEntity, $relationshipPropertyName);
    }
    
    public function __construct(\Dataservice_Doctrine_Entity $parentEntity, $relationshipPropertyName)
    {
	parent::__construct($parentEntity, $relationshipPropertyName);
	
	$collection_method			    = "get".$relationshipPropertyName;
	$this->relationshipCollection		    = $parentEntity->$collection_method();
	
	return $this;
    }
    
    public function getHtml()
    {
	$Anchor	    = new \Dataservice\Html\Anchor;
	$html	    = '<h4>';
	$html	    .= $this->relationshipPropertyName;
	$Account    = \Services\Company\Website::factory()->getCurrentWebsite()->getCurrentUserAccount(\Zend_Auth::getInstance());
	
	if($Account->hasRoleByRoleNames($this->relationshipPermissions->add))
	    $html .= $Anchor->manageIcon(
			"", 
			"/".$this->parentClassUrl."/manage-".strtolower($this->relationshipPropertyName).
			    "/id/".$this->parentEntity->getId(), 
			"Manage ".$this->relationshipPropertyName
		    );
	$html .= '</h4>';
	$html .= '<ul>';

	if(!count($this->relationshipCollection))$html .= "<li>No ".$this->relationshipPropertyName."</li>";
	else
	    /* @var $Entity \Dataservice_Doctrine_Entity */
	    foreach ($this->relationshipCollection as $Entity)
	    {
		$html .= "<li>";
		
		if($Account->hasRoleByRoleNames($Entity->getCrudPermission("view")))
		    $html .= $Anchor->viewIcon("", "/".$Entity->getCrudUrl()."/view/id/".$Entity->getId(), "View ".$this->relationshipClassName);
		
		if($Account->hasRoleByRoleNames($this->relationshipPermissions->remove))
		    $html .= $Anchor->deleteIcon("", "/".$this->relationshipClassUrl."/delete/id/".$Entity->getId(), true, "Delete ".$this->relationshipClassName);
		
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