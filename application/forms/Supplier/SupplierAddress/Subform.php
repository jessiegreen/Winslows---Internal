<?php

/**
 * Name:
 * Supplier:
 *
 * Description for class (if any)...
 *
 * @author     Jessie Green <jessie.winslows@gmail.com>
 * @copyright  2012 Winslows inc.
 * @version    Release: @package_version@
 */
class Form_SupplierAddress_Subform extends Form_Address_Subform
{    
    private $_SupplierAddress;
    
    public function __construct($options = null, Entities\SupplierAddress $SupplierAddress = null) {
	$this->_SupplierAddress = $SupplierAddress;
	parent::__construct($options, $this->_SupplierAddress);
    }
    
    public function init($options = array())
    {
	parent::init($options);
    }
}

?>
