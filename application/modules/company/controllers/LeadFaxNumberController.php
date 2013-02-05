<?php
class Company_LeadFaxNumberController extends Dataservice_Controller_Crud_Action
{    
    public function init()
    {
	$this->_EntityClass = "Entities\Company\Lead\FaxNumber";
	
	parent::init();
    }
}

