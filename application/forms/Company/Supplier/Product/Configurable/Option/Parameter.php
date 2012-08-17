<?php
namespace Forms\Company\Supplier\Product\Configurable\Option;
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
class Parameter extends \Zend_Form
{    
    private $_Parameter;
    
    public function __construct($options = null, \Entities\Company\Supplier\Product\Configurable\Option\Parameter $Parameter = null)
    {
	$this->_Parameter = $Parameter;
	parent::__construct($options, $this->_Parameter);
    }
    
    public function init($options = array())
    {	
        $form = new Parameter\Subform($options, $this->_Parameter);
	
	$this->addSubForm($form, "company_supplier_product_configurable_option_parameter");
	
	$this->addElement('submit', 'submit', array(
            'ignore'   => true,
        ));
    }
}

?>
