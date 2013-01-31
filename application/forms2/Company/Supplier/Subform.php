<?php
namespace Forms\Company\Supplier;

class Subform extends \Zend_Form_SubForm
{
    private $_Supplier;
    
    public function __construct($options = null, \Entities\Company\Supplier $Supplier = null)
    {
	$this->_Supplier = $Supplier;
	
	parent::__construct($options);
    }
    
    public function init()
    {		
	$this->addElement('text', 'name', array(
            'required'	    => true,
            'label'	    => 'Name:',
	    'belongsTo'	    => 'supplier',
	    'value'	    => $this->_Supplier ? $this->_Supplier->getName() : ""
        ));
    }
}