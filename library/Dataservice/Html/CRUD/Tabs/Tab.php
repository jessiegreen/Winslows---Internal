<?php
namespace Dataservice\Html\CRUD\Tabs;

class Tab
{
    /**
     * @var string 
     */
    private $name	    = "";
    
    /**
     * @var string 
     */
    private $header_html    = "";
    
    /**
     * @var string 
     */
    private $content_html    = "";
    
    public function __construct($name)
    {
	$this->name = $name;
    }
    
    /**
     * @param string $name
     * @return \Dataservice\Html\CRUD\Tabs\Tab
     */
    public static function factory($name)
    {
	return new Tab($name);
    }
    
    public function addContent($html)
    {
	$this->content_html .= $html;
	
	return $this;
    }
    
    public function addCollectionList(\Dataservice\Html\CRUD\CollectionList $List)
    {
	$this->content_html .= $List->getHtml();
	
	return $this;
    }
    
    public function addEntityView(\Dataservice\Html\CRUD\EntityView $View)
    {
	$this->content_html .= $View->getHtml();
	
	return $this;
    }
    
    /**
     * @param \Dataservice_Doctrine_Entity $Entity
     * @param string $relationshipPropertyName
     * @return \Dataservice\Html\CRUD\Tabs\Tab
     */
    public function addRelationshipView(\Dataservice_Doctrine_Entity $Entity, $relationshipPropertyName)
    {
	$this->content_html .= \Dataservice\Html\CRUD\Content\Relationship\View::factory($Entity, $relationshipPropertyName)->getHTML();
	
	return $this;
    }
    
    /**
     * @param array $lists
     */
    public function addCollectionLists($lists)
    {
	foreach($lists as $List)
	    $this->addCollectionList($List);
	
	return $this;
    }
    
    public function getTabHtml()
    {
	return '<li><a href="#'.str_ireplace(" ", "_", $this->name).'">'.$this->name.'</a></li>';
	
	return $this;
    }
    
    public function getBodyHtml()
    {
	$html = '<div id="'.str_ireplace(" ", "_", $this->name).'">';
	$html .= $this->content_html;
	$html .= '</div>';
	
	return $html;
	
	return $this;
    }
}