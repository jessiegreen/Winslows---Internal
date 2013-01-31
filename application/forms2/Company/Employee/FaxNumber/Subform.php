<?php
namespace Forms\Company\Employee\FaxNumber;

class Subform extends \Forms\Company\FaxNumber\Subform
{    
    protected $_FaxNumber;
    
    public function __construct(\Entities\Company\Employee\FaxNumber $FaxNumber, $options = null)
    {
	$this->_FaxNumber = $FaxNumber;
	
	parent::__construct($options, $this->_FaxNumber);
    }
    
    public function init($options = array())
    {
	$this->addElement(new \Dataservice_Form_Element_Company_Employee_Select("employee_id", array(
            'required'	    => true,
            'label'	    => 'Employee:',
	    'belongsTo'	    => 'company_employee_fax_number',
	    'value'	    => $this->_FaxNumber && $this->_FaxNumber->getEmployee() ? $this->_FaxNumber->getEmployee()->getId() : ""
        )));
	
	parent::init($options);
    }
}
