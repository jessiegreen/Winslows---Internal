<?php
class Company_ContactLogContactController extends Dataservice_Controller_Crud_Action
{    
    public function init() 
    {
	$this->_EntityClass = "Entities\Company\ContactLog\Contact";
	
	parent::init();
    }
}

