<?php
namespace Forms\Company\Supplier\Product\Configurable;

class Instance extends \Dataservice_Form
{
    private $_Instance;
    
    public function __construct(\Entities\Company\Supplier\Product\Configurable\Instance $Instance, $options = null)
    {
	$this->_Instance = $Instance;
	
	parent::__construct($options);
    }
    
    public function init($options = array())
    {	
        $form = new Instance\Subform($this->_Instance, $options);
	
	$this->addSubForm($form, "company_supplier_product_configurable_instance");
	
	$this->addElement('submit', 'submit', array(
            'ignore'   => true,
        ));
    }
}