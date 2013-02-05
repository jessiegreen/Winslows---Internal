<?php
class Company_LocationController extends Dataservice_Controller_Crud_Action
{    
    public function init()
    {
	$this->_EntityClass = "Entities\Company\Location";
	
	parent::init();
    }
}

