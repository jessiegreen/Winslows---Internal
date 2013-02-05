<?php
class Company_WebsiteRoleController extends Dataservice_Controller_Crud_Action
{    
    public function init() 
    {
	$this->_EntityClass = "Entities\Company\Website\Role";
	
	parent::init();
    }
}