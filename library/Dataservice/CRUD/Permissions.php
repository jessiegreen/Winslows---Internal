<?php
namespace Dataservice\CRUD;

class Permissions
{
    /**
     * @var array 
     */
    private $permissions    = array("add" => array(""), "edit" => array(""), "delete" => array(""));
    
    /**
     * @return \Dataservice_View_Helper_CRUD_Tabs
     */
    public function CRUD_Tabs()
    {
	return $this;
    }
    
    /**
     * @param Dataservice_View_Helper_CRUD_Tab $Tab
     */
    public function addTab(Dataservice_View_Helper_CRUD_Tab $Tab)
    {
	$this->Tabs[$Tab->getNameIndex()] = $Tab;
    }
}