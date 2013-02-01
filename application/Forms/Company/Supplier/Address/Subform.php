<?php
namespace Forms\Company\Supplier\Address;

class Subform extends \Forms\Company\Address\Subform
{    
    private $_Address;
    
    public function __construct(Entities\Company\Supplier\Address $Address, $options = null)
    {
	$this->_Address = $Address;
	
	parent::__construct($this->_Address, $options);
    }
    
    public function init($options = array())
    {
	parent::init($options);
	
	$this->setElementsBelongTo("company_supplier_address");
    }
}