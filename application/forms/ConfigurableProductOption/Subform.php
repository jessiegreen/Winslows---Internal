<?php

/**
 * Name:
 * Location:
 *
 * Description for class (if any)...
 *
 * @author     Jessie Green <jessie.winslows@gmail.com>
 * @copyright  2012 Winslows inc.
 * @version    Release: @package_version@
 */
class Form_ConfigurableProductOption_Subform extends Zend_Form_SubForm
{
    private $_ConfigurableProductOption;
    
    public function __construct($options = null, \Entities\ConfigurableProductOption $ConfigurableProductOption = null) {
	$this->_ConfigurableProductOption = $ConfigurableProductOption;
	parent::__construct($options);
    }
    
    public function init()
    {
	$this->addElement(new Dataservice_Form_Element_ConfigurableProductOptionGroupSelect("configurableproductoptiongroup_id", array(
            'required'	    => false,
            'label'	    => 'Option Group:',
	    'belongsTo'	    => 'configurableproductoption',
	    'value'	    => $this->_ConfigurableProductOption && 
				    $this->_ConfigurableProductOption->getConfigurableProductOptionGroup()
				? $this->_ConfigurableProductOption->getConfigurableProductOptionGroup()->getId() 
				: ""
        )));
	
	$this->addElement('text', 'name', array(
            'required'	    => true,
            'label'	    => 'Name:',
	    'belongsTo'	    => 'configurableproductoption',
	    'value'	    => $this->_ConfigurableProductOption ? $this->_ConfigurableProductOption->getName() : ""
        ));
	
	$this->addElement('text', 'index_string', array(
            'required'	    => true,
            'label'	    => 'Name Index:',
	    'belongsTo'	    => 'configurableproductoption',
	    'value'	    => $this->_ConfigurableProductOption ? $this->_ConfigurableProductOption->getIndex() : ""
        ));
	
	$this->addElement('text', 'length', array(
            'required'	    => true,
            'label'	    => 'Length:',
	    'size'	    => 2,
	    'maxlength'	    => 2,
	    'belongsTo'	    => 'configurableproductoption',
	    'value'	    => $this->_ConfigurableProductOption ? $this->_ConfigurableProductOption->getLength() : ""
        ));
	
	$this->addElement('textarea', 'description', array(
            'required'	    => false,
            'label'	    => 'Description:',
	    'cols'	    => 50,
	    'rows'	    => 8,
	    'belongsTo'	    => 'configurableproductoption',
	    'value'	    => $this->_ConfigurableProductOption ? $this->_ConfigurableProductOption->getDescription() : ""
        ));
	
	$this->addElement('select', 'required', array(
            'required'	    => true,
            'label'	    => 'Required:',
	    'belongsTo'	    => 'configurableproductoption',
	    'multioptions'  => array(false, true),
	    'value'	    => $this->_ConfigurableProductOption ? $this->_ConfigurableProductOption->isRequired() : ""
        ));
    }
}

?>
