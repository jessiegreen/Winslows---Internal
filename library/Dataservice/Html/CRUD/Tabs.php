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
     * @param Dataservice_View_Helper_CRUD_Tab $Tab
     */
    public function addTab(Tab $Tab)
    {
	$this->Tabs[$Tab->getNameIndex()] = $Tab;
    }
}