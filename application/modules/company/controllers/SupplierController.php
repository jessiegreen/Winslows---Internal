<?php
class Company_SupplierController extends Dataservice_Controller_Crud_Action
{    
    public function init()
    {
	$this->_EntityClass = "Entities\Company\Supplier";
	
	parent::init();
    }
}

