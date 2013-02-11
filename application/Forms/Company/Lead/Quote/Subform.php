<?php
namespace Forms\Company\Lead\Quote;

class Subform extends QuoteAbstract\Subform
{
    private $_Quote; 
    
    public function __construct(\Entities\Company\Lead\Quote $Quote, $options = null) 
    {
	$this->_Quote = $Quote;
	
	parent::__construct($this->_Quote, $options);
    }
    
    public function init() 
    {
	$this->addElement(new \Dataservice_Form_Element_LeadSelect("lead_id", array(
            'required'	    => true,
            'label'	    => 'Lead:',
	    'belongsTo'	    => 'quote',
	    'value'	    => $this->_Quote && 
				    $this->_Quote->getLead()
				? $this->_Quote->getLead()->getId() 
				: ""
        )));
	
	parent::init();
    }
}