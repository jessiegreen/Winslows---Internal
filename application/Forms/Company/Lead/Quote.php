<?php
namespace Forms\Company\Lead;

class Quote extends \Dataservice_Form
{    
    private $_Quote;
    
    public function __construct(\Entities\Company\Lead\Quote $Quote, $options = null)
    {
	$this->_Quote = $Quote;
	
	parent::__construct($options, $this->_Quote);
    }
    
    public function init($options = array())
    {	
        $form = new Quote\Subform($this->_Quote, $options);
	
	$this->addSubForm($form, "company_lead_quote");
	
	$this->addElement('submit', 'submit', array(
            'ignore'   => true,
        ));
    }
}