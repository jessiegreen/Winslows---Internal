<?php
class Company_RtoProviderFeeRangeValueController extends Dataservice_Controller_Crud_Action
{    
    public function init() 
    {
	$this->_EntityClass = "Entities\Company\RtoProvider\Fee\Range\Value";
	
	parent::init();
    }
}

