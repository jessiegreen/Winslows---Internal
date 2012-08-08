<?php
namespace Forms\Company;
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
class Supplier extends \Zend_Form
{    
    private $_Supplier;
    
    public function __construct($options = null, \Entities\Company\Supplier $Supplier = null)
    {
	$this->_Supplier = $Supplier;
	parent::__construct($options, $this->_Supplier);
    }
    
    public function init($options = array())
    {	
        $form = new Supplier\Subform($options, $this->_Supplier);
	
	$this->addSubForm($form, "company_supplier");
	
	$this->addElement('submit', 'submit', array(
            'ignore'   => true,
        ));
    }
}

?>
