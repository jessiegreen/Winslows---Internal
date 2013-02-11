<?php
class Company_SupplierProductSimpleController extends Dataservice_Controller_Company_Supplier_Product_ProductAbstract_Action
{    
    public function init()
    {
	$this->_EntityClass = "Entities\Company\Supplier\Product\Simple";
	
	parent::init();
    }
}

