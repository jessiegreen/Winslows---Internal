<?php
class Company_SupplierProductPurposeController extends Dataservice_Controller_Crud_Action
{    
    public function init()
    {
	$this->_EntityClass = "Entities\Company\Supplier\Product\Purpose";
	
	parent::init();
    }
}

