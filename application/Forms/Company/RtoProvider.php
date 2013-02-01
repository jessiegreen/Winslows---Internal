<?php
namespace Forms\Company;

class RtoProvider extends \Dataservice_Form
{    
    private $_RtoProvider;
    
    public function __construct(\Entities\Company\RtoProvider $RtoProvider, $options = null)
    {
	$this->_RtoProvider = $RtoProvider;
	
	parent::__construct($options, $this->_RtoProvider);
    }
    
    public function init($options = array())
    {	
        $form = new RtoProvider\Subform($this->_RtoProvider, $options);
	
	$this->addSubForm($form, "company_rto_provider");
	
	$this->addElement('submit', 'submit', array(
            'ignore'   => true,
        ));
    }
}