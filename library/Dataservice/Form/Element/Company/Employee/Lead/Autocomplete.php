<?php
namespace Dataservice\Form\Element\Company\Employee\Lead;

class AutoComplete extends \ZendX_JQuery_Form_Element_AutoComplete
{
    protected $_Employee;
    
    public function __construct(\Entities\Company\Employee $Employee, $select_js, $spec, $options = null)
    {
	$this->_Employee = $Employee;
	
	$this->setJQueryParams(
		    array(
			'select' => new \Zend_Json_Expr($select_js),
			'source' => "/employee/get-leads-label-value-json/all/1"
		    )
		);
    
	parent::__construct($spec, $options);
    }
    
    public function init()
    {
	parent::init();
    }
}
