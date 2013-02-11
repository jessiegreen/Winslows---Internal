<?php
class Company_SupplierProductInstanceController extends Dataservice_Controller_Crud_Action
{    
    public function init()
    {
	$this->_EntityClass = "Entities\Company\Supplier\Product\Instance\InstanceAbstract";
	
	parent::init();
    }
}

