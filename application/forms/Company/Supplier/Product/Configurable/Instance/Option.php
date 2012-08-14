<?php
namespace Forms\Company\Supplier\Product\Configurable\Instance;
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
class Option extends \Dataservice_Form
{
    private $_Option;
    private $_Instance;
    
    public function __construct
    (
	\Entities\Company\Supplier\Product\Configurable\Instance $Instance,
	\Entities\Company\Supplier\Product\Configurable\Option $Option, 
	$options = null
    ) 
    {
	$this->_Instance    = $Instance;
	$this->_Option	    = $Option;
	
	parent::__construct($options);
    }
    
    public function init($options = array())
    {
	$form = new \Forms\Company\Supplier\Product\Configurable\Instance\Option\Subform($this->_Instance, $this->_Option, $options);
	
	$this->addSubForm($form, (string) $this->_Option->getId());
    }
}

?>
