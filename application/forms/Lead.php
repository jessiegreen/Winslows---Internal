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
class Form_Lead extends Zend_Form
{    
    private $_Lead;
    
    public function __construct($options = null, Entities\Lead $Lead = null) {
	$this->_Lead = $Lead;
	parent::__construct($options);
    }
    
    public function init($options = array())
    {
	$form = new Form_Lead_Subform($options, $this->_Lead);
	
	$this->addSubForm($form, "lead");
	
	$this->addElement('submit', 'submit', array(
            'ignore'   => true,
        ));
    }
}

?>
