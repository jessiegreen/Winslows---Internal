<?php
namespace Forms\Company\Supplier\Product\Configurable\Option;
use Entities\Company\Supplier\Product\Configurable\Option as Option;
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
class Subform extends \Zend_Form_SubForm
{
    private $_Option;
    
    public function __construct($options = null, Option $Option = null) {
	$this->_Option = $Option;
	parent::__construct($options);
    }
    
    public function init()
    {
	$this->addElement('text', 'name', array(
            'required'	    => true,
            'label'	    => 'Name:',
	    'belongsTo'	    => 'company_supplier_product_configurable_option',
	    'value'	    => $this->_Option ? $this->_Option->getName() : ""
        ));
	
	$this->addElement('text', 'index_string', array(
            'required'	    => true,
            'label'	    => 'Name Index:',
	    'belongsTo'	    => 'company_supplier_product_configurable_option',
	    'value'	    => $this->_Option ? $this->_Option->getIndex() : ""
        ));
	
	$this->addElement('text', 'code', array(
            'required'	    => true,
	    'maxlength'	    => 2,
	    'size'	    => 2,
            'label'	    => 'Code:',
	    'belongsTo'	    => 'company_supplier_product_configurable_option',
	    'value'	    => $this->_Option ? $this->_Option->getCode() : ""
        ));
	
	$this->addElement('text', 'maxcount', array(
            'required'	    => true,
	    'maxlength'	    => 4,
	    'size'	    => 4,
            'label'	    => 'Max Count:',
	    'belongsTo'	    => 'company_supplier_product_configurable_option',
	    'value'	    => $this->_Option ? $this->_Option->getMaxCount() : "",
	    'validators'    => array("digits")
        ));
	
	$this->addElement('textarea', 'description', array(
            'required'	    => false,
            'label'	    => 'Description:',
	    'cols'	    => 50,
	    'rows'	    => 8,
	    'belongsTo'	    => 'company_supplier_product_configurable_option',
	    'value'	    => $this->_Option ? $this->_Option->getDescription() : ""
        ));
	
	$this->addElement('select', 'required', array(
            'required'	    => true,
            'label'	    => 'Required:',
	    'belongsTo'	    => 'company_supplier_product_configurable_option',
	    'multioptions'  => array(0 => "false", 1 => "true"),
	    'value'	    => $this->_Option ? $this->_Option->isRequired() : ""
        ));
    }
}