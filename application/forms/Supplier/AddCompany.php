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
class Form_Supplier_AddCompany extends Zend_Form
{
    
    public function init($options = array())
    {	
        $form = new Form_Supplier_AddCompany_Subform($options);
	
	$this->addSubForm($form, "supplier_addcompany");
	
	$this->addElement('submit', 'submit', array(
            'ignore'   => true,
        ));
    }
}

?>
