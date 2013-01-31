<?php
namespace Forms\Company\RtoProvider\Fee;

class Range extends \Dataservice_Form
{
    private $_Range;
    
    public function __construct(\Entities\Company\RtoProvider\Fee\Range $Range, $options = null)
    {
	$this->_Range = $Range;
	
	parent::__construct($options);
    }
    
    public function init($options = array())
    {	
        $form = new Range\Subform($this->_Range, $options);
	
	$this->addSubForm($form, "company_rto_provider_fee_range");
	
	$this->addElement('submit', 'submit', array(
            'ignore'   => true,
        ));
    }
}