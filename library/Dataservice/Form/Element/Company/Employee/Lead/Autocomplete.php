<?php
namespace Dataservice\Form\Element\Company\Employee\Lead;

class AutoComplete extends \ZendX_JQuery_Form_Element_AutoComplete
{    
    public function __construct($select_js, $spec, $options = null)
    {
	$source = "/employee/get-leads-label-value-json/";
	
	$this->setJQueryParams(
		    array(
			'select' => new \Zend_Json_Expr($select_js),
			'source' => $source
		    )
		);
    
	parent::__construct($spec, $options);
    }
    
    public function init()
    {
	parent::init();
    }
}
