<?php
namespace Forms\Company\Supplier\Product\Configurable\Instance;

class Subform extends \Forms\Company\Supplier\Product\Instance\InstanceAbstract\Subform
{
    private $_Instance;
    
    public function __construct(\Entities\Company\Supplier\Product\Configurable\Instance $Instance, $options = null)
    {
	$this->_Instance = $Instance;
	
	parent::__construct($Instance, $options);
    }
    
    public function init()
    {	
	parent::init();
	
	$this->setElementsBelongTo("company_supplier_product_configurable_instance");
    }
}