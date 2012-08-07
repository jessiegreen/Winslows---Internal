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
class Form_ConfigurableProductOptionGroup_Subform extends Zend_Form_SubForm
{
    private $_ConfigurableProductOptionGroup;
    
    public function __construct($options = null, \Entities\ConfigurableProductOptionGroup $ConfigurableProductOptionGroup = null) {
	$this->_ConfigurableProductOptionGroup = $ConfigurableProductOptionGroup;
	parent::__construct($options);
    }
    
    public function init()
    {
	$this->addElement('text', 'name', array(
            'required'	    => true,
            'label'	    => 'Name:',
	    'belongsTo'	    => 'configurableproductoptiongroup',
	    'value'	    => $this->_ConfigurableProductOptionGroup ? $this->_ConfigurableProductOptionGroup->getName() : ""
        ));
	
	$this->addElement('text', 'index_string', array(
            'required'	    => true,
            'label'	    => 'Name Index:',
	    'belongsTo'	    => 'configurableproductoptiongroup',
	    'value'	    => $this->_ConfigurableProductOptionGroup ? $this->_ConfigurableProductOptionGroup->getIndex() : ""
        ));
	
	$this->addElement('text', 'code', array(
            'required'	    => true,
	    'maxlength'	    => 2,
	    'size'	    => 2,
            'label'	    => 'Code:',
	    'belongsTo'	    => 'configurableproductoptiongroup',
	    'value'	    => $this->_ConfigurableProductOptionGroup ? $this->_ConfigurableProductOptionGroup->getCode() : ""
        ));
	
	$this->addElement('textarea', 'description', array(
            'required'	    => false,
            'label'	    => 'Description:',
	    'cols'	    => 50,
	    'rows'	    => 8,
	    'belongsTo'	    => 'configurableproductoptiongroup',
	    'value'	    => $this->_ConfigurableProductOptionGroup ? $this->_ConfigurableProductOptionGroup->getDescription() : ""
        ));
    }
}

?>
