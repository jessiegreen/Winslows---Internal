<?php
namespace Forms\Company\Supplier\Product\Configurable\Option\Parameter;
use Entities\Company\Supplier\Product\Configurable\Option\Parameter as Parameter;
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
    private $_Parameter;
    
    public function __construct($options = null, Parameter $Parameter = null)
    {
	$this->_Parameter = $Parameter;
	parent::__construct($options);
    }
    
    public function init()
    {
	$this->addElement(new \Dataservice_Form_Element_OptionSelect("option_id", array(
            'required'	    => false,
            'label'	    => 'Option:',
	    'belongsTo'	    => 'company_supplier_product_configurable_option_parameter',
	    'value'	    => $this->_Parameter && 
				    $this->_Parameter->getOption()
				? $this->_Parameter->getOption()->getId() 
				: ""
        )));
	
	$this->addElement('text', 'name', array(
            'required'	    => true,
            'label'	    => 'Name:',
	    'belongsTo'	    => 'company_supplier_product_configurable_option_parameter',
	    'value'	    => $this->_Parameter ? $this->_Parameter->getName() : ""
        ));
	
	$this->addElement('text', 'index_string', array(
            'required'	    => true,
            'label'	    => 'Name Index:',
	    'belongsTo'	    => 'company_supplier_product_configurable_option_parameter',
	    'value'	    => $this->_Parameter ? $this->_Parameter->getIndex() : ""
        ));
	
	$this->addElement('text', 'length', array(
            'required'	    => true,
            'label'	    => 'Length:',
	    'size'	    => 2,
	    'maxlength'	    => 2,
	    'belongsTo'	    => 'company_supplier_product_configurable_option_parameter',
	    'value'	    => $this->_Parameter ? $this->_Parameter->getLength() : ""
        ));
	
	$this->addElement('textarea', 'description', array(
            'required'	    => false,
            'label'	    => 'Description:',
	    'cols'	    => 50,
	    'rows'	    => 8,
	    'belongsTo'	    => 'company_supplier_product_configurable_option_parameter',
	    'value'	    => $this->_Parameter ? $this->_Parameter->getDescription() : ""
        ));
	
	$this->addElement('select', 'required', array(
            'required'	    => true,
            'label'	    => 'Required:',
	    'belongsTo'	    => 'company_supplier_product_configurable_option_parameter',
	    'multioptions'  => array(false, true),
	    'value'	    => $this->_Parameter ? $this->_Parameter->isRequired() : ""
        ));
    }
}

?>
