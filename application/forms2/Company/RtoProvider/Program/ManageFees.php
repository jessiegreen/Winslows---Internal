<?php
namespace Forms\Company\RtoProvider\Program;

class ManageFees extends \Dataservice_Form
{
    private $_Program;
    
    public function __construct(\Entities\Company\RtoProvider\Program $Program, $options = null)
    {
	$this->_Program = $Program;
	
	parent::__construct($options);
    }
    
    public function init($options = array())
    {	
        $form = new ManageFees\Subform($this->_Program, $options);
	
	$this->addSubForm($form, "company_rto_provider_program_managefees");
	
	$this->addElement('submit', 'submit', array(
            'ignore'   => true,
        ));
    }
}