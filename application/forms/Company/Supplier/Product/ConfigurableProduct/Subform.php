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
class Form_ConfigurableProduct_Subform extends Form_Product_Subform
{    
    private $_ConfigurableProduct;
    
    public function __construct($options = null, Entities\ConfigurableProduct $ConfigurableProduct = null) {
	$this->_ConfigurableProduct = $ConfigurableProduct;
	parent::__construct($options, $this->_ConfigurableProduct);
    }
    
    public function init($options = array())
    {
	$this->addElement('text', 'pricer', array(
            'required'	    => true,
            'label'	    => 'Pricer:',
	    'belongsTo'	    => 'configurableproduct',
	    'value'	    => $this->_ConfigurableProduct ? $this->_ConfigurableProduct->getPricer() : ""
        ));
	
	$this->addElement('text', 'validator', array(
            'required'	    => true,
            'label'	    => 'Validator:',
	    'belongsTo'	    => 'configurableproduct',
	    'value'	    => $this->_ConfigurableProduct ? $this->_ConfigurableProduct->getValidator() : ""
        ));
	parent::init($options);
    }
}

?>
