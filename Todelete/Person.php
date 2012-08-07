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
class Form_Person extends Zend_Form
{
    protected $_Person;
    
    public function __construct($options = null, Entities\Person\PersonAbstract $Person = null) {
	$this->_Person = $Person;
	parent::__construct($options);
    }
  
    public function init($options = array()){
	$form = new Form_Person_Subform($options, $this->_Person);
	
        $this->addSubForm($form, "person");

        $this->addElement('submit', 'submit', array(
            'ignore'	    => true,
        ));

    }
}

?>
