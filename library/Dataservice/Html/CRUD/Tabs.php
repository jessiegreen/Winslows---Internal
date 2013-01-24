<?php
namespace Dataservice\Html\CRUD;

class Tabs
{
    /**
     * @var string 
     */
    private $Tabs	    = array();
    
    /**
     * @var array 
     */
    private $permissions    = array("add" => array("Admin"), "edit" => array("Admin"), "delete" => array("Admin"));
    
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
     * @param string $label
     * @param \Dataservice_Doctrine_Entity $Entity
     * @param string $collection_name
     * @return \Dataservice\Html\CRUD\Tabs
     */
    public function addCollectionListTab($label, \Dataservice_Doctrine_Entity $Entity, $collection_name)
    {
	$this->addTab(Tabs\Tab::factory($label)->addCollectionList(CollectionList::factory($Entity, $collection_name)));
	
	return $this;
    }
    
    /**
     * @param array $params array(array($label, \Dataservice_Doctrine_Entity $Entity, $collection_name))
     */
    public function addCollectionListTabs($params)
    {
	foreach ($params as $value)
	{
	    $this->addCollectionListTab($value[0], $value[1], $value[2]);
	}
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