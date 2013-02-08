<?php
namespace Forms\Company\Lead\Quote;

class SalesTypes extends \Dataservice_Form
{    
    /* @var $Quote \Entities\Company\Lead\Quote */
    private $Quote;
    
    public function __construct(\Entities\Company\Lead\Quote $Quote, $options = null)
    {
	$this->Quote = $Quote;
	
	parent::__construct($options);	
    }
    
    public function init($options = array())
    {
	$form = new SalesTypes\Subform($this->Quote, $options);
	
	$this->addSubForm($form, "company_lead_quote_salestypes");

        $this->addElement('submit', 'submit', array(
            'ignore'   => true,
        ));
    }
}