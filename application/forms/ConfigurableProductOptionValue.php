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
class Form_ConfigurableProductOptionValue extends Zend_Form
{    
    private $_ConfigurableProductOptionValue;
    
    public function __construct($options = null, Entities\ConfigurableProductOptionValue $ConfigurableProductOptionValue = null)
    {
	$this->_ConfigurableProductOptionValue = $ConfigurableProductOptionValue;
	parent::__construct($options, $this->_ConfigurableProductOptionValue);
    }
    
    public function init($options = array())
    {	
        $form = new Form_ConfigurableProductOptionValue_Subform($options, $this->_ConfigurableProductOptionValue);
	
	$this->addSubForm($form, "configurableproductoptionvalue");
	
	$this->addElement('submit', 'submit', array(
            'ignore'   => true,
        ));
    }
}

?>
