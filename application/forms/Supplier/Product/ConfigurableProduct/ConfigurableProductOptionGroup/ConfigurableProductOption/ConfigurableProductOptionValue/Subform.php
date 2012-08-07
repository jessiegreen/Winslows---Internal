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
class Form_ConfigurableProductOptionValue_Subform extends Zend_Form_SubForm
{
    private $_ConfigurableProductOptionValue;
    
    public function __construct($options = null, \Entities\ConfigurableProductOptionValue $ConfigurableProductOptionValue = null) {
	$this->_ConfigurableProductOptionValue = $ConfigurableProductOptionValue;
	parent::__construct($options);
    }
    
    public function init()
    {
	$this->addElement(new Dataservice_Form_Element_ConfigurableProductOptionSelect("configurableproductoption_id", array(
            'required'	    => false,
            'label'	    => 'Option:',
	    'belongsTo'	    => 'configurableproductoptionvalue',
	    'value'	    => $this->_ConfigurableProductOptionValue && 
				    $this->_ConfigurableProductOptionValue->getConfigurableProductOption()
				? $this->_ConfigurableProductOptionValue->getConfigurableProductOption()->getId() 
				: ""
        )));
	
	$this->addElement('text', 'name', array(
            'required'	    => true,
            'label'	    => 'Name:',
	    'belongsTo'	    => 'configurableproductoptionvalue',
	    'value'	    => $this->_ConfigurableProductOptionValue ? $this->_ConfigurableProductOptionValue->getName() : ""
        ));
	
	$this->addElement('text', 'index_string', array(
            'required'	    => true,
            'label'	    => 'Name Index:',
	    'belongsTo'	    => 'configurableproductoptionvalue',
	    'value'	    => $this->_ConfigurableProductOptionValue ? $this->_ConfigurableProductOptionValue->getIndex() : ""
        ));
	
	$this->addElement('text', 'code', array(
            'required'	    => true,
            'label'	    => 'Code:',
	    'belongsTo'	    => 'configurableproductoptionvalue',
	    'value'	    => $this->_ConfigurableProductOptionValue ? $this->_ConfigurableProductOptionValue->getCode() : ""
        ));
	
	$this->addElement('textarea', 'description', array(
            'required'	    => false,
            'label'	    => 'Description:',
	    'cols'	    => 50,
	    'rows'	    => 8,
	    'belongsTo'	    => 'configurableproductoptionvalue',
	    'value'	    => $this->_ConfigurableProductOptionValue ? $this->_ConfigurableProductOptionValue->getDescription() : ""
        ));
    }
}

?>
