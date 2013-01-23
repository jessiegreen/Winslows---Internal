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
     * @param Tabs/Tab $Tab
     */
    public function addTab(Tabs\Tab $Tab)
    {
	$this->Tabs[] = $Tab;
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
	
	$html .= "<ul>";
	
	/* @var $Tab \Dataservice\Html\CRUD\Tabs\Tab */
	foreach ($this->Tabs as $Tab)
	{
	    $html .= $Tab->getBodyHtml();
	}
	
	return $html;
    }
    
    public function render()
    {
	echo $this->getHtml();
    }
}