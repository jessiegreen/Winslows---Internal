<?php
namespace Forms\Company\Lead\Quote\QuoteAbstract;

use Entities\Company\Lead\Quote\QuoteAbstract as QuoteAbstract;

class Subform extends \Zend_Form_SubForm
{
    private $_QuoteAbstract;
    
    public function __construct($options = null, QuoteAbstract $QuoteAbstract = null) 
    {
	$this->_QuoteAbstract = $QuoteAbstract;
	
	parent::__construct($options);
    }
}