<?php
namespace Forms\Company\Supplier;

class Subform extends \Zend_Form_SubForm
{
    private $_Supplier;
    
    public function __construct(\Entities\Company\Supplier $Supplier, $options = null)
    {
	$this->_Supplier = $Supplier;
	
	parent::__construct($options);
    }
    
    public function init()
    {		
	$this->addElement('text', 'name', array(
            'required'	    => true,
            'label'	    => 'Name:',
	    'value'	    => $this->_Supplier ? $this->_Supplier->getName() : ""
        ));
	
	
	$this->setElementsBelongTo("company_supplier");
    }
}