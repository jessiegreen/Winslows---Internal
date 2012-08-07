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
class Form_SimpleProduct extends Zend_Form
{    
    private $_SimpleProduct;
    
    public function __construct($options = null, Entities\SimpleProduct $SimpleProduct = null)
    {
	$this->_SimpleProduct = $SimpleProduct;
	parent::__construct($options, $this->_SimpleProduct);
    }
    
    public function init($options = array())
    {	
        $form = new Form_SimpleProduct_Subform($options, $this->_SimpleProduct);
	
	$this->addSubForm($form, "simpleproduct");
	
	$this->addElement('submit', 'submit', array(
            'ignore'   => true,
        ));
    }
}

?>
