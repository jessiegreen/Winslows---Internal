<?php
namespace Forms\Company\Lead\Quote\Item\Value;
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
    
    public function __construct(\Entities\Company\Supplier\Product\Configurable\Option $Option, $options = null) {
	$this->_Option = $Option;
	parent::__construct($options);
    }
    
    public function init($options = array()){
	$form = new \Forms\Company\Lead\Quote\Item\Value\Option\Subform($this->_Option, $options);
	
	$this->addSubForm($form, (string) $this->_Option->getId());
    }
}

?>
