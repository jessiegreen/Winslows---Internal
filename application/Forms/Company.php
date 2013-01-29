<?php
namespace Forms;

class Company extends \Dataservice_Form
{    
    private $_Company;
    
    public function __construct($options = null, \Entities\Company $Company = null)
    {
	$this->_Company = $Company;
	
	parent::__construct($options, $this->_Company);
    }
    
    public function init($options = array())
    {	
        $form = new Company\Subform($options, $this->_Company);
	
	$this->addSubForm($form, "company");
	
	$this->addElement('submit', 'submit', array(
            'ignore'   => true,
        ));
    }
}