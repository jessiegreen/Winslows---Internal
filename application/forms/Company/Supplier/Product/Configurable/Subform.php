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
class Subform extends \Form_Product_Subform
{    
    private $_Configurable;
    
    public function __construct($options = null, Configurable $Configurable = null) 
    {
	$this->_Configurable = $Configurable;
	parent::__construct($options, $this->_Configurable);
    }
    
    public function init($options = array())
    {
	$this->addElement('text', 'pricer', array(
            'required'	    => true,
            'label'	    => 'Pricer:',
	    'belongsTo'	    => 'configurableproduct',
	    'value'	    => $this->_Configurable ? $this->_Configurable->getPricer() : ""
        ));
	
	$this->addElement('text', 'validator', array(
            'required'	    => true,
            'label'	    => 'Validator:',
	    'belongsTo'	    => 'configurableproduct',
	    'value'	    => $this->_Configurable ? $this->_Configurable->getValidator() : ""
        ));
	parent::init($options);
    }
}

?>
