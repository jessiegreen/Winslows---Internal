<?php
namespace Forms\Company\Supplier\Product\Configurable;
use Entities\Company\Supplier\Product\Configurable as Configurable;
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
class Subform extends \Forms\Company\Supplier\Product\Subform
{    
    private $_Configurable;
    
    public function __construct($options = null, Configurable $Configurable = null) 
    {
	$this->_Configurable = $Configurable;
	parent::__construct($options, $this->_Configurable);
    }
    
    public function init($options = array())
    {
	$this->addElement('text', 'class_name', array(
            'required'	    => true,
            'label'	    => 'Class Name:',
	    'belongsTo'	    => 'company_product_supplier_configurable',
	    'value'	    => $this->_Configurable ? $this->_Configurable->getClassName() : ""
        ));

	parent::init($options);
    }
}