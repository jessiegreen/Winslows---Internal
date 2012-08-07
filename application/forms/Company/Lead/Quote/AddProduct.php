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
class Form_Quote_AddProduct extends Zend_Form
{
    public function init($options = array()){
	$form = new Form_Quote_AddProduct_Subform($options);
	
	$this->addSubForm($form, "quote_addproduct");

        $this->addElement('submit', 'submit', array(
            'ignore'   => true,
        ));
    }
}

?>
