<?php
namespace Dataservice\Html\CRUD;

class Tabs
{
    /**
     * @var string 
     */
    private $Tabs	    = array();
    
    /**
     * @return \Dataservice\Html\CRUD\Tabs
     */
    public static function factory()
    {
	return new Tabs();
    }
    
    /**
     * @param Tabs/Tab $Tab
     */
    public function addTab(Tabs\Tab $Tab)
    {
	$this->Tabs[] = $Tab;
	
	return $this;
    }
    
    /**
     * @param \Dataservice_Doctrine_Entity $Entity
     * @param string $relationshipPropertyName
     * @return \Dataservice\Html\CRUD\Tabs
     */
    public function addRelationshipViewTab(\Dataservice_Doctrine_Entity $Entity, $relationshipPropertyName)
    {
	$this->addTab(Tabs\Tab::factory($relationshipPropertyName)
		->addRelationshipView($Entity, $relationshipPropertyName));
	
	return $this;
    }
    
    /**
     * @param string $label
     * @param \Dataservice_Doctrine_Entity $Entity
     * @return \Dataservice\Html\CRUD\Tabs
     */
    public function addEntityViewTab($label, \Dataservice_Doctrine_Entity $Entity)
    {
	$this->addTab(Tabs\Tab::factory($label)->addEntityView(EntityView::factory($Entity)));
	
	return $this;
    }
    
    /**
     * @return string
     */
    public function getHtml()
    {
	$html = "<ul>";
	/* @var $Tab \Dataservice\Html\CRUD\Tabs\Tab */
	foreach ($this->Tabs as $Tab)
	{
	    $html .= $Tab->getTabHtml();
	}
	
	$html .= "</ul>";
	
	/* @var $Tab \Dataservice\Html\CRUD\Tabs\Tab */
	foreach ($this->Tabs as $Tab)
	{
	    $html .= $Tab->getBodyHtml();
	}
	
	return $html;
    }
    
    public function getJS()
    {
	return "<script>
	    $(function() {
		$( \"#tabs\" ).tabs({
		    select: function(event, ui) {                   
			window.location.hash = ui.tab.hash;
		    }
		}).addClass( \"ui-tabs-vertical ui-helper-clearfix\" );
		$( \"#tabs li\" ).removeClass( \"ui-corner-top\" ).addClass( \"ui-corner-left\" );
	    });
	</script>";
    }
    
    public function render()
    {
	echo $this->getHtml();
    }
}