<?php
namespace Forms\Company\Supplier\Product\Purpose;

class Subform extends \Zend_Form_SubForm
{
    private $_Purpose;
    
    public function __construct(\Entities\Company\Supplier\Product\Purpose $Purpose = null, $options = null)
    {
	$this->_Purpose = $Purpose;
	
	parent::__construct($options);
    }
    
    public function init()
    {
	$this->addElement(new \Dataservice_Form_Element_Company_Supplier_ProductRadio("product_id", array(
            'required'	    => false,
            'label'	    => 'Product:',
	    'belongsTo'	    => 'company_supplier_product_purpose',
	    'value'	    => $this->_Purpose && $this->_Purpose->getProduct() ? 
				$this->_Purpose->getProduct()->getId() : 
				""
        )));
	
	$this->addElement('text', 'name', array(
            'required'	    => true,
            'label'	    => 'Name:',
	    'belongsTo'	    => 'company_supplier_product_purpose',
	    'value'	    => $this->_Purpose ? $this->_Purpose->getName() : ""
        ));
    }
}