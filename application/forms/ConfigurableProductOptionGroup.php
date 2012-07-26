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
class Form_ConfigurableProductOptionGroup extends Zend_Form
{    
    private $_ConfigurableProductOptionGroup;
    
    public function __construct($options = null, Entities\ConfigurableProductOptionGroup $ConfigurableProductOptionGroup = null)
    {
	$this->_ConfigurableProductOptionGroup = $ConfigurableProductOptionGroup;
	parent::__construct($options, $this->_ConfigurableProductOptionGroup);
    }
    
    public function init($options = array())
    {	
        $form = new Form_ConfigurableProductOptionGroup_Subform($options, $this->_ConfigurableProductOptionGroup);
	
	$this->addSubForm($form, "configurableproductoptiongroup");
	
	$this->addElement('submit', 'submit', array(
            'ignore'   => true,
        ));
    }
}

?>
