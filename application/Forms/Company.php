<?php
namespace Forms;

class Company extends \Dataservice_Form
{    
    private $_Company;
    
    public function __construct(\Entities\Company $Company, $options = null)
    {
	$this->_Company = $Company;
	
	parent::__construct($options, $this->_Company);
    }
    
    public function init($options = array())
    {	
        $form = new Company\Subform($this->_Company, $options);
	
	$this->addSubForm($form, "company");
	
	$this->addElement('submit', 'submit', array(
            'ignore'   => true,
        ));
    }
}