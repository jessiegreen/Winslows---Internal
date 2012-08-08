<?php
namespace Forms\Company\Supplier;
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
class Subform extends \Zend_Form_SubForm
{
    private $_Supplier;
    
    public function __construct($options = null, \Entities\Company\Supplier $Supplier = null)
    {
	$this->_Supplier = $Supplier;
	parent::__construct($options);
    }
    
    public function init()
    {		
	$this->addElement('text', 'name', array(
            'required'	    => true,
            'label'	    => 'Name:',
	    'belongsTo'	    => 'supplier',
	    'value'	    => $this->_Supplier ? $this->_Supplier->getName() : ""
        ));
    }
}

?>
