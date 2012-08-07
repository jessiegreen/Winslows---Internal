<?php

/**
 * Name:
 * Company:
 *
 * Description for class (if any)...
 *
 * @author     Jessie Green <jessie.winslows@gmail.com>
 * @copyright  2012 Winslows inc.
 * @version    Release: @package_version@
 */
class Form_ConfigurableProduct_ManageOptions extends Zend_Form
{
    private $_Product;
    
    public function __construct(\Entities\Product $Product, $options = null)
    {
	$this->_Product = $Product;
	parent::__construct($options);
    }
    
    public function init($options = array())
    {	
        $form = new Form_ConfigurableProduct_ManageOptions_Subform($this->_Product, $options);
	
	$this->addSubForm($form, "product_manageoptions");
	
	$this->addElement('submit', 'submit', array(
            'ignore'   => true,
        ));
    }
}

?>
