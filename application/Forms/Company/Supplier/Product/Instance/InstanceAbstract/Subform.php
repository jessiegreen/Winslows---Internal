<?php
namespace Forms\Company\Supplier\Product\Instance\InstanceAbstract;

class Subform extends \Zend_Form_SubForm
{
    private $_Instance;
    
    public function __construct(\Entities\Company\Supplier\Product\Instance\InstanceAbstract $Instance = null, $options = null)
    {
	$this->_Instance = $Instance;
	
	parent::__construct($options);
    }
    
    public function init()
    {
	$this->addElement('textarea', 'note', array(
            'required'	    => true,
	    'cols'	    => 55,
	    'rows'	    => 8,
	    'value'	    => $this->_Instance ? $this->_Instance->getNote() : ""
        ));
	
	parent::init();
	
	$this->setElementsBelongTo("company_supplier_product_instance_instance_abstract");
    }
}