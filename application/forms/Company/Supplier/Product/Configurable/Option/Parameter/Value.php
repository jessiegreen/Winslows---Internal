<?php
namespace Forms\Company\Supplier\Product\Configurable\Option\Parameter;
/**
 * Name:
 * Product:
 *
 * Description for class (if any)...
 *
 * @author     Jessie Green <jessie.winslows@gmail.com>
 * @copyright  2012 Winslows inc.
 * @version    Release: @package_version@
 */
class Value extends \Zend_Form
{    
    private $_Value;
    
    public function __construct($options = null, \Entities\Company\Supplier\Product\Configurable\Option\Parameter\Value $Value = null)
    {
	$this->_Value = $Value;
	parent::__construct($options, $this->_Value);
    }
    
    public function init($options = array())
    {	
        $form = new Value\Subform($options, $this->_Value);
	
	$this->addSubForm($form, "company_supplier_product_configurable_option_parameter_value");
	
	$this->addElement('submit', 'submit', array(
            'ignore'   => true,
        ));
    }
}

?>
