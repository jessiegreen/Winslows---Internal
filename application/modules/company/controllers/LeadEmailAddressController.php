<?php
class Company_LeadEmailAddressController extends Dataservice_Controller_Crud_Action
{    
    public function init()
    {
	$this->_EntityClass = "Entities\Company\Lead\EmailAddress";
	
	parent::init();
    }
}

