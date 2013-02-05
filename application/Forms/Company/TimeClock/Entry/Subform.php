<?php
namespace Forms\Company\TimeClock\Entry;

class Subform extends \Zend_Form_SubForm
{
    private $_Entry;
    
    public function __construct(\Entities\Company\TimeClock\Entry $Entry, $options = null)
    {
	$this->_Entry = $Entry;
	
	parent::__construct($options);
    }
    
    public function init()
    {		
	$this->addElement(new \Dataservice_Form_Element_EmployeeSelect("employee_id", array(
            'required'	    => true,
            'label'	    => 'Employee:',
	    'value'	    => $this->_Entry && $this->_Entry->getEmployee() ? $this->_Entry->getEmployee()->getId() : ""
        )));
	
	$this->addElement('text', 'date_time_value', array(
            'required'	    => true,
            'label'	    => 'Date/Time:',
	    'value'	    => $this->_Entry->getDateTime() ? $this->_Entry->getDateTime()->format("Y-m-d H:i:s") : ""
        ));
	
	$this->addElement('text', 'ip_address', array(
            'required'	    => true,
            'label'	    => 'IP Address:',
	    'value'	    => $this->_Entry ? $this->_Entry->getIpAddress() : ""
        ));	
	
	$this->setElementsBelongTo("company_time_clock_entry");
    }
}