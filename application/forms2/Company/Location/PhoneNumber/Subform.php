<?php
namespace Forms\Company\Location\PhoneNumber;

class Subform extends \Forms\Company\PhoneNumber\Subform
{
    private $_PhoneNumber;
    
    public function __construct($options = null, \Entities\Company\Location\PhoneNumber $PhoneNumber = null)
    {
	$this->_PhoneNumber = $PhoneNumber;
	parent::__construct($options, $this->_PhoneNumber);
    }
}