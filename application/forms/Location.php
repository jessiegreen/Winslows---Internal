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
class Form_Location extends Zend_Form
{    
    private $_Location;
    
    public function __construct($options = null, Entities\Location $Location = null)
    {
	$this->_Location = $Location;
	parent::__construct($options, $this->_Location);
    }
    
    public function init($options = array())
    {	
        $form = new Form_Customer_Subform($options, $this->_Location);
	
	$this->addSubForm($form, "location");
	
	$this->addElement('submit', 'submit', array(
            'ignore'   => true,
        ));
    }
}

?>
