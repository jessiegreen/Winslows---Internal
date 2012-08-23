<?php
namespace Forms\Company\Supplier\Product\Configurable;
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
class Option extends \Zend_Form
{    
    private $_Option;
    
    public function __construct($options = null, \Entities\Company\Supplier\Product\Configurable\Option $Option = null)
    {
	$this->_Option = $Option;
	parent::__construct($options, $this->_Option);
    }
    
    public function init($options = array())
    {	
        $form = new Option\Subform($options, $this->_Option);
	
	$this->addSubForm($form, "company_supplier_product_configurable_option");
	
	$this->addElement('submit', 'submit', array(
            'ignore'   => true,
        ));
    }
}