<?php
class Company_SupplierProductCategoryController extends Dataservice_Controller_Crud_Action
{    
    public function init()
    {
	$this->_EntityClass = "Entities\Company\Supplier\Product\Category";
	
	parent::init();
    }
}

