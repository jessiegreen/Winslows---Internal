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
	    'belongsTo'	    => 'configurableproductoption',
	    'value'	    => $this->_Option ? $this->_Option->getName() : ""
        ));
	
	$this->addElement('text', 'index_string', array(
            'required'	    => true,
            'label'	    => 'Name Index:',
	    'belongsTo'	    => 'configurableproductoption',
	    'value'	    => $this->_Option ? $this->_Option->getIndex() : ""
        ));
	
	$this->addElement('text', 'code', array(
            'required'	    => true,
	    'maxlength'	    => 2,
	    'size'	    => 2,
            'label'	    => 'Code:',
	    'belongsTo'	    => 'configurableproductoption',
	    'value'	    => $this->_Option ? $this->_Option->getCode() : ""
        ));
	
	$this->addElement('textarea', 'description', array(
            'required'	    => false,
            'label'	    => 'Description:',
	    'cols'	    => 50,
	    'rows'	    => 8,
	    'belongsTo'	    => 'configurableproductoption',
	    'value'	    => $this->_Option ? $this->_Option->getDescription() : ""
        ));
    }
}

?>
