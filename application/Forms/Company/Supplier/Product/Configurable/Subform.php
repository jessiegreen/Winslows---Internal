<?php
namespace Forms\Company\Supplier\Product\Configurable;

use Entities\Company\Supplier\Product\Configurable as Configurable;

class Subform extends \Forms\Company\Supplier\Product\Subform
{    
    private $_Configurable;
    
    public function __construct(Configurable $Configurable, $options = null) 
    {
	$this->_Configurable = $Configurable;
	
	parent::__construct($options, $this->_Configurable);
    }
    
    public function init($options = array())
    {
	$this->addElement('text', 'class_name', array(
            'required'	    => true,
            'label'	    => 'Class Name:',
	    'value'	    => $this->_Configurable ? $this->_Configurable->getClassName() : ""
        ));

	parent::init($options);
	
	$this->setElementsBelongTo("company_supplier_product_configurable");
    }
}