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
class Form_Customer_Subform extends Form_Lead_Subform
{    
    private $_Customer;
    
    public function __construct($options = null, Entities\Customer $Customer = null) {
	$this->_Customer = $Customer;
	parent::__construct($options, $this->_Customer);
    }
    
    public function init($options = array())
    {	
	parent::init($options);
    }
}

?>
