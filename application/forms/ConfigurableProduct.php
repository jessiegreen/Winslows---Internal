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
class Form_ConfigurableProduct extends Zend_Form
{    
    private $_ConfigurableProduct;
    
    public function __construct($options = null, Entities\ConfigurableProduct $ConfigurableProduct = null)
    {
	$this->_ConfigurableProduct = $ConfigurableProduct;
	parent::__construct($options, $this->_ConfigurableProduct);
    }
    
    public function init($options = array())
    {	
        $form = new Form_ConfigurableProduct_Subform($options, $this->_ConfigurableProduct);
	
	$this->addSubForm($form, "configurableproduct");
	
	$this->addElement('submit', 'submit', array(
            'ignore'   => true,
        ));
    }
}

?>
