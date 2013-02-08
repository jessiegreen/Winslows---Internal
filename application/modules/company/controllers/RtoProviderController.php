<?php
class Company_RtoProviderController extends Dataservice_Controller_Crud_Action
{    
    public function init()
    {
	$this->_EntityClass = "Entities\Company\RtoProvider";
	
	parent::init();
    }
}

