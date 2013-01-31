<?php
namespace Forms\Company;

class Dealer extends \Dataservice_Form
{    
    private $_Dealer;
    
    public function __construct($options = null, \Entities\Company\Dealer $Dealer = null)
    {
	$this->_Dealer = $Dealer;
	
	parent::__construct($options, $this->_Dealer);
    }
    
    public function init($options = array())
    {	
        $form = new Dealer\Subform($options, $this->_Dealer);
	
	$this->addSubForm($form, "company_dealer");
	
	$this->addElement('submit', 'submit', array(
            'ignore'   => true,
        ));
    }
}