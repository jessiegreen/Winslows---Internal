<?php
class Company_RtoProviderFeePercentageController extends Dataservice_Controller_Crud_Action
{    
    public function init()
    {
	$this->_EntityClass = "Entities\Company\RtoProvider\Fee\Percentage";
	
	parent::init();
    }
}