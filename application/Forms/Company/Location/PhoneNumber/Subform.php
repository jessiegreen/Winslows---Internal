<?php
namespace Forms\Company\Location\PhoneNumber;

class Subform extends \Forms\Company\PhoneNumber\Subform
{
    private $_PhoneNumber;
    
    public function __construct(\Entities\Company\Location\PhoneNumber $PhoneNumber, $options = null)
    {
	$this->_PhoneNumber = $PhoneNumber;
	
	parent::__construct($this->_PhoneNumber, $options);
    }
}