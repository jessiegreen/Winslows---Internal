<?php
class Company_LocationFaxNumberController extends Dataservice_Controller_Crud_Action
{    
    public function init()
    {
	$this->_EntityClass = "Entities\Company\Location\FaxNumber";
	
	parent::init();
    }
}

