<?php
class Company_TimeClockController extends Dataservice_Controller_Crud_Action
{    
    public function init() 
    {
	$this->_EntityClass = "Entities\Company\TimeClock";
	
	parent::init();
    }
}

