<?php

/**
 * Name:
 * Quote:
 *
 * Description for class (if any)...
 *
 * @author     Jessie Green <jessie.winslows@gmail.com>
 * @copyright  2012 Winslows inc.
 * @version    Release: @package_version@
 */
class Form_Quote extends Zend_Form
{    
    private $_Quote;
    
    public function __construct($options = null, Entities\Quote $Quote = null)
    {
	$this->_Quote = $Quote;
	parent::__construct($options, $this->_Quote);
    }
    
    public function init($options = array())
    {	
        $form = new Form_Quote_Subform($options, $this->_Quote);
	
	$this->addSubForm($form, "quote");
	
	$this->addElement('submit', 'submit', array(
            'ignore'   => true,
        ));
    }
}

?>
