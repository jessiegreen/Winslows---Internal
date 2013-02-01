<?php
namespace Forms\Company;

class Lead extends \Dataservice_Form
{    
    private $_Lead;
    
    public function __construct(\Entities\Company\Lead $Lead, $options = null)
    {
	$this->_Lead = $Lead;
	
	parent::__construct($options);
    }
    
    public function init($options = array())
    {
	$form = new Lead\Subform($this->_Lead, $options);
	
	$this->addSubForm($form, "company_lead");
	
	$this->addElement('submit', 'submit', array(
            'ignore'   => true,
        ));
    }
}