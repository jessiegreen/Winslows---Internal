<?php
namespace Forms\Company\RtoProvider;

class Program extends \Dataservice_Form
{
    private $_Program;
    
    public function __construct(\Entities\Company\RtoProvider\Program $Program, $options = null)
    {
	$this->_Program = $Program;
	
	parent::__construct($options);
    }
    
    public function init($options = array())
    {	
        $form = new Program\Subform($this->_Program, $options);
	
	$this->addSubForm($form, "company_rto_provider_program");
	
	$this->addElement('submit', 'submit', array(
            'ignore'   => true,
        ));
    }
}