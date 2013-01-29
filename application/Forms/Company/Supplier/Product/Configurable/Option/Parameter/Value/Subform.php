<?php
namespace Forms\Company\Supplier\Product\Configurable\Option\Parameter\Value;

use Entities\Company\Supplier\Product\Configurable\Option\Parameter\Value as Value;

class Subform extends \Zend_Form_SubForm
{
    private $_Value;
    
    public function __construct($options = null, Value $Value = null)
    {
	$this->_Value = $Value;
	
	parent::__construct($options);
    }
    
    public function init()
    {
	$this->addElement(new \Dataservice_Form_Element_ParameterSelect("parameter_id", array(
            'required'	    => false,
            'label'	    => 'Option:',
	    'belongsTo'	    => 'configurableproductoptionparametervalue',
	    'value'	    => $this->_Value && 
				    $this->_Value->getParameter()
				? $this->_Value->getParameter()->getId() 
				: ""
        )));
	
	$this->addElement('text', 'name', array(
            'required'	    => true,
            'label'	    => 'Name:',
	    'belongsTo'	    => 'configurableproductoptionparametervalue',
	    'value'	    => $this->_Value ? $this->_Value->getName() : ""
        ));
	
	$this->addElement('text', 'index_string', array(
            'required'	    => true,
            'label'	    => 'Name Index:',
	    'belongsTo'	    => 'configurableproductoptionparametervalue',
	    'value'	    => $this->_Value ? $this->_Value->getIndex() : ""
        ));
	
	$this->addElement('text', 'code', array(
            'required'	    => true,
            'label'	    => 'Code:',
	    'belongsTo'	    => 'configurableproductoptionparametervalue',
	    'value'	    => $this->_Value ? $this->_Value->getCode() : ""
        ));
	
	$this->addElement('text', 'sort_order', array(
            'required'	    => false,
            'label'	    => 'Order:',
	    'belongsTo'	    => 'configurableproductoptionparametervalue',
	    'value'	    => $this->_Value ? $this->_Value->getOrder() : ""
        ));
	
	$this->addElement('textarea', 'description', array(
            'required'	    => false,
            'label'	    => 'Description:',
	    'cols'	    => 50,
	    'rows'	    => 8,
	    'belongsTo'	    => 'configurableproductoptionparametervalue',
	    'value'	    => $this->_Value ? $this->_Value->getDescription() : ""
        ));
    }
}