<?php
class Company_ContactLogController extends Dataservice_Controller_Crud_Action
{    
    public function init() 
    {
	$this->_EntityClass = "Entities\Company\ContactLog";
	
	parent::init();
    }
}

