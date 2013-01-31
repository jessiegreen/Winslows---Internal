<?php
namespace Forms\Company\RtoProvider\Fee\Range;

class Subform extends \Forms\Company\RtoProvider\Fee\Subform
{
    private $_Range;
    
    public function __construct(\Entities\Company\RtoProvider\Fee\Range $Range, $options = null)
    {
	$this->_Range = $Range;
	
	parent::__construct($Range, $options);
    }
}
