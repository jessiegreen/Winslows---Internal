<?php
namespace Forms\Company;

class Dealer extends \Dataservice_Form
{    
    private $_Dealer;
    
    public function __construct(\Entities\Company\Dealer $Dealer, $options = null)
    {
	$this->_Dealer = $Dealer;
	
	parent::__construct($options, $this->_Dealer);
    }
    
    public function init($options = array())
    {	
        $form = new Dealer\Subform($this->_Dealer, $options);
	
	$this->addSubForm($form, "company_dealer");
	
	$this->addElement('submit', 'submit', array(
            'ignore'   => true,
        ));
    }
}