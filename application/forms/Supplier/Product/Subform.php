<?php

/**
 * Name:
 * Product:
 *
 * Description for class (if any)...
 *
 * @author     Jessie Green <jessie.winslows@gmail.com>
 * @copyright  2012 Winslows inc.
 * @version    Release: @package_version@
 */
class Form_Product_Subform extends Zend_Form_SubForm
{
    private $_Product;
    
    public function __construct($options = null, \Entities\Product $Product = null)
    {
	$this->_Product = $Product;
	parent::__construct($options);
    }
    
    public function init()
    {	
	$this->addElement(new Dataservice_Form_Element_SupplierSelect("supplier_id", array(
            'required'	    => true,
            'label'	    => 'Supplier:',
	    'belongsTo'	    => 'product',
	    'value'	    => $this->_Product && $this->_Product->getSupplier() ? 
				$this->_Product->getSupplier()->getId() : 
				""
        )));
	
	$this->addElement('text', 'name', array(
            'required'	    => true,
            'label'	    => 'Name:',
	    'belongsTo'	    => 'product',
	    'value'	    => $this->_Product ? $this->_Product->getName() : ""
        ));
	
	$this->addElement('text', 'part_number', array(
            'required'	    => true,
            'label'	    => 'Part #:',
	    'belongsTo'	    => 'product',
	    'value'	    => $this->_Product ? $this->_Product->getPartNumber() : ""
        ));
	
	$this->addElement('textarea', 'description', array(
            'required'	    => false,
            'label'	    => 'Description:',
	    'belongsTo'	    => 'product',
	    'rows'	    => '10',
	    'cols'	    => '35',
	    'value'	    => $this->_Product ? $this->_Product->getDescription() : ""
        ));
    }
}

?>
