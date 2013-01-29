<?php
namespace Forms\Company\Supplier\Address;

class Subform extends \Forms\Company\Address\Subform
{    
    private $_Address;
    
    public function __construct($options = null, Entities\Company\Supplier\Address $Address = null)
    {
	$this->_Address = $Address;
	
	parent::__construct($options, $this->_Address);
    }
    
    public function init($options = array())
    {
	parent::init($options);
    }
}