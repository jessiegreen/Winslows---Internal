<?php
namespace Forms\Company;

class Website extends \Zend_Form
{    
    private $_Website;
    
    public function __construct(\Entities\Company\Website $Website, $options = null)
    {
	$this->_Website = $Website;
	
	parent::__construct($options, $this->_Website);
    }
    
    public function init($options = array())
    {	
        $form = new \Forms\Company\Website\Subform($this->_Website, $options);
	
	$this->addSubForm($form, "company_website");
	
	$this->addElement('submit', 'submit', array(
            'ignore'   => true,
        ));
    }
}