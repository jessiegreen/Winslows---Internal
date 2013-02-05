<?php
namespace Forms\Company\TimeClock;

class Entry extends \Dataservice_Form
{    
    private $_Entry;
    
    public function __construct(\Entities\Company\TimeClock\Entry $Entry, $options = null) 
    {
	$this->_Entry = $Entry;
	
	parent::__construct($options);
    }
    
    public function init($options = array())
    {
	$form = new Entry\Subform($this->_Entry, $options);
	
	$this->addSubForm($form, "company_time_clock_entry");

        $this->addElement('submit', 'submit', array(
            'ignore'   => true,
        ));
    }
}