<?php
namespace Forms\Company\Supplier\Product;
use Entities\Company\Supplier\Product\Configurable as Configurable;
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
class Configurable extends \Zend_Form
{    
    private $_Configurable;
    
    public function __construct($options = null, Configurable $Configurable = null)
    {
	$this->_Configurable = $Configurable;
	parent::__construct($options, $this->_Configurable);
    }
    
    public function init($options = array())
    {	
        $form = new Configurable\Subform($options, $this->_Configurable);
	
	$this->addSubForm($form, "company_supplier_product_configurable");
	
	$this->addElement('submit', 'submit', array(
            'ignore'   => true,
        ));
    }
}

?>
