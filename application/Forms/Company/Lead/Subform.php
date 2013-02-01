<?php
namespace Forms\Company\Lead;

class Subform extends \Forms\Company\Person\Subform
{    
    private $_Lead;
    
    public function __construct(\Entities\Company\Lead $Lead, $options = null)
    {
	$this->_Lead = $Lead;
	
	parent::__construct($this->_Lead, $options);
    }
    
    public function init($options = array())
    {	
        $this->addElement(new \Dataservice_Form_Element_EmployeeSelect("employee_id", array(
            'required'	    => true,
            'label'	    => 'Employee:',
	    'value'	    => $this->_Lead && $this->_Lead->getEmployee() ? 
				    $this->_Lead->getEmployee()->getId() : 
				    \Services\Company\Website::factory()
					->getCurrentWebsite()
					->getCurrentUserAccount(\Zend_Auth::getInstance())
					->getPerson()
					->getId()
        )));
	
	parent::init($options);
	
	$this->setElementsBelongTo("company_lead");
    }
}