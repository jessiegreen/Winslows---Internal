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
class Address extends \Zend_Form
{    
    private $_Address;
    
    public function __construct($options = null, \Entities\Company\Supplier\Address $Address = null) 
    {
	$this->_Address = $Address;
	parent::__construct($options, $this->_Address);
    }
    
    public function init($options = array())
    {
	$form = new Address\Subform($options, $this->_Address);
	
	$this->addSubForm($form, "company_supplier_address");

        $this->addElement('submit', 'submit', array(
            'ignore'   => true,
        ));
    }
}

?>
