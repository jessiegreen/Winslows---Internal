<?php
namespace Forms\Company\Supplier;
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
class Address extends Zend_Form
{    
    private $_SupplierAddress;
    
    public function __construct($options = null, Entities\SupplierAddress $SupplierAddress = null) 
    {
	$this->_SupplierAddress = $SupplierAddress;
	parent::__construct($options, $this->_SupplierAddress);
    }
    
    public function init($options = array())
    {
	$form = new Address\Subform($options, $this->_SupplierAddress);
	
	$this->addSubForm($form, "company_supplier_address");

        $this->addElement('submit', 'submit', array(
            'ignore'   => true,
        ));
    }
}

?>
