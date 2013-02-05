<?php
class Company_TimeClockEntryController extends Dataservice_Controller_Crud_Action
{    
    public function init() 
    {
	$this->_EntityClass = "Entities\Company\TimeClock\Entry";
	
	parent::init();
    }
}

