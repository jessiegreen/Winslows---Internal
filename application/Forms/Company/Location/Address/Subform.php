<?php
namespace Forms\Company\Location\Address;

class Subform extends \Forms\Company\Address\Subform
{    
    private $_Address;
    
    public function __construct(\Entities\Company\Location\Address $Address, $options = null)
    {
	$this->_Address = $Address;
	
	parent::__construct($options, $this->_Address);
    }
    
    public function init($options = array())
    {
	parent::init($options);
    }
}