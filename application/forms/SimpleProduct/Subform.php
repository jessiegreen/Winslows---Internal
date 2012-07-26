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
class Form_SimpleProduct_Subform extends Form_Product_Subform
{    
    private $_SimpleProduct;
    
    public function __construct($options = null, Entities\SimpleProduct $SimpleProduct = null) {
	$this->_SimpleProduct = $SimpleProduct;
	parent::__construct($options, $this->_SimpleProduct);
    }
    
    public function init($options = array())
    {
	$this->addElement('text', 'price', array(
            'required'	    => true,
            'label'	    => 'Price:',
	    'belongsTo'	    => 'simpleproduct',
	    'value'	    => $this->_SimpleProduct ? $this->_SimpleProduct->getPrice() : ""
        ));
	
	parent::init($options);
    }
}

?>
