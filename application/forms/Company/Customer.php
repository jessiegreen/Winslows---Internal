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
class Form_Customer extends Zend_Form
{    
    private $_Customer;
    
    public function __construct($options = null, Entities\Customer $Customer = null)
    {
	$this->_Customer = $Customer;
	parent::__construct($options, $this->_Customer);
    }
    
    public function init($options = array())
    {	
        $form = new Form_Customer_Subform($options, $this->_Customer);
	
	$this->addSubForm($form, "customer");
	
	$this->addElement('submit', 'submit', array(
            'ignore'   => true,
        ));
    }
}

?>
