<?php
class Company_WebsiteController extends Dataservice_Controller_Crud_Action
{    
    public function init()
    {
	$this->view->headScript()->appendFile("/javascript/company/website.js");
	
	$this->_EntityClass = "Entities\Company\Website";
	
	parent::init();
    }
}

