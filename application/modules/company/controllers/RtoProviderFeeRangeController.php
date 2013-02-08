<?php
class Company_RtoProviderFeeRangeController extends Dataservice_Controller_Crud_Action
{    
    public function init()
    {
	$this->_EntityClass = "Entities\Company\RtoProvider\Fee\Range";
	
	parent::init();
    }
}

