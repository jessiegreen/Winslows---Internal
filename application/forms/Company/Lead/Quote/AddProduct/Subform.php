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
class Form_Quote_AddProduct_Subform extends Zend_Form_SubForm
{    
    public function init() {
	$this->addElement(new Dataservice_Form_Element_ProductSelect("product_id", array(
            'required'	    => true,
            'label'	    => 'Products:',
	    'belongsTo'	    => 'quote_addproduct'
        )));
	
	parent::init();
    }
}

?>
