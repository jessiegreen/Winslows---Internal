<?php
namespace Forms\Company\RtoProvider\Fee;

class Percentage extends \Dataservice_Form
{
    private $_Percentage;
    
    public function __construct(\Entities\Company\RtoProvider\Fee\Percentage $Percentage, $options = null)
    {
	$this->_Percentage = $Percentage;
	
	parent::__construct($options);
    }
    
    public function init($options = array())
    {	
        $form = new Percentage\Subform($this->_Percentage, $options);
	
	$this->addSubForm($form, "company_rto_provider_fee_percentage");
	
	$this->addElement('submit', 'submit', array(
            'ignore'   => true,
        ));
    }
}