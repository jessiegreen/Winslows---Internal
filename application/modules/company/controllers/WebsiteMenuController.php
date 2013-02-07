<?php
class Company_WebsiteMenuController extends Dataservice_Controller_Crud_Action
{    
    public function init()
    {
	$this->_EntityClass = "Entities\Company\Website\Menu";
	
	parent::init();
    }
}

